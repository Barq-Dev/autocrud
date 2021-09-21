<template>
  <v-row no-gutters>
      <v-col cols="12" sm="3" class="pa-2 p-2">
        <v-card class="pa-2" outlined tile>
          <Roles />
        </v-card>
      </v-col>
      <v-col cols="12" sm="9" class="pa-2 p-2">
        <v-card class="pa-2" outlined tile>
          <Permissions />
        </v-card>
      </v-col>
    </v-row>
    <!-- <v-card elevation="2">

      <DataTable :moduleName="moduleName" :headers="headers" :formData="true" :slots="slots">

       <template #modal-form="{editedItem}">
         <ModulForm :form="editedItem" />
       </template>

       <template #avatar="{ item }">
         <v-list-item-avatar>
          <img width="50" :src="`/storage/uploads/files/${item.avatar}`" alt="Fotomu">
         </v-list-item-avatar>
        </template>

      </DataTable>

    </v-card> -->
</template>
<script>
import DataTable from '@/components/DataTable'
import ModulForm from './Form'
import Roles from './Roles'
import Permissions from './Permissions'
export default {
  components:{
    DataTable,
    ModulForm,
    Roles,
    Permissions,
  },
  data() {
    return {
      moduleName: 'Role',
      slots:['avatar'],
      headers: [
        { text: 'Avatar', value: 'avatar' },
        { text: 'Nama', value: 'name'},
        { text: 'Email', value: 'email' },
        { text: 'Actions', value: 'actions', sortable: false },
      ]
    }
  }
}
</script>