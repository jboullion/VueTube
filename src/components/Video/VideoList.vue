<template>
	<div class="video-list">
		<div class="video-wrap" style="width: 6800px;">
			<VideoCard v-for="video in videos" :key="video.video_id" :video="video" />
		</div>
	</div>
</template>

<script>
import VideoCard from './VideoCard';

export default {
	props: ['videos'],
	components: {
		VideoCard
	},
	data() {
		return {
			
		};
	},
	mounted() {
		// console.log('Video List Videos:');
		// console.log(console.log(this.videos));
	}
}
</script>

<style scoped>
	.video-list {
		overflow: hidden;
		white-space: nowrap;
	}

	.video-wrap {
		display: flex;
		transition: transform 0.2s ease-out;
	}

	.card {
		margin-right: 20px;
	}

	.card:last-child {
		margin: 0;
	}
</style>