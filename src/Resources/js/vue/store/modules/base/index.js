import router from '@/router'
export default {
  namespaced: true,
  state: {
    moduleName: '',
    moduleUrl: '',
    loading: false,
    item: {},
    items: [],
    params:[],
    options: {
      page: 1,
      per_page: 10,
      q: null,
      sortby: null,
      sortbydesc: null,
    },
    errors:{},
    total: 0,
  },
  mutations: {
      SET_MODULE_NAME(state, value){
        state.moduleName = value
        state.moduleUrl = this._vm._.kebabCase(value)
      },
      SET_OPTIONS(state, value){
        state.options = value
        state.options.q = value.q
        state.options.page = value.page
        state.options.per_page = value.itemsPerPage
        state.options.sortby = value.sortBy && value.sortBy[0]
        state.options.sortbydesc = value.sortDesc && value.sortDesc[0]? 'desc' : 'asc'
      },
      SET_ERRORS(state, value){
        state.errors = Object.assign(state.errors, value)
      },
      DEL_ERRORS(state, value){
        delete state.errors[value]
      },
      CLEAR_ERRORS(state, value){
        state.errors = {}
      },

      SET_ITEM(state, value){
        state.item = value
      },
      SET_ITEMS(state, value){
        state.items = value
      },
      SET_TOTAL(state, value){
        state.total = value
      },
  },
  actions: {
      async getData({state, commit}, {customUrl, params, id} = {}){
        state.loading = true
      
        let url = `${customUrl || state.moduleUrl}`+(id? `/${id}` : ``)
        const {data} = await this._vm.$http(url, {
          params: {...state.options, ...params}
        })
        if(id){
          commit('SET_ITEM', data)
        }
        else{
          commit('SET_ITEMS', data.data)
          commit('SET_TOTAL', data.total)
        }

        state.loading = false
      },

      async saveData({state, commit, dispatch}, {customUrl, data}){
        state.loading = true
        
        await this._vm.$http.post(customUrl || state.moduleUrl, data)
          .then(() => {
            this._vm.$swal('Success','Data has been saved','success')
            commit('CLEAR_ERRORS')
          })
          .catch(({response}) => {
            this._vm.$swal('Failed','Failed to save data','error')
            commit('SET_ERRORS', response.data)
          })
        dispatch('getData')
        state.loading = false
      },

      async deleteData({state, dispatch}, {customUrl, data}){
        state.loading = true

        await this._vm.$http.delete(`${customUrl || state.moduleUrl}/${data.id}`, {...data})
          .then(() => {
            this._vm.$swal('Success','Data has been deleted','success')
          })
          .catch((error) => {
            this._vm.$swal('Failed','Failed to delete data','error')
          })

        dispatch('getData')
        state.loading = false
      }
  },
}
