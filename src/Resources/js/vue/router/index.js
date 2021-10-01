import Vue from 'vue'
import VueRouter from 'vue-router'
import app from '@/app'
import store from '@/store'
import Dashboard from '../views/Dashboard'
import Login from '../views/auth/Login'
import Users from '../views/users/Index'
import Activity from '../views/activity/Index'
import Roles from '../views/roles/Index'
import myRoutes from './routes'

Vue.use(VueRouter)

const routes = [
    {
      path: '/login',
      name: 'login',
      component: Login,
    },
    {
      path: '/',
      name: 'dashboard',
      component: Dashboard,
      meta:{
        breadcrumbs:[
          { text: 'Dashboard', disabled: false},
        ]
      }
    },
    {
      path: '/users',
      name: 'users',
      component: Users,
      meta:{
        breadcrumbs:[
          { text: 'Dashboard', to:'/'},
          { text: 'Users', disabled: false},
        ]
      }
    },
    {
      path: '/roles',
      name: 'roles',
      component: Roles,
      meta:{
        breadcrumbs:[
          { text: 'Dashboard', to:'/'},
          { text: 'Roles', disabled: false},
        ]
      }
    },
    {
      path: '/log-activity',
      name: 'log-activity',
      component: Activity,
      meta:{
        breadcrumbs:[
          { text: 'Dashboard', to:'/'},
          { text: 'Activity Log', disabled: false},
        ]
      }
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
    if(store.state.auth.token)
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