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
export default {
  data() {
    return {
      isi: ""
    };
  },
  methods: {
    close() {
      this.$emit("closed", false);
    },

    submit() {
      alert("masuk metod komen");
    }
  }
};
</script>
