<template>
<div class="sound custom-margin-page">
  <v-lazy :options="{
        threshold: .4
      }" min-height="100vh" transition-group="scale-transition">
    <div>
      <v-card class="mx-auto ml-3 mr-3" elevation="0" tile>
        <v-app-bar class="toolbar-mb" fixed app tile>
          <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>

          <v-toolbar-title>OpenLab FEI Tuke</v-toolbar-title>

          <v-spacer></v-spacer>

          <v-btn icon to="/notifications">
            <v-icon>mdi-bell</v-icon>
          </v-btn>

          <v-btn icon>
            <v-icon>mdi-dots-vertical</v-icon>
          </v-btn>
        </v-app-bar>
      </v-card>

      <v-row class="mx-auto">
        <v-col class="mb-5" cols="12" lg="12" md="12" sm="12">
          <v-card class="rounded" elevation="0">
            <v-sheet class="v-sheet--offset mx-auto rounded" elevation="0" max-width="calc(100% - 32px)">
              <div id="wrapper">
                <div id="chart-line2">
                  <apexchart type="line" height="230" :options="chartOptionsBrush" :series="seriesBrush"></apexchart>
                </div>
                <div id="chart-line">
                  <apexchart type="area" height="130" :options="chartOptionsLine" :series="seriesLine"></apexchart>
                </div>
              </div>
            </v-sheet>

            <v-card-text class="pt-0">
              <div class="title font-weight-light mb-2">
                Vlhkosť - Tlak - Teplota
              </div>
              <v-divider class="my-2"></v-divider>
              <v-icon class="mr-2" small>
                mdi-clock
              </v-icon>
              <span class="caption grey--text font-weight-light">Posledná aktualizácia pred 26 minutami</span>
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>
    </div>
  </v-lazy>
  <NavigationDrawer :drawer="drawer" />
  <BottomNavigation />
  <Footer />
</div>
</template>
<script>
// import moment from 'moment'
// import mqtt from 'mqtt'
import Footer from "../components/Footer.vue";
import NavigationDrawer from "../components/NavigationDrawer.vue";
import BottomNavigation from "../components/BottomNavigation.vue";
import VueApexCharts from 'vue-apexcharts'

function generateDayWiseTimeSeries(baseval, count, yrange) {
  var i = 0;
  var series = [];
  while (i < count) {
    var x = baseval;
    var y = Math.floor(Math.random() * (yrange.max - yrange.min + 1)) + yrange.min;

    series.push([x, y]);
    baseval += 86400000;
    i++;
  }
  return series;
}

var data = generateDayWiseTimeSeries(new Date('11 Feb 2017')
  .getTime(), 185, {
    min: 30,
    max: 90
  })

export default {
  name: "Sound",
  components: {
    Footer,
    NavigationDrawer,
    BottomNavigation,
    apexchart: VueApexCharts,
  },
  props: ['drawerNew'],
  data() {
    return {
      drawer: false,
      //brush chart
      seriesBrush: [{
        data: data
      }],
      chartOptionsBrush: {
        chart: {
          id: 'chart2',
          type: 'line',
          height: 230,
          toolbar: {
            autoSelected: 'pan',
            show: false
          }
        },
        colors: ['#546E7A'],
        stroke: {
          width: 3
        },
        dataLabels: {
          enabled: false
        },
        fill: {
          opacity: 1,
        },
        markers: {
          size: 0
        },
        xaxis: {
          type: 'datetime'
        }
      },

      seriesLine: [{
        data: data
      }],
      chartOptionsLine: {
        chart: {
          // id: 'chart1',
          // height: 130,
          type: 'area',
          brush: {
            target: 'chart2',
            enabled: true
          },
          selection: {
            enabled: true,
            xaxis: {
              min: new Date('19 Jun 2017')
                .getTime(),
              max: new Date('14 Aug 2017')
                .getTime()
            }
          },
        },
        colors: ['#008FFB'],
        fill: {
          type: 'gradient',
          gradient: {
            opacityFrom: 0.91,
            opacityTo: 0.1,
          }
        },
        xaxis: {
          type: 'datetime',
          tooltip: {
            enabled: false
          }
        },
        yaxis: {
          tickAmount: 2
        }
      },
    }
  },

  updated() {
    this.drawer = this.drawerNew;
  },

  methods: {},

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

</style>
