<template>
	<div id="history-videos" class="row vertical-list">
			<VideoCard v-for="video in historyVideos" :key="video.video_id" :video="video" v-bind:class="{'col-md-4 col-lg-3': true}" />
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
			historyLoading: false,
			historyPage: 0,
			historyVideos: []
		};
	},
	mounted(){
		this.loadHistory();
	},
	methods: {
		loadHistory(){

			this.historyLoading = true;

			fetch('http://science.narrative.local/api/user/get-history.php?user_id=1&offset='+this.historyPage, {
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
				this.historyLoading = false;
				if(data.length){
					this.historyPage++;
					this.historyVideos = this.historyVideos.concat(data);
				}
			})
			.catch(error => {
				//this.errorMessage = error;
				this.historyLoading = false;
				console.error('There was an error!', error);
			});
		},
	},
}
</script>

<style scoped>


</style>