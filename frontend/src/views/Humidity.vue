<template>
<div class="humidity mt-page">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <v-lazy :options="{
        threshold: .4
      }" min-height="100vh" transition-group="scale-transition">
    <v-card class="v-content ml-3 mr-3 mb-3" elevation="0" tile>
      <v-app-bar color="white" fixed app tile>
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

      <v-row>
        <v-btn @click="getHistoricalData()">get historical data</v-btn>
        <v-col cols="12" lg="12" md="12" sm="12">
          <v-card class="toolbar-mb">
            <v-sheet class="v-sheet--offset mx-auto" color="grey lighten-5" elevation="0" max-width="calc(100% - 32px)" rounded>
              <div id="chart">
                <div class="toolbar pt-3">
                  <v-btn icon color="primary" id="one_month" @click="updateData('one_month')" class="mr-2" :class="{active: selection==='one_month'}">
                    1M
                  </v-btn>

                  <v-btn icon color="primary" id="six_months" @click="updateData('six_months')" class="mr-2" :class="{active: selection==='six_months'}">
                    6M
                  </v-btn>

                  <v-btn icon color="primary" id="one_year" @click="updateData('one_year')" class="mr-2" :class="{active: selection==='one_year'}">
                    1Y
                  </v-btn>

                  <v-btn icon color="primary" id="ytd" @click="updateData('ytd')" class="mr-2" :class="{active: selection==='ytd'}">
                    YTD
                  </v-btn>

                  <v-btn icon color="primary" id="all" @click="updateData('all')" :class="{active: selection==='all'}">
                    ALL
                  </v-btn>
                </div>

                <div id="chart-timeline">
                  <apexchart type="area" height="350" ref="chart" :options="chartOptions" :series="series"></apexchart>
                </div>
              </div>
            </v-sheet>

            <v-card-text class="pt-0">
              <div class="title font-weight-light mb-2">
                Vlhkosť
              </div>
              <v-divider class="my-2"></v-divider>
              <v-icon class="mr-2" small>
                mdi-clock
              </v-icon>
              <span class="caption grey--text font-weight-light">Posledná aktualizácia pred 26 minutami</span>
            </v-card-text>
          </v-card>
        </v-col>
        <v-col cols="12" lg="6" md="12" sm="12">
          <v-card class="toolbar-mb">
            <v-sheet class="v-sheet--offset mx-auto rounded-lg" color="grey lighten-5" elevation="0" max-width="calc(100% - 32px)">
              <div id="chart">
                <apexchart type="radialBar" ref="circle_gradient" height="350" :options="chartOptionsCircle_gradient" :series="seriesCircle_gradient"></apexchart>
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
              <span class="caption grey--text font-weight-light">Posledná aktualizácia: {{lastUpdate}}</span>
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>
    </v-card>
  </v-lazy>
  <NavigationDrawer :drawer="drawer" />
  <Footer />
</div>
</template>
<script>
import axios from 'axios';
// import moment from 'moment'
import VueApexCharts from 'vue-apexcharts';
import Footer from "../components/Footer.vue";
import NavigationDrawer from "../components/NavigationDrawer.vue";

export default {
  name: "Humidity",
  components: {
    Footer,
    NavigationDrawer,
    apexchart: VueApexCharts,
  },
  props: ['drawerNew'],
  data() {
    return {
      drawer: false,

      series: [{
        data: [
          [1327359600000, 30.95],
          [1354489200000, 34.70],
          [1354575600000, 35.30],
          [1354662000000, 35.40],
          [1354748400000, 35.14],
          [1354834800000, 35.48],
          [1355094000000, 35.75],
          [1355180400000, 35.54],
          [1355266800000, 35.96],
          [1355353200000, 35.53],
          [1355439600000, 37.56],
          [1361833200000, 38.59],
          [1361919600000, 39.60],
        ],
      }],
      chartOptions: {
        chart: {
          id: 'area-datetime',
          type: 'area',
          height: 350,
          zoom: {
            autoScaleYaxis: true
          },
          dynamicAnimation: {
            speed: 1000
          }
        },
        annotations: {
          yaxis: [{
            y: 30,
            borderColor: '#999',
            label: {
              show: true,
              text: 'Support',
              style: {
                color: "#fff",
                background: '#00E396'
              }
            }
          }],
          xaxis: [{
            x: new Date('14 Nov 2012')
              .getTime(),
            borderColor: '#999',
            yAxisIndex: 0,
            label: {
              show: true,
              text: 'Rally',
              style: {
                color: "#fff",
                background: '#775DD0'
              }
            }
          }]
        },
        dataLabels: {
          enabled: false
        },
        markers: {
          size: 0,
          style: 'hollow',
        },
        xaxis: {
          type: 'datetime',
          min: new Date('01 Mar 2012')
            .getTime(),
          tickAmount: 6,
        },
        tooltip: {
          x: {
            format: 'dd MMM yyyy'
          }
        },
        fill: {
          type: 'gradient',
          gradient: {
            shadeIntensity: 1,
            opacityFrom: 0.7,
            opacityTo: 0.9,
            stops: [0, 100]
          }
        },
      },

      selection: 'one_year',
      data: [],
    }
  },

  updated() {
    this.drawer = this.drawerNew;
  },

  methods: {
    getHistoricalData() {
      axios.get('http://127.0.0.1:8000/api/getHistoricalData')
        .then(res => {
          this.seriesCircle_gradient.push(res.data);
          //update chart
          this.$refs.circle_gradient.updateSeries([{
            data: this.seriesCircle_gradient[0],
          }]);
        })
    },

    updateData(timeline) {
      this.selection = timeline;

      switch (timeline) {
        case 'one_month':
          this.$refs.chart.zoomX(
            new Date('28 Jan 2013')
            .getTime(),
            new Date('27 Feb 2013')
            .getTime()
          )
          break
        case 'six_months':
          this.$refs.chart.zoomX(
            new Date('27 Sep 2012')
            .getTime(),
            new Date('27 Feb 2013')
            .getTime()
          )
          break
        case 'one_year':
          this.$refs.chart.zoomX(
            new Date('27 Feb 2012')
            .getTime(),
            new Date('27 Feb 2013')
            .getTime()
          )
          break
        case 'ytd':
          this.$refs.chart.zoomX(new Date('01 Jan 2013')
            .getTime(), new Date('27 Feb 2013')
            .getTime())
          break
        case 'all':
          this.$refs.chart.zoomX(
            new Date('23 Jan 2012')
            .getTime(),
            new Date('27 Feb 2013')
            .getTime()
          )
          break
        default:
      }
    },
  },

  watch: {},

  mounted() {
    //do something after mounting vue instance
    console.log('Component Welcome mounted.')
  },

  created() {
    console.log('Component Welcome created')
    this.getHistoricalData();
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
