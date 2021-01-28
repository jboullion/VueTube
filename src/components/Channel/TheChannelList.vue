<template>
	<div id="channels">
		<Channel v-for="channel in channels" :key="channel.id" :channel="channel" />
	</div>
</template>


<script>
import Channel from './Channel';

export default {
	props: [],
	components: {
		Channel
	},
	data() {
		return {
			channels: [
				{ 
					id: 'transhumania', 
					channel_id: 'UCAvRKtQNLKkAX0pOKUTOuzw',
					title: 'TRANSHUMANIA', 
					description: 'Videos about the future',
					image: 'http://science.narrative.local/wp-content/uploads/sites/4/2021/01/Arvin-Ash.png',
					link: 'https://www.youtube.com/channel/UCAvRKtQNLKkAX0pOKUTOuzw',
					patreon: ''
				},
				{ 
					id: 'abc-news', 
					channel_id: 'UCBi2mrWuNuyYy4gbM6fU18Q',
					title: 'ABC News', 
					description: 'News from ABC',
					image: 'http://science.narrative.local/wp-content/uploads/sites/4/2021/01/Arvin-Ash.png',
					link: 'https://www.youtube.com/channel/UCBi2mrWuNuyYy4gbM6fU18Q',
					patreon: ''
				},
			]
		};
	},
	provide(){
		return {
			channels: this.channels
		}
	},
}
</script>

<style scoped>
	#channels {
		padding: 50px 0;
	}
</style>