<template>
	<div class="video-info">
		<h3>{{ video.title }}</h3>
		<p>{{ video.date }}</p>
		<div class="video-actions">
			<i class="fas fa-heart" @click="toggleLiked" v-bind:class="{active: isLiked}"></i>
		</div>
		<div class="video-description">
			{{ video.description }}
		</div>
	</div>
</template>


<script>
export default {
	props: ['video'],
	data() {
		return {
			isLiked: false
			//videoDate: null
		};
	},
	created(){
		this.isLiked = this.video.isLiked?true:false;
		
		//this.videoDate = moment(this.video.date).format('MMM D, YYYY');
	},
	watch: { 
		video: function(newVal) { 
			this.isLiked = newVal.isLiked?true:false;
		}
	},
	methods: {
		toggleLiked(){
			console.log(this.video);
			fetch('http://science.narrative.local/api/videos/liked.php', {
				//mode: 'no-cors',
				method: 'POST',
				headers: { 'Content-Type': 'application/json' },
				body: JSON.stringify({ user_id: 1, video_id: this.video.video_id })
			})
			.then(response => {
				if(response.ok){
					this.isLiked = !this.isLiked;
					return response.json();
				}
			})
			.catch(error => {
				//this.errorMessage = error;
				console.error('There was an error!', error);
			});
		},
	}
}
</script>


<style scoped>
	.video-info {
		border-bottom: 1px solid #ccc;
		margin: 15px 0;
		padding-bottom: 15px;
		position: relative;
	}

	.video-actions {
		font-size: 24px;
		position: absolute;
		top: 0;
		right: 15px;
	}

	.video-actions i {
		color: #ccc;
		cursor: pointer;
		transition: color 0.2s linear;
	}

	.video-actions i.active {
		color: var(--red);
	}
</style>