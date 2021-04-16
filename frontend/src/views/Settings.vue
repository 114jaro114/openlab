<template>
<div class="settings mt-page">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <v-lazy :options="{
        threshold: .4
      }" min-height="100vh" transition-group="scale-transition">
    <v-card class="v-content" elevation="0" tile>
      <v-app-bar class="toolbar-mb" color="white" fixed app tile>
        <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>

        <v-toolbar-title>OpenLab FEI Tuke</v-toolbar-title>

        <v-spacer></v-spacer>

        <v-btn icon>
          <v-icon>mdi-dots-vertical</v-icon>
        </v-btn>
      </v-app-bar>
    </v-card>
  </v-lazy>
  <NavigationDrawer :drawer="drawer" />
  <Footer />
</div>
</template>
<script>
import Footer from "../components/Footer.vue";
import NavigationDrawer from "../components/NavigationDrawer.vue";

export default {
  name: "Settings",
  components: {
    Footer,
    NavigationDrawer,
  },
  props: ['drawerNew'],
  data() {
    return {
      drawer: false,
    }
  },

  updated() {
    this.drawer = this.drawerNew;
  },

  methods: {

  },

  watch: {},

  mounted() {
    //do something after mounting vue instance
    console.log('Component Welcome mounted.')
  },

  created() {
    console.log('Component Welcome created')
  },
}
</script>
<style type="scss">
.v-card.v-content {
  min-height: 100vh;
  border-radius: 0px;
}

.v-card {
  border-top-left-radius: unset !important;
  border-top-right-radius: unset !important;
}

.v-navigation-drawer {
  position: fixed !important;
  width: 300px !important;
  box-shadow: unset !important;
}

.v-overlay__scrim {
  position: fixed !important;
}


.v-sheet--offset {
  top: -24px;
  position: relative;
}
</style>
