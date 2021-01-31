<template>
	<div class="channel">
		<div class="title-card">
			<a :href="'https://www.youtube.com/channel/'+channel.youtube_id" target="_blank">
				<img :src="channel.img_url" loading="lazy">
			</a>
			<div class="channel-info">
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
				<div class="channel-social">
					<i class="fas fa-trash-alt delete-channel" @click="removeChannel(channel.id)"></i>
				</div>
				<a class="channel-control prev">
					<i class="fas fa-chevron-left"></i>
				</a>
				<a class="channel-control next">
					<i class="fas fa-chevron-right"></i>
				</a>
			</div>
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

<style scoped>
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

	.title-card img {
		border-radius: 50%;
		width: 72px;
		height: 72px;
	}

	.title-card .channel-info {
		margin-left: 20px;
	}

	.title-card h4 {
		margin: 0;
	}

	.delete-channel {
		cursor: pointer;
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