import { createApp } from 'vue';
import { createStore } from 'vuex';
import { createRouter, createWebHistory } from 'vue-router'

import App from './App';

import BaseButton from './components/UI/BaseButton';
import BaseDialog from './components/UI/BaseDialog';
import BaseModal from './components/UI/BaseModal';
import Tabs from './components/UI/Tabs/Tabs';

import TheAdmin from './components/Admin/TheAdmin';
import TheChannelList from './components/Channel/TheChannelList';
import TheAccount from './components/Users/TheAccount';
import VideoPage from './components/Video/VideoPage';
import ChannelPage from './components/Channel/ChannelPage';




const store = createStore({
	state() {
		return {
			
		};
	}
});



const router = createRouter({
	history: createWebHistory(),
	routes: [
		{ path: '/', name: "Home", component: TheChannelList },
		{ path: '/video/:videoId', name: "Video", component: VideoPage }, //props: true
		{ path: '/channel/:channelId', name: "Channel", component: ChannelPage }, //props: true
		{ path: '/account', name: "Account", component: TheAccount },
		{ path: '/admin', name: "Admin", component: TheAdmin },
		{ path: '/:notFound(.*)', name: "404", redirect: '/' } // 404 Error
	],
	scrollBehavior(to) { // to, from, savedPosition

		// Smooth scroll
		// return {
		// 	left: 0,
		// 	top: 0
		// }

		// Instant move to top
		if (to.hash) {
			return {
				el: to.hash,
				//behavior: 'smooth',
			}
		}

		// Delay scroll behavior
		// return new Promise((resolve, reject) => {
		// 	setTimeout(() => {
		// 	  resolve({ left: 0, top: 0 })
		// 	}, 500)
		//   })
		
	},
});

const app = createApp(App);

app.use(store);
app.use(router);

app.component('base-button', BaseButton);
app.component('base-dialog', BaseDialog);
app.component('base-modal', BaseModal);
app.component('tabs', Tabs);

// Remove animation from route transitions
// router.isReady().then(function(){
// 	app.mount('#app');
// });

app.mount('#app');
