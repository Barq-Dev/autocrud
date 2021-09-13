<template>
    <div>
        <v-row>
          <v-col cols="12" sm="6" md="4">
            <v-text-field v-model="form.nama" label="Nama"></v-text-field>
          </v-col>
          <v-col cols="12" sm="6" md="4">
            <v-text-field v-model="form.no_hp" label="No Hp"></v-text-field>
          </v-col>
          <v-col cols="12" sm="12" md="4">
            <v-text-field v-model="form.email" label="Email"></v-text-field>
          </v-col>
        </v-row>
    </div>
</template>
<script>
export default {
    props: ['form']
}
</script>
<style lang="">
    
</style>