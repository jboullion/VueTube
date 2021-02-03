<template>
	<div id="channel-page">
		<ChannelFilters />
		<div id="channels">
			<ChannelCard v-for="channel in $store.getters.getChannels" :key="channel.channel_id" :channel="channel" />
		</div>
	</div>
</template>

<script>
import ChannelFilters from './ChannelFilters';
import ChannelCard from './ChannelCard';

export default {
	inject: [],
	components: {
		ChannelFilters,
		ChannelCard
	},
	data() {
		return {
			
		};
	},
	provide(){
		return {

		}
	},
	created(){

	},
	mounted(){
		
	},
	methods: {
		
	}
}
</script>

<style scoped>
	#channels {
		padding: 50px 0;
	}
</style>