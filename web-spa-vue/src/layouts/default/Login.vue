<template>
  <v-card>
    <v-toolbar dark color="primary">
      <v-btn icon dark @click.native="close">
        <v-icon>mdi-close</v-icon>
      </v-btn>
      <v-toolbar-title>Login</v-toolbar-title>
    </v-toolbar>
    <v-divider></v-divider>
    <v-container fluid>
      <v-form ref="form">
        <v-text-field
          v-model="email"
          label="E-mail"
          required
          append-icon="mdi-email"
        ></v-text-field>
        <v-text-field
          v-model="password"
          :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
          :type="showPassword ? 'text' : 'password'"
          label="Password"
          counter
          @click:append="showPassword = !showPassword"
        ></v-text-field>

        <div class="text-xs-center">
          <v-btn color="primary lighten-1" @click="submit"
            >Login
            <v-icon right dark>mdi-lock-open</v-icon>
          </v-btn>
        </div>
      </v-form>
    </v-container>
  </v-card>
</template>

<script>
import { mapActions } from "vuex";

export default {
  data() {
    return {
      email: "",
      showPassword: false,
      password: "",
      apiDomain: "http://project-webservice.herokuapp.com"
    };
  },
  methods: {
    ...mapActions({
      setAlert: "alert/set",
      setToken: "auth/setToken"
    }),

    close() {
      this.$emit("closed", false);
    },

    submit() {
      const config = {
        method: "post",
        url: this.apiDomain + "/api/auth/login",
        data: {
          email: this.email,
          password: this.password
        }
      };

      this.axios(config)
        .then(response => {
          this.setToken(response.data.access_token);
          console.log(response.data);
          this.setAlert({
            status: true,
            color: "success",
            text: "Berhasil Login"
          });
          this.close();
        })
        .catch(response => {
          console.log(response);
          this.setAlert({
            status: true,
            color: "error",
            text: "Gagal Login"
          });
        });
    }
  }
};
</script>
