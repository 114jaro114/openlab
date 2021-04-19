<template>
<div class="phone-viewport w-100">
  <!-- v-model="value" -->
  <v-bottom-navigation :input-value="this.$store.getters['bottomNavigationState'].state" color="primary" app shift grow>
    <v-btn to="/" value="home">
      <span>Domov</span>
      <v-icon>mdi-home</v-icon>
    </v-btn>
    <v-btn to="/notifications" value="notifications">
      <span>Notifikácie</span>
      <v-icon>mdi-bell</v-icon>
    </v-btn>
    <v-btn to="/settings" value="settings">
      <span>Nastavenia</span>
      <v-icon>mdi-cog</v-icon>
    </v-btn>
  </v-bottom-navigation>
</div>
</template>

<script>
export default {
  data() {
    return {
      value: '',
      num: 5,
    }
  },

  mounted() {
    // do something after mounting vue instance
    console.log("BottomNavigation mounted");
    if (JSON.parse(localStorage.getItem("bottom_navigation")) == true) {
      this.$store.dispatch('bottomNavigationState', {
        status: true
      });
    } else {
      this.$store.dispatch('bottomNavigationState', {
        status: false
      });
    }
  },

  updated() {
    //do something after updating vue instance
    // console.log("BottomNavigation updated");
  },

  methods: {
    // home() {
    //   this.$router.push('/home');
    // },
    // messenger() {
    //   this.$router.push('/messenger');
    // },
    // reservation() {
    //   this.$router.push('/reservation');
    // },
    // administration() {
    //   this.$router.push('/administration');
    // },
    // settings() {
    //   this.$router.push('/settings');
    // },
  }
}
</script>

<style>
.bottom-nav {
  .btn:not(.btn--active) {
    filter: none;
    opacity: 1;

    i,
    span:first-child {
      filter: grayscale(100%);
      opacity: 0.5;
    }

    .badge__badge {
      span {
        filter: none;
        opacity: 1;
      }
    }
  }
}

.v-bottom-navigation {
  z-index: 12 !important;
}
</style>
