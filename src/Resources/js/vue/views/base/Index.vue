<template>
  <v-card elevation="2">
    <DataTable v-bind="datatable">
      <template #modal-form="{ editedItem, save, dialog }">
        <ModulForm :form="editedItem" @save="save" :dialog="dialog" />
      </template>
    </DataTable>
  </v-card>
</template>
<script>
import DataTable from "@/components/DataTable";
import ModulForm from "./Form";
export default {
  components: {
    DataTable,
    ModulForm,
  },
  data() {
    return {
      datatable: {
        moduleName: "#MODULE#",
        formData: true,
        headers: [
          { text: "ID", value: "id" },
          {
            text: "Actions",
            value: "actions",
            align: "center",
            sortable: false,
          },
        ],
      },
    };
  },
};
</script>