<template>
  <v-container fluid tag="section" class="ma-0 pa-0" grid-list-sm>
    <view-intro
      heading="Pengumuman"
      link="Berisi Kumpulan Pengumuman Terbaru Dari Desa Sukamaju"
    />
    <div class="py-3" />

    <v-layout wrap>
      <pengumuman-component
        v-for="blog in blogs"
        :key="`blog-` + blog.id"
        :blog="blog"
      ></pengumuman-component>
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
import PengumumanComponent from "../layouts/default/PengumumanComponent.vue";

export default {
  name: "Pengumuman",

  data: () => ({
    apiDomain: "http://demo-api-vue.sanbercloud.com",
    blogs: [],
    page: 0,
    lengthPage: 0,
    perPage: 0
  }),

  components: {
    "pengumuman-component": PengumumanComponent
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
