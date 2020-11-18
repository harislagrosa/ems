require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router';
import routes from './routes';
import Vue from 'vue';
import VueSweetalert2 from 'vue-sweetalert2';

Vue.use(VueSweetalert2);
Vue.use(VueRouter);


// Getting auth id from meta

Vue.prototype.$userId = document.querySelector("meta[name='auth_id']").getAttribute('content');

// The following block of code may be used to automatically register your
// Vue components. It will recursively scan this directory for the Vue
// components and automatically register them with their "basename".

// Vue.component('dasboard-vue', require('./components/Dashboard.vue').default);
// Vue.component('user-vue', require('./components/Users.vue').default);

const app = new Vue({
    el: '#app',
    router: new VueRouter(routes),
    data: {
        selected: 'default'
    }
});
