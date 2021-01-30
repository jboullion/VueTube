<template>
	<ChannelFilters />
	<div id="channels">
		<ChannelCard v-for="channel in channels" :key="channel.channel_id" :channel="channel" />
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
			channelsLoading: false,
			channelsPage: 0,
			channels: [],
		};
	},
	provide(){
		return {
			//channels: this.channels
		}
	},
	created(){
		//console.log(this.channels);
	},
	mounted(){
		this.loadChannels();
	},
	methods: {
		loadChannels(){
			//var limit = 10;

			this.channelsLoading = true;

			fetch('http://science.narrative.local/api/channel/search.php?offset='+this.channelsPage, {
				//mode: 'no-cors',
				method: 'GET',
				headers: { 'Content-Type': 'application/json' }
			})
			.then(response => {
				if(response.ok){
					this.channelsPage++;
					return response.json();
				}
			})
			.then(data => {
				this.channelsLoading = false;
				
				this.channels = this.channels.concat(data);
			})
			.catch(error => {
				//this.errorMessage = error;
				this.channelsLoading = false;
				console.error('There was an error!', error);
			});
		},
	}
}
</script>

<style scoped>
	#channels {
		padding: 50px 0;
	}
</style>