<template>
    <div>
        <v-row>
          <v-col cols="12" sm="6" md="4">
            <v-text-field outlined v-model="form.nama" label="Nama"></v-text-field>
          </v-col>
          <v-col cols="12" sm="6" md="4">
            <v-text-field outlined v-model="form.nik" label="NIK"></v-text-field>
          </v-col>
          <v-col cols="12" sm="12" md="4">
            <v-textarea outlined v-model="form.alamat" label="Alamat"></v-textarea>
          </v-col>
          <v-col cols="12" sm="12" md="4">
            <VFileInput :form="form" label="Foto" />
          </v-col>
        </v-row>
    </div>
</template>
<script>
import VFileInput from '@/components/FormInput/VFileInput'
export default {
    props: ['form'],
    components:{
      VFileInput
    }
}
</script>
<style lang="">
    
</style>