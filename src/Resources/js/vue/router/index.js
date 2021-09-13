import Vue from 'vue'
import VueRouter from 'vue-router'
import store from '@/store'
import Dashboard from '../views/Dashboard'
import Login from '../views/auth/Login'
import Pelanggan from '../views/ex_pelanggan/Index'
import Users from '../views/ex_users/Index'

Vue.use(VueRouter)

const routes = [
    {
      path: '/',
      name: 'dashboard',
      component: Dashboard,
    },
    {
      path: '/login',
      name: 'login',
      component: Login,
    },
    {
      path: '/pelanggan',
      name: 'pelanggan',
      component: Pelanggan,
    },
    {
      path: '/users',
      name: 'users',
      component: Users,
    },
  ]
  
  const router = new VueRouter({
    mode: 'history',
    base: process.env.BASE_URL,
    routes
  })

  router.beforeEach((to, from, next) => {
    /* must call `next` */
    if(!store.state.auth.isAuth && to.name != 'login')
      next('login')

    if(store.state.auth.isAuth && to.name == 'login')
      next('/')

    next()
  })

export default router