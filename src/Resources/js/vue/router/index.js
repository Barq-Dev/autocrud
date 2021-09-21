import Vue from 'vue'
import VueRouter from 'vue-router'
import app from '@/app'
import store from '@/store'
import Dashboard from '../views/Dashboard'
import Login from '../views/auth/Login'
import Users from '../views/users/Index'
import Roles from '../views/roles/Index'
import myRoutes from './routes'

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
      path: '/users',
      name: 'users',
      component: Users,
    },
    {
      path: '/roles',
      name: 'roles',
      component: Roles,
    },
    ...myRoutes,
  ]
  
  const router = new VueRouter({
    mode: 'history',
    base: process.env.BASE_URL,
    routes
  })

  router.beforeEach(async (to, from, next) => {
    /* must call `next` */
    await store.dispatch('auth/auth')

    if(!(store.state.auth.isAuth || store.state.auth.user.id) && to.name != 'login')
      next('login')
      
    if(store.state.auth.isAuth && to.name == 'login')
      next('/')

    if(to.meta.can == undefined || app.userCan(to.meta.can))
      next()
    else
      next('/')
  })

export default router