<template>
  <v-app>
    <alert />
    <Dialog />
    <!-- Bar Atas -->
    <v-app-bar
      id="default-app-bar"
      app
      absolute
      class="v-bar--underline"
      color="transparent"
      :clipped-left="$vuetify.rtl"
      :clipped-right="!$vuetify.rtl"
      height="70"
      flat
    >
      <v-app-bar-nav-icon class="hidden-md-and-up" @click="drawer = !drawer" />

      <default-drawer-toggle class="hidden-sm-and-down" />

      <v-toolbar-title class="font-weight-light text-h5" v-text="name" />

      <v-spacer />

      <v-btn class="ml-2" min-width="0" text to="/" exact>
        <v-icon>mdi-home</v-icon>
      </v-btn>

      <v-menu
        bottom
        left
        min-width="200"
        offset-y
        origin="top right"
        transition="scale-transition"
      >
        <template v-slot:activator="{ attrs, on }">
          <v-btn class="ml-2" min-width="0" text v-bind="attrs" v-on="on">
            <v-icon>mdi-account</v-icon>
          </v-btn>
        </template>

        <v-list class="pa-2" v-if="guest">
          <v-btn block color="primary" class="mb-1" @click="login">
            <v-icon left>mdi-lock</v-icon>
            login
          </v-btn>
        </v-list>
        <v-list class="pa-2" v-if="!guest">
          <v-btn block color="primary" class="mb-1" @click="logout">
            <v-icon left>mdi-lock</v-icon>
            logout
          </v-btn>
        </v-list>
      </v-menu>
    </v-app-bar>

    <!-- SIDEBAR -->
    <v-navigation-drawer
      id="default-drawer"
      v-model="drawer"
      :dark="dark"
      :right="$vuetify.rtl"
      :src="drawerImage ? image : ''"
      :mini-variant.sync="mini"
      mini-variant-width="80"
      app
      width="260"
    >
      <template v-if="drawerImage" #img="props">
        <v-img :key="image" :gradient="gradient" v-bind="props" />
      </template>

      <div class="px-2">
        <v-list>
          <v-list-item v-if="!guest" class="mb-0 justify-space-between pl-3">
            <v-list-item-avatar>
              <v-img
                :src="
                  user.photo_profile
                    ? apiDomain + user.photo_profile
                    : 'https://randomuser.me/api/portraits/men/77.jpg'
                "
              ></v-img>
            </v-list-item-avatar>

            <v-list-item-content class="pl-2">
              <v-list-item-title>
                <span class="mr-1">{{ user.nama }}</span>
              </v-list-item-title>
            </v-list-item-content>
          </v-list-item>

          <div class="pa-2" v-if="guest">
            <v-btn block color="primary" class="mb-1" @click="login">
              <v-icon left>mdi-lock</v-icon>
              login
            </v-btn>
            <v-btn block color="success" @click="register">
              <v-icon left>mdi-account</v-icon>
              Register
            </v-btn>
          </div>
        </v-list>

        <v-divider class="mx-3 mb-2" />

        <default-list :items="items" />
      </div>

      <template #append v-if="!guest">
        <div class="pa-4 text-center">
          <app-btn block class="text-none" color="error" @click="logout">
            <v-icon left>
              mdi-lock
            </v-icon>

            Log Out
          </app-btn>
        </div>
      </template>

      <div class="pt-12" />
    </v-navigation-drawer>
    <default-view />
    <default-footer />
    <default-settings />
  </v-app>
</template>

<script>
import { get, sync } from "vuex-pathify";
import { mapActions, mapGetters } from "vuex";

export default {
  name: "DefaultLayout",

  components: {
    DefaultList: () => import("./List"),
    DefaultFooter: () => import("./Footer"),
    DefaultSettings: () => import("./Settings"),
    DefaultView: () => import("./View"),
    Alert: () => import("./Alert.vue"),
    DefaultDrawerToggle: () => import("./widgets/DrawerToggle"),
    Dialog: () => import("./Dialog.vue")
  },

  data: () => ({
    // guest: true,
    // menus: [
    //   { title: "Home", icon: "mdi-home", route: "/" },
    //   { title: "Berita", icon: "mdi-note", route: "/berita" },
    //   {
    //     title: "Pengumuman",
    //     icon: "mdi-clipboard-outline",
    //     route: "/pengumuman"
    //   }
    // ],
    // apiDomain: "http://localhost:8081/"
    apiDomain: "https://project-webservice.herokuapp.com"
    // apiDomain: "http://demo-api-vue.sanbercloud.com"
  }),

  methods: {
    logout() {
      let config = {
        method: "post",
        url: this.apiDomain + "/api/auth/login",
        // url: this.apiDomain + "logout",
        headers: {
          Authorization: "Bearer " + this.token
        }
      };
      this.axios(config)
        .then(() => {
          this.setToken("");
          this.setUser({});

          this.setAlert({
            status: true,
            color: "success",
            text: "Anda berhasil logout"
          });
        })
        .catch(response => {
          this.setAlert({
            status: true,
            color: "error",
            text: response.data.error
          });
        });
    },

    login() {
      this.setDialogComponent({ component: "login" });
      // this.guest = false;
    },

    register() {
      this.setDialogComponent({ component: "register" });
      // this.otp();
    },

    ...mapActions({
      setAlert: "alert/set",
      setDialogComponent: "dialog/setComponent",
      setToken: "auth/setToken",
      setUser: "auth/setUser"
      // checkToken: "auth/checkToken"
    })
  },

  computed: {
    ...mapGetters({
      guest: "auth/guest",
      user: "auth/user",
      token: "auth/token"
    }),

    ...get("user", ["dark", "gradient", "image"]),
    ...get("app", ["items", "version"]),
    ...sync("app", ["drawer", "drawerImage", "mini"]),
    name: get("route/name")
  }

  // mounted() {
  //   if (this.token) {
  //     this.checkToken(this.token);
  //   }
  // }
};
</script>
<style lang="sass">
#default-drawer
  .v-list-item
    margin-bottom: 8px

  .v-list-item::before,
  .v-list-item::after
    display: none

  .v-list-group__header__prepend-icon,
  .v-list-item__icon
    margin-top: 12px
    margin-bottom: 12px
    margin-left: 4px

  &.v-navigation-drawer--mini-variant
    .v-list-item
      justify-content: flex-start !important
</style>
