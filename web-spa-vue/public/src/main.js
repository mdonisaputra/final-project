import Vue from 'vue'
import App from './App.vue'
import router from './router'
import vuetify from './plugins/vuetify'
import './plugins'
import store from './store'
import { sync } from 'vuex-router-sync'
import axios from './plugins/axios';

Vue.config.productionTip = false

sync(store, router)

new Vue({
  router,
  vuetify,
  axios,
  store,
  render: h => h(App),
}).$mount('#app')
