<template>
	<Header />
	<div class="container-fluid">
		<TheAdmin></TheAdmin>
		<!-- <ChannelList :channels="channels"></ChannelList> -->
	</div>
</template>

<script>
import Header from './components/Header/Header';
//import ChannelList from './components/Channel/ChannelList';
import TheAdmin from './components/Admin/TheAdmin';

export default {
	components: {
		Header,
		//ChannelList,
		TheAdmin
	},
	data() {
		return {
			
		};
	}
}
</script>

<style>
	* {
		box-sizing: border-box;
	}

	html {
		font-family: 'Roboto', sans-serif;
	}

	body {
		background-color: #f8f8f8;
		margin: 0;
		font-family: 'Roboto', sans-serif;
	}

	h1,h2,h3,h4,h5,h6, p {
		margin-top: 0;
	}
</style>