<template>
	<div class="channel-list row">
		<VideoCard v-for="video in videos" :key="video.video_id" :video="video" v-bind:class="{'col-md-4': true}" />
	</div>
</template>



<script>

import VideoCard from '../Video/VideoCard';

export default {
	inject: [],
	props: ['videos'],
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

<style>
	.channel-list .card-img-back {
		padding-top: 56.25%;
	}

	.channel-list .card-img-back img {
		width: 100%;
		height: auto;
	}
</style>