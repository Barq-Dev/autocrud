<template>
    <div>
      <v-row no-gutters>
        <v-subheader>Role List</v-subheader>
        <v-spacer></v-spacer>
        <v-dialog v-model="dialog" max-width="500px">
          <template v-slot:activator="{ on, attrs }">
            <v-btn 
              small depressed 
              :loading="loading"
              v-bind="attrs"
              v-on="on"
              color="primary" 
              class="mt-2">
              <v-icon>add</v-icon>
            </v-btn>
          </template>
          <v-card>
            <v-card-title>
              <span class="headline">{{ !form.id ? 'New Item' : 'Edit Item' }}</span>
            </v-card-title>

            <v-card-text>
              <v-container>
                <v-row>
                  <v-col cols="12" sm="12" md="12">
                    <v-text-field 
                      label="Nama"
                      v-model="form.name" 
                      :error-messages="errors.role" 
                      @input="DEL_ERRORS('role')"
                      @keyup.enter="save"
                      ></v-text-field>
                  </v-col>
                </v-row>
              </v-container>
            </v-card-text>

            <v-card-actions>
              <v-btn v-if="form.id" color="red darken-1" text :loading="loading" @click="remove">Remove</v-btn>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="close">Cancel</v-btn>
              <v-btn color="blue darken-1 white--text" :loading="loading" @click="save">Save</v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
      </v-row>
      <v-divider></v-divider>
      <v-text-field
          class="mr-2 pl-3"
          @input="search"
          append-icon="mdi-magnify"
          label="Search"
          single-line
          hide-details
      ></v-text-field>
      <v-list rounded>
        <v-list-item-group
          v-model="selectedItem"
          color="primary"
        >
          <v-list-item
            v-for="(item, i) in items"
            :key="i"
            @click="getData({id: item.id})"
          >
            <v-list-item-content>
              <h5>{{_.upperFirst(item.name)}}</h5>
            </v-list-item-content>
            <v-icon v-if="selectedItem == i" small right @click="edit(item)">edit</v-icon>
          </v-list-item>
          <v-list-item v-if="!items.length">
            <i class="muted">No data.</i>
          </v-list-item>
        </v-list-item-group>
      </v-list>
    </div>
</template>
<script>
import {mapState, mapMutations, mapActions} from 'vuex'
export default {
    data() {
        return {
            selectedItem: null,
            dialog: false,
            form:{},
            
        }
    },
    mounted() {
      this.SET_MODULE_NAME("Role")
      this.getData()
    },
    computed:{
      ...mapState('base', ['items','loading','errors']),
    },
    watch:{
      dialog(val){
        if(!val)
          this.close()
      }
    },
    methods: {
      ...mapActions('base', ['getData','saveData','deleteData']),
      ...mapMutations('base', ['SET_MODULE_NAME','DEL_ERRORS']),
      async save(){
        await this.saveData({data:this.form})
        
        if(!this.errors.role)
          this.close()
        
      },
      edit(item){
        this.dialog = true
        this.form = item
      },
      async remove(){
        await this.deleteData({data:this.form})

        if(!this.errors.role)
          this.close()
      },
      search: _.debounce(function (e) {
          this.getData({params:{q:e}})
      }, 500),
      close(){
        this.dialog = false
        this.$nextTick(() => {
          this.form = Object.assign({})
        })
      }
    },
    
}
</script>
<style lang="">
    
</style>