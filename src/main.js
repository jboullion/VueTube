import { createApp } from 'vue';
import { createRouter, createWebHistory } from 'vue-router'

//https://github.com/Maronato/vue-toastification/tree/next
import Toast from "vue-toastification";
// Import the CSS or use your own!
import "vue-toastification/dist/index.css";

// import GoogleAuth from 'vue-google-oauth'

import store from './store/index';

import App from './App';

// TODO: These could probably be loaded Async? Or at least the dialog, modal, and tabs.
import BaseButton from './components/UI/BaseButton';
import BaseDialog from './components/UI/BaseDialog';
//import BaseModal from './components/UI/BaseModal';
import Tabs from './components/UI/Tabs/Tabs';

//import TheAdmin from './components/Admin/TheAdmin';
import TheChannelList from './components/Channel/TheChannelList';

//TODO: All these pages could be loaded async with 'defineAsyncComponent'
// import AccountPage from './components/Users/AccountPage';
// import VideoPage from './components/Video/VideoPage';
// import ChannelPage from './components/Channel/ChannelPage';

//import './registerServiceWorker'

//import LoginPage from './components/Users/Login/LoginPage';
//import CreateAccountPage from './components/Users/Login/CreateAccountPage';

// NOTE: Any negative side effects to loading these async?
const AccountPage = () => import('./components/Users/AccountPage');
const VideoPage = () => import('./components/Video/VideoPage');
const ChannelPage = () => import('./components/Channel/ChannelPage');

const router = createRouter({
	history: createWebHistory(),
	routes: [
		{ path: '/', name: "Home", component: TheChannelList },
		{ path: '/video/:videoId', name: "Video", component: VideoPage }, //props: true
		{ path: '/channel/:channelId', name: "Channel", component: ChannelPage }, //props: true
		{ path: '/account', name: "Account", component: AccountPage },
		//{ path: '/login', name: "Login", component: LoginPage },
		//{ path: '/createaccount', name: "Create Account", component: CreateAccountPage },
		//{ path: '/admin', name: "Admin", component: TheAdmin },
		{ path: '/:notFound(.*)', name: "404", redirect: '/' } // 404 Error
	],
	scrollBehavior() { // to, from, savedPosition

		// Smooth scroll
		// return {
		// 	left: 0,
		// 	top: 0
		// }

		// Instant move to top ...stopped working?
		// if (to.hash) {
		// 	return {
		// 		el: to.hash,
		// 		//behavior: 'smooth',
		// 	}
		// }
		// if (to.hash) {
		// 	return {
		// 		selector: to.hash
		// 		// , offset: { x: 0, y: 10 }
		// 	}
		// }

		// Delay scroll behavior
		// return new Promise((resolve, reject) => {
		// 	setTimeout(() => {
		// 	  resolve({ left: 0, top: 0 })
		// 	}, 500)
		//   })
		
	},
});

const toastOptions = {
    transition: "Vue-Toastification__bounce",
	maxToasts: 20,
	newestOnTop: true
};

const app = createApp(App);

app.use(store);
app.use(router);

app.use(Toast, toastOptions);

// app.use(GoogleAuth, { client_id: '310021421846-4atakhdcfm62jj95u4193fu2ri8h9q40.apps.googleusercontent.com' });
// app.googleAuth().load();

app.component('base-button', BaseButton);
app.component('base-dialog', BaseDialog);
//app.component('base-modal', BaseModal);
app.component('tabs', Tabs);

// Remove animation from route transitions
// router.isReady().then(function(){
// 	app.mount('#app');
// });

app.mount('#app');
