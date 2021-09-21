<template>
    <v-card
    elevation="2"
    >

      <DataTable 
        title="Daftar Transaksi"
        :headers="headers"
        :items="items"
       >
       
       <template #modal-form="{editedItem}">
         <v-row>
          <v-col cols="12" sm="6" md="4">
            <v-text-field v-model="editedItem.nama" label="Nama"></v-text-field>
          </v-col>
          <v-col cols="12" sm="6" md="4">
            <v-text-field v-model="editedItem.no_hp" label="No Hp"></v-text-field>
          </v-col>
          <v-col cols="12" sm="12" md="4">
            <v-text-field v-model="editedItem.email" label="Email"></v-text-field>
          </v-col>
        </v-row>
       </template>

      </DataTable>

    </v-card>
</template>
<script>
import DataTable from '@/components/DataTable'
export default {
  components:{
    DataTable
  },
  data() {
    return {
      headers: [
        { text: 'Nama', value: 'nama'},
        { text: 'No Hp', value: 'no_hp' },
        { text: 'Email', value: 'email' },
        { text: 'Actions', value: 'actions', sortable: false },
      ],
      items: []
    }
  },
  created () {
    this.initialize()
  },
  methods: {
    initialize () {
        this.items = [
          {
            nama: 'Fikri',
            no_hp: '0822828111',
            email: 'fikri@gmail.com',
          },
          {
            nama: 'Saif',
            no_hp: 237,
            email: 9.0,
          },
          {
            nama: 'Rifki',
            no_hp: 262,
            email: 16.0,
          },
        ]
      },
  },
}
</script>
<style>
    
</style>