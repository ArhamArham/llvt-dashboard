window.Vue = require('vue').default;

Vue.component('l-input', require('./components/Partials/Input').default);
Vue.component('l-select', require('./components/Partials/Select').default);
Vue.component('l-checkbox', require('./components/Partials/Checkbox').default);

Vue.component('admin-website-setting', () => import(/*webpackChunkName:"AdminWebsiteSetting"*/'./components/Admin/Setting/Website'));
