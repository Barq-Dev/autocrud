<template>
    <v-card elevation="2">

      <DataTable 
        :btnAdd="false" 
        :moduleName="moduleName" 
        :headers="headers" 
        :slots="slots"
        :params="{sortby:'created_at', sortbydesc:'desc', with:['causer','subject']}"
      >
        <template #subject="{ item }">
         Model <b>{{item.subject_type.split('\\')[2]}}</b> with id <b>{{item.subject_id}} </b><br>
        </template>

        <template #properties="{ item }">
          <template v-if="item.properties.old">
            <i  v-for="(attr, key) in item.properties.old" :key="key"><b>{{key}}</b>: {{attr}}, </i>
            <br><b>changed to:</b><br>
          </template>
          <i v-for="(attr, key) in item.properties.attributes" :key="attr"><b>{{key}}</b>: {{attr}}, </i>
        </template>

        <template #causer="{ item }">
         <b>By {{item.causer.name}} </b>
        </template>

        <template #description="{ item }">
         <v-chip
            small
            class="ma-2"
            text-color="white"
            :color="options.color[item.description]"
          >
          <v-icon left>
            {{options.icons[item.description]}}
          </v-icon>
            {{item.description}}
          </v-chip>
        </template>


      </DataTable>

    </v-card>
</template>
<script>
import DataTable from '@/components/DataTable'

export default {
  components:{
    DataTable,
  },
  data() {
    return {
      moduleName: 'Log Activity',
      slots:['subject','properties','causer','description'],
      headers: [
        { text: 'Date', value: 'created_at'},
        { text: 'Subject', value: 'subject'},
        { text: 'Data', value: 'properties'},
        { text: 'Description', value: 'description' },
        { text: 'Causer', value: 'causer'},
        { text: 'Actions', value: 'actions', sortable: false },
      ],
      options:{
        color: {
          created:'success',
          updated:'cyan',
          deleted:'pink',
        },
        icons: {
          created:'add',
          updated:'edit',
          deleted:'delete',
        },
      }
    }
  },
}
</script>