<template>
	<div id="admin">
		<Tabs>
			<TabItem @click="setSelectedTab('add-channel')" :mode="addChannelMode">Add Channel</TabItem>
			<TabItem @click="setSelectedTab('edit-channel')" :mode="editChannelMode">Edit Channel</TabItem>
		</Tabs>

		<component :is="selectedTab"></component>
	</div>
</template>

<script>
import AddChannel from './AddChannel.vue';
import EditChannel from './EditChannel.vue';

import BaseButton from '../UI/BaseButton.vue';
import Tabs from '../UI/Tabs/Tabs.vue';
import TabItem from '../UI/Tabs/TabItem.vue';

export default {
	props: [],
	components: {
		AddChannel,
		EditChannel,
		Tabs,
		TabItem,
		BaseButton
	},
	data() {
		return {
			selectedTab: 'add-channel',
			channel: null,
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
	// provide(){
	// 	return {
	// 		channel: this.channel
	// 	}
	// },
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
		}
	}
}
</script>

<style>
	
</style>