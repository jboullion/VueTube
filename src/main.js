import { createApp } from 'vue';

import "./firebase";

//https://github.com/Maronato/vue-toastification/tree/next
import Toast from "vue-toastification";
// Import the CSS or use your own!
import "vue-toastification/dist/index.css";

import store from './store/index';

import router from './router';

import "./firebase";

import App from './App';

//import './registerServiceWorker'


const toastOptions = {
    transition: "Vue-Toastification__bounce",
	maxToasts: 20,
	newestOnTop: true
};

const app = createApp(App);
app.use(store);
app.use(router);
app.use(Toast, toastOptions);
app.mount('#app');