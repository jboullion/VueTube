import { createStore } from 'vuex'; 

import channelModules from './channels/index';
import userModules from './users/index';
import formModule from './forms/index';

const store = createStore({
	modules: {
		channels: channelModules,
		users: userModules,
		forms: formModule
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