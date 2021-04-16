import Vue from 'vue'
import App from './App.vue'

//Routes import
import router from './router'
//Vuex import
import store from './store'
//vuetify import
import vuetify from './plugins/vuetify'

import Vuex from 'vuex'
Vue.use(Vuex)

// bootstrap-vue
import {
  BootstrapVue,
  IconsPlugin
} from 'bootstrap-vue'

Vue.use(BootstrapVue)
// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin)

import Echo from 'laravel-echo'
window.Pusher = require('pusher-js')

// This assumes you have already saved your bearer token in your browsers local storage
// const token = localStorage.getItem('authToken');

window.Echo = new Echo({
  broadcaster: 'pusher',
  key: "websocketkey",
  // cluster: 'mt1',
  authEndpoint: 'http://localhost:8000/api/broadcast',
  // authHost: "http://localhost",
  // authEndpoint: "/broadcasting/auth",
  // authEndpoint: 'http://127.0.0.1/public/broadcasting/auth',
  encrypted: true,
  forceTLS: false,
  wsHost: window.location.hostname,
  wsPort: 6001,
  // wssPort: 6001,
  disableStats: true,
  enabledTransports: ['ws', 'wss'],
  // auth: {
  //   headers: {
  //     Accept: 'application/json',
  //     Authorization: 'Bearer ' + token,
  //   }
  // }
})

// import scss file
require('@/assets/styles/main.scss');

Vue.config.productionTip = false

new Vue({
    router,
    vuetify,
    store,
    render: h => h(App),
  })
  .$mount('#app')