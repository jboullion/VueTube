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
	.channel {
		border-bottom: 1px solid #f7f7f9;
		padding-bottom: 30px;
		margin-bottom: 30px;
		transition: border-color 0.2s;
	}

	.title-card {
		margin-bottom: 20px;
		display: flex;
		align-items: center;

		
	}

	.title-card img {
		border-radius: 50%;
		width: 44px;
		height: 44px;
	}

	.title-card h4 {
		margin: 0 10px 0 20px;
	}

	.channel-control {
		display: inline-block;
		padding: 10px;
		margin: 0 10px;
		z-index: 1;
		width: 40px;
		top: 40%;
		text-align: center;
	}

	.channel-control.prev {
		left: 0;
	}

	.channel-control.next {
		right: 0;
	}

	.channel-control i {
		width: 10px;
		transition: all 0.2s linear;
		color: black;
	}

	
	.channel-social {
		display: inline-block;
		margin: 8px;
		width: 24px;
	}

	.patreon i { color: #f96854; }

	.twitter i { color: #1DA1F2; }

	.website i { color: #55595c; }
</style>