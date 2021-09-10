import Vue from 'vue'
import VueRouter from 'vue-router'
import App from '../App.vue'
import Dashboard from '../views/Dashboard'

Vue.use(VueRouter)

const routes = [
    {
      path: '/',
      name: 'App',
      component: App,
      children:[
        {
          path: '/',
          name: 'dashboard',
          component: Dashboard,
        },
      ]
    },
  ]
  
  const router = new VueRouter({
    mode: 'history',
    base: process.env.BASE_URL,
    routes
  })

export default router