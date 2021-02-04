export default {
	login(context) {
		context.commit('setAuth', { isAuth: true });
	},
	logout(context) {
		context.commit('setAuth', { isAuth: false });
	},
	// signOut() {
	// 	var auth2 = gapi.auth2.getAuthInstance();
	// 	auth2.signOut().then(function () {
	// 		console.log('User signed out.');
	// 		context.commit('setAuth', { isAuth: false });
	// 	});
	// }
}