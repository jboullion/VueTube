<template>
	<router-link :to="'/channel/'+channel.youtube_id">
		<img :src="channel.img_url" loading="lazy">
	</router-link>
	<div class="channel-info">
		<h4>{{ channel.title }}</h4>
		<a :href="'https://www.youtube.com/channel/'+channel.youtube_id" class="channel-social youtube" target="_blank">
			<i class="fab fa-youtube"></i>
		</a>
		<a :href="channel.patreon" class="channel-social patreon" target="_blank">
			<i class="fab fa-patreon"></i>
		</a>
		<a :href="channel.twitter" class="channel-social twitter" target="_blank">
			<i class="fab fa-twitter"></i>
		</a>
		<a :href="channel.website" class="channel-social website" target="_blank">
			<i class="fas fa-globe"></i>
		</a>
		<div class="channel-social">
			<i class="fas fa-trash-alt delete-channel" @click="removeChannel(channel.id)"></i>
		</div>
		
	</div>
</template>


<script>
export default {
	props: ['channel'],
	data() {
		return {
		};
	}
	
}
</script>

<style scoped>
	img {
		border-radius: 50%;
		width: 72px;
		height: 72px;
	}

	.channel-info {
		margin-left: 20px;
	}

	h4 {
		margin: 0;
	}

	.delete-channel {
		cursor: pointer;
	}
</style>