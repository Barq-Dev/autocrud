
require('./bootstrap');

window.Vue = require('vue').default;
// import vuetify from './vuetify';
import router from './router';

Vue.component('app-component', require('./App.vue').default);


const app = new Vue({
    el: '#app',
    // vuetify,
    router
});