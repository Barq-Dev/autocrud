<template>
  <v-data-table
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
        
        <v-menu
            bottom
            left
          >
            <template v-slot:activator="{ on, attrs }">
              <v-btn
                small
                rounded
                color="primary"
                v-bind="attrs"
                v-on="on"
              >
              <v-icon>file_download</v-icon>
                Export
              </v-btn>
            </template>

            <v-list>
              <v-list-item
                dense
                v-for="(item) in ['excel', 'pdf']"
                :key="item"
                @click="exportData(item)"
              >
                <v-list-item-title>
                  <v-icon>fa fa-file-{{item}}</v-icon> 
                    <span>{{ _.startCase(item) }}</span>
                </v-list-item-title>
                
              </v-list-item>
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
              outlined
              class="ml-2 mb-2"
              color="primary"

              :loading="loading"
              @click="load"
            >
              <v-icon>cached</v-icon>
            </v-btn>
            <v-btn
              v-if="btnAdd"
              color="primary"
              dark
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
      </v-toolbar>
    </template>

    <template v-for="slot in slots" v-slot:[`item.${slot}`]="{item}">
      <slot :name="slot" :item="item"></slot>
    </template>

    <template v-slot:[`item.actions`]="{ item }">
      <v-icon
        small
        class="mr-2"
        @click="editItem(item)"
      >
        edit
      </v-icon>
      <v-icon
        small
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
import {mapState, mapMutations, mapActions} from 'vuex'
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
    },
    data: () => ({
      search: '',
      options: {},
      dialog: false,
      editedItem: {},
    }),

    created() {
      this.SET_MODULE_NAME(this.moduleName)
    },

    computed: {
      ...mapState('base', ['loading','items','total','errors']),
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
      ...mapMutations('base',['SET_OPTIONS','SET_MODULE_NAME']),
      load(){
        this.SET_OPTIONS({...this.options, q: this.search, ...this.params})
        
        this.getData({params: this.params})
      },

      async save () {
        await this.saveData({data: this.form})
        this.$emit('saved', this.form)
        if(this._.isEmpty(this.errors))
          this.close()
      },

      editItem (item) {
        this.editedItem = Object.assign({}, item)
        this.dialog = true
      },

      deleteItem (item) {
        confirm('Are you sure you want to delete this item?') && 
          this.deleteData({data: item})
        
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