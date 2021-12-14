<template>
  <div class="text-left">
    <v-dialog v-model="dialog" width="500">
      <template v-slot:activator="{ on, attrs }">
        <v-btn color="primary" v-bind="attrs" v-on="on" class="mb-6">
          Buat Pengumuman
        </v-btn>
      </template>

      <v-card>
        <v-card-title
          class="d-flex justify-space-between text-h5 primary lighten-2 white--text"
        >
          Buat Pengumuman
          <v-btn icon dark @click="close">
            <v-icon>mdi-close</v-icon>
          </v-btn>
        </v-card-title>
        <v-card-text>
          <div class="text-center">
            Bikin Berita Terbaru Dan Bermanfaat
          </div>
          <v-form ref="form">
            <v-text-field
              v-model="judul"
              label="Judul Pengumuman"
              required
            ></v-text-field>
            <v-text-field
              v-model="deskripsi"
              label="Deskripsi Pengumuman"
              required
            ></v-text-field>
            <v-text-field
              v-model="file"
              label="Berupa Link"
              required
            ></v-text-field>
          </v-form>
          <regotp />
        </v-card-text>

        <v-divider></v-divider>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="primary" @click="submit">
            Submit
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>
<script>
import { mapActions, mapGetters } from "vuex";

export default {
  data() {
    return {
      judul: "",
      deskripsi: "",
      file: "",
      apiDomain: "https://project-webservice.herokuapp.com",
      dialog: false
    };
  },
  computed: {
    ...mapGetters({
      token: "auth/token"
    })
  },

  methods: {
    clearform() {
      this.judul = "";
      this.deskripsi = "";
      this.file = "";
    },
    ...mapActions({
      setAlert: "alert/set"
    }),
    close() {
      this.dialog = false;
    },

    submit() {
      console.log(this.token);
      const config = {
        method: "post",
        url: this.apiDomain + "/api/announcement",
        headers: {
          Authorization: "Bearer " + this.token
        },
        data: {
          judul: this.judul,
          deskripsi: this.deskripsi,
          file: this.file
        }
      };

      this.axios(config)
        .then(response => {
          console.log(response.data);
          this.setAlert({
            status: true,
            color: "success",
            text: "Berhasil Buat Pengumuman"
          });
          this.clearform();
          this.close();
        })
        .catch(response => {
          console.log(response);
          this.setAlert({
            status: true,
            color: "error",
            text: "Gagal Buat Pengumuman"
          });
        });
    }
  }
};
</script>
