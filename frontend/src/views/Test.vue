<template>
<v-lazy :options="{
          threshold: .4
        }" min-height="100vh" transition-group="scale-transition">
  <div class="energy custom-margin-page">
    <v-card class="mx-auto ml-3 mr-3" elevation="0" tile>
      <v-app-bar fixed app tile>
        <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>

        <v-toolbar-title>OpenLab FEI Tuke</v-toolbar-title>

        <v-spacer></v-spacer>

        <v-btn icon to="/notifications">
          <v-badge :content="this.$store.getters['notificationCounter']" :value="this.$store.getters['notificationCounter']" color="orange" overlap bordered>
            <v-icon>mdi-bell</v-icon>
          </v-badge>
        </v-btn>
        <v-btn icon to="/settings">
          <v-icon>mdi-cog</v-icon>
        </v-btn>
      </v-app-bar>
    </v-card>

    <v-row class="m-0">
      <v-text-field v-model="new_notif" counter v-on:keyup.enter="addItem" required></v-text-field>
      <v-btn color="primary" v-bind:class="{ active: new_notif }" @click="addItem">Pridat</v-btn>
    </v-row>
    <NavigationDrawer :drawer="drawer" />
    <BottomNavigation />
    <Footer />
  </div>
</v-lazy>
</template>

<script>
import moment from 'moment'
import Footer from "../components/Footer.vue";
import NavigationDrawer from "../components/NavigationDrawer.vue";
import BottomNavigation from "../components/BottomNavigation.vue";
export default {
  name: 'Test',
  components: {
    Footer,
    NavigationDrawer,
    BottomNavigation,
  },
  props: ['drawerNew'],
  data() {
    return {
      drawer: false,
      //localstorage todo list for notifications
      notif: [],
      new_notif: '',
    }
  },

  mounted() {
    this.getTodos();
  },

  methods: {
    // get all todos when loading the page
    getTodos() {
      if (localStorage.getItem('notifications')) {
        this.notif = JSON.parse(localStorage.getItem('notifications'));
      } else {
        this.notif = [];
      }
    },
    // add a new item
    addItem() {
      // validation check
      if (JSON.parse(localStorage.getItem("notifState")) == true) {
        if (this.new_notif) {
          this.notif.unshift({
            id: this.notif.length,
            title: this.new_notif,
            subtitle: 'hmm',
            text: 'hmm',
            date: moment(new Date)
              .format('DD MM YYYY HH:mm:ss'),
            status: 'unread',
          });
          if (JSON.parse(localStorage.getItem("notifSoundState")) == true) {
            var audio = new Audio(require('../assets/AirPlaneDing.mp3'));
            audio.play();
          }
        }

        var counter = 0;
        for (var i = 0; i < this.notif.length; i++) {
          if (this.notif[i].status == 'unread') {
            counter++;
          }
        }
        console.log(counter);
        this.$store.dispatch('notificationCounter', {
          notifCounter: counter
        });
        localStorage.setItem('notifCounter', counter);
        localStorage.setItem('notifications', JSON.stringify(this.notif));
        // reset new_todo
        this.new_notif = '';
      }
    },
  },
}
</script>

<style>

</style>
