<template>
  <v-container class="ma-0 pa-0" grid-list-sm>
    <view-intro
      heading="Berita"
      link="Berisi Kumpulan Berita Terbaru Dari Desa Sukamaju"
    />

    <v-layout wrap>
      <v-flex v-for="berita in beritas" :key="`berita-` + berita.id" xs6>
        <v-card :to="'/news/' + berita.id">
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
            <v-progress-linear color="primary" height="7"> </v-progress-linear>
          </v-card-actions>

          <v-card-actions>
            <span>{{ berita.title.substring(0, 15) }}...</span>
          </v-card-actions>
        </v-card>
      </v-flex>
    </v-layout>

    <v-pagination
      v-model="page"
      @input="go"
      :length="lengthPage"
      :total-visible="perPage"
    >
    </v-pagination>

    <div class="py-3" />
  </v-container>
</template>

<script>
export default {
  name: "Berita",

  data: () => ({
    apiDomains: "http://project-webservice.herokuapp.com",
    beritas: [],
    page: 0,
    lengthPage: 0,
    perPage: 0
  }),

  methods: {
    go() {
      const config = {
        method: "get",
        url: this.apiDomain + "/api/v2/news?page=" + this.page
      };

      this.axios(config)
        .then(response => {
          let { beritas } = response.data;
          this.beritas = beritas.data;
          this.page = beritas.current_page;
          this.lengthPage = beritas.last_page;
          this.perPage = beritas.per_page;
        })
        .catch(error => {
          console.log(error);
        });
    }
  }
};
</script>
