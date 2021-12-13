<template>
    <v-card>
        <v-toolbar dark color="primary">
            <v-btn icon dark @click.native="close">
                <v-icon>mdi-close</v-icon>
            </v-btn>
            <v-toolbar-title>Register</v-toolbar-title>
        </v-toolbar>
    <v-divider></v-divider>
    <v-container fluid>
        <v-form ref="form">
            <v-text-field
            v-model="nama"
            label="Nama"
            required
            append-icon="mdi-account-edit"
            ></v-text-field>
            <v-text-field
            v-model="username"
            label="Username"
            required
            append-icon="mdi-account-key"
            ></v-text-field>
            <v-text-field
            v-model="email"
            label="E-mail"
            required
            append-icon="mdi-email"
            ></v-text-field>



            <div class="text-xs-center">
                <v-btn
                color="primary lighten-1"
                @click="submit"
                >Register
                </v-btn>
            </div>
        </v-form>
    </v-container>



    </v-card>
</template>

<script>
import { mapActions } from 'vuex'

export default {
    data(){
        return {
            nama: '',
            username: '',
            email : ''
        }
    },
    methods : {
        ...mapActions({
            setAlert: 'alert/set',
            setToken: 'auth/setToken'
        }),

        close() {
            this.$emit('closed', false)
        },

        submit() {
            const config = {
                method: "post",
                url: this.apiDomain + "/api/v2/auth/register",
                data: {
                    'email' : this.email,
                    'nama' : this.nama,
                    'username' : this.username
                }
            };

            this.axios(config)
                .then((response) => {
                    this.setToken(response.data.access_token)
                    console.log(response.data)
                    this.setAlert({
                        status: true,
                        color: 'success',
                        text: 'Berhasil Register',
                    })
                    this.close()
                })
                .catch((response) => {
                    console.log(response)
                    this.setAlert({
                        status: true,
                        color: 'error',
                        text: 'Gagal Register',
                    })
                })
        }

    },
}
</script>