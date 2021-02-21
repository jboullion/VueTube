export default {
	setAuth(state, payload) {
		state.loggedIn = payload.isAuth;
	},
	logout(state){
		state.googleUser = {}
	},
	setGoogleUser(state, payload) {
		state.googleUser.email = payload.user.email;
		state.googleUser.photoURL = payload.user.photoURL;
		state.googleUser.uid = payload.user.uid;
		state.googleUser.idToken = payload.credential.idToken;
		state.googleUser.accessToken = payload.credential.accessToken;
		state.googleUser.refreshToken = payload.user.refreshToken;
	},
}