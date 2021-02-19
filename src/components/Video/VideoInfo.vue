<template>
	<div class="video-info">
		<div v-if="tags" class="tags">
			<span v-for="tag in tags" :key="tag">{{ tag }}</span>
		</div>
		<h3>{{ video.title }}</h3>
		<p>{{ videoDate }}</p>
		<div class="video-actions">
			<i class="fas fa-clock" @click="toggleWatchLater" v-bind:class="{active: isSaved}"></i>
			<i class="fas fa-heart" @click="toggleLiked" v-bind:class="{active: isLiked}"></i>
		</div>
		<div class="video-description" v-html="video.content"></div>
	</div>
</template>


<script>
import { useToast } from "vue-toastification";

import moment from 'moment'

export default {
	props: ['video'],
	components: {
		
	},
	data() {
		return {
			isLiked: false,
			isSaved: false,
			showUserError: false,
			tags: '',
			googleUser: {},
			toast: null,
			toastOptions: {
				position: "top-center", // bottom-center?
				timeout: 3000,
				closeOnClick: true,
				pauseOnFocusLoss: true,
				pauseOnHover: true,
				draggable: true,
				draggablePercent: 0.6,
				showCloseButtonOnHover: false,
				hideProgressBar: true,
				closeButton: "button",
				icon: true,
				rtl: false
			}
			//videoDate: null
		};
	},
	created() {
		this.isLiked = this.video.isLiked?true:false;
		this.isSaved = this.video.isSaved?true:false;
		this.tags = this.video.tags?this.video.tags.split(','):'';
		
		this.videoDate = moment(this.video.date).format('MMM D, YYYY');

		this.googleUser = this.$store.getters.getGoogleUser;

		this.toast = useToast();
	},
	watch: {
		video: function(newVal) { 
			this.isLiked = newVal.isLiked?true:false;
			this.isSaved = newVal.isSaved?true:false;
		}
	},
	methods: {
		toggleLiked() {
			if(this.googleUser){
				this.$store.dispatch('toggleLiked', { video: this.video });
				this.isLiked = !this.isLiked;
			}else{
				this.toast.error("You must be logged in to like a video!", this.toastOptions);
			}
		},
		toggleWatchLater() {
			if(this.googleUser){
				this.$store.dispatch('toggleWatchLater', { video: this.video });
				this.isSaved = !this.isSaved;
			}else{
				this.toast.error("You must be logged in to save a video!", this.toastOptions);
			}
		},
		confirmError(){
			this.showUserError = false;
		}
	}
}
</script>

<style scoped>
	.video-info {
		border-bottom: 1px solid #ccc;
		margin: 15px 0;
		padding-bottom: 15px;
		position: relative;
		padding-right: 80px;
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
		margin-left: 15px;
	}

	.video-actions i.fa-heart.active {
		color: var(--red);
	}

	.video-actions i.fa-clock.active {
		color: var(--bs-dark);
	}

	.darkmode .video-actions i.fa-clock.active {
		color: var(--bs-light);
	}

	.tags span {
		color: var(--bs-blue);
		margin-right: 10px;
	}

	@media (max-width: 1199px) {
		.video-info {
			padding: 0 90px 15px 15px;
		}
		
		.video-actions {
			line-height: 1;
		}
	}
</style>