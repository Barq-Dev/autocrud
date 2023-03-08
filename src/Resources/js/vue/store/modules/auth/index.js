import router from '@/router'
export default {
  namespaced: true,
  state: {
    user: {},
    isAuth: localStorage.getItem('isAuth') || false,
    token: localStorage.getItem('token') || '',
    cancelTokens: [],
    error: '',
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
      SET_LOADING(state, value = null){
        state.loading = value
      },
      CLEAR_ERROR(state, value){
        state.error = ''
      },
      LOGIN(state, data){
        state.isAuth = true
        localStorage.setItem('isAuth', true)
        state.token = data.token
        localStorage.setItem('token', data.token)
      },
      LOGOUT(state){
        state.isAuth = false
        localStorage.removeItem('isAuth')
        state.token = null
        localStorage.removeItem('token')
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
        commit('SET_LOADING', true)
        
        this._vm.$http.post('auth', data)
          .then(async (response) => {
            await commit('LOGIN', response.data)
            
            commit('SET_LOADING')
            router.push('/')
          })
          .catch(({response}) => {
            commit('SET_LOADING')
            commit('SET_ERROR', response.data.error)
          })
      },
      async logout({commit}, data){
        await commit('LOGOUT')
        router.push('/login')
      },
      async auth({state, dispatch}){
        await this._vm.$http('auth')
          .then(({data})=>{
            state.user = data
          })
          .catch(({response})=>{
            dispatch('logout')
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
