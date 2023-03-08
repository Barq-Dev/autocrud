<template>
  <div>
    <v-row>
      <v-col cols="12" sm="12" md="12">
        <TextField
          name="name"
          label="Name"
          :form="form"
          required
          autofocus
        ></TextField>
      </v-col>
      <v-col cols="12" sm="12" md="12">
        <TextField
          name="letak"
          label="Letak"
          :form="form"
          required
          autofocus
        ></TextField>
      </v-col>
      <v-col cols="12" sm="12" md="12">
        <TextField
          name="kepemilikan"
          label="Kepemilikan"
          :form="form"
          required
          autofocus
        ></TextField>
      </v-col>
      <v-col cols="12" sm="12" md="12">
        <TextField
          name="spesifikasi"
          label="Spesifikasi"
          :form="form"
          required
          autofocus
        ></TextField>
      </v-col>
      <v-col cols="12" sm="6" md="6">
        <v-text-field
          type="number"
          min="0"
          step="0.01"
          v-model="form.jumlah"
          label="Jumlah"
        ></v-text-field>
      </v-col>
      <v-col cols="12" sm="6" md="6">
        <v-text-field
          type="number"
          min="0"
          step="0.01"
          v-model="form.laik"
          label="Laik"
        ></v-text-field>
      </v-col>
      <v-col cols="12" sm="6" md="6">
        <v-text-field
          type="number"
          min="0"
          step="0.01"
          v-model="form.tidak_laik"
          label="Tidak Laik"
        ></v-text-field>
      </v-col>
    </v-row>
  </div>
</template>
<script>
import BarqunDatePicker from "@/components/FormInput/BarqunDatePicker";
import BarqunVSelect from "@/components/FormInput/BarqunVSelect";
import TextField from "@/components/FormInput/TextField";

export default {
  props: ["form", "dialog"],
  components: { BarqunDatePicker, BarqunVSelect, TextField },
  data() {
    return {
      tahun_ajaran: [],
    };
  },
};
</script>
