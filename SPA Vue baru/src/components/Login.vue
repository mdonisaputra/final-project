<template>
  
  <v-card>
        <v-toolbar dark color="success">
            <v-btn icon dark @click.native="close">
                <v-icon> mdi-close</v-icon>
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
                append-icon="mdi-email">
            </v-text-field>
            <v-text-field
                v-model="password"
                :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                :type="showPassword ? 'text' : 'password'"
                label="Password"
                counter
                @click:append="showPassword = !showPassword">
            </v-text-field>

            <div class="text-xs-center">
                <v-btn
                color="success lighten-1"
                @click="submit">
                Login
                <v-icon right dark>mdi-lock-open</v-icon>
                </v-btn>
            </div>
        </v-form>
    </v-container>
    </v-card>

</template>

<script>
import github from "@/assets/img/github.svg";
import google from "@/assets/img/google.svg";

export default {
  data() {
    return {
      github,
      google,
      email: '',
      showPassword: false,
      password: '',
    };
  },
   methods: {
        close(){
            this.$emit('closed', false)
        },

        submit(){
          alert('Anda berhasil login')
        }
    },
};
</script>
