<template>
	<!-- <g-signin-button @done="onUserLoggedIn"/> -->
	<div id="my-signin2" v-if="! googleUser"></div>
	<router-link to="/account" v-else><span class="account-image"><img :src="googleUser.Image" width="36" height="36" /></span></router-link>
	<!-- <a id="signin-button" v-on:click="signIn">
      <i class="fa fa-google-plus-official fa-3x"></i>
      Sign in with Google
    </a> -->
</template>


<script>

export default {
  components: {  },
	props: [],
	data() {
		return {
			// section: 'Login',
			// loading: '',
			// response: '',
			googleUser: {}
		};
	},
	created(){
		
	},
	mounted(){

		this.googleUser = this.$store.getters.getGoogleUser;
	},
	methods: {
		// signIn: function () {
		// 	this.googleAuth().signIn(this.onSignInSuccess, this.onSignInError)
		// },
		// onSignInSuccess: function (authorizationCode) {
		// 	this.toggleLoading()
		// 	this.resetResponse()

		// 	this.$http.post('http://your-backend-server.com/auth/google', { code: authorizationCode, redirect_uri: 'postmessage' }).then(function (response) {
		// 		if (response.body) {
		// 		var data = response.body

		// 		// Save to vuex
		// 		var token = 'Bearer ' + data.token
		// 		this.$store.commit('SET_USER', data.user_data)
		// 		this.$store.commit('SET_TOKEN', token)

		// 		// Save to local storage as well
		// 		// ( or you can install the vuex-persistedstate plugin so that you won't have to do this step, only store to Vuex is sufficient )
		// 		if (window.localStorage) {
		// 			window.localStorage.setItem('user', JSON.stringify(data.user_data))
		// 			window.localStorage.setItem('token', token)
		// 		}

		// 		// redirect to the dashboard
		// 		this.$router.push({ name: 'home' })
		// 		}
		// 	}, function (response) {
		// 		var data = response.body
		// 		this.response = data.error
		// 		console.log('BACKEND SERVER - SIGN-IN ERROR', data)
		// 	})
		// },
		// onSignInError: function (error) {
		// 	this.response = 'Failed to sign-in'
		// 	console.log('GOOGLE SERVER - SIGN-IN ERROR', error)
		// },
		// toggleLoading: function () {
		// 	this.loading = (this.loading === '') ? 'loading' : ''
		// },
		// resetResponse: function () {
		// 	this.response = ''
		// }
	}
}
</script>

<style scoped>
	.account-image img {
		border: 2px solid #818384;
		border-radius: 50%;
	}
</style>