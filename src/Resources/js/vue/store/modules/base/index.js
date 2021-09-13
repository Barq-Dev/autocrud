import router from '@/router'
export default {
  namespaced: true,
  state: {
    moduleName: '',
    moduleUrl: '',
    loading: false,
    items: [],
    params:[],
    options: {
      page: 1,
      per_page: 10,
      q: null,
      sortby: null,
      sortbydesc: null,
    },
    total: 0,
  },
  mutations: {
      SET_MODULE_NAME(state, value){
        state.moduleName = value
        state.moduleUrl = this._vm._.kebabCase(value)
      },
      SET_OPTIONS(state, value){
        state.options.q = value.q
        state.options.page = value.page
        state.options.per_page = value.itemsPerPage
        state.options.sortby = value.sortBy && value.sortBy[0]
        state.options.sortbydesc = value.sortDesc && value.sortDesc[0]? 'desc' : 'asc'
        
      },
      SET_ITEMS(state, value){
        state.items = value
      },
      SET_TOTAL(state, value){
        state.total = value
      },
  },
  actions: {
      async getData({state, commit}, {customUrl, params} = {}){
        state.loading = true

        const {data} = await this._vm.$http(customUrl || state.moduleUrl, {
          params: {...state.options, ...params}
        })
        
        commit('SET_ITEMS', data.data)
        commit('SET_TOTAL', data.total)

        state.loading = false
      },

      async saveData({state, dispatch}, {customUrl, data}){
        state.loading = true
        
        await this._vm.$http.post(customUrl || state.moduleUrl, data)
          .then(() => {})
          .catch((error) => {
            console.log(error);
            alert('error')
          })

        dispatch('getData')
        state.loading = false
      },

      async deleteData({state, dispatch}, {customUrl, data}){
        state.loading = true

        await this._vm.$http.delete(`${customUrl || state.moduleUrl}/${data.id}`, {...data})
          .then(() => {})
          .catch((error) => {
            console.log(error);
            alert('error')
          })

        dispatch('getData')
        state.loading = false
      }
  },
}
