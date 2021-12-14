<template>
  <div class="text-center">
    <v-dialog v-model="dialog" width="500">
      <template v-slot:activator="{ on, attrs }">
        <v-btn color="primary" text v-bind="attrs" v-on="on">
          Update Password
        </v-btn>
      </template>

      <v-card>
        <v-card-title
          class="d-flex justify-space-between text-h5 primary lighten-2 white--text"
        >
          Update Password
          <v-btn icon dark @click="close">
            <v-icon>mdi-close</v-icon>
          </v-btn>
        </v-card-title>
        <v-card-text>
          <div class="text-center">
            Silakan Buat Password, Jika Belum Verifikasi Silahkan Verifikasi OTP
            terlebih Dahulu <otpverif />
          </div>
          <v-form ref="form">
            <v-text-field
              v-model="email"
              label="Masukkan Email"
              required
            ></v-text-field>
            <v-text-field
              v-model="password"
              :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
              :type="showPassword ? 'text' : 'password'"
              label="Masukkan Password"
              required
              @click:append="showPassword = !showPassword"
            ></v-text-field>
            <v-text-field
              v-model="password_confirmation"
              :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
              :type="showPassword ? 'text' : 'password'"
              label="Masukkan Konfirmasi Password"
              required
              @click:append="showPassword = !showPassword"
            ></v-text-field>
          </v-form>
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
import { mapActions } from "vuex";
import OtpVerif from "./OtpVerif";

export default {
  data() {
    return {
      email: "",
      password: "",
      password_confirmation: "",
      showPassword: false,
      apiDomain: "https://project-webservice.herokuapp.com",
      dialog: false
    };
  },
  components: {
    otpverif: OtpVerif
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
        url: this.apiDomain + "/api/auth/update-password",
        data: {
          email: this.email,
          password: this.password,
          password_confirmation: this.password_confirmation
        }
      };

      this.axios(config)
        .then(response => {
          console.log(response.data);
          this.setAlert({
            status: true,
            color: "success",
            text: "Berhasil Update Password, Silahkan Login"
          });
          this.clearform();
          this.close();
        })
        .catch(response => {
          console.log(response);
          this.setAlert({
            status: true,
            color: "error",
            text:
              "Gagal Update Password, Email belum terdaftar atau belum verifikasi OTP"
          });
        });
    }
  }
};
</script>
