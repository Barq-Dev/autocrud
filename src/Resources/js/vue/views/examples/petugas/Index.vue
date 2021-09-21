<template>
    <v-card elevation="2">

      <DataTable 
        :moduleName="moduleName" 
        :headers="headers"
        :slots="slots"
        :formData="true"
      >

       <template #modal-form="{editedItem}">
         <ModulForm :form="editedItem" />
       </template>

        <template #foto="{ item }">
          <img width="50" :src="`/storage/uploads/foto/${item.foto}`" alt="Fotomu">
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
      moduleName: 'Petugas',
      slots:['foto'],
      headers: [
        { text: 'Foto', value: 'foto', sortable: false },
        { text: 'Nama', value: 'nama'},
        { text: 'NIK', value: 'nik' },
        { text: 'Jabatan', value: 'jabatan' },
        { text: 'Pendidikan', value: 'pendidikan' },
        { text: 'Actions', value: 'actions', sortable: false },
      ]
    }
  }
}
</script>