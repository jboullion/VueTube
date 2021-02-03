import { createStore } from 'vuex'; 

import channelModules from './channels/index';
import userModules from './users/index';

const store = createStore({
	modules: {
		channels: channelModules,
		users: userModules
	},
	state() {
		return {
		};
	},
	mutations: {

	},
	getters: {

	},
	actions: {

	}
});

export default store;