<template>
    <v-card elevation="2">

      <DataTable :moduleName="moduleName" :headers="headers" :formData="true">

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
      moduleName: 'Pelanggan',
      headers: [
        { text: 'Nama', value: 'nama'},
        { text: 'NIK', value: 'nik' },
        { text: 'Alamat', value: 'alamat' },
        { text: 'Actions', value: 'actions', sortable: false },
      ]
    }
  }
}
</script>