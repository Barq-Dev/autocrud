import Vue from 'vue'
import Vuex from 'vuex'
import auth from './modules/auth'
import base from './modules/base'
import theme from './modules/theme'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    errors:{

    }
  },
  mutations: {
    SET_ERRORS(state, value){
      state.errors = Object.assign(state.errors, value)
    }
  },
  actions: {
  },
  modules: {
    theme,
    auth,
    base,
  }
})
