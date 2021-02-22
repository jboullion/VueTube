export default {
	login(context, payload) {
		//context.commit('setAuth', { isAuth: true });

		// This basically just tracks the last visit / login. However it will also create a user if one does not exist
		fetch(process.env.VUE_APP_URL+'user/login.php', {
			//mode: 'no-cors',
			method: 'POST',
			headers: { 'Content-Type': 'application/json' },
			body: JSON.stringify({ googleUser: payload })
		}).then(response => {
			if(response.ok){
				return response.json();
			}
		})
		.then(data => {
			if(data.success){
				context.commit('login', payload);
				
			}
		})
		.catch(error => {
			//this.errorMessage = error;
			this.channelLoading = false;
			console.error('There was an error!', error);
		});
	},
	logout(context) {

		// This basically just tracks the last visit / login. However it will also create a user if one does not exist
		fetch(process.env.VUE_APP_URL+'user/logout.php', {
			//mode: 'no-cors',
			method: 'POST',
			headers: { 'Content-Type': 'application/json' },
			body: JSON.stringify({ googleUser: context.getters.getGoogleUser })
		}).then(response => {
			if(response.ok){
				return response.json();
			}
		})
		.then(data => {
			if(data.success){
				context.commit('logout');
			}
		})
		.catch(error => {
			//this.errorMessage = error;
			this.channelLoading = false;
			console.error('There was an error!', error);
		});
	},
	addToHistory({ getters }, payload){
		
		let googleUser = getters.getGoogleUser;

		if(googleUser && googleUser.accessToken){
			fetch(process.env.VUE_APP_URL+'videos/watched.php', {
				//mode: 'no-cors',
				method: 'POST',
				headers: { 'Content-Type': 'application/json' },
				body: JSON.stringify({ googleUser: googleUser, video_id: payload.video.video_id, channel_id: payload.video.channel_id })
			});
		}

	},
	toggleLiked({ getters }, payload){
		
		let googleUser = getters.getGoogleUser;

		if(googleUser && googleUser.accessToken){
			fetch(process.env.VUE_APP_URL+'videos/liked.php', {
				//mode: 'no-cors',
				method: 'POST',
				headers: { 'Content-Type': 'application/json' },
				body: JSON.stringify({ googleUser: googleUser, video_id: payload.video.video_id })
			})
		}

	},
	toggleWatchLater({ getters }, payload){
		
		let googleUser = getters.getGoogleUser;

		if(googleUser && googleUser.accessToken){
			fetch(process.env.VUE_APP_URL+'videos/watch-later.php', {
				//mode: 'no-cors',
				method: 'POST',
				headers: { 'Content-Type': 'application/json' },
				body: JSON.stringify({ googleUser: googleUser, video_id: payload.video.video_id })
			})
		}

	},
}