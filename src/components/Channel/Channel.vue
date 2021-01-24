<template>
	<div class="channel">
		<div class="title-card">
			<a :href="'https://www.youtube.com/channel/'+channel.video_id" target="_blank">
				<img :src="channel.image">
			</a>
			<h4>{{ channel.title }}</h4>
			<a :href="channel.patreon" class="channel-social patreon" target="_blank">
				<i class="fab fa-patreon"></i>
			</a>
			<a :href="channel.twitter" class="channel-social twitter" target="_blank">
				<i class="fab fa-twitter"></i>
			</a>
			<a :href="channel.website" class="channel-social website" target="_blank">
				<i class="fas fa-globe"></i>
			</a>
			<a href="#" class="channel-control prev">
				<i class="fas fa-chevron-left"></i>
			</a>
			<a href="#" class="channel-control next">
				<i class="fas fa-chevron-right"></i>
			</a>
		</div>
		<VideoList  :videos="videos" />
	</div>
</template>

<script>
import VideoList from '../Video/VideoList';

export default {
	props: ['channel'],
	components: {
		VideoList
	},
	data() {
		return {
			videos: [
				{ 
					id: 0,
					video_id: 'OjrEudqgZ1M', 
					title: 'Video Name', 
					description: 'A Video Description',
					link: 'https://www.youtube.com//watch?v=OjrEudqgZ1M',
				},
				{ 
					id: 0,
					video_id: 'OjrEudqgZ1M', 
					title: 'Video Name', 
					description: 'A Video Description',
					link: 'https://www.youtube.com//watch?v=OjrEudqgZ1M',
				}
			]
		};
	}
}
</script>

<style scoped>
	li {
		margin: auto;
		max-width: 40rem;
	}

	header {
		display: flex;
		justify-content: space-between;
		align-items: center;
	}

	h3 {
		font-size: 1.25rem;
		margin: 0.5rem 0;
	}

	p {
		margin: 0.5rem 0;
	}

	a {
		text-decoration: none;
		color: #ce5c00;
	}

	a:hover,
	a:active {
		color: #c89300;
	}
</style>