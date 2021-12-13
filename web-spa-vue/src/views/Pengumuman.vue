<template>
  <v-container class="ma-0 pa-0" grid-list-sm>
    <view-intro
      heading="Pengumuman"
      link="Berisi Kumpulan Pengumuman Terbaru Dari Desa Sukamaju"
    />

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
            <v-progress-linear color="primary" height="7"> </v-progress-linear>
          </v-card-actions>

          <v-card-actions>
            <span>{{ pengumuman.title.substring(0, 15) }}...</span>
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
  name: "Pengumuman",

  data: () => ({
    apiDomains: "http://project-webservice.herokuapp.com",
    pengumumans: [],
    page: 0,
    lengthPage: 0,
    perPage: 0
  }),

  methods: {
    go() {
      const config = {
        method: "get",
        url: this.apiDomain + "/api/v2/announcements?page=" + this.page
      };

      this.axios(config)
        .then(response => {
          let { pengumumans } = response.data;
          this.pengumumans = pengumumans.data;
          this.page = pengumumans.current_page;
          this.lengthPage = pengumumans.last_page;
          this.perPage = pengumumans.per_page;
        })
        .catch(error => {
          console.log(error);
        });
    }
  }
};
</script>
