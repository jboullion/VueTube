<template>
	<div id="account-page" class="container-fluid">
		<div class="row">
			<div id="account-menu" class="col-lg-3">
				<base-button @click="setSelectedTab('history')" type="button" class="btn" :class="{'btn-secondary':selectedTab=='history', 'btn-dark':selectedTab!='history'}" aria-current="true">
					History
				</base-button>
				<base-button @click="setSelectedTab('liked')" type="button" class="btn" :class="{'btn-secondary':selectedTab=='liked', 'btn-dark':selectedTab!='liked'}">Liked</base-button>
			</div>

			<div class="col-lg-9">
				<transition name="route" mode="out-in" >
					<component :is="selectedTab"></component>
				</transition>
			</div>
		</div>
	</div>
</template>

<script>
//import Profile from './Profile.vue';
import History from './History.vue';
import Liked from './Liked.vue';

import BaseButton from '../UI/BaseButton.vue';

export default {
	props: [],
	components: {
		//Profile,
		History,
		Liked,
		BaseButton
	},
	data() {
		return {
			selectedTab: 'history',
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
	#account-page {
		padding: 50px 0;
	}

	#account-menu button {
		display: block;
		margin-bottom: 10px;
		width: 100%;
	}

	#account-page h3 {
		margin-bottom: 20px;
	}
</style>