// Vue
import Vue from 'vue'
import Vuex from 'vuex'
import pathify from '@/plugins/vuex-pathify'
import dialog from './dialog'
import alert from './alert'

// Modules
// import * as modules from './modules'

Vue.use(Vuex)

const store = new Vuex.Store({
  modules: {
    dialog,
    alert,
  },
  plugins: [
    pathify.plugin,
  ],
})

store.subscribe(mutation => {
  if (!mutation.type.startsWith('user/')) return

  store.dispatch('user/update', mutation)
})

store.dispatch('app/init')

export default store

export const ROOT_DISPATCH = Object.freeze({ root: true })
