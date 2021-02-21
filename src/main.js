import { createApp } from 'vue';

// https://firebase.google.com/docs/auth/web/google-signin
// https://medium.com/@anas.mammeri/vue-2-firebase-how-to-add-firebase-social-sign-in-into-your-vue-application-21f341bbf1b
import firebase from "firebase/app";
// import "firebase/analytics";

//https://github.com/Maronato/vue-toastification/tree/next
import Toast from "vue-toastification";
// Import the CSS or use your own!
import "vue-toastification/dist/index.css";

import store from './store/index';

import router from './router';

import App from './App';

//import './registerServiceWorker'


const toastOptions = {
    transition: "Vue-Toastification__bounce",
	maxToasts: 20,
	newestOnTop: true
};

// Your web app's Firebase configuration
var firebaseConfig = {
    apiKey: "AIzaSyDkFuySyVdIFw7yrrjCU5VLT5Z1mYH24po",
    authDomain: "vuetube-305505.firebaseapp.com",
    projectId: "vuetube-305505",
    storageBucket: "vuetube-305505.appspot.com",
    messagingSenderId: "379575362506",
    appId: "1:379575362506:web:970f65fb6c4c912f9aa533",
    measurementId: "G-X9081RKYRM"
  };

firebase.initializeApp(firebaseConfig);
// firebase.analytics();

const app = createApp(App);
app.use(store);
app.use(router);
app.use(Toast, toastOptions);
app.mount('#app');