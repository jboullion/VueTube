<template>
	<div class="video-list">
		<div class="video-wrap" style="width: 6800px;">
			<SingleVideo v-for="video in videos" :key="video.video_id" :video="video" />
		</div>
	</div>
</template>

<script>
import SingleVideo from './SingleVideo';

export default {
	props: ['videos'],
	components: {
		SingleVideo
	},
	data() {
		return {
			
		};
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