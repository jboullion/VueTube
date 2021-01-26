<template>
	<div id="admin">
		<div class="container">
		<!-- <Channel v-for="channel in storedChannels" :key="channel.id" :channel="channel" /> -->
		<tabs>
			<TabItem @click="setSelectedTab('add-channel')" :mode="addChannelMode">Add Channel</TabItem>
			<TabItem @click="setSelectedTab('edit-channel')" :mode="editChannelMode">Edit Channel</TabItem>
		</tabs>

		<keep-alive>
			<component :is="selectedTab"></component>
		</keep-alive>
		</div>
	</div>
</template>

<script>
import AddChannel from './AddChannel.vue';
import EditChannel from './EditChannel.vue';

import Channel from '../Channel/Channel';
import BaseButton from '../UI/BaseButton.vue';
import TabItem from '../UI/Tabs/TabItem.vue';

export default {
	props: [],
	components: {
		AddChannel,
		EditChannel,
		Channel,
		TabItem,
		BaseButton
	},
	data() {
		return {
			selectedTab: 'add-channel',
			storedChannels: [
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
			],
			// menu: [{
			// 	id: 'add-channel',
			// 	title: 'Add Channel'
			// }, 
			// {
			// 	id: 0,
			// 	title: 'edit-channel'
			// }]
		};
	},
	provide(){
		return {
			channels: this.storedChannels,
			addChannel: this.addChannel
		}
	},
	computed: {
		addChannelMode(){
			return this.selectedTab === 'add-channel' ? 'btn-primary' : 'btn-outline-primary'
		},
		editChannelMode(){
			return this.selectedTab === 'edit-channel' ? 'btn-primary' : 'btn-outline-primary'
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

			this.storedChannels.unshift(newChannel)
			//this.selectedTab = 'add-channel';

		}
	}
}
</script>

<style>

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