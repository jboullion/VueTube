<template>
	<i class="fas fa-heart" @click.prevent="toggleLiked" :class="{active: isLiked}"></i>
</template>

<script>
export default {
	props: ['video'],
	data() {
		return {
			isLiked: false,
		};
	},
	created(){
		this.isLiked = this.video.isLiked?true:false;
	},
	methods: {
		toggleLiked() {
			if(this.$store.getters.loggedIn){
				this.$store.dispatch('toggleLiked', { video: this.video });
				this.isLiked = !this.isLiked;

				if(! this.isLiked){
					this.$emit('unLiked', this.video);
				}
			}else{
				this.toast.error("You must be logged in to like a video!", this.$store.getters.getToastOptions);
			}
		},
	}
}
</script>

<style scoped>
	i.fa-heart {
		opacity: 1;
		transition: color 0.15s;
		color: var(--bs-light);
	}

	i.fa-heart.active {
		color: var(--red);
	}
</style>