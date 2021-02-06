<template>
	<div id="channel-list" class="row">
		<VideoCard v-for="video in channelVideos" :key="video.video_id" :video="video" v-bind:class="{'col-md-4': true}" />
	</div>
</template>


<script>
import _debounce from 'lodash/debounce';
//import _throttle from 'lodash/throttle';

import VideoCard from '../Video/VideoCard';

export default {
	inject: [],
	props: ['channel'],
	components: {
		VideoCard,
	},
	data() {
		return {
			channelVideosLoading: false,
			channelVideos: [],
			channelVideoPage: 0,
			xDown: false,
			yDown: false,
			sliderSize: 340,
			moveLeft: false,
			moveRight: false
		};
	},
	created(){
		
	},
	mounted(){
		this.scroll();
	},
	methods: {
		scroll () {
			//const scrollPadding = 400;
			const throttleSpeed = 300;

			var $channelList = document.getElementById('channel-list');

			// Ideally this should be a debounce but the lodash underscore wasn't working as I hoped
			window.addEventListener('scroll', _debounce(() => {
				if($channelList.scrollHeight - $channelList.scrollTop === $channelList.clientHeight){
					this.loadChannelVideos();
				}
			}, throttleSpeed));
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
		channel: function() { 
			this.channelVideos = [];
			this.channelVideoPage = 0;
			this.loadChannelVideos();
		}
	}

}
</script>

<style>
	#channel-list .card-img-back {
		padding-top: 56.25%;
	}

	#channel-list .card-img-back img {
		width: 100%;
		height: auto;
	}
</style>