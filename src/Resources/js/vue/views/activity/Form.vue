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
          <v-col cols="12" sm="12" md="12">
            <v-autocomplete
              dense
              clearable
              chips
              label="Role"
              item-value="id"
              item-text="nama"
              v-model="form.role"
              :items="items"
              :error="errors.role"
              :error-messages="errors.role" 
              @input="DEL_ERRORS('role')"
            ></v-autocomplete>
          </v-col>
          <v-col cols="12" sm="6" md="12">
            <VFileInput :form="form" label="File Foto" />
          </v-col>
        </v-row>
    </div>
</template>
<script>
import VFileInput from '@/components/FormInput/VFileInput'
import {mapState, mapMutations} from 'vuex'
export default {
    props: ['form'],
    components:{
      VFileInput
    },
    data() {
      return {
        items: []
      }
    },
    computed:{
      ...mapState('base', ['errors']),
      ...mapState('auth', ['user'])
    },
    methods: {
      ...mapMutations('base',['DEL_ERRORS'])
    },
    mounted() {
      this.$http('role', {
        params:{
          all:true, pluck:['name']
        }
      })
      .then(({data}) => this.items = data)
    }
}
</script>
<style lang="">
    
</style>