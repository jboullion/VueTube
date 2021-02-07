<template>
	<div id="channel-list" >
		<div v-if="channelSearch" class="channel-search mb-4">
			<form class="form-inline row justify-content-end" method="get" action="" @submit.prevent="searchChannels()">
				<div class="">
					<div class="input-group">
						<input type="search" class="form-control" placeholder="Search Channel" aria-label="search" name="s" v-model.trim="search" @change="searchChannels()" />
						<div class="input-group-append">
							<i class="fas fa-cog fa-spin" v-if="channelVideosLoading"></i>
							<i class="fas fa-search" @click="searchChannels()" v-else></i>
							
						</div>
					</div>
				</div>
			</form>
		</div>
		<div class="row channel-videos vertical-list">
			<VideoCard v-for="video in channelVideos" :key="video.video_id" :video="video" v-bind:class="{'col-md-4': true}" />
		</div>
	</div>
</template>


<script>
import _debounce from 'lodash/debounce';
//import _throttle from 'lodash/throttle';

import VideoCard from '../Video/VideoCard';

export default {
	inject: [],
	props: ['channel', 'channelSearch'],
	components: {
		VideoCard
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
			moveRight: false,
			search: ''
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
		searchChannels(){

			this.channelVideos = [];
			this.channelVideosLoading = true;
			
			let searchString = '?channel_id='+this.channel.channel_id;

			if(this.order){
				searchString += '&offset='+this.channelsPage+'&order='+this.order;
			}else{
				searchString += '&orderby=title&order=asc';
			}

			if(this.search){
				searchString += '&s='+this.search.replace('#','');
			}

			fetch('http://science.narrative.local/api/videos/search.php'+searchString, {
				//mode: 'no-cors',
				method: 'GET',
				headers: { 'Content-Type': 'application/json' }
			})
			.then(response => {
				if(response.ok){
					this.channelsPage++;
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

	.channel-search {
		position: absolute;
		bottom: 100%;
		right: 15px;
	}

	.channel-videos {
		min-height: 80vh
	}

	.vertical-list {
		position: relative;
	}

	.vertical-list .card {
		margin-bottom: 15px;
	}
	
	.vertical-list .card-img-back {
		padding-top: 56.25%;
	}

	.vertical-list .card-img-back img {
		width: 100%;
		height: auto;
	}

	@media (max-width: 1199px) {

		.vertical-list {
			padding: 0 15px;
		}


	}

	@media (max-width: 768px) {

		.channel-search {
			position: relative;
			bottom: auto;
			right: auto;
		}

	}
</style>