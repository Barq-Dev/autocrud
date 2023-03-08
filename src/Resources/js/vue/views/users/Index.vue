<template>
    <v-card elevation="2">

      <DataTable 
        @saved="saved"
        :moduleName="moduleName" 
        :headers="headers" 
        :slots="slots"
        :formData="true" 
        
      >

       <template #modal-form="{editedItem}">
         <ModulForm :form="editedItem" />
       </template>

       <template #avatar="{ item }">
         <v-list-item-avatar>
          <img width="50" :src="item.avatar_link" alt="Fotomu">
         </v-list-item-avatar>
        </template>

      </DataTable>

    </v-card>
</template>
<script>
import DataTable from '@/components/DataTable'
import ModulForm from './Form'
import {mapActions} from 'vuex'
export default {
  components:{
    DataTable,
    ModulForm
  },
  data() {
    return {
      moduleName: 'Users',
      slots:['avatar'],
      headers: [
        { text: 'Avatar', value: 'avatar' },
        { text: 'Nama', value: 'name'},
        { text: 'Email', value: 'email' },
        { text: 'Role', value: 'role' },
        { text: 'Actions', value: 'actions', sortable: false },
      ]
    }
  },
  methods: {
    ...mapActions('auth', ['auth']),
    saved(){
      this.auth()
    },
  },
}
</script>