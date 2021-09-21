<template>
    <div>
        <v-row>
          <v-col cols="12" sm="6" md="12">
            <v-text-field v-model="form.name" label="Nama"></v-text-field>
          </v-col>
          <v-col cols="12" sm="6" md="12">
            <v-text-field v-model="form.email" label="Email"></v-text-field>
          </v-col>
          <v-col cols="12" sm="12" md="12">
            <v-text-field v-model="form.password" type="password" label="Password"></v-text-field>
          </v-col>
          <v-col cols="12" sm="6" md="12">
            <VFileInput :form="form" label="File Foto" />
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