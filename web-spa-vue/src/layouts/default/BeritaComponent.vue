<template>
  <v-flex xs6>
    <v-card :to="'/berita/' + berita.id">
      <v-img
        :src="berita.gambar ? berita.gambar : 'https://picsum.photos/200/300'"
        class="white--text"
        height="200px"
      >
        <v-card-title
          class="fill-height align-end text-h3 font-weight-bold"
          v-text="berita.judul"
        >
        </v-card-title>
      </v-img>

      <v-card-actions>
        <v-progress-linear color="primary" height="7"> </v-progress-linear>
      </v-card-actions>

      <v-card-actions>
        <span>{{ berita.deskripsi.substring(0, 15) }}...</span>
      </v-card-actions>
    </v-card>
  </v-flex>
</template>

<script>
export default {
  data: () => ({
    apiDomain: "http://project-webservice.herokuapp.com/api/news/"
  }),
  props: ["berita"]
};
</script>
