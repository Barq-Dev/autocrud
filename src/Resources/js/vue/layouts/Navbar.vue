<template>
    <nav>
        <v-app-bar color="blue" dark app>
            <v-app-bar-nav-icon @click.stop="drawer = !drawer"> </v-app-bar-nav-icon>

            <v-toolbar-title class="text-uppercase">
                <router-link
                    to="/"
                    class="text-decoration-none white--text"
                    >
                    <span class="font-weight-light">BASE </span>
                    <span>X</span>
                </router-link>
            </v-toolbar-title>

            <v-spacer></v-spacer>

            <v-menu offset-y>
                <template v-slot:activator="{on}">
                    <v-btn text v-on="on">
                        <v-icon left>expand_more</v-icon>
                        <span>Menu</span>
                    </v-btn>
                </template>
                <v-list flat>
                    <v-list-item v-for="link in links" :key="link.text" router :to="link.route" active-class="border">
                        <v-list-item-title> {{ link.text }} </v-list-item-title>
                    </v-list-item>
                </v-list>
            </v-menu>

            <!-- <v-btn text to="/login" >
                <span>Login</span>
                <v-icon right>lock</v-icon>
            </v-btn> -->

            <v-btn text @click="logout">
                <span>Exit</span>
                <v-icon right>exit_to_app</v-icon>
            </v-btn>

        </v-app-bar>

        <v-navigation-drawer v-model="drawer" dark app class="blue darken-4"
            
        >
            <v-layout column align-center>
                <v-flex class="mt-5">
                    <v-avatar
                        size="100"
                        color="red"
                    >
                        <img src="https://pbs.twimg.com/profile_images/1197759599224320000/VVApPxap_400x400.jpg" alt="alt">
                    </v-avatar>
                    <p class="white--text subheading mt-1 text-center">Username</p>
                </v-flex>
                
            </v-layout>
            <v-divider></v-divider>
            <v-list flat>
                <v-list-item v-for="link in links" :key="link.text" router :to="link.route" active-class="border">
                    <v-list-item-action>
                        <v-icon>{{link.icon}}</v-icon>
                    </v-list-item-action>
                    <v-list-item-content>
                        <v-list-item-title> {{link.text}} </v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <v-divider></v-divider>
                <v-subheader>Settings</v-subheader>
                <v-list-item router to="/users" active-class="border">
                    <v-list-item-action>
                        <v-icon>person</v-icon>
                    </v-list-item-action>
                    <v-list-item-content>
                        <v-list-item-title> Users </v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </v-list>
        </v-navigation-drawer>

    </nav>
</template>
<script>
import {mapState, mapActions} from 'vuex'

export default {
    data() {
        return {
            drawer: true,
            links: [
                { icon: 'dashboard', text:'Dashboard',route:'/' },
                { icon: 'menu_book', text:'Barang',route:'/barang' },
                { icon: 'person', text:'Pelanggan',route:'/pelanggan' },
                { icon: 'local_library', text:'Transaksi',route:'/transaksi' },
            ]
        }
    },
    computed:{
        // ...mapState(['isAuth'])
    },
    methods: {
        ...mapActions('auth',['logout'])
    },
}
</script>

<style scoped>
.border{
    border-left: 4px solid#3490dc;
}
</style>