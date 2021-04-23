<template>
<v-footer class="p-0">
  <v-card flat tile width="100%" class="text-center">
    <!-- <v-divider class="primary mt-0" /> -->
    <v-card-text class="p-0 pt-3">
      <!-- <img src="../assets/kpi.png" /> -->
      <!-- <v-img :src="require('./assets/logo.jpg')" /> -->
      <!-- <v-row> -->
      <v-col>
        <v-img class="ml-5 mt-3" :lazy-src="require('../assets/fei.png')" max-height="180" max-width="350" :src="require('../assets/fei.png')"></v-img>
        <v-img class="ml-5 mt-5" :lazy-src="require('../assets/kpi.png')" max-height="70" max-width="200" :src="require('../assets/kpi.png')"></v-img>
      </v-col>
      <!-- </v-row> -->

      <v-btn color="primary" v-for="icon in icons" :key="icon" class="mx-4" fab icon>
        <v-icon large>
          {{ icon }}
        </v-icon>
      </v-btn>
    </v-card-text>
    <!-- <v-divider /> -->
    <v-card-text>
      <v-icon color="primary">mdi-copyright</v-icon> {{ new Date().getFullYear() }} — <strong>Balent, Jenči, Jurík</strong>
    </v-card-text>
  </v-card>
</v-footer>
</template>
<script type="text/javascript">
export default {
  name: "Footer",
  data() {
    return {
      icons: ['mdi-facebook', 'mdi-instagram', 'mdi-github'],
    }
  },
}
</script>
<style>
.facebook {
  color: #3490dc;
  font-size: 30px;
  margin-top: -3px;
}

.facebook:hover {
  color: #165283;
}

.instagram {
  color: #e3342f;
  font-size: 30px;
  margin-top: -3px;
}

.instagram:hover {
  color: #b41e18;
  ;
}

.footer {
  background-color: #e9ecef;
}

.footer-content {
  margin-top: -3px;
}
</style>
