<template>
	<div class="full-video row">
		<div class="col-xl-8">
			<div class="yt-video-wrapper">
				<iframe @click="togglePlay" type="text/html" :src="'http://www.youtube.com/embed/'+youtube_id+'?enablejsapi=1'" frameborder="0" allowfullscreen></iframe>
			</div>
			<div class="video-info">
				<h3>{{ fullVideo.title }}</h3>
				<p>{{ fullVideo.date }}</p>
				<div class="video-actions">
					<i class="fas fa-heart"></i>
				</div>
			</div>
			<div class="video-channel-info">
				<a :href="'https://www.youtube.com/channel/'+videoChannel.youtube_id" target="_blank">
					<img :src="videoChannel.img_url" loading="lazy">
				</a>
				<div class="channel-info">
					<h4>{{ videoChannel.title }}</h4>
					<a :href="videoChannel.patreon" class="channel-social patreon" target="_blank">
						<i class="fab fa-patreon"></i>
					</a>
					<a :href="videoChannel.twitter" class="channel-social twitter" target="_blank">
						<i class="fab fa-twitter"></i>
					</a>
					<a :href="videoChannel.website" class="channel-social website" target="_blank">
						<i class="fas fa-globe"></i>
					</a>
				</div>
			</div>
		</div>
		<div class="col-xl-4 side-list">
			<VideoCard v-for="video in videos" :key="video.video_id" :video="video" :showChannel="true" />
		</div>
	</div>
</template>

<script>
import moment from 'moment'

import VideoCard from './VideoCard';

export default {
	inject: [],
	components: {
		VideoCard
	},
	data() {
		return {
			isPlaying: false,
			hasLoaded: false,
			player: null,
			youtube_id: null,
			selectedVideo: null,
			channelLoading: false,
			videoChannel: {},
			videoLoading: false,
			videoPage: 0,
			videos: [],
			fullVideo: {}
		};
	},
	created(){
		this.youtube_id = this.$route.params.videoId;

		this.loadVideo();
		//this.selectedVideo = this.videos.find(video => video.youtube_id === this.videoId);
		//this.videoChannel = this.channels.find(channel => this.selectedVideo.channel_id === channel.channel_id);
	},
	mounted(){
		//window.scrollTo(0, 0);
	},
	methods: {
		loadVideo(){

			this.videoLoading = true;

			fetch('http://science.narrative.local/api/videos/search.php?youtube_id='+this.youtube_id+'&limit=1', {
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
				if(data[0]){
					this.fullVideo = data[0];
					this.fullVideo.date = moment(this.fullVideo.date).format('MMM D, YYYY');
					this.loadRelatedVideos(this.fullVideo);
					this.loadRelatedChannel(this.fullVideo);
				}
			})
			.catch(error => {
				//this.errorMessage = error;
				this.videoLoading = false;
				console.error('There was an error!', error);
			});
		},
		loadRelatedChannel(video){

			this.channelLoading = true;

			fetch('http://science.narrative.local/api/channel/get.php?channel_id='+video.channel_id, {
				//mode: 'no-cors',
				method: 'GET',
				headers: { 'Content-Type': 'application/json' }
			})
			.then(response => {
				if(response.ok){
					this.videoPage++;
					return response.json();
				}
			})
			.then(data => {
				this.channelLoading = false;

				this.videoChannel = data;
				console.log(this.videoChannel);
			})
			.catch(error => {
				//this.errorMessage = error;
				this.channelLoading = false;
				console.error('There was an error!', error);
			});
		},
		loadRelatedVideos(video){

			this.videosLoading = true;

			fetch('http://science.narrative.local/api/channel/videoList.php?channel_id='+video.channel_id+'&offset='+this.videoPage, {
				//mode: 'no-cors',
				method: 'GET',
				headers: { 'Content-Type': 'application/json' }
			})
			.then(response => {
				if(response.ok){
					this.videoPage++;
					return response.json();
				}
			})
			.then(data => {
				this.videosLoading = false;
				this.videos = this.videos.concat(data);
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
					this.loadVideo();
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
		position: relative;
	}

	.full-video iframe {
		position: absolute;
		top: 0;
		left: 0;
		height: 100%;
		width: 100%;
	}

	.video-info {
		border-bottom: 1px solid #ccc;
		margin: 15px 0;
		
		position: relative;
	}

	.video-actions {
		position: absolute;
		top: 0;
		right: 0;
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
	
	.full-video .card.video {
		display: flex;
		flex-direction: row;
		margin-bottom: 0;
		margin-top: 15px;
		width: 100%;
	}
	
	.full-video .card.video .card-link {
		width: 40%;
	}

	.full-video .card.video .card-img-back {
		width: 100%;
		height: auto;
	}

	.full-video .card.video .card-img-back img {
		position: relative;
	}

	.full-video .card.video .card-img-back i {
		font-size: 50px;
	}

	.full-video .card.video .card-img-back img {
		width: 100%;
		height: auto;
	}

	.full-video .card.video .card-body {
		height: auto;
		width: 60%;
		padding: 0 10px;
	}

	.full-video .card.video .card-body p {
		font-size: 14px;
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
	}
</style>