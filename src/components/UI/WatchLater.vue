<template>
	<i class="fas" @click.prevent="toggleWatchLater" :class="isSaved ? 'fa-check-circle' : 'fa-clock'"></i>
</template>


<script>
export default {
	props: ['video'],
	data() {
		return {
			isSaved: false,
		};
	},
	created(){
		this.isSaved = this.video.isSaved?true:false;
	},
	methods: {
		toggleWatchLater() {
			if(this.$store.getters.getGoogleUser){
				this.$store.dispatch('toggleWatchLater', { video: this.video });
				this.isSaved = !this.isSaved;

				if(! this.isSaved){
					this.$emit('unSaved', this.video);
				}
			}else{
				this.toast.error("You must be logged in to save a video!", this.$store.getters.getToastOptions);
			}
		},
	}
}
</script>

<style scoped>
	i.fas {
		opacity: 1;
		transition: color 0.15s;
		color: var(--bs-light);
	}
</style>