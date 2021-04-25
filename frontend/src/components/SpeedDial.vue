<template>
<v-card id="create">
  <v-speed-dial v-if="this.$store.getters['speedDialState'].state" v-model="fab" :bottom="bottom" :right="right" :direction="direction" :open-on-hover="hover" :transition="transition">
    <template v-slot:activator>
      <v-tooltip left>
        <template v-slot:activator="{ on }">
          <v-btn v-on="on" color="primary" v-model="fab" fab medium>
            <v-icon v-if="fab"> mdi-close </v-icon>
            <v-icon v-else> mdi-gesture-tap </v-icon>
          </v-btn>
        </template>
        <span>speed dial</span>
      </v-tooltip>

    </template>

    <v-tooltip left>
      <template v-slot:activator="{ on }">
        <v-btn v-on="on" color="primary" fab small to="/humidity">
          <v-icon>mdi-water-percent</v-icon>
        </v-btn>
      </template>
      <span>prejsť na stránku relatívnej vlhkosti</span>
    </v-tooltip>
    <v-tooltip left>
      <template v-slot:activator="{ on }">
        <v-btn v-on="on" color="primary" fab small to="/temperature">
          <v-icon>mdi-thermometer</v-icon>
        </v-btn>
      </template>
      <span>prejsť na stránku teploty</span>
    </v-tooltip>
    <v-tooltip left>
      <template v-slot:activator="{ on }">
        <v-btn v-on="on" color="primary" fab small to="/lights">
          <v-icon>mdi-lightbulb-on</v-icon>
        </v-btn>
      </template>
      <span>prejsť na stránku svetiel</span>
    </v-tooltip>
    <v-tooltip left>
      <template v-slot:activator="{ on }">
        <v-btn v-on="on" color="primary" fab small to="/pressure">
          <v-icon>mdi-arrow-collapse-all</v-icon>
        </v-btn>
      </template>
      <span>prejsť na stránku barometrického tlaku</span>
    </v-tooltip>
    <v-tooltip left>
      <template v-slot:activator="{ on }">
        <v-btn v-on="on" color="primary" fab small to="/sound">
          <v-icon>mdi-surround-sound</v-icon>
        </v-btn>
      </template>
      <span>prejsť na stránku hlasitosti zvuku</span>
    </v-tooltip>
    <v-tooltip left>
      <template v-slot:activator="{ on }">
        <v-btn v-on="on" color="primary" fab small to="/energy">
          <v-icon>mdi-flash</v-icon>
        </v-btn>
      </template>
      <span>prejsť na stránku spotreby energií</span>
    </v-tooltip>
  </v-speed-dial>
</v-card>
</template>
<script>
export default {
  data: () => ({
    direction: 'top',
    fab: false,
    fling: false,
    hover: false,
    tabs: null,
    top: false,
    right: true,
    bottom: true,
    transition: 'scale-transition',
  }),

  mounted() {
    //do something after mounting vue instance
    // console.log("SpeedDial mounted");

    if (JSON.parse(localStorage.getItem("speed_dial")) == true) {
      this.$store.dispatch('speedDialState', {
        status: true
      });
    } else {
      this.$store.dispatch('speedDialState', {
        status: false
      });
    }
  },

  updated() {
    //do something after updating vue instance
    // console.log("SpeedDial updated");
  }
}
</script>
<style>
/* This is for documentation purposes and will not be needed in your application */
#create .v-speed-dial {
  position: fixed;
}

#create .v-btn--floating {
  position: relative;
}

.v-speed-dial {
  z-index: 12 !important;
}

.v-speed-dial--bottom {
  bottom: 160px !important;
}
</style>
