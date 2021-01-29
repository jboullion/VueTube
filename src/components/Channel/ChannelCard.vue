<template>
	<div class="channel">
		<div class="title-card">
			<a :href="'https://www.youtube.com/channel/'+channel.youtube_id" target="_blank">
				<img :src="channel.image">
			</a>
			<h4>{{ channel.title }}</h4>
			<a :href="channel.patreon" class="channel-social patreon" target="_blank">
				<i class="fab fa-patreon"></i>
			</a>
			<a :href="channel.twitter" class="channel-social twitter" target="_blank">
				<i class="fab fa-twitter"></i>
			</a>
			<a :href="channel.website" class="channel-social website" target="_blank">
				<i class="fas fa-globe"></i>
			</a>
			<a class="channel-control prev">
				<i class="fas fa-chevron-left"></i>
			</a>
			<a class="channel-control next">
				<i class="fas fa-chevron-right"></i>
			</a>
			<a>
				<i class="fas fa-trash-alt" @click="removeChannel(channel.id)"></i>
			</a>
		</div>
		<VideoList  :videos="videos" />
	</div>
</template>

<script>
import VideoList from '../Video/VideoList';

export default {
	inject: [], // 'channels',
	props: ['channel'],
	components: {
		VideoList
	},
	data() {
		return {
			videos: [],
			videoPage: 0,
			videosLoading: false
		};
	},
	mounted(){
		this.loadVideos();
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
				
				console.log(this.videos);
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

<style scoped>
	.channel {
		border-bottom: 1px solid #f7f7f9;
		padding-bottom: 30px;
		margin-bottom: 30px;
		transition: border-color 0.2s;
	}

	.title-card {
		margin-bottom: 20px;
		display: flex;
		align-items: center;

		
	}

	.title-card img {
		border-radius: 50%;
		width: 44px;
		height: 44px;
	}

	.title-card h4 {
		margin: 0 10px 0 20px;
	}

	.channel-control {
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

	.channel-social {
		display: inline-block;
		margin: 8px;
		width: 24px;
	}


	.patreon i { color: #f96854; }
	.twitter i { color: #1DA1F2; }
	.website i { color: #55595c; }


	@media (max-width: 768px) {
		.channel-control {
			display: none;
		}
	}
</style>