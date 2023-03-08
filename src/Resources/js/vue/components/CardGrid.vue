<template>
  <div>
    <v-text-field
        class="mr-2"
        v-model="search"
        append-icon="mdi-magnify"
        label="Search"
        single-line
        hide-details
      >
    </v-text-field>

    <v-row v-if="filteredData.length" class="ma-2">
      <v-card
        class="ma-3"
        v-for="(item, index) in filteredData" :key="index" 
        :loading="loading"
        max-width="22%"
      >
        <template slot="progress">
          <v-progress-linear
            color="deep-purple"
            height="10"
            indeterminate
          ></v-progress-linear>
        </template>

        <v-img
          height="250"
          :src="`/storage/uploads/foto/${item.foto}`"
        ></v-img>
        
        
        <v-card-title>{{item.title}}</v-card-title>

        <v-card-text>
          <v-row
            align="center"
            class="mx-0"
          >
            <v-rating
              :value="4.5"
              color="amber"
              dense
              half-increments
              readonly
              size="14"
            ></v-rating>

            <div class="grey--text ms-4">
              4.5 (413)
            </div>
          </v-row>

          <div class="my-4 text-subtitle-1">
            $ • Italian, Cafe
          </div>

          <div>{{item.description}}</div>
        </v-card-text>

        <v-divider class="mx-4"></v-divider>

        <v-card-text>
          <v-chip-group
            v-model="selection"
            active-class="deep-purple accent-4 white--text"
            column
          >
            <v-chip v-for="(genre, i) in item.genres" :key="i">{{genre}}</v-chip>
          </v-chip-group>
        </v-card-text>

        <v-card-actions>
          <v-btn
            class="white--text"
            color="green"
            @click="reserve"
          >
          <v-icon>shopping_bag</v-icon>
            Pinjam
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-row>

    <div v-else class="text-center mt-2">
      <img
        width="500"
        src="../assets/img/empty.png"
      >
      <h3>Tidak ada data</h3>
    </div>
    
  </div>
</template>

<script>
export default {
    props:['items'],
    data() {
        return {
            search: '',
            loading: false,
            selection:[]
        }
    },
    methods: {
      reserve(){

      }
    },

    computed:{
      filteredData(){
        
        return this.search? this.items.filter(i => i.title.toLowerCase().includes(this.search)) : this.items
      }
    }
}
</script>