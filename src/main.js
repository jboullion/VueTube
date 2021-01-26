import { createApp } from 'vue';

import App from './App';

// import { VuelidatePlugin } from "@vuelidate/core"; 

import BaseButton from './components/UI/BaseButton';
import BaseDialog from './components/UI/BaseDialog';
import BaseModal from './components/UI/BaseModal';
import Tabs from './components/UI/Tabs/Tabs';

import { VuelidatePlugin } from '@vuelidate/core'

//import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'

//import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
//import { FontAwesomeIcon } from "@/plugins/font-awesome";

//import router from "./router";
//import store from "./store";

//Vue.component('font-awesome-icon', FontAwesomeIcon)

//Vue.config.productionTip = false

const app = createApp(App);

app.component('base-button', BaseButton);
app.component('base-dialog', BaseDialog);
app.component('base-modal', BaseModal);
app.component('tabs', Tabs);

app.use(VuelidatePlugin);

//.component("bsv", BootstrapVue)
//.component("bsi", IconsPlugin)
//.component("fa", FontAwesomeIcon)

app.mount('#app');
