<template>
	<div class="full-video row">
		<div class="col-xl-8">
			<div class="yt-video-wrapper">
				<iframe @click="togglePlay" type="text/html" :src="'http://www.youtube.com/embed/'+videoId+'?enablejsapi=1'" frameborder="0" allowfullscreen></iframe>
			</div>
		</div>
		<div class="col-xl-4 video-list">
			<VideoCard v-for="video in videos" :key="video.video_id" :video="video" />
		</div>
	</div>
</template>

<script>
import VideoCard from './VideoCard';

export default {
	inject: ['videos', 'channels'],
	components: {
		VideoCard
	},
	data() {
		return {
			isPlaying: false,
			player: null,
			videoId: null,
			selectedVideo: null,
			videoChannel: null
		};
	},
	created(){
		this.videoId = this.$route.params.videoId;

		//this.selectedVideo = this.videos.find(video => video.youtube_id === this.videoId);
		//this.videoChannel = this.channels.find(channel => this.selectedVideo.channel_id === channel.channel_id);
	},
	mounted(){
		
	},
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
	
	.full-video .card.video {
		display: flex;
		flex-direction: row;
		margin-bottom: 0;
		margin-top: 15px;
		width: 100%;
	}

	.full-video .card.video .card-img-back {
		width: 50%;
		height: auto;
	}

	.full-video .card.video .card-img-back i {
		font-size: 50px;
	}

	.full-video .card.video .card-img-back img {
		width: 100%;
		height: auto;
	}

	.full-video .card.video .card-body {
		width: 50%;
	}

	@media (max-width: 1199px) {
		.full-video .yt-video-wrapper {
			margin-top: 0;
		}
	}
</style>