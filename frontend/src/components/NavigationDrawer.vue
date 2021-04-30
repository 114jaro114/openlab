<template id="NavigationDrawer">
<v-navigation-drawer :value="drawer2" absolute temporary>
  <v-list-item class="justify-center" style="height:64px">
    <v-toolbar-title class="primary--text">OpenLab FEI Tuke</v-toolbar-title>
  </v-list-item>
  <v-divider class="mb-0 mt-0"></v-divider>
  <v-list class="text-uppercase" nav dense>
    <v-list-item-group v-model="group" active-class="primary--text text--accent-4">
      <v-list-item to="/">
        <v-icon>mdi-home</v-icon>
        <v-list-item-title>Domov</v-list-item-title>
      </v-list-item>

      <v-list-item to="/humidity">
        <v-icon>mdi-water-percent</v-icon>
        <v-list-item-title>Relatívna vlkhosť</v-list-item-title>
      </v-list-item>

      <v-list-item to="/temperature">
        <v-icon>mdi-thermometer</v-icon>
        <v-list-item-title>Teplota</v-list-item-title>
      </v-list-item>

      <v-list-item to="/lights">
        <v-icon>mdi-lightbulb-on</v-icon>
        <v-list-item-title>Svetlo</v-list-item-title>
      </v-list-item>

      <v-list-item to="/pressure">
        <v-icon>mdi-arrow-collapse-all</v-icon>
        <v-list-item-title>Barometrický tlak</v-list-item-title>
      </v-list-item>

      <v-list-item to="/sound">
        <v-icon>mdi-surround-sound</v-icon>
        <v-list-item-title>Hlasitosť zvuku</v-list-item-title>
      </v-list-item>

      <v-list-item to="/energy">
        <v-icon>mdi-flash</v-icon>
        <v-list-item-title>Spotreba energie</v-list-item-title>
      </v-list-item>

      <v-list-item to="/notifications">
        <v-badge :content="this.$store.getters['notificationCounter']" :value="this.$store.getters['notificationCounter']" color="orange" overlap bordered>
          <v-icon>mdi-bell</v-icon>
        </v-badge>
        <v-list-item-title>Notifikácie</v-list-item-title>
      </v-list-item>

      <v-list-item to="/settings">
        <v-icon>mdi-cog</v-icon>
        <v-list-item-title>Nastavenia</v-list-item-title>
      </v-list-item>
    </v-list-item-group>
  </v-list>
</v-navigation-drawer>
</template>
<script>
export default {
  name: "NavigationDrawer",
  components: {},
  props: ['drawer'],
  data() {
    return {
      drawerNew: false,
      group: null,
    }
  },
  computed: {
    drawer2() {
      return this.drawer;
    },
  },

  updated() {
    //do something after updating vue instance
  }
}
</script>
<style type="scss">
.v-navigation-drawer {
  position: fixed !important;
  width: 100px !important;
  box-shadow: unset !important;
  z-index: 51 !important;
}

.v-navigation-drawer--temporary {
  z-index: 51 !important;
}

.v-navigation-drawer__append {
  /* margin-bottom: 64px; */
  margin-bottom: 6px;
}

.v-overlay__scrim {
  position: fixed !important;
}

#SidebarNavigation .theme--dark.v-icon {
  color: red !important;
}

.v-list-item-group .theme--dark.v-list-item--active {
  color: #1976d2;
}

.v-list-item-group .theme--light.v-list-item--active {
  color: #1976d2;
}

.v-navigation-drawer:not(.v-navigation-drawer--floating) .v-navigation-drawer__border {
  background-color: unset !important;
}
</style>
