// https://firebase.google.com/docs/auth/web/google-signin
// https://medium.com/@anas.mammeri/vue-2-firebase-how-to-add-firebase-social-sign-in-into-your-vue-application-21f341bbf1b

import firebase from "firebase/app";
import 'firebase/auth'

// Your web app's Firebase configuration
const firebaseConfig = {
	apiKey: "AIzaSyBzYZwF4Z3mErYRBOk-4UfHVMR1HgXS1Ws",
	authDomain: "vuetutorials-628fe.firebaseapp.com",
	databaseURL: "https://vuetutorials-628fe.firebaseio.com",
	projectId: "vuetutorials-628fe",
	storageBucket: "vuetutorials-628fe.appspot.com",
	messagingSenderId: "185699130941",
	appId: "1:185699130941:web:66923b2bccd7e4775d9454"
};

firebase.initializeApp(firebaseConfig);

// const firebaseAuth = firebase.auth();

// // export utils/refs
// export {
// 	firebaseAuth
// }