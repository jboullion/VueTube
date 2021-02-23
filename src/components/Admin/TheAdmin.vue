<template>
	<div id="admin" class="container-fluid">
		<div class="row">
			<div id="admin-menu" class="col-lg-3">
				<base-button @click="setSelectedTab('add-channel')" type="button" class="btn" :class="{'btn-secondary':selectedTab=='add-channel', 'btn-dark':selectedTab!='add-channel'}">Add Channel</base-button>
				<base-button @click="setSelectedTab('edit-channel')" type="button" class="btn" :class="{'btn-secondary':selectedTab=='edit-channel', 'btn-dark':selectedTab!='edit-channel'}">Edit Channel</base-button>
			</div>

			<div class="col-lg-9">
				<keep-alive>
				<component :is="selectedTab"></component>
				</keep-alive>
			</div>
		</div>
	</div>
</template>

<script>
import AddChannel from './AddChannel.vue';
import EditChannel from './EditChannel.vue';

import BaseButton from '../UI/BaseButton.vue';

export default {
	props: [],
	components: {
		AddChannel,
		EditChannel,
		BaseButton
	},
	data() {
		return {
			selectedTab: 'add-channel',
			storedChannels: [],
			page: 0,
			channelsLoading: false
		};
	},
	provide(){
		return {
			channels: this.storedChannels,
			addChannel: this.addChannel,
			removeChannel: this.removeChannel
		}
	},
	created(){
		if(! this.$store.getters.getStyles.length){
			fetch(process.env.VUE_APP_URL+'ui/get-filters.php', {
				//mode: 'no-cors',
				method: 'GET',
				headers: { 'Content-Type': 'application/json' },
			})
			.then(response => {
				if(response.ok){
					return response.json();
				}
			})
			.then(data => {
				this.styles = data.styles;
				this.topics = data.topics;
				this.$store.dispatch('setStylesAndTopics', data);
			})
			.catch(error => {
				console.error('There was an error!', error);
			});
		}
	},
	methods: {
		setSelectedTab(tab){
			this.selectedTab = tab;
		},
		addChannel(title, channel_id){ // website
			const newChannel = {
				id: new Date().toISOString(),
				title: title,
				channel_id: channel_id,
				//website: website
			};

			this.storedChannels.unshift(newChannel);
			//this.selectedTab = 'add-channel';

		},
		removeChannel( id ){ // website
			// remove from props
			this.storedChannels = this.storedChannels.filter(channel => channel.id !== id);

			// Remove from provide
			//const channelIndex = this.storedChannels.findIndex(channel => channel.id !== id);
			//this.storedChannels.splice(channelIndex,1);
		},
		loadChannels(){
			//var limit = 10;

			this.channelsLoading = true;

			fetch(process.env.VUE_APP_URL+'channel/search.php?offset='+this.page, {
				//mode: 'no-cors',
				method: 'GET',
				headers: { 'Content-Type': 'application/json' }
			})
			.then(response => {
				if(response.ok){
					this.page++;
					return response.json();
				}
			})
			.then(data => {
				this.channelsLoading = false;
				this.storedChannels = this.storedChannels.concat(data);
			})
			.catch(error => {
				//this.errorMessage = error;
				this.channelsLoading = false;
				console.error('There was an error!', error);
			});
		}

	}
}
</script>

<style>
	#admin {
		padding: 50px 0;
	}

	#admin-menu button {
		display: block;
		margin-bottom: 10px;
		width: 100%;
	}

	.card {
		margin-bottom: 30px;
	}

	.card .form-group {
		margin-bottom: 20px;
	}

	.card label {
		font-weight: bold;
	}

	.card .card-footer {
		background-color: white;
		padding: 30px 15px;
	}
</style>