import { createApp } from 'vue';
import { createRouter, createWebHistory } from 'vue-router'

import store from './store/index';

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
import LoginPage from './components/Users/Login/LoginPage';
import CreateAccountPage from './components/Users/Login/CreateAccountPage';

import VueGapi from 'vue-gapi'


const router = createRouter({
	history: createWebHistory(),
	routes: [
		{ path: '/', name: "Home", component: TheChannelList },
		{ path: '/video/:videoId', name: "Video", component: VideoPage }, //props: true
		{ path: '/channel/:channelId', name: "Channel", component: ChannelPage }, //props: true
		{ path: '/account', name: "Account", component: TheAccount },
		{ path: '/login', name: "Login", component: LoginPage },
		{ path: '/createaccount', name: "Create Account", component: CreateAccountPage },
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

app.use(VueGapi, {
	apiKey: 'AIzaSyAiXvrjHqYkVxC4y1U1neEYGsTFQE2rvzY',
	clientId: '310021421846-4atakhdcfm62jj95u4193fu2ri8h9q40.apps.googleusercontent.com',
	discoveryDocs: ['https://sheets.googleapis.com/$discovery/rest?version=v4'],
	scope: 'https://www.googleapis.com/auth/spreadsheets',
})


app.component('base-button', BaseButton);
app.component('base-dialog', BaseDialog);
app.component('base-modal', BaseModal);
app.component('tabs', Tabs);

// Remove animation from route transitions
// router.isReady().then(function(){
// 	app.mount('#app');
// });

app.mount('#app');
