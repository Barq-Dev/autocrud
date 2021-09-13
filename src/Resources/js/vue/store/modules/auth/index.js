import router from '@/router'
export default {
  namespaced: true,
  state: {
    isAuth: localStorage.getItem('isAuth') || false,
    cancelTokens: [],
  },
  getters:{
    cancelTokens(state) {
      return state.cancelTokens
    }
  },
  mutations: {
      LOGIN(state){
        state.isAuth = true
        localStorage.setItem('isAuth', true)
      },
      LOGOUT(state){
        state.isAuth = false
        localStorage.removeItem('isAuth')
      },
      ADD_CANCEL_TOKEN(state, token) {
        state.cancelTokens.push(token)
      },
      CLEAR_CANCEL_TOKENS(state) {
        state.cancelTokens = []
      },
  },
  actions: {
      login({commit}, data){
        commit('LOGIN', data)
        router.push('/')
      },
      logout({commit}, data){
        commit('LOGOUT')
        router.push('/login')
      },
      CANCEL_PENDING_REQUESTS(context) {
        context.state.cancelTokens.forEach((request, i) => {
          if(request.cancel) request.cancel()
        })
  
        context.commit('CLEAR_CANCEL_TOKENS')
      }
  },
}
