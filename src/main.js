import { createApp } from 'vue';

import App from './App';

import BaseButton from './components/UI/BaseButton';

//import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'

//import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
//import { FontAwesomeIcon } from "@/plugins/font-awesome";

//import router from "./router";
//import store from "./store";

//Vue.component('font-awesome-icon', FontAwesomeIcon)

//Vue.config.productionTip = false

const app = createApp(App);

app.component('base-button', BaseButton);
//.component("bsv", BootstrapVue)
//.component("bsi", IconsPlugin)
//.component("fa", FontAwesomeIcon)

app.mount('#app');
