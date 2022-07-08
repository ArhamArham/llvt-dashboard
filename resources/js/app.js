require('./bootstrap');

window.Vue = require('vue').default;
import CKEditor from 'ckeditor4-vue';
import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css';
import VueAlertify from "vue-alertify"
import "./chunk";

Vue.use(CKEditor);
Vue.use(VueAlertify)
Vue.component('v-select', vSelect)

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */



const app = new Vue({
    el: '#app',
});
