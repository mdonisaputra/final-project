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
export default {
    data(){
        return {
            email : '',
            showPassword: false,
            password: '',
        }
    },
    methods : {
        close() {
            this.$emit('closed', false)
        },

        submit() {
            alert('masuk metod register')
        }

    },
}
</script>