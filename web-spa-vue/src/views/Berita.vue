<template>
  <v-container fluid tag="section" class="ma-0 pa-0" grid-list-sm>
    <view-intro
      heading="Berita"
      link="Berisi Kumpulan Berita Terbaru Dari Desa Sukamaju"
    />
    <div class="py-3" />

    <create-news v-if="this.token" />
    <v-layout wrap>
      <berita-component
        v-for="berita in beritas"
        :key="`berita-` + berita.id"
        :berita="berita"
      ></berita-component>
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
import BeritaComponent from "../layouts/default/BeritaComponent.vue";
import CreateNews from "../layouts/default/CreateNews";
import { mapGetters } from "vuex";

export default {
  name: "Berita",

  data: () => ({
    apiDomain: "http://project-webservice.herokuapp.com",
    // apiDomain: "http://demo-api-vue.sanbercloud.com",
    beritas: [],
    page: 0,
    lengthPage: 0,
    perPage: 0
  }),

  components: {
    "berita-component": BeritaComponent,
    "create-news": CreateNews
  },

  methods: {
    go() {
      console.log(this.token);
      const config = {
        method: "get",
        // url: this.apiDomain + "/api/v2/blog?page=" + this.page
        url: this.apiDomain + "/api/news"
      };

      this.axios(config)
        .then(response => {
          let { data } = response.data;
          this.beritas = data;
          // this.beritas = data.data;
          this.page = data.current_page;
          this.lengthPage = data.last_page;
          this.perPage = data.per_page;
          console.log(this.beritas);
        })
        .catch(error => {
          console.log(error);
        });
    }
  },
  computed: {
    ...mapGetters({
      token: "auth/token"
    })
  },

  created() {
    this.go();
  }
};
</script>
