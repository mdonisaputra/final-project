<template>
  <v-container class="ma-0 pa-0" grid-list-sm>
    <div class="text-right">
      <v-btn small text to="/news" class="blue--text">
        Semua Berita <v-icon>mdi-chevron-right</v-icon>
      </v-btn>
      <br>
      <v-btn small text to="/announcements" class="blue--text">
        Semua Pengumuman <v-icon>mdi-chevron-right</v-icon>
      </v-btn>
    </div>
  
    <view-intro
      heading="Pemerintah Desa Sukamaju"
    />

    <v-layout wrap>
      <v-flex v-for="berita in beritas" :key="`berita-`+berita.id" xs6>
        <v-card :to="'/berita/'+berita.id">
          <v-img
            :src="berita.gambar ? apiDomain + berita.gambar : 'https://picsum.photos/200/300'"
            class="white--text"
            height="200px"
          >
            <v-card-title
            class="fill-height align-end"
            v-text="berita.title"
            ></v-card-title>
          </v-img>

          <v-card-actions>
            <v-progress-linear
            color="blue-grey"
            height="7">
            </v-progress-linear>
          </v-card-actions>

          <v-card-actions>
            <span>{{berita.title.substring(0,15)}}...</span>
          </v-card-actions>

        </v-card>
      </v-flex>

      <v-flex v-for="pengumuman in pengumumans" :key="`pengumuman-`+pengumuman.id" xs6>
        <v-card :to="'/announcement/'+pengumuman.id">
          <v-img
            :src="pengumuman.file ? apiDomain + pengumuman.file : 'https://picsum.photos/200/300'"
            class="white--text"
            height="200px"
          >
            <v-card-title
            class="fill-height align-end"
            v-text="pengumuman.title"
            ></v-card-title>
          </v-img>

          <v-card-actions>
            <v-progress-linear
            color="blue-grey"
            height="7">
            </v-progress-linear>
          </v-card-actions>

          <v-card-actions>
            <span>{{pengumuman.title.substring(0,15)}}...</span>
          </v-card-actions>

        </v-card>
      </v-flex>

    </v-layout>

    <div class="py-3" />

  </v-container>
</template>

<script>
  export default {
    name: 'Home',

    data:() => ({
      apiDomain: 'http://project-webservice.herokuapp.com',
      beritas: [],
      pengumumans: []
    }),

    created() {
      const config = {
        method: 'get',
        url: this.apiDomain + '/api/v2/new/random/2',
        url: this.apiDomain + '/api/v2/announcement/random/2'
      }

      this.axios(config)
        .then(response => {
          let {beritas} = response.data;
          this.beritas = beritas;
        })
        .catch(error => {
          console.log(error);
        })

      this.axios(config)
        .then(response => {
          let {pengumumans} = response.data;
          this.pengumumans = pengumumans;
        })
        .catch(error => {
          console.log(error);
        });
    }

    // computed: {

    // },
  }
</script>
