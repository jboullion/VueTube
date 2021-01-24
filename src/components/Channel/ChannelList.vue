<template>
	<div id="channels">
		<Channel v-for="channel in channels" :key="channel.id" :channel="channel" />
	</div>
</template>


<script>
import Channel from './Channel';

export default {
	props: ['channels'],
	components: {
		Channel
	},
	data() {
		return {
			
		};
	}
}
</script>

<style scoped>
	
</style>