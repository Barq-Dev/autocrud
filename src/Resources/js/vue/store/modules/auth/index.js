import router from '@/router'
export default {
  namespaced: true,
  state: {
    user: {},
    isAuth: localStorage.getItem('isAuth') || false,
    token: localStorage.getItem('token') || '',
    cancelTokens: [],
    error: ''
  },
  getters:{
    cancelTokens(state) {
      return state.cancelTokens
    }
  },
  mutations: {
      SET_ERROR(state, value){
        state.error = value
      },
      CLEAR_ERROR(state, value){
        state.error = ''
      },
      LOGIN(state, data){
        state.isAuth = true
        localStorage.setItem('isAuth', true)
        localStorage.setItem('token', data.token)
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

        commit('CLEAR_ERROR')

        this._vm.$http.post('auth', data)
          .then((response) => {
            commit('LOGIN', response.data)
            router.push('/')
          })
          .catch(({response}) => {
            commit('SET_ERROR', response.data.error)
          })
      },
      logout({commit}, data){
        commit('LOGOUT')
        router.push('/login')
      },
      async auth({state}){
        await this._vm.$http('auth')
          .then(({data})=>{
            state.user = data
          })
      },
      CANCEL_PENDING_REQUESTS(context) {
        context.state.cancelTokens.forEach((request, i) => {
          if(request.cancel) request.cancel()
        })
  
        context.commit('CLEAR_CANCEL_TOKENS')
      }
  },
}
