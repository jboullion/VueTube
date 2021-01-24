<template>
	<Header />
	<ChannelList :channels="channels"></ChannelList>
</template>

<script>
import Header from './components/Header/Header';
import ChannelList from './components/Channel/ChannelList';

export default {
	components: {
		Header,
		ChannelList
	},
	data() {
		return {
			channels: [
				{ 
					id: 'transhumania', 
					channel_id: 'UCAvRKtQNLKkAX0pOKUTOuzw',
					title: 'TRANSHUMANIA', 
					description: 'Videos about the future',
					link: 'https://www.youtube.com/channel/UCAvRKtQNLKkAX0pOKUTOuzw',
					patreon: ''
				},
				{ 
					id: 'abc-news', 
					channel_id: 'UCBi2mrWuNuyYy4gbM6fU18Q',
					title: 'ABC News', 
					description: 'News from ABC',
					link: 'https://www.youtube.com/channel/UCBi2mrWuNuyYy4gbM6fU18Q',
					patreon: ''
				},
			]
		};
	}
}
</script>

<style>
	@import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');

	* {
		box-sizing: border-box;
	}

	html {
		font-family: 'Roboto', sans-serif;
	}

	body {
		margin: 0;
	}

	h1,h2,h3,h4,h5,h6 {
		margin-top: 0;
	}
</style>