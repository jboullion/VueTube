<template>
	<div id="liked-videos" class="row vertical-list">
			<VideoCard v-for="video in likedVideos" :key="video.video_id" :video="video" v-bind:class="{'col-md-4 col-lg-3': true}" />
		</div>
</template>

<script>
import VideoCard from '../Video/VideoCard';

export default {
	props: ['videos'],
	components: {
		VideoCard
	},
	data() {
		return {
			likedLoading: false,
			likedPage: 0,
			likedVideos: []
		};
	},
	mounted(){
		this.loadliked();
	},
	methods: {
		loadliked(){

			this.likedLoading = true;

			fetch('http://science.narrative.local/api/user/get-liked.php?user_id=1&offset='+this.likedPage, {
				//mode: 'no-cors',
				method: 'GET',
				headers: { 'Content-Type': 'application/json' }
			})
			.then(response => {
				if(response.ok){
					return response.json();
				}
			})
			.then(data => {
				this.likedLoading = false;
				if(data.length){
					this.likedPage++;
					this.likedVideos = this.likedVideos.concat(data);
				}
			})
			.catch(error => {
				//this.errorMessage = error;
				this.likedLoading = false;
				console.error('There was an error!', error);
			});
		},
	},
}
</script>

<style scoped>


</style>