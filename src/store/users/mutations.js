export default {
	setAuth(state, payload) {
		state.loggedIn = payload.isAuth;
	},
	setGoogleUser(state, payload) {
		state.loggedIn = payload;
	},
}