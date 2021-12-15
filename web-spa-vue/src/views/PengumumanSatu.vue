<template>
  <div>
    <v-btn color="primary" class="mb-5" @click="hapus()" v-if="this.token">
      Delete Pengumuman
    </v-btn>
    <v-card v-if="pengumuman.id">
      <v-img
        src="https://picsum.photos/200/300"
        class="white--text"
        height="400px"
      >
        <!-- <v-img
        :src="
          pengumuman.file ? pengumuman.file : 'https://picsum.photos/200/300'
        "
        class="white--text"
        height="400px"
      > -->
        <v-card-title
          class="fill-height align-end text-h2 font-weight-bold"
          v-text="pengumuman.judul"
        >
        </v-card-title>
      </v-img>

      <v-card-text>
        <v-simple-table dense>
          <tbody>
            <tr>
              <td><v-icon>mdi-format-title</v-icon> Judul</td>
              <td class="blue--text">{{ pengumuman.judul }}</td>
            </tr>
            <tr>
              <td><v-icon>mdi-note</v-icon> Deskripsi</td>
              <td>
                {{ pengumuman.deskripsi }}
              </td>
            </tr>
          </tbody>
        </v-simple-table>
        <div class="text-left pt-6 pb-2">
          <announcement-comment v-if="this.token" />
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
import AnnouncementComment from "../layouts/default/AnnouncementComment";
import { mapActions, mapGetters } from "vuex";

export default {
  data: () => ({
    pengumuman: {},
    idcom: "",
    komens: {},
    apiDomain: "http://project-webservice.herokuapp.com"
  }),

  components: {},
  computed: {
    ...mapGetters({
      token: "auth/token"
    })
  },
  components: {
    "announcement-comment": AnnouncementComment
  },
  methods: {
    ...mapActions({
      setAlert: "alert/set"
    }),
    go() {
      let { id } = this.$route.params;

      const config = {
        method: "get",
        url: `${this.apiDomain}/api/announcement/${id}`
      };

      this.axios(config)
        .then(response => {
          let { data } = response.data;
          console.log(data.file);
          this.pengumuman = data;
        })
        .catch(error => {
          console.log(error);
        });
    },
    komen() {
      let { id } = this.$route.params;

      const config = {
        method: "get",
        // url: this.apiDomain + "/api/v2/blog?page=" + this.page
        url: `${this.apiDomain}/api/announcecomment?announcement_id=${id}`
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
        url: `${this.apiDomain}/api/announcement/${id}`,
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
            text: "Berhasil Hapus Pengumuman"
          });
          this.go();
        })
        .catch(response => {
          console.log(response);
          this.setAlert({
            status: true,
            color: "error",
            text: "Gagal Hapus Pengumuman"
          });
        });
    }
    // del(komens) {
    //   let { id } = komens.id;
    //   console.log(komens.id);
    //   const config = {
    //     method: "delete",
    //     url: `${this.apiDomain}/api/announcecomment/${id}`,
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
