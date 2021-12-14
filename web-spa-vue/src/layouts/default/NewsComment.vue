<template>
  <div class="text-left">
    <v-dialog v-model="dialog" width="500">
      <template v-slot:activator="{ on, attrs }">
        <v-btn color="primary" v-bind="attrs" v-on="on" class="mb-6">
          Komentar
        </v-btn>
      </template>

      <v-card>
        <v-card-title
          class="d-flex justify-space-between text-h5 primary lighten-2 white--text"
        >
          Komentar
          <v-btn icon dark @click="close">
            <v-icon>mdi-close</v-icon>
          </v-btn>
        </v-card-title>
        <v-card-text>
          <div class="text-center">
            Komentari Berita
          </div>
          <v-form ref="form">
            <v-text-field
              v-model="isi"
              label="Isi Komentar"
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
import { mapGetters, mapActions } from "vuex";
export default {
  data() {
    return {
      isi: "",
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
    close() {
      this.dialog = false;
    },
    ...mapActions({
      setAlert: "alert/set"
    }),
    clearform() {
      this.isi = "";
    },

    submit() {
      let { id } = this.$route.params;
      console.log(this.token);
      console.log(this.id);
      const config = {
        method: "post",
        url: `${this.apiDomain}/api/newscomment?new_id=${id}`,
        headers: {
          Authorization: "Bearer " + this.token
        },
        data: {
          isi: this.isi
        }
      };

      this.axios(config)
        .then(response => {
          console.log(response.data);
          this.setAlert({
            status: true,
            color: "success",
            text: "Berhasil komen"
          });
          this.clearform();
          this.close();
        })
        .catch(response => {
          console.log(response);
          this.setAlert({
            status: true,
            color: "error",
            text: "Gagal Komen"
          });
        });
    }
  }
};
</script>
