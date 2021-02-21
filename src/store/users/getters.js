export default {
	userId(state){
		return state.userId;
	},
	userIsAuthenticated(state){
		return state.loggedIn;
	},
	getGoogleUser(state){
		return state.googleUser;
		//return JSON.parse(sessionStorage.getItem('GoogleUser'));
	}
}