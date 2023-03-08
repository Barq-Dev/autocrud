<template lang="">
    <div>
        <v-subheader>Permission List</v-subheader>
        <v-divider></v-divider>
        <v-row no-gutters>
            <v-text-field
                class="mr-2"
                v-model="filter"
                prepend-icon="filter_alt"
                label="Filter Permission"
                single-line
                hide-details
            >
            </v-text-field>

            <v-tooltip top>
                <span>{{checkedAll? 'Uncheck All!' : 'Check All!'}}</span>
                <template #activator="{on, attr}">
                    <v-btn
                    depressed
                    small
                    color="info"
                    class="mt-5 mr-2 text--white"
                    v-bind="attr"
                    v-on="on"
                    @click="checkAll"
                    >
                        <v-icon>{{checkedAll? 'close' : 'done_all'}}</v-icon>
                    </v-btn>
                </template>
            </v-tooltip>
            <v-tooltip top>
                <span>Save!</span>
                <template #activator="{on, attr}">
                    <v-btn
                    depressed
                    small
                    v-bind="attr"
                    v-on="on"
                    :loading="loading"
                    @click="save"
                    color="primary"
                    class="mt-5 text--white"
                    >
                        <v-icon>save</v-icon>            
                    </v-btn>
                </template>
            </v-tooltip>    
        </v-row>

        <v-row no-gutters>
            <v-col 
                v-for="permission in permissions"
                :key="permission.id" cols="12" sm="3" class="pa-2">
                    <v-checkbox
                        v-model="hasPermission"
                        :value="permission.id"
                        :label="permission.name"
                        :disabled="!item"
                    ></v-checkbox>
            </v-col>
        </v-row>
        
    </div>
</template>
<script>
import {mapState, mapMutations, mapActions} from 'vuex'
export default {
    data() {
        return {
            filter: '',
            data:[],
            hasPermission: [],

            form:{},
        }
    },
    mounted() {
        this.SET_MODULE_NAME("Role")
        this.load()
    },
    computed:{
        ...mapState('base', ['item','items','loading','errors']),
        checkedAll(){
            return _.difference(_.map(this.permissions, 'id'), this.hasPermission).length < 1
        },
        permissions(){
            if(this.filter)
                return _.filter(this.data,i => i.name.toLowerCase().indexOf(this.filter) > -1);
            return this.data
        },
    },
    watch:{
        item(val){
            this.hasPermission = val.permission_id
        }
    },
    methods: {
      ...mapActions('base', ['getData','saveData','deleteData']),
      ...mapMutations('base', ['SET_MODULE_NAME','DEL_ERRORS']),
      load(){
          this.$http('permissions').then(({data})=>{
              this.data = data
          })
      },
      checkAll(){
        if(this.checkedAll)
            this.hasPermission = _.difference(this.hasPermission, _.map(this.permissions, 'id'))
        else
            this.hasPermission = _.union(this.hasPermission, _.map(this.permissions, 'id'))
        },
      async save(){
          this.item.permissions = this.hasPermission
        await this.saveData({data:this.item})
        
        this.$store.dispatch('auth/auth')
      }
    }
}
</script>
<style lang="">
    
</style>