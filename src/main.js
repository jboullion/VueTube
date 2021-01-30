import { createApp } from 'vue';
import { createRouter, createWebHistory } from 'vue-router'

import App from './App';

import BaseButton from './components/UI/BaseButton';
import BaseDialog from './components/UI/BaseDialog';
import BaseModal from './components/UI/BaseModal';
import Tabs from './components/UI/Tabs/Tabs';

import TheAdmin from './components/Admin/TheAdmin';
import TheChannelList from './components/Channel/TheChannelList';
import TheAccount from './components/Users/TheAccount';
import FullVideo from './components/Video/FullVideo';
import FullChannel from './components/Channel/FullChannel';



//import VueFormulate from '@braid/vue-formulate'

const router = createRouter({
	history: createWebHistory(),
	routes: [
		{ path: '/', name: "Home", component: TheChannelList },
		{ path: '/admin', name: "Admin", component: TheAdmin },
		{ path: '/account', name: "Account", component: TheAccount },
		{ path: '/video/:videoId', name: "Video", component: FullVideo },
		{ path: '/channel/:channelId', name: "Channel", component: FullChannel }
	]
});

const app = createApp(App);

app.component('base-button', BaseButton);
app.component('base-dialog', BaseDialog);
app.component('base-modal', BaseModal);
app.component('tabs', Tabs);

//app.use(VueFormulate);
app.use(router);
//app.use('vue-moment');


app.mount('#app');
