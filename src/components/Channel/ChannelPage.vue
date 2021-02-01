<template>
	<div class="full-video row">
		<div class="col-xl-8">
			<VideoFrame :video="fullVideo" />
			<VideoInfo :video="fullVideo" />
			
			<ChannelInfo :channel="channel" />
			
			<ChannelList :channel="channel" />
		</div>
		<RelatedVideos :video="fullVideo" />
	</div>
</template>

<script>
import moment from 'moment';

import ChannelInfo from './ChannelInfo';
import ChannelList from './ChannelList';
import VideoFrame from '../Video/VideoFrame';
import RelatedVideos from '../Video/RelatedVideos';
import VideoInfo from '../Video/VideoInfo';

export default {
	inject: [],
	components: {
		ChannelInfo,
		ChannelList,
		VideoFrame,
		RelatedVideos,
		VideoInfo
	},
	data() {
		return {
			hasLoaded: false,
			youtube_id: null,
			channelLoading: false,
			channel: {},
			channelVideosLoading: false,
			fullVideo: {},
		};
	},
	created(){
		this.youtube_id = this.$route.params.channelId;

		this.loadChannel();
	},
	mounted(){
		
	},
	methods: {

		loadChannel(){

			this.channelLoading = true;

			fetch('http://science.narrative.local/api/channel/get.php?youtube_id='+this.youtube_id, {
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
				this.channelLoading = false;

				this.channel = data;
				this.loadChannelVideo();
			})
			.catch(error => {
				//this.errorMessage = error;
				this.channelLoading = false;
				console.error('There was an error!', error);
			});
		},
		loadChannelVideo(){

			if(! this.channel.channel_id) return;

			this.channelVideosLoading = true;

			fetch('http://science.narrative.local/api/channel/videoList.php?channel_id='+this.channel.channel_id+'&limit=1', {
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
					this.fullVideo = data[0];
					this.fullVideo.date = moment(this.fullVideo.date).format('MMM D, YYYY');

				}
			})
			.catch(error => {
				//this.errorMessage = error;
				this.channelVideosLoading = false;
				console.error('There was an error!', error);
			});
		},
	},
	watch: {
		'$route.params': {
			handler(newValue) {
				if(this.hasLoaded){
					this.youtube_id = newValue.channelId;
					this.loadChannel();
					this.loadChannelVideo();
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

	@media (max-width: 1199px) {

		.col-xl-8 {
			padding: 0;
		}
		
	}
</style>