<template>
  <v-app>
    <Navbar v-if="$store.state.auth.isAuth" />
    
    <v-main>
      <v-container grid-list-xs>
        <v-breadcrumbs v-if="$store.state.auth.isAuth" :items="items">
          <template v-slot:divider>
            <v-icon>mdi-chevron-right</v-icon>
          </template>
        </v-breadcrumbs>
        
        <router-view></router-view>
      </v-container>
    </v-main>
    
    <Footer v-if="$store.state.auth.isAuth" />
  </v-app>
</template>

<script>
import Navbar from './layouts/Navbar'
import Footer from './layouts/Footer'
export default {
  name: 'App',
  components:{
    Navbar,
    Footer,
  },
  data() {
    return {
      items: [
        {
          text: 'Dashboard',
          disabled: false,
          href: 'dashboard',
        },
        {
          text: 'Link 1',
          disabled: false,
          href: 'breadcrumbs_link_1',
        },
        {
          text: 'Link 2',
          disabled: true,
          href: 'breadcrumbs_link_2',
        },
      ],
    }
  },
}
</script>