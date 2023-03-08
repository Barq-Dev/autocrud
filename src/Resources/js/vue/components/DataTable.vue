<template>
  <v-data-table
    :show-select="showSelected"
    v-model="selected"
    :headers="headers"
    :items="items"
    :options.sync="options"
    :server-items-length="total"
    :loading="loading"
    @update:options="load"
    
    class="elevation-1"
  >
    <template v-slot:top>
      <v-toolbar flat color="white">
        <v-toolbar-title>Daftar {{moduleName}}</v-toolbar-title>
        <v-divider
          class="mx-4"
          inset
          vertical
        ></v-divider>
        <v-btn
          v-if="btnImport"
          class="mr-2"
          small
          outlined
          color="primary"
        >
        <v-icon>file_upload</v-icon>
        </v-btn>
        <v-menu
            bottom
            left
          >
            <template v-slot:activator="{ on, attrs }">
              <v-btn
                small
                
                color="primary"
                v-bind="attrs"
                v-on="on"
                v-if="userCan(`${url}-export`) && btnExport"
              >
              <v-icon>file_download</v-icon>
                Export
              </v-btn>
            </template>

            <v-list>
              <template v-for="(item) in ['excel', 'pdf']">
                <v-list-item
                  dense
                  :key="item"
                  @click="exportData(item)"
                >
                  <v-list-item-title>
                    <v-icon>fa fa-file-{{item}}</v-icon> 
                      <span>{{ _.startCase(item) }}</span>
                  </v-list-item-title>
                  
                </v-list-item>
              </template>
            </v-list>
        </v-menu>
        
        <v-spacer></v-spacer>

        <v-text-field
          class="mr-2"
          v-model="search"
          @input="handleSearch"
          append-icon="mdi-magnify"
          label="Search"
          single-line
          hide-details
        ></v-text-field>
        
        <v-dialog v-model="dialog" max-width="500px">
          <template v-slot:activator="{ on, attrs }">
            <v-btn
              v-if="btnAdd && userCan(`${url}-create`)"
              color="primary"
              dark
              small
              class="mb-2"
              v-bind="attrs"
              v-on="on"
            >
              <v-icon>add</v-icon> Add
            </v-btn>
          </template>
          <v-card>
            <v-card-title>
              <span class="headline">{{ !editedItem.id ? 'New Item' : 'Edit Item' }}</span>
            </v-card-title>

            <v-card-text>
              <v-container>
                <slot name="modal-form" :editedItem="editedItem"></slot>
              </v-container>
            </v-card-text>

            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="close">Cancel</v-btn>
              <v-btn color="blue darken-1 white--text" :loading="loading" @click="save">Save</v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
        <v-btn
          v-if="selected.length"
          outlined
          class="ml-2 mb-2"
          color="red"

          :loading="loading"
          @click="deleteItem"
        >
          <v-icon>delete</v-icon> ({{selected.length}})
        </v-btn>
        <v-btn
          outlined
          small
          class="ml-2 mb-2"
          color="primary"
          :loading="loading"
          @click="load"
        >
          <v-icon>cached</v-icon>
        </v-btn>
      </v-toolbar>
    </template>

    <template v-for="slot in slots" v-slot:[`item.${slot}`]="{item}">
      <slot :name="slot" :item="item"></slot>
    </template>

    <template v-slot:[`item.actions`]="{ item }">
      <v-icon
        small
        class="mr-2"
        v-if="userCan(`${url}-edit`)"
        @click="editItem(item)"
      >
        edit
      </v-icon>
      <v-icon
        small
        v-if="userCan(`${url}-delete`)"
        @click="deleteItem(item)"
      >
        delete
      </v-icon>
    </template>
    <template v-slot:no-data>
      <i>No Data</i>
    </template>
  </v-data-table>
</template>

<script>
import {mapActions} from 'vuex'
  export default {
    props:{
      moduleName:String,
      headers:Array,
      slots:Array,
      params:{
        type:Object,
        default: () => {}
      },
      formData:{
        type:Boolean,
        default: false
      },
      btnAdd:{
        type:Boolean,
        default: true
      },
      btnImport:{
        type:Boolean,
        default: false
      },
      btnExport:{
        type:Boolean,
        default: false
      },
      showSelected:{
        type:Boolean,
        default: true
      },
    },
    data: () => ({
      loading: false,
      selected: [],
      items: [],
      total: 0,
      search: '',
      options: {},
      errors: {},
      dialog: false,
      editedItem: {},
    }),

    computed: {
      meta(){
        return {
          ...this.options, 
          page: this.options.page,
          per_page: this.options.itemsPerPage,
          sortby: this.options.sortBy && this.options.sortBy[0],
          sortbydesc: this.options.sortDesc && this.options.sortDesc[0]? 'desc' : 'asc',
          q: this.search, 
          ...this.params
        }
      },
      url(){
        return this._.kebabCase(this.moduleName)
      },
      form(){
        if(this.formData){
          const formData = new FormData()
          for (const key in this.editedItem) {
            formData.append(key, this.editedItem[key] == null? '' : this.editedItem[key])
          }
          return formData
        }else
          return this.editedItem
      }
    },

    watch: {
      dialog (val) {
        val || this.close()
      },
    },

    methods: {
      ...mapActions('base',['getData','saveData','deleteData']),
      // ...mapMutations('base',['SET_MODULE_NAME']),
      load(){
        this.loading = true
        this.getData({customUrl: this.url, params: this.meta})
          .then((res)=>{
            this.items = res.data
            this.total = res.total
            this.loading = false
          })

      },

      async save () {
        this.loading = true
        await this.saveData({ customUrl: this.url, data: this.form, params:{noState:true} })
        this.load()
        this.$emit('saved', this.form)
        if(this._.isEmpty(this.errors))
          this.close()
      },

      editItem (item) {
        this.editedItem = Object.assign({}, item)
        this.dialog = true
      },

      async deleteItem (item) {
        this.$swal({
          title: 'Delete Item',
          text: 'Are you sure want to delete this item?',
          icon: 'warning',
          confirmButtonText: "Yes!",
          showCancelButton: true,
          showLoaderOnConfirm: true,
          preConfirm: async () => {
            this.loading = true
            await this.deleteData({
              customUrl: this.url, 
              data: item, 
              params:{
                noState:true, 
                selected: this.selected.map(i=>i.id)
              }
            })
            this.loading = false
            this.selected = []
            this.load()
          }
        })
      },

      exportData(exportType){

      },

      handleSearch: _.debounce(function (e) {
          this.load()
      }, 500),

      close () {
        this.dialog = false
        this.$nextTick(() => {
          this.editedItem = Object.assign({})
        })
      },

    },
  }
</script>