import Pelanggan from '../views/examples/pelanggan/Index'
import Barang from '../views/examples/barang/Index'
import Transaksi from '../views/examples/transaksi/Index'
import Petugas from '../views/examples/petugas/Index'

const routes = [
    {
        path: '/pelanggan',
        name: 'pelanggan',
        component: Pelanggan,
      },
      {
        path: '/barang',
        name: 'barang',
        component: Barang,
      },
      {
        path: '/transaksi',
        name: 'transaksi',
        component: Transaksi,
      },
      {
        path: '/petugas',
        name: 'petugas',
        component: Petugas,
        meta:{
          can: 'petugas-manage'
        }
      },
]

export default routes