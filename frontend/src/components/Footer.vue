<template>
<v-footer class="p-0 footer" style="bottom: 0">
  <v-card flat tile width="100%" class="text-center">
    <v-card-text class="p-0 pt-3 mb-5">
      <v-row class="ml-5 mr-5">
        <v-col cols="12" lg="6" md="6" class="pl-0 pr-0 mt-5 d-flex">
          <v-flex class="pl-0 pr-0 justify-lg-start justify-md-start justify-center">
            <v-img class="ma-lg-0 ma-md-0 ma-auto" :lazy-src="require('../assets/fei.png')" max-height="100" max-width="400" :src="require('../assets/fei.png')"></v-img>
            <!-- <v-img class="ma-lg-0 ma-md-0 ma-auto mt-lg-5 mt-md-5 mt-5" :lazy-src="require('../assets/kpi.png')" max-height="150" max-width="300" :src="require('../assets/kpi.png')"></v-img> -->
          </v-flex>
        </v-col>

        <v-col class="d-block-xs d-lg-none d-md-none">
          <v-divider class="d-lg-none d-md-none d-block mb-0" />
        </v-col>

        <v-col cols="12" lg="6" md="6" class="pl-0 pr-0 d-flex">
          <v-container class="pl-0 pr-0 justify-lg-end justify-md-end justify-center text-lg-end text-md-end text-center">
            <strong class="text-h5 mb-6 font-weight-bold">Adresa</strong>
            <v-spacer></v-spacer>
            <span class="text-h6 mb-6 font-weight-light">Katedra počítačov a informatiky</span>
            <v-spacer></v-spacer>
            <span class="text-h6 mb-6 font-weight-light">Fakulta elektrotechniky a informatiky</span>
            <v-spacer></v-spacer>
            <span class="text-h6 mb-6 font-weight-light">Technická univerzita v Košiciach</span>
            <v-spacer></v-spacer>
            <span class="text-h6 mb-6 font-weight-light">Letná 9 042 00 Košice</span>
            <v-spacer></v-spacer>
            <span class="text-h6 mb-6 font-weight-light">Slovenská republika</span>
          </v-container>
        </v-col>

        <v-col class="d-block-xs d-lg-none d-md-none">
          <v-divider class="d-lg-none d-md-none d-block mt-0" />
        </v-col>
      </v-row>
    </v-card-text>

    <v-btn class="text-h6 font-weight-bold" outlined disabled>Sociálne siete</v-btn>

    <v-row class="ml-0 mr-0 mt-2">
      <v-col>
        <v-btn color="primary" v-for="item in items" :key="item.id" :href="item.link" class="mx-4" fab icon>
          <v-icon large>
            {{ item.icon }}
          </v-icon>
        </v-btn>
      </v-col>
    </v-row>

    <v-divider />
    <v-card-text class="justify-center" justify="center">
      <v-icon color="primary">mdi-copyright</v-icon> {{ new Date().getFullYear() }} — <strong>KPI FEI TUKE</strong>
      <v-spacer></v-spacer>
      <span>Made by — <strong>Balent • Jenči • Jurík</strong></span>
    </v-card-text>
  </v-card>
</v-footer>
</template>
<script type="text/javascript">
export default {
  name: "Footer",
  data() {
    return {
      items: [{
          id: 1,
          icon: 'mdi-facebook',
          link: 'https://www.facebook.com/kpi.fei.tuke'
        },
        {
          id: 2,
          icon: 'mdi-instagram',
          link: 'https://www.instagram.com/kpi_fei_tuke/'
        },
        {
          id: 3,
          icon: 'mdi-github',
          link: 'https://github.com/kpi-tuke'
        },
        {
          id: 4,
          icon: 'mdi-twitter',
          link: 'https://twitter.com/KPI_FEI_TUKE'
        },
        {
          id: 5,
          icon: 'mdi-linkedin',
          link: 'https://www.linkedin.com/company/katedra-po%C4%8D%C3%ADta%C4%8Dov-a-informatiky-kpi-fei-tuke/about/'
        },
        {
          id: 6,
          icon: 'mdi-youtube',
          link: 'https://www.youtube.com/channel/UCcJFOmxCzDqIeF76SKw_dnQ'
        },
        {
          id: 7,
          icon: 'mdi-google-play',
          link: 'https://play.google.com/store/apps/dev?id=7856447508542981978'
        },
      ]
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

.footer .v-btn.v-btn--disabled:not(.v-btn--flat):not(.v-btn--text):not(.v-btn-outlined) {
  color: #2196f3 !important;
}
</style>
