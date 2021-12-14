<template>
  <div>
    <v-btn color="primary" class="mb-5" @click="hapus()" v-if="this.token">
      Delete Berita
    </v-btn>
    <v-card v-if="berita.id">
      <v-img
        :src="berita.gambar ? berita.gambar : 'https://picsum.photos/200/300'"
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
        <div class="text-left pt-6 pb-2">
          <news-comment v-if="this.token" />
        </div>
      </v-card-text>
    </v-card>

    <v-card>
      <v-card-title class=" text-h5 primary white--text mt-8">
        Komentar
      </v-card-title>
      <div>
        <v-simple-table dense>
          <tbody>
            <tr
              v-for="komen in komens"
              :key="`komen-` + komen.id"
              :komen="komen"
            >
              <td class="d-flex justify-space-between align-center">
                {{ komen.isi }}
                <!-- <v-btn @click="del" color="primary" text>Delete</v-btn> -->
              </td>
            </tr>
          </tbody>
        </v-simple-table>
      </div>
    </v-card>
  </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import NewsComment from "../layouts/default/NewsComment";

export default {
  data: () => ({
    isi: "",
    berita: {},
    komens: {},
    apiDomain: "http://project-webservice.herokuapp.com"
  }),
  computed: {
    ...mapGetters({
      token: "auth/token"
    })
  },
  components: {
    "news-comment": NewsComment
  },

  methods: {
    ...mapActions({
      setAlert: "alert/set"
    }),
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
    komen() {
      const config = {
        method: "get",
        // url: this.apiDomain + "/api/v2/blog?page=" + this.page
        url: this.apiDomain + "/api/newscomment"
      };

      this.axios(config)
        .then(response => {
          let { data } = response.data;
          this.komens = data;
          console.log(this.komens);
        })
        .catch(error => {
          console.log(error);
        });
    },
    hapus() {
      let { id } = this.$route.params;
      console.log(this.token);

      const config = {
        method: "delete",
        url: `${this.apiDomain}/api/news/${id}`,
        headers: {
          Authorization: "Bearer " + this.token
        }
      };

      this.axios(config)
        .then(response => {
          console.log(response.data);
          this.setAlert({
            status: true,
            color: "success",
            text: "Berhasil Hapus Berita"
          });
          this.go();
        })
        .catch(response => {
          console.log(response);
          this.setAlert({
            status: true,
            color: "error",
            text: "Gagal Hapus Berita"
          });
        });
    }
    // del() {
    //   let { id } = this.$route.params;
    //   console.log(this.token);

    //   const config = {
    //     method: "delete",
    //     url: `${this.apiDomain}/api/newscomment/${id}`,
    //     headers: {
    //       Authorization: "Bearer " + this.token
    //     }
    //   };

    //   this.axios(config)
    //     .then(response => {
    //       console.log(response.data);
    //       this.setAlert({
    //         status: true,
    //         color: "success",
    //         text: "Berhasil Hapus Berita"
    //       });
    //       this.go();
    //     })
    //     .catch(response => {
    //       console.log(response);
    //       this.setAlert({
    //         status: true,
    //         color: "error",
    //         text: "Gagal Hapus Berita"
    //       });
    //     });
    // }
  },

  created() {
    this.go();
    this.komen();
  }
};
</script>
