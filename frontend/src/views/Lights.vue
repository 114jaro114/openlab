<template>
<div class="lights mt-page">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <v-lazy :options="{
        threshold: .4
      }" min-height="100vh" transition-group="scale-transition">
    <v-card class="mx-auto ml-3 mr-3 mb-3" elevation="0" tile>
      <v-app-bar class="toolbar-mb" color="white" fixed app tile>
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
        <v-col cols="12" lg="12" md="12" sm="12">
          <v-card class="toolbar-mb">
            <v-sheet class="v-sheet--offset mx-auto rounded-lg" color="grey lighten-5" elevation="0" max-width="calc(100% - 32px)">
              <div id="chart">
                <apexchart type="candlestick" height="350" :options="chartOptionsCandle_stick" :series="seriesCandle_stick"></apexchart>
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
                  <apexchart type="area" height="350" ref="historicalChart" :options="chartOptions" :series="series"></apexchart>
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
              <span class="caption grey--text font-weight-light">Posledná aktualizácia: {{lastUpdate}}</span>
            </v-card-text>
          </v-card>
        </v-col>

        <v-col cols="12" lg="12" md="12" sm="12">
          <v-card class="toolbar-mb">
            <v-sheet class="v-sheet--offset mx-auto rounded-lg" color="grey lighten-5" elevation="0" max-width="calc(100% - 32px)">
              <div id="chart">
                <apexchart ref="realtimeChart" type="line" height="200" :options="chartOptionsRealtime" :series="seriesRealtime" />
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
        <v-col cols="12" lg="6" md="12" sm="12">
          <v-card class="toolbar-mb">
            <v-sheet class="v-sheet--offset mx-auto rounded-lg" color="grey lighten-5" elevation="0" max-width="calc(100% - 32px)">
              <div id="chart">
                <apexchart type="radialBar" ref="strokedGauge" height="350" :options="chartOptionsStroked_gauge" :series="seriesStroked_gauge"></apexchart>
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
import axios from 'axios'
import moment from 'moment'
// import mqtt from 'mqtt'
import VueApexCharts from 'vue-apexcharts'
import Footer from "../components/Footer.vue";
import NavigationDrawer from "../components/NavigationDrawer.vue";

export default {
  name: "Lights",
  components: {
    Footer,
    NavigationDrawer,
    apexchart: VueApexCharts,
  },
  props: ['drawerNew'],
  data() {
    return {
      drawer: false,
      lastUpdate: localStorage.getItem('lastUpdateLights'),
      //candlestick chart
      seriesCandle_stick: [{
        data: [{
            x: new Date(1538778600000),
            y: [6629.81, 6650.5, 6623.04, 6633.33]
          },
          {
            x: new Date(1538780400000),
            y: [6632.01, 6643.59, 6620, 6630.11]
          },
          {
            x: new Date(1538782200000),
            y: [6630.71, 6648.95, 6623.34, 6635.65]
          },
          {
            x: new Date(1538784000000),
            y: [6635.65, 6651, 6629.67, 6638.24]
          },
          {
            x: new Date(1538785800000),
            y: [6638.24, 6640, 6620, 6624.47]
          },
          {
            x: new Date(1538787600000),
            y: [6624.53, 6636.03, 6621.68, 6624.31]
          },
          {
            x: new Date(1538789400000),
            y: [6624.61, 6632.2, 6617, 6626.02]
          },
          {
            x: new Date(1538791200000),
            y: [6627, 6627.62, 6584.22, 6603.02]
          },
          {
            x: new Date(1538793000000),
            y: [6605, 6608.03, 6598.95, 6604.01]
          },
          {
            x: new Date(1538794800000),
            y: [6604.5, 6614.4, 6602.26, 6608.02]
          },
          {
            x: new Date(1538796600000),
            y: [6608.02, 6610.68, 6601.99, 6608.91]
          },
          {
            x: new Date(1538798400000),
            y: [6608.91, 6618.99, 6608.01, 6612]
          },
          {
            x: new Date(1538800200000),
            y: [6612, 6615.13, 6605.09, 6612]
          },
          {
            x: new Date(1538802000000),
            y: [6612, 6624.12, 6608.43, 6622.95]
          },
          {
            x: new Date(1538803800000),
            y: [6623.91, 6623.91, 6615, 6615.67]
          },
          {
            x: new Date(1538805600000),
            y: [6618.69, 6618.74, 6610, 6610.4]
          },
          {
            x: new Date(1538807400000),
            y: [6611, 6622.78, 6610.4, 6614.9]
          },
          {
            x: new Date(1538809200000),
            y: [6614.9, 6626.2, 6613.33, 6623.45]
          },
          {
            x: new Date(1538811000000),
            y: [6623.48, 6627, 6618.38, 6620.35]
          },
          {
            x: new Date(1538812800000),
            y: [6619.43, 6620.35, 6610.05, 6615.53]
          },
          {
            x: new Date(1538814600000),
            y: [6615.53, 6617.93, 6610, 6615.19]
          },
          {
            x: new Date(1538816400000),
            y: [6615.19, 6621.6, 6608.2, 6620]
          },
          {
            x: new Date(1538818200000),
            y: [6619.54, 6625.17, 6614.15, 6620]
          },
          {
            x: new Date(1538820000000),
            y: [6620.33, 6634.15, 6617.24, 6624.61]
          },
          {
            x: new Date(1538821800000),
            y: [6625.95, 6626, 6611.66, 6617.58]
          },
          {
            x: new Date(1538823600000),
            y: [6619, 6625.97, 6595.27, 6598.86]
          },
          {
            x: new Date(1538825400000),
            y: [6598.86, 6598.88, 6570, 6587.16]
          },
          {
            x: new Date(1538827200000),
            y: [6588.86, 6600, 6580, 6593.4]
          },
          {
            x: new Date(1538829000000),
            y: [6593.99, 6598.89, 6585, 6587.81]
          },
          {
            x: new Date(1538830800000),
            y: [6587.81, 6592.73, 6567.14, 6578]
          },
          {
            x: new Date(1538832600000),
            y: [6578.35, 6581.72, 6567.39, 6579]
          },
          {
            x: new Date(1538834400000),
            y: [6579.38, 6580.92, 6566.77, 6575.96]
          },
          {
            x: new Date(1538836200000),
            y: [6575.96, 6589, 6571.77, 6588.92]
          },
          {
            x: new Date(1538838000000),
            y: [6588.92, 6594, 6577.55, 6589.22]
          },
          {
            x: new Date(1538839800000),
            y: [6589.3, 6598.89, 6589.1, 6596.08]
          },
          {
            x: new Date(1538841600000),
            y: [6597.5, 6600, 6588.39, 6596.25]
          },
          {
            x: new Date(1538843400000),
            y: [6598.03, 6600, 6588.73, 6595.97]
          },
          {
            x: new Date(1538845200000),
            y: [6595.97, 6602.01, 6588.17, 6602]
          },
          {
            x: new Date(1538847000000),
            y: [6602, 6607, 6596.51, 6599.95]
          },
          {
            x: new Date(1538848800000),
            y: [6600.63, 6601.21, 6590.39, 6591.02]
          },
          {
            x: new Date(1538850600000),
            y: [6591.02, 6603.08, 6591, 6591]
          },
          {
            x: new Date(1538852400000),
            y: [6591, 6601.32, 6585, 6592]
          },
          {
            x: new Date(1538854200000),
            y: [6593.13, 6596.01, 6590, 6593.34]
          },
          {
            x: new Date(1538856000000),
            y: [6593.34, 6604.76, 6582.63, 6593.86]
          },
          {
            x: new Date(1538857800000),
            y: [6593.86, 6604.28, 6586.57, 6600.01]
          },
          {
            x: new Date(1538859600000),
            y: [6601.81, 6603.21, 6592.78, 6596.25]
          },
          {
            x: new Date(1538861400000),
            y: [6596.25, 6604.2, 6590, 6602.99]
          },
          {
            x: new Date(1538863200000),
            y: [6602.99, 6606, 6584.99, 6587.81]
          },
          {
            x: new Date(1538865000000),
            y: [6587.81, 6595, 6583.27, 6591.96]
          },
          {
            x: new Date(1538866800000),
            y: [6591.97, 6596.07, 6585, 6588.39]
          },
          {
            x: new Date(1538868600000),
            y: [6587.6, 6598.21, 6587.6, 6594.27]
          },
          {
            x: new Date(1538870400000),
            y: [6596.44, 6601, 6590, 6596.55]
          },
          {
            x: new Date(1538872200000),
            y: [6598.91, 6605, 6596.61, 6600.02]
          },
          {
            x: new Date(1538874000000),
            y: [6600.55, 6605, 6589.14, 6593.01]
          },
          {
            x: new Date(1538875800000),
            y: [6593.15, 6605, 6592, 6603.06]
          },
          {
            x: new Date(1538877600000),
            y: [6603.07, 6604.5, 6599.09, 6603.89]
          },
          {
            x: new Date(1538879400000),
            y: [6604.44, 6604.44, 6600, 6603.5]
          },
          {
            x: new Date(1538881200000),
            y: [6603.5, 6603.99, 6597.5, 6603.86]
          },
          {
            x: new Date(1538883000000),
            y: [6603.85, 6605, 6600, 6604.07]
          },
          {
            x: new Date(1538884800000),
            y: [6604.98, 6606, 6604.07, 6606]
          },
        ]
      }],
      chartOptionsCandle_stick: {
        chart: {
          type: 'candlestick',
          height: 350
        },
        title: {
          text: 'CandleStick graf',
          align: 'left'
        },
        xaxis: {
          type: 'datetime',
          tooltip: {
            enabled: false
          }
        },
        yaxis: {
          tooltip: {
            enabled: false
          }
        },
        tooltip: {
          custom: function({
            seriesIndex,
            dataPointIndex,
            w,
          }) {
            const d = w.globals.seriesX[seriesIndex][dataPointIndex]
            const o = w.globals.seriesCandleO[seriesIndex][dataPointIndex]
            const h = w.globals.seriesCandleH[seriesIndex][dataPointIndex]
            const l = w.globals.seriesCandleL[seriesIndex][dataPointIndex]
            const c = w.globals.seriesCandleC[seriesIndex][dataPointIndex]
            return (
              '<div class="p-2 apexcharts-tooltip-candlestick">' +
              '<div>Dátum: <span>' +
              moment(d)
              .format("D MMMM YYYY") +
              '<div>Open: <span class="value">' +
              o +
              '</span></div>' +
              '<div>Najvyššia: <span class="value">' +
              h +
              '</span></div>' +
              '<div>Najnižšia: <span class="value">' +
              l +
              '</span></div>' +
              '<div>Close: <span class="value">' +
              c +
              '</span></div>' +
              '</div>'
            )
          }
        }
      },

      //area historical
      series: [{
        name: 'Vlhkosť (%)',
        data: []
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
          tooltip: {
            enabled: false,
          }
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

      // realtime
      seriesRealtime: [{
        name: 'Vlhkosť (%)',
        data: [],
      }],
      chartOptionsRealtime: {
        // colors: ['#FCCF31', '#17ead9', '#f02fc2'],
        chart: {
          height: 350,
          type: 'line',
          animations: {
            enabled: true,
            easing: 'linear',
            dynamicAnimation: {
              speed: 1000
            }
          },
        },
        grid: {
          show: true,
          strokeDashArray: 0,
          xaxis: {
            lines: {
              show: true,
            },
          },
        },
        stroke: {
          // curve: 'straight',
          curve: 'smooth',
          width: 5,
        },
        // grid: {
        //   padding: {
        //     left: 0,
        //     right: 0,
        //   },
        // },
        dropShadow: {
          enabled: true,
          opacity: 0.3,
          blur: 5,
          left: -7,
          top: 22,
        },
        dataLabels: {
          enabled: false,
        },
        title: {
          text: 'Realtime graf',
          align: 'left'
          // style: {
          //   color: '#FFF',
          // },
        },
        xaxis: {
          show: false,
          type: 'category',
          labels: {
            formatter: function(value) {
              return moment(value)
                .format('YYYY-MM-DD HH:mm:ss');
            },
            show: false,
          },
          tooltip: {
            enabled: false,
          }
        },
        yaxis: {
          // labels: {
          //   style: {
          //     color: '#000',
          //   },
          // },
        },
        legend: {
          show: false
        },
      },
      //apexchart stroked gauge
      seriesStroked_gauge: [],
      chartOptionsStroked_gauge: {
        chart: {
          height: 350,
          type: 'radialBar',
          offsetY: -10
        },
        plotOptions: {
          radialBar: {
            startAngle: -135,
            endAngle: 135,
            dataLabels: {
              name: {
                fontSize: '16px',
                color: undefined,
                offsetY: 120
              },
              value: {
                offsetY: 76,
                fontSize: '22px',
                color: undefined,
                formatter: function(val) {
                  return val + "%";
                }
              }
            }
          }
        },
        fill: {
          type: 'gradient',
          gradient: {
            shade: 'dark',
            shadeIntensity: 0.15,
            inverseColors: false,
            opacityFrom: 1,
            opacityTo: 1,
            stops: [0, 50, 65, 91]
          },
        },
        stroke: {
          dashArray: 4
        },
        labels: ['Median Ratio'],
      },

    }
  },

  updated() {
    this.drawer = this.drawerNew;
  },

  methods: {
    updateCharts() {
      //updateSeriesLine
      // this.$refs.realtimeChart.updateOptions({
      //   series: [{
      //     data: this.seriesRealtime[0].data,
      //   }]
      // });
      this.$refs.realtimeChart.updateSeries([{
        data: this.seriesRealtime[0].data,
      }]);
      //updateHistoricalChart
      this.$refs.historicalChart.updateSeries([{
        data: this.series[0].data,
      }]);
      //updateStrokedGauge
      this.$refs.strokedGauge.updateSeries([{
        data: this.seriesStroked_gauge[0],
      }]);
    },

    //for area historical chart
    updateData(timeline) {
      this.selection = timeline;

      switch (timeline) {
        case 'one_month':
          this.$refs.historicalChart.zoomX(
            // new Date('28 Mar 2021')
            // .getTime(),
            moment(new Date())
            .subtract(1, 'months')
            .valueOf(),
            new Date()
            .getTime()
          )
          break
        case 'six_months':
          this.$refs.historicalChart.zoomX(
            moment(new Date())
            .subtract(6, 'months')
            .valueOf(),
            new Date()
            .getTime()
          )
          break
        case 'one_year':
          this.$refs.historicalChart.zoomX(
            moment(new Date())
            .subtract(1, 'years')
            .valueOf(),
            new Date()
            .getTime()
          )
          break
        case 'ytd':
          this.$refs.historicalChart.zoomX(
            moment()
            .startOf('year')
            .valueOf(),
            new Date()
            .getTime())
          break
        case 'all':
          this.$refs.historicalChart.zoomX(
            new Date('01 Jan 2012')
            .getTime(),
            new Date()
            .getTime()
          )
          break
        default:
      }
    },
  },

  watch: {},

  mounted() {
    // this.createConnection();
    // this.setDataLineChart();
    //do something after mounting vue instance
    console.log('Component Welcome mounted.')
    axios.get('http://127.0.0.1:8000/api/getHum')
      .then(res => {
        for (var i = 0; i < res.data.length; i++) {
          this.seriesRealtime[0].data.push([
            moment(res.data[i].created_at)
            .valueOf(),
            parseFloat(`${res.data[i].hum}`)
          ]);

          this.series[0].data.push([
            moment(res.data[i].created_at)
            .valueOf(),
            parseFloat(`${res.data[i].hum}`)
          ]);
        }
        localStorage.setItem("lastUpdateLights", moment(res.data[res.data.length - 1].created_at)
          .format('YYYY-MM-DD HH:mm:ss'));
        this.seriesStroked_gauge.splice(0, 1);
        this.seriesStroked_gauge.push(res.data[res.data.length - 1].hum);
        this.updateCharts();
      })
  },

  created() {
    //do something after creating vue instance
    // if (localStorage.getItem('lastUpdateLights') == null) {
    //   this.lastUpdate = localStorage.getItem('lastUpdateLights');
    // }
    window.Echo.channel('test')
      .listen('HumEvent', (e) => {
        this.lastUpdate = moment(e.humidity.created_at)
          .format('YYYY-MM-DD HH:mm:ss');
        localStorage.setItem("lastUpdateLights", moment(e.humidity.created_at)
          .format('YYYY-MM-DD HH:mm:ss'));
        this.seriesRealtime[0].data.push([
          moment(e.humidity.created_at)
          .valueOf(),
          parseFloat(`${e.humidity.hum}`)
        ]);
        this.series[0].data.push([
          moment(e.humidity.created_at)
          .valueOf(),
          parseFloat(`${e.humidity.hum}`)
        ]);
        this.seriesStroked_gauge.splice(0, 1);
        this.seriesStroked_gauge.push(e.humidity.hum);
        this.updateCharts();
      })
  }
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
