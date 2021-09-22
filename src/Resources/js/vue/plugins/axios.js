import axios from 'axios'

import vm from '@/app'
import store from '@/store'
import router from '@/router'

const getToken = () => {
  const token = localStorage.getItem('token')

  return token ? `Bearer ${token}` : ''
}

const instance = axios.create({
  baseURL: '/api',
  headers: {
    'Content-Type': 'application/json',
  },
})

instance.defaults.headers.common['Authorization'] = getToken()
instance.defaults.timeout = 60000
instance.interceptors.request.use(
  config => {
    const source = axios.CancelToken.source()
    // let token = localStorage.getItem('token')

    // if (token) {
    //   config.headers['Authorization'] = `Bearer ${ token }`
    // }
    config.headers['Authorization'] = `Bearer ${ store.state.auth.token }`
    config.cancelToken = source.token
    store.commit('auth/ADD_CANCEL_TOKEN', source, {root:true})

    return config
  },
  error => Promise.reject(error)
)
instance.interceptors.response.use(
  response => response,
  error => {
    const is401 = error.response.status === 401
    
    if (is401) {
      vm.$vs.loading({ background: '#7367f0', color: 'rgb(255, 255, 255)' })
      router.replace({ name: 'login' })
    }

    return Promise.reject(error)
  }
)

export default instance
