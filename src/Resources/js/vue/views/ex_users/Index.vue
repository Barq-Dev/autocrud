<template>
    <v-card elevation="2">

      <DataTable :moduleName="moduleName" :headers="headers">

       <template #modal-form="{editedItem}">
         <ModulForm :form="editedItem" />
       </template>

      </DataTable>

    </v-card>
</template>
<script>
import DataTable from '@/components/DataTable'
import ModulForm from './Form'
export default {
  components:{
    DataTable,
    ModulForm
  },
  data() {
    return {
      moduleName: 'Users',
      headers: [
        { text: 'Nama', value: 'name'},
        { text: 'Email', value: 'email' },
        { text: 'Actions', value: 'actions', sortable: false },
      ]
    }
  }
}
</script>