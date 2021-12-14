<template>
  <div class="text-center">
    <v-dialog v-model="dialog" width="500">
      <template v-slot:activator="{ on, attrs }">
        <v-btn color="primary" text v-bind="attrs" v-on="on">
          Verif OTP
        </v-btn>
      </template>

      <v-card>
        <v-card-title
          class="d-flex justify-space-between text-h5 primary lighten-2 white--text"
        >
          Verifikasi OTP
          <v-btn icon dark @click="close">
            <v-icon>mdi-close</v-icon>
          </v-btn>
        </v-card-title>
        <v-card-text>
          <div>
            Silakan Masukkan Kode OTP yang telah dikirim ke email anda
          </div>
          <v-form ref="form">
            <v-text-field
              v-model="otp"
              label="Silahkan Masukkan OTP"
              required
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
    </v-dialog>
  </div>
</template>
<script>
import { mapActions } from "vuex";

export default {
  data() {
    return {
      otp: "",
      apiDomain: "https://project-webservice.herokuapp.com",
      dialog: false
    };
  },
  methods: {
    clearform() {
      this.otp = "";
    },
    ...mapActions({
      setAlert: "alert/set"
    }),
    close() {
      this.dialog = false;
    },

    submit() {
      const config = {
        method: "post",
        url: this.apiDomain + "/api/auth/verification",
        data: {
          otp: this.otp
        }
      };

      this.axios(config)
        .then(response => {
          console.log(response.data);
          this.setAlert({
            status: true,
            color: "success",
            text: "Berhasil Verifikasi OTP"
          });
          this.clearform();
          this.close();
        })
        .catch(response => {
          console.log(response);
          this.setAlert({
            status: true,
            color: "error",
            text: "Gagal Verifikasi OTP"
          });
        });
    }
  }
};
</script>
