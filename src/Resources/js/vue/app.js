window.Vue = require('vue').default;
import _ from 'lodash'
import axios from "./axios.js"
import vuetify from './vuetify';
import router from './router';
import store from './store';
import App from '@/App.vue'

Vue.prototype.$http = axios
Vue.prototype._ = _

const app = new Vue({
    vuetify,
    router,
    store,
    render: h => h(App)
}).$mount('#app')

export default app