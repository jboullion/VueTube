<template>
	<div class="full-video row">
		<div class="col-xl-8">
			<div class="yt-video-wrapper">
				<iframe type="text/html" :src="'http://www.youtube.com/embed/'+fullVideo.youtube_id+'?enablejsapi=1'" frameborder="0" allowfullscreen></iframe>
			</div>
			<VideoInfo :video="fullVideo" />
			<div class="video-channel-info">
				<ChannelInfo :channel="channel" />
			</div>
			<div class="channel-list row">
				<VideoCard v-for="video in channelVideos" :key="video.video_id" :video="video" v-bind:class="{'col-md-4': true}" />
			</div>
		</div>
		<div class="col-xl-4 side-list">
			<VideoCard v-for="video in relatedVideos" :key="video.video_id" :video="video" :showChannel="true" />
		</div>

	</div>
</template>

<script>
import moment from 'moment'
import _debounce from 'lodash/debounce';
//import _throttle from 'lodash/throttle';

import ChannelInfo from './ChannelInfo';
import VideoCard from '../Video/VideoCard';
import VideoInfo from '../Video/VideoInfo';

export default {
	inject: [],
	components: {
		ChannelInfo,
		VideoCard,
		VideoInfo
	},
	data() {
		return {
			isPlaying: false,
			hasLoaded: false,
			player: null,
			youtube_id: null,
			selectedVideo: null,
			channelLoading: false,
			channelVideosLoading: false,
			channelVideos: [],
			channelVideoPage: 0,
			channel: {},
			videoLoading: false,
			relatedVideoPage: 0,
			relatedVideos: [],
			fullVideo: {},
			scrolledToBottom: false
		};
	},
	created(){
		this.youtube_id = this.$route.params.channelId;

		this.loadChannel();
		//this.selectedVideo = this.videos.find(video => video.youtube_id === this.videoId);
		//this.channel = this.channels.find(channel => this.selectedVideo.channel_id === channel.channel_id);
	},
	mounted(){
		//window.scrollTo(0, 0);
		this.scroll();
	},
	methods: {
		scroll () {
			const scrollPadding = 400;
			const throttleSpeed = 300;

			// Ideally this should be a debounce but the lodash underscore wasn't working as I hoped
			window.addEventListener('scroll', _debounce(() => {
				if ((window.innerHeight + window.scrollY + scrollPadding ) >= document.body.offsetHeight) {
					// you're at the bottom of the page
					this.loadChannelVideos(this.fullVideo);
					this.loadRelatedVideos(this.fullVideo);
				}
			}, throttleSpeed));
		},
		loadVideo(video){

			this.videoLoading = true;

			fetch('http://science.narrative.local/api/videos/get.php?youtube_id='+video.youtube_id+'&limit=1', {
				//mode: 'no-cors',
				method: 'GET',
				headers: { 'Content-Type': 'application/json' }
			})
			.then(response => {
				if(response.ok){
					return response.json();
				}
			})
			.then(data => {
				this.videoLoading = false;
				//console.log(data);
				if(data){
					this.fullVideo = data;
					this.fullVideo.date = moment(this.fullVideo.date).format('MMM D, YYYY');
					this.loadRelatedVideos(this.fullVideo);
					//this.loadRelatedChannel(this.fullVideo);
					console.log(this.fullVideo);
				}
			})
			.catch(error => {
				//this.errorMessage = error;
				this.videoLoading = false;
				console.error('There was an error!', error);
			});
		},
		loadChannel(){

			this.channelLoading = true;

			fetch('http://science.narrative.local/api/channel/get.php?youtube_id='+this.youtube_id, {
				//mode: 'no-cors',
				method: 'GET',
				headers: { 'Content-Type': 'application/json' }
			})
			.then(response => {
				if(response.ok){
					//this.relatedVideoPage++;
					return response.json();
				}
			})
			.then(data => {
				this.channelLoading = false;

				this.channel = data;
				this.loadChannelVideos();
				//console.log(this.channel);
			})
			.catch(error => {
				//this.errorMessage = error;
				this.channelLoading = false;
				console.error('There was an error!', error);
			});
		},
		loadChannelVideos(){

			this.channelVideosLoading = true;

			fetch('http://science.narrative.local/api/channel/videoList.php?channel_id='+this.channel.channel_id+'&offset='+this.channelVideoPage, {
				//mode: 'no-cors',
				method: 'GET',
				headers: { 'Content-Type': 'application/json' }
			})
			.then(response => {
				if(response.ok){
					return response.json();
				}
			})
			.then(data => {
				this.channelVideosLoading = false;
				if(data.length){
					this.channelVideoPage++;
					this.channelVideos = this.channelVideos.concat(data);
					this.loadVideo(this.channelVideos[0]);
				}
			})
			.catch(error => {
				//this.errorMessage = error;
				this.channelVideosLoading = false;
				console.error('There was an error!', error);
			});
		},
		loadRelatedVideos(video){

			this.videosLoading = true;

			fetch('http://science.narrative.local/api/videos/related.php?channel_id='+video.channel_id, { // +'&offset='+this.relatedVideoPage
				//mode: 'no-cors',
				method: 'GET',
				headers: { 'Content-Type': 'application/json' }
			})
			.then(response => {
				if(response.ok){
					//this.relatedVideoPage++;
					return response.json();
				}
			})
			.then(data => {
				this.videosLoading = false;
				if(data.length){
					this.relatedVideoPage++;
					this.relatedVideos = this.relatedVideos.concat(data);
				}
			})
			.catch(error => {
				//this.errorMessage = error;
				this.videosLoading = false;
				console.error('There was an error!', error);
			});
		}
	},
	watch: {
		'$route.params': {
			handler(newValue) {
				if(this.hasLoaded){
					this.youtube_id = newValue.videoId;
					this.channelVideoPage = 0;
					this.channelVideos = [];
					this.relatedVideoPage = 0;
					this.relatedVideos = [];
					//this.loadVideo();
				}

				// prevent firing on the first component load
				this.hasLoaded = true;
			},
			immediate: true,
		}
	}
}
</script>

<style>
	.full-video .yt-video-wrapper {
		margin-top: 15px;
		width: 100%;
		padding-top: 56.25%;
		/* padding-top: 50%; */
		position: relative;
	}

	.full-video iframe {
		position: absolute;
		top: 0;
		left: 0;
		height: 100%;
		width: 100%;
	}

	.video-channel-info {
		margin-bottom: 20px;
		display: flex;
		align-items: center;
		
	}

	.video-channel-info img {
		border-radius: 50%;
		width: 62px;
		height: 62px;
	}

	.video-channel-info .channel-info {
		margin-left: 20px;
	}

	.video-channel-info h4 {
		margin: 0;
	}

	.channel-list .card-img-back {
		padding-top: 56.25%;
	}

	.channel-list .card-img-back img {
		width: 100%;
		height: auto;
	}



	.side-list .card.video {
		display: flex;
		flex-direction: row;
		margin-bottom: 0;
		margin-top: 15px;
		width: 100%;
	}
	
	.side-list .card.video .card-link {
		width: 45%;
	}

	.side-list .card.video .card-img-back {
		width: 100%;
		height: auto;
	}

	.side-list .card.video .card-img-back img {
		position: relative;
	}

	.side-list .card.video .card-img-back i {
		font-size: 50px;
	}

	.side-list .card.video .card-img-back img {
		width: 100%;
		height: auto;
	}

	.side-list .card.video .card-body {
		height: auto;
		width: 55%;
		padding: 0 10px;
	}

	.side-list .card.video .card-body p {
		font-size: 14px;
	}

	.side-list .card.video .card-body span.date {
		position: relative;
		display: block;
		left: 0;
		bottom: 0;
	}


	.side-list .card.video {
		width: 100%;
		height: auto;
	}

	@media (max-width: 1199px) {
		.full-video .yt-video-wrapper {
			margin-top: 0;
			/* margin-left: -30px;
			margin-right: -30px; */
		}

		.col-xl-8 {
			padding: 0;
		}

		.video-info {
			padding: 0 50px 15px 15px;
		}

		.video-channel-info {
			padding: 0 15px 15px 15px;
		}

		.video-actions {
			line-height: 1;
		}
		
	}
</style>