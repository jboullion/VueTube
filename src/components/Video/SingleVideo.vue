<template>
	<a href="#" class="card video h-100 yt-video">
		<div class="card-img-back">
			<img loading="lazy" class="lazy" width="320" height="180" :src="'https://img.youtube.com/vi/'+video.video_id+'/mqdefault.jpg'" style="">
			<i class="fas fa-play-circle"></i>
		</div>
		<div class="card-body">
			<p class="ellipsis">{{ video.title }}</p>
			<span class="date">{{ video.date }}</span>
		</div>
	</a>
</template>

<script>
export default {
	props: ['video'],
	data() {
		return {
			
		};
	}
}
</script>

<style scoped>

</style>