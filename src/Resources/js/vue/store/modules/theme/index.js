import router from '@/router'
export default {
  namespaced: true,
  state: {
    links:[
      { icon: 'dashboard', text:'Dashboard',route:'/' },
      { icon: 'menu_book', text:'Barang',route:'/barang' },
      { icon: 'person', text:'Pelanggan',route:'/pelanggan' },
      { icon: 'person', text:'Petugas',route:'/petugas' },
      { icon: 'local_library', text:'Transaksi',route:'/transaksi' },
      { divider: true},
      { subheader: 'Settings'},
      { icon: 'person', text:'Users',route:'/users' },
      { icon: 'admin_panel_settings', text:'Roles & Permissions',route:'/roles' },
    ],
  },
  mutations: {
      
  },
  actions: {
      
  },
}
