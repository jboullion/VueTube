<template>
	<div class="yt-video-wrapper">
		<iframe type="text/html" :src="'http://www.youtube.com/embed/'+video.youtube_id+'?enablejsapi=1'" frameborder="0" allowfullscreen></iframe>
	</div>
</template>


<script>
export default {
	props: ['video'],
	data() {
		return {

		};
	},
	created(){

	},
	computed: {
		
	},
	methods: {

	}
}
</script>

<style scoped>
	.yt-video-wrapper {
		margin-top: 15px;
		width: 100%;
		padding-top: 56.25%;
		/* padding-top: 50%; */
		position: relative;
	}

	iframe {
		position: absolute;
		top: 0;
		left: 0;
		height: 100%;
		width: 100%;
	}

	@media (max-width: 1199px) {
		.yt-video-wrapper {
			margin-top: 0;
		}
	}
</style>