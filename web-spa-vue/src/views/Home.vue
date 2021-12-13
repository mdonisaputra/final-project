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
      <v-flex v-for="berita in beritas" :key="`berita-` + berita.id" xs6>
        <v-card :to="'/berita/' + berita.id">
          <v-img
            :src="
              berita.gambar
                ? apiDomain + berita.gambar
                : 'https://picsum.photos/200/300'
            "
            class="white--text"
            height="200px"
          >
            <v-card-title
              class="fill-height align-end"
              v-text="berita.title"
            ></v-card-title>
          </v-img>

          <v-card-actions>
            <v-progress-linear color="blue-grey" height="7">
            </v-progress-linear>
          </v-card-actions>

          <v-card-actions>
            <span>{{ berita.title.substring(0, 15) }}...</span>
          </v-card-actions>
        </v-card>
      </v-flex>
    </v-layout>

    <div class="d-flex justify-space-between pt-7 pb-2">
      <h2>Pengumuman Terbaru</h2>
      <v-btn to="/pengumuman" class="primary">
        Semua Pengumuman <v-icon>mdi-chevron-right</v-icon>
      </v-btn>
    </div>

    <v-layout wrap>
      <v-flex
        v-for="pengumuman in pengumumans"
        :key="`pengumuman-` + pengumuman.id"
        xs6
      >
        <v-card :to="'/announcement/' + pengumuman.id">
          <v-img
            :src="
              pengumuman.file
                ? apiDomain + pengumuman.file
                : 'https://picsum.photos/200/300'
            "
            class="white--text"
            height="200px"
          >
            <v-card-title
              class="fill-height align-end"
              v-text="pengumuman.title"
            ></v-card-title>
          </v-img>

          <v-card-actions>
            <v-progress-linear color="blue-grey" height="7">
            </v-progress-linear>
          </v-card-actions>

          <v-card-actions>
            <span>{{ pengumuman.title.substring(0, 15) }}...</span>
          </v-card-actions>
        </v-card>
      </v-flex>
    </v-layout>

    <div class="py-3" />
  </v-container>
</template>

<script>
export default {
  name: "Home",

  data: () => ({
    apiDomain: "http://project-webservice.herokuapp.com",
    beritas: [],
    pengumumans: [],
    items: [
      {
        src: "https://cdn.vuetifyjs.com/images/carousel/squirrel.jpg"
      },
      {
        src: "https://cdn.vuetifyjs.com/images/carousel/sky.jpg"
      },
      {
        src: "https://cdn.vuetifyjs.com/images/carousel/bird.jpg"
      },
      {
        src: "https://cdn.vuetifyjs.com/images/carousel/planet.jpg"
      }
    ]
  }),

  created() {
    const config = {
      method: "get",
      url: this.apiDomain + "/api/v2/new/random/2",
      url: this.apiDomain + "/api/v2/announcement/random/2"
    };

    this.axios(config)
      .then(response => {
        let { beritas } = response.data;
        this.beritas = beritas;
      })
      .catch(error => {
        console.log(error);
      });

    this.axios(config)
      .then(response => {
        let { pengumumans } = response.data;
        this.pengumumans = pengumumans;
      })
      .catch(error => {
        console.log(error);
      });
  }

  // computed: {

  // },
};
</script>
