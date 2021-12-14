<template>
  <v-container fluid tag="section" class="ma-0 pa-0" grid-list-sm>
    <view-intro
      heading="Pemerintah Desa Sukamaju"
      link="Desa Sukamaju terbentuk pada tahun 1984 yang berawal Dari desa transmigrasi di Kabupaten Siak. Dikarenakan adanya bencana banjir,Desa Sukamaju dipindahkan ke Kabupaten Kuantan Singingi. Desa Sukamaju resmi membentuk pemerintahan desa pada tahun 1992 yang sebelumnya hanya dikepalai oleh KUPT atau Kepala Unit Pemukiman Transmigrasi.
      Dahulu perjalanan menuju Desa Sukamaju memakan waktu yang cukup lama dikarenakan jarak tempuh yang sangat jauh dan akses jalan yang kurang baik."
    />

    <v-carousel>
      <v-carousel-item v-for="(item, i) in items" :key="i" :src="item.src">
      </v-carousel-item>
    </v-carousel>

    <div class="d-flex justify-space-between pt-15 pb-2">
      <h2>Berita Terbaru</h2>
      <v-btn to="/berita" class="primary">
        Semua Berita <v-icon>mdi-chevron-right</v-icon>
      </v-btn>
    </div>

    <v-layout wrap>
      <berita-component
        v-for="berita in beritas"
        :key="`berita-` + berita.id"
        :berita="berita"
      ></berita-component>
    </v-layout>

    <div class="d-flex justify-space-between pt-7 pb-2">
      <h2>Pengumuman Terbaru</h2>
      <v-btn to="/pengumuman" class="primary">
        Semua Pengumuman <v-icon>mdi-chevron-right</v-icon>
      </v-btn>
    </div>

    <v-layout wrap>
      <pengumuman-component
        v-for="pengumuman in pengumumans"
        :key="`pengumuman-` + pengumuman.id"
        :pengumuman="pengumuman"
      ></pengumuman-component>
    </v-layout>

    <div class="py-3" />
  </v-container>
</template>

<script>
import BeritaComponent from "../layouts/default/BeritaComponent.vue";
import PengumumanComponent from "../layouts/default/PengumumanComponent.vue";

export default {
  name: "Home",

  components: {
    "berita-component": BeritaComponent,
    "pengumuman-component": PengumumanComponent
  },

  data: () => ({
    apiDomain: "http://project-webservice.herokuapp.com",
    beritas: [],
    pengumumans: [],
    model: 0,
    blogs: [],
    items: [
      {
        src:
          "https://images.unsplash.com/photo-1572908721147-0a9eb395762d?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxzZWFyY2h8OHx8dmlsbGFnZXxlbnwwfHwwfHw%3D&auto=format&fit=crop&w=1000&q=60"
      },
      {
        src:
          "https://images.unsplash.com/photo-1442544213729-6a15f1611937?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxzZWFyY2h8MTJ8fHZpbGxhZ2V8ZW58MHx8MHx8&auto=format&fit=crop&w=1000&q=60"
      },
      {
        src:
          "https://images.unsplash.com/photo-1592853338606-6df619d6fadd?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxzZWFyY2h8MTd8fHZpbGxhZ2V8ZW58MHx8MHx8&auto=format&fit=crop&w=1000&q=60"
      },
      {
        src:
          "https://images.unsplash.com/photo-1498122920496-ed9f9aab2051?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxzZWFyY2h8MTl8fHZpbGxhZ2V8ZW58MHx8MHx8&auto=format&fit=crop&w=1000&q=60"
      },
      {
        src:
          "https://images.unsplash.com/photo-1475332831881-e80974377cb7?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1279&q=80"
      }
    ]
  }),

  methods: {
    go() {
      const config = {
        method: "get",
        url: this.apiDomain + "/api/news"
      };

      this.axios(config)
        .then(response => {
          let { data } = response.data;
          this.beritas = data;

          console.log(this.beritas);
        })
        .catch(error => {
          console.log(error);
        });
    },
    goo() {
      const config = {
        method: "get",
        url: this.apiDomain + "/api/announcement"
      };

      this.axios(config)
        .then(response => {
          let { data } = response.data;
          this.pengumumans = data;

          console.log(this.pengumumans);
        })
        .catch(error => {
          console.log(error);
        });
    }
  },

  created() {
    console.log(this.$store.state.count);

    this.go();
    this.goo();
  }
};
</script>
