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

		}
	},
	created(){

	},
	mounted(){
		this.loadChannels();
	},
	methods: {
		loadChannels(){

			this.channelsLoading = true;
			
			let searchString = '';
			if(this.$route.query){
				searchString = '?';

				if(this.$route.query.order){
					searchString += '&offset='+this.channelsPage+'&order='+this.$route.query.order;
				}else{
					searchString += '&rand=1';
				}

				if(this.$route.query.search){
					searchString += '&search='+this.$route.query.search;
				}

				if(this.$route.query.style){
					searchString += '&style='+this.$route.query.style;
				}

				if(this.$route.query.topic){
					searchString += '&topic='+this.$route.query.topic;
				}
			}

			fetch('http://science.narrative.local/api/channel/search.php'+searchString, {
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