<template>
  <div class="text-left">
    <v-dialog v-model="dialog" width="500">
      <template v-slot:activator="{ on, attrs }">
        <v-btn x-small color="primary" text v-bind="attrs" v-on="on">
          Regenerate Otp
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
          <div class="text-center">
            Silakan Masukkan email anda
          </div>
          <v-form ref="form">
            <v-text-field
              v-model="email"
              label="Masukkan Email"
              required
              append-icon="mdi-email"
            ></v-text-field>
            <!-- <v-text-field
              v-model="otp"
              label="Masukkan OTP Lama"
              required
            ></v-text-field> -->
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
      email: "",
      // otp: "",
      apiDomain: "https://project-webservice.herokuapp.com",
      dialog: false
    };
  },
  methods: {
    clearform() {
      this.email = "";
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
        url: this.apiDomain + "/api/auth/regenerate-otp-code",
        data: {
          email: this.email
        }
      };

      this.axios(config)
        .then(response => {
          console.log(response.data);
          this.setAlert({
            status: true,
            color: "success",
            text: "Berhasil Regenerate OTP, Silahkan Verifikasi OTP"
          });
          this.clearform();
          this.close();
        })
        .catch(response => {
          console.log(response);
          this.setAlert({
            status: true,
            color: "error",
            text: "Email Belum Terdaftar"
          });
        });
    }
  }
};
</script>
