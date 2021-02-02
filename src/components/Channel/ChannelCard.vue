<template>
	<div v-if="videos && videos.length > 0" class="channel">
		<div class="title-card">
			<ChannelInfo :channel="channel" />
			<a class="channel-control prev">
			<i class="fas fa-chevron-left"></i>
		</a>
		<a class="channel-control next">
			<i class="fas fa-chevron-right"></i>
		</a>
		</div>
		<div class="video-wrap">
			<VideoList  :videos="videos" />
		</div>
	</div>
</template>

<script>
import ChannelInfo from './ChannelInfo';
import VideoList from '../Video/VideoList';

export default {
	inject: [], // 'channels',
	props: ['channel'],
	components: {
		ChannelInfo,
		VideoList
	},
	data() {
		return {
			videos: [],
			videoPage: 1,
			videosLoading: false
		};
	},
	created(){
		//this.loadVideos();
		//console.log(this.channel);
		this.videos = this.channel.videos;
	},
	methods: {
		loadVideos(){
			//var limit = 10;

			this.videosLoading = true;

			fetch('http://science.narrative.local/api/channel/videoList.php?channel_id='+this.channel.channel_id+'&offset='+this.videoPage, {
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
	}
}
</script>

<style>
	.channel {
		/* border-bottom: 1px solid #f7f7f9; */
		padding-bottom: 20px;
		margin-bottom: 20px;
		transition: border-color 0.2s;
	}

	.title-card {
		margin-bottom: 20px;
		display: flex;
		align-items: center;
	}

	.video-wrap .card.video {
		width: 320px;
	}

	.video-wrap .card-img-back {
		width: 320px;
		height: 180px;
	}

	.channel-control {
		cursor: pointer;
		display: inline-block;
		padding: 10px;
		margin: 0 10px;
		z-index: 1;
		width: 40px;
		top: 40%;
		text-align: center;
	}

	.channel-control.prev {
		left: 0;
	}

	.channel-control.next {
		right: 0;
	}

	.channel-control i {
		width: 10px;
		transition: all 0.2s linear;
		color: black;
	}


	@media (max-width: 768px) {
		.channel-control {
			display: none;
		}
	}
</style>