import Vue from 'vue'

import VueSweetalert2 from 'vue-sweetalert2';
// @import url('sweetalert2/dist/sweetalert2.min.css'); import in app.scss
const options = {
    confirmButtonColor: '#2196f3',
    cancelButtonColor: '#ff7674',
  };
Vue.use(VueSweetalert2, options);