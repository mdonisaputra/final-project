<template>
  <v-container fluid tag="section" class="ma-0 pa-0" grid-list-sm>
    <view-intro
      heading="Berita"
      link="Berisi Kumpulan Berita Terbaru Dari Desa Sukamaju"
    />

    <v-layout wrap>
      <berita-component
        v-for="blog in blogs"
        :key="`blog-` + blog.id"
        :blog="blog"
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

export default {
  name: "Berita",

  data: () => ({
    // apiDomains: "http://project-webservice.herokuapp.com",
    apiDomain: "http://demo-api-vue.sanbercloud.com",
    // beritas: [],
    blogs: [],
    page: 0,
    lengthPage: 0,
    perPage: 0
  }),

  components: {
    "berita-component": BeritaComponent
  },

  methods: {
    go() {
      const config = {
        method: "get",
        url: this.apiDomain + "/api/v2/blog?page=" + this.page
      };

      this.axios(config)
        .then(response => {
          let { blogs } = response.data;
          this.blogs = blogs.data;
          this.page = blogs.current_page;
          this.lengthPage = blogs.last_page;
          this.perPage = blogs.per_page;
        })
        .catch(error => {
          console.log(error);
        });
    }
  },

  created() {
    this.go();
  }
};
</script>
