export default {
	login(state, payload) {
		state.loggedIn = true;

		state.googleUser = payload;

		localStorage.setItem("googleUser", JSON.stringify(state.googleUser) );
		//sessionStorage.setItem("googleUser", "Smith");
	},
	logout(state){
		state.loggedIn = false;

		state.googleUser = null

		localStorage.removeItem("googleUser");
		//sessionStorage.removeItem("googleUser");
	},
}