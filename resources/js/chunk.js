window.Vue = require('vue').default;

Vue.component('admin-website-setting', () => import(/*webpackChunkName:"AdminWebsiteSetting"*/'./components/Admin/Setting/Website'));
