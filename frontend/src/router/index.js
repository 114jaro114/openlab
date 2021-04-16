import Vue from 'vue'
import VueRouter from 'vue-router'

//views
import Home from '../views/Home.vue'
import Humidity from '../views/Humidity.vue'
import Temperature from '../views/Temperature.vue'
import Energy from '../views/Energy.vue'
import Lights from '../views/Lights.vue'
import Notifications from '../views/Notifications.vue'
import Pressure from '../views/Pressure.vue'
import Sound from '../views/Sound.vue'
import Settings from '../views/Settings.vue'

Vue.use(VueRouter)

const routes = [{
  path: '/',
  name: 'Home',
  component: Home,
}, {
  path: '/humidity',
  name: 'Humidity',
  component: Humidity,
}, {
  path: '/temperature',
  name: 'Temperature',
  component: Temperature,
}, {
  path: '/energy',
  name: 'Energy',
  component: Energy,
}, {
  path: '/lights',
  name: 'Lights',
  component: Lights,
}, {
  path: '/notifications',
  name: 'Notifications',
  component: Notifications,
}, {
  path: '/pressure',
  name: 'Pressure',
  component: Pressure,
}, {
  path: '/sound',
  name: 'Sound',
  component: Sound,
}, {
  path: '/settings',
  name: 'Settings',
  component: Settings,
}, ]

const router = new VueRouter({
  mode: 'history',
  // base: process.env.BASE_URL,
  routes
})

export default router