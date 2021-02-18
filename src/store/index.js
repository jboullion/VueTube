import { createStore } from 'vuex'; 

import channelModules from './channels/index';
import videoModules from './videos/index';
import userModules from './users/index';
import formModule from './forms/index';

const store = createStore({
	modules: {
		channels: channelModules,
		videoModules: videoModules,
		users: userModules,
		forms: formModule
	},
	state() {
		return {
			domain: ''
		};
	},
	getters: {
		getSubdomain(){
			const host = window.location.host;
			const parts = host.split('.');
			return parts[0];
		}
	},
	actions: {
		setDomain(context) {
			context.commit('setDomain', this.getSubdomain());
		},
	},
	mutations: {
		setDomain(state, payload) {
			state.domain = payload;
		},
	}
});

export default store;