<template>
  <div>
    <DialogKecil />
    <v-card v-if="berita.id">
      <v-img
        :src="
          berita.gambar
            ? apiDomain + berita.gambar
            : 'https://picsum.photos/200/300'
        "
        class="white--text"
        height="400px"
      >
        <v-card-title
          class="fill-height align-end text-h2 font-weight-bold"
          v-text="berita.judul"
        >
        </v-card-title>
      </v-img>

      <v-card-text>
        <v-simple-table dense>
          <tbody>
            <tr>
              <td><v-icon>mdi-format-title</v-icon> Judul</td>
              <td class="blue--text">{{ berita.judul }}</td>
            </tr>
            <tr>
              <td><v-icon>mdi-note</v-icon> Deskripsi</td>
              <td>
                {{ berita.deskripsi }}
              </td>
            </tr>
          </tbody>
        </v-simple-table>
        <div class="text-left pt-6 pb-2" v-if="!guest">
          <v-btn class="primary" @click="comment">
            <v-icon>mdi-account-edit</v-icon> Komentar
          </v-btn>
        </div>
        <comment />
      </v-card-text>
    </v-card>

    <v-card>
      <v-card-title class=" text-h5 primary white--text mt-8">
        Komentar
      </v-card-title>

      <v-card-text>
        <v-form ref="form">
          <v-text-field disabled v-model="isi" label="Komentar"></v-text-field>
        </v-form>
      </v-card-text>
    </v-card>
  </div>
</template>

<script>
import { mapActions } from "vuex";

export default {
  data: () => ({
    berita: {},
    apiDomain: "http://project-webservice.herokuapp.com"
  }),

  components: {
    DialogKecil: () => import("../layouts/default/DialogKecil.vue")
  },

  methods: {
    go() {
      let { id } = this.$route.params;

      const config = {
        method: "get",
        url: `${this.apiDomain}/api/news/${id}`
      };

      this.axios(config)
        .then(response => {
          let { data } = response.data;
          console.log(data.gambar);
          this.berita = data;
        })
        .catch(error => {
          console.log(error);
        });
    },
    comment() {
      this.setDialogComponent({ component: "comment" });
    },
    ...mapActions({
      setDialogComponent: "dialog/setComponent"
    })
  },

  created() {
    this.go();
  }
};
</script>
