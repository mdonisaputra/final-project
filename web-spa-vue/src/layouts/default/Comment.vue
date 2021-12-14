<template>
  <v-card>
    <v-card-title
      class="d-flex justify-space-between text-h5 primary lighten-2 white--text"
    >
      Komentar
      <v-btn icon dark @click.native="close">
        <v-icon>mdi-close</v-icon>
      </v-btn>
    </v-card-title>

    <v-card-text>
      <v-form ref="form">
        <v-text-field
          v-model="isi"
          label="Komentar"
          required
          append-icon="mdi-account-edit"
        ></v-text-field>
      </v-form>
    </v-card-text>

    <v-divider></v-divider>

    <v-card-actions>
      <v-spacer></v-spacer>
      <v-btn color="primary" text @click="submit">
        Submit
      </v-btn>
    </v-card-actions>
  </v-card>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
export default {
  data() {
    return {
      isi: ""
    };
  },
  computed: {
    ...mapGetters({
      token: "auth/token"
    })
  },
  methods: {
    close() {
      this.$emit("closed", false);
    },
    ...mapActions({
      setAlert: "alert/set"
    }),

    submit() {
      const config = {
        method: "post",
        url: this.apiDomain + "/api/newscomment",
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
