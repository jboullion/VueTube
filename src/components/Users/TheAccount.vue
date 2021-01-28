<template>
	<div class="admin">
		<h2>Account</h2>

		<div class="tabs">
			<base-button @click="setSelectedTab('profile')" class="btn btn-primary">Profile</base-button>
			<base-button @click="setSelectedTab('history')" class="btn btn-secondary">History</base-button>
			<base-button @click="setSelectedTab('liked')" class="btn btn-secondary">Liked</base-button>
		</div>

		<component :is="selectedTab"></component>
	</div>
</template>

<script>
import Profile from './Profile.vue';
import History from './History.vue';
import Liked from './Liked.vue';

import BaseButton from '../UI/BaseButton.vue';

export default {
	props: [],
	components: {
		Profile,
		History,
		Liked,
		BaseButton
	},
	data() {
		return {
			selectedTab: 'add-channel',
			user: null
		};
	},
	provide(){
		return {
			user: this.user
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