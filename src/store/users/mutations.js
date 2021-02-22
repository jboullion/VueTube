export default {
	login(state, payload) {
		state.loggedIn = true;

		state.googleUser.email = payload.user.email;
		state.googleUser.photoURL = payload.user.photoURL;
		state.googleUser.uid = payload.user.uid;
		state.googleUser.idToken = payload.credential.idToken;
		state.googleUser.accessToken = payload.credential.accessToken;
		state.googleUser.refreshToken = payload.user.refreshToken;

		localStorage.setItem("googleUser", "Smith");
		//sessionStorage.setItem("googleUser", "Smith");
	},
	logout(state){
		state.loggedIn = false;

		state.googleUser = {}

		localStorage.removeItem("googleUser");
		//sessionStorage.removeItem("googleUser");
	},
}