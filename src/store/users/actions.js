export default {
	login(context) {
		context.commit('setAuth', { isAuth: true });
	},
	logout(context) {
		context.commit('setAuth', { isAuth: false });
	},
	setGoogleUser(context, payload) {
		context.commit('payload', payload);
	},




	
	addToHistory({ getters }, payload){
		
		let googleUser = getters.getGoogleUser;

		if(googleUser && googleUser.Token){
			fetch(process.env.VUE_APP_URL+'videos/watched.php', {
				//mode: 'no-cors',
				method: 'POST',
				headers: { 'Content-Type': 'application/json' },
				body: JSON.stringify({ token: googleUser.Token, video_id: payload.video.video_id, channel_id: payload.video.channel_id })
			});
		}

	},
	toggleLiked({ getters }, payload){
		
		let googleUser = getters.getGoogleUser;

		if(googleUser && googleUser.Token){
			fetch(process.env.VUE_APP_URL+'videos/liked.php', {
				//mode: 'no-cors',
				method: 'POST',
				headers: { 'Content-Type': 'application/json' },
				body: JSON.stringify({ token: googleUser.Token, video_id: payload.video.video_id })
			})
		}

	},
	toggleWatchLater({ getters }, payload){
		
		let googleUser = getters.getGoogleUser;

		if(googleUser && googleUser.Token){
			fetch(process.env.VUE_APP_URL+'videos/watch-later.php', {
				//mode: 'no-cors',
				method: 'POST',
				headers: { 'Content-Type': 'application/json' },
				body: JSON.stringify({ token: googleUser.Token, video_id: payload.video.video_id })
			})
		}

	},
}