const formModule = {

	state() {
		return {
			// TODO: De we want to load these dynamically? They won't change much
			styles: [
				{ id: 1, name: 'Explainer' },
				{ id: 2, name: 'Review' },
				{ id: 3, name: 'Podcast' },
				{ id: 4, name: 'Interview' },
				{ id: 5, name: 'Wonder' },
				{ id: 6, name: 'News' }
			],
			topics: [
				{ id: 1, name: 'Space' },
				{ id: 2, name: 'Phyisics' },
				{ id: 3, name: 'Math' },
				{ id: 4, name: 'AI' },
				{ id: 5, name: 'Technology' },
				{ id: 6, name: 'Health' },
				{ id: 7, name: 'Biology' },
				{ id: 8, name: 'Energy' }
			]
		};
	},
	getters: {
		getStyles(state){
			return state.styles;
		},
		getTopics(state){
			return state.topics;
		}
	},
	actions: {

	},
	mutations: {
		
	}
}

export default formModule;