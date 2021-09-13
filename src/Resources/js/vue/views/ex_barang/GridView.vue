<template>
    <CardGrid :items="buku"/>
</template>
<script>
import CardGrid from '@/components/CardGrid'
export default {
  data() {
    return {
      buku: [
        {
          title: 'Laskar Pelangi',
          img: 'https://cf.shopee.co.id/file/e6ac22ce119bef2983ccaa9065956f1c',
          description: 'Cerita tentang alam',
          genres: ['Action','Crime']
        },
        {
          title: 'Api Sejarah',
          img: 'https://pbs.twimg.com/media/EHKBHDIUUAAAN8T.jpg:large',
          description: 'Buku yang sangat menginspirasi',
          genres: ['Comedy','Drama','Mystery']
        },
        {
          title: 'Catatan',
          img: 'https://pbs.twimg.com/media/EHKBHDIUUAAAN8T.jpg:large',
          description: 'Buku yang sangat menginspirasi',
          genres: ['Comedy','Drama','Mystery']
        },
        {
          title: 'Belajar Vue Js',
          img: 'https://pbs.twimg.com/media/EHKBHDIUUAAAN8T.jpg:large',
          description: 'Buku yang sangat menginspirasi',
          genres: ['Comedy','Drama','Mystery']
        },
      ]
    }
  },
  components:{
    CardGrid
  }
}
</script>