import { createRouter, createWebHistory } from 'vue-router'

//import TheAdmin from './components/Admin/TheAdmin';
import TheChannelList from './components/Channel/TheChannelList';

//TODO: All these pages could be loaded async with 'defineAsyncComponent'
import AccountPage from './components/Users/AccountPage';
import VideoPage from './components/Video/VideoPage';
import ChannelPage from './components/Channel/ChannelPage';


//import LoginPage from './components/Users/Login/LoginPage';
//import CreateAccountPage from './components/Users/Login/CreateAccountPage';

// NOTE: Any negative side effects to loading these async?
// const AccountPage = () => import('./components/Users/AccountPage');
// const VideoPage = () => import('./components/Video/VideoPage');
// const ChannelPage = () => import('./components/Channel/ChannelPage');

const router = createRouter({
	history: createWebHistory(),
	routes: [
		{ path: '/', name: "Home", component: TheChannelList },
		{ path: '/video/:videoId', name: "Video", component: VideoPage }, //props: true
		{ path: '/channel/:channelId', name: "Channel", component: ChannelPage }, //props: true
		{ path: '/account', name: "Account", component: AccountPage, meta: { requiresAuth: true } },
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

// Remove animation from route transitions
// router.isReady().then(function(){
// 	app.mount('#app');
// });

export default router;