<template>
	<div class="col-xl-4 side-list">
		<VideoCard v-for="video in videos" :key="video.video_id" :video="video" :showChannel="showChannel" />
	</div>
</template>


<script>

import VideoCard from '../Video/VideoCard';

export default {
	inject: [],
	props: ['videos', 'showChannel'],
	components: {
		VideoCard,
	},
	data() {
		return {

		};
	},
	created(){
	
	},
	mounted(){

	},
	methods: {
	
	},

}
</script>

<style >
	.side-list .card.video {
		display: flex;
		flex-direction: row;
		margin-bottom: 0;
		margin-top: 15px;
		width: 100%;
	}
	
	.side-list .card.video .card-link {
		width: 45%;
	}

	.side-list .card.video .card-img-back {
		width: 100%;
		height: auto;
	}

	.side-list .card.video .card-img-back img {
		position: relative;
	}

	.side-list .card.video .card-img-back i {
		font-size: 50px;
	}

	.side-list .card.video .card-img-back img {
		width: 100%;
		height: auto;
	}

	.side-list .card.video .card-body {
		height: auto;
		width: 55%;
		padding: 0 10px;
	}

	.side-list .card.video .card-body p {
		font-size: 14px;
	}

	.side-list .card.video .card-body span.date {
		position: relative;
		display: block;
		left: 0;
		bottom: 0;
	}


	.side-list .card.video {
		width: 100%;
		height: auto;
	}

	@media (max-width: 1199px) {

		
	}
</style>