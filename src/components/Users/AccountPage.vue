<template>
	<div id="account-page" class="container-fluid">
		<div class="row">
			<div id="account-menu" class="col-lg-3">
				<base-button @click="setSelectedTab('watch-later')" type="button" class="btn" :class="{'btn-secondary':selectedTab=='watch-later', 'btn-dark':selectedTab!='watch-later'}">Watch Later</base-button>
				<base-button @click="setSelectedTab('history')" type="button" class="btn" :class="{'btn-secondary':selectedTab=='history', 'btn-dark':selectedTab!='history'}" aria-current="true">History</base-button>
				<base-button @click="setSelectedTab('liked')" type="button" class="btn" :class="{'btn-secondary':selectedTab=='liked', 'btn-dark':selectedTab!='liked'}">Liked</base-button>
				<base-button @click="signOut();" type="button" class="btn" :class="'btn-danger'">Sign out</base-button>
			</div>

			<div class="col-lg-9">
				<transition name="route" mode="out-in" >
					<keep-alive>
					<component :is="selectedTab"></component>
					</keep-alive>
				</transition>
			</div>
		</div>
	</div>
</template>

<script>
import firebase from "firebase/app";
import 'firebase/auth'

//import Profile from './Profile.vue';
import History from './History.vue';
import Liked from './Liked.vue';
import WatchLater from './WatchLater.vue';

import BaseButton from '../UI/BaseButton.vue';

export default {
	props: [],
	components: {
		//Profile,
		History,
		Liked,
		WatchLater,
		BaseButton
	},
	data() {
		return {
			selectedTab: 'watch-later',
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
		},
		signOut(){

			// Signing out of firebase will allow us to generate a new access token on next login
			firebase.auth().signOut();
			this.$store.dispatch('logout');

			// We will head home now since we shouldn't have access to the account page anymore.
			this.$router.replace('/');

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

	.card-img-back {
		padding-top: 56.25%;
	}

	@media (max-width: 768px) {
		#account-page {
			padding: 15px 0 50px;
		}
	}
</style>