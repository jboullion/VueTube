import actions from './actions'; 
import getters from './getters'; 
import mutations from './mutations'; 

const userModules = {
	// namespaced: true,
	state() {
		return {
			loggedIn: false,
			usedId: 0,
			googleUser: null,
			//userEntity: {}
		};
	},
	actions: actions,
	getters: getters,
	mutations: mutations
}

export default userModules;