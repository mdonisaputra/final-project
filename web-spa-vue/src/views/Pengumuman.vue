<template>
  <v-container fluid tag="section" class="ma-0 pa-0" grid-list-sm>
    <view-intro
      heading="Pengumuman"
      link="Berisi Kumpulan Pengumuman Terbaru Dari Desa Sukamaju"
    />
    <div class="py-3" />

    <v-layout wrap>
      <pengumuman-component
        v-for="pengumuman in pengumumans"
        :key="`pengumuman-` + pengumuman.id"
        :pengumuman="pengumuman"
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
    apiDomain: "http://project-webservice.herokuapp.com",
    pengumumans: [],
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
        // url: this.apiDomain + "/api/announcement?page=" + this.page
        url: this.apiDomain + "/api/announcement"
      };

      this.axios(config)
        .then(response => {
          let { data } = response.data;
          this.pengumumans = data;
          // this.pengumumans = data.data;
          this.page = data.current_page;
          this.lengthPage = data.last_page;
          this.perPage = data.per_page;
          console.log(this.pengumumans);
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
