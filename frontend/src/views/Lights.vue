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
                <apexchart type="candlestick" ref="candlestick" height="350" :options="chartOptionsCandle_stick" :series="seriesCandle_stick"></apexchart>
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
        data: [
          // {
          //   x: new Date(1538778600000),
          //   y: [6629.81, 6650.5, 6623.04, 6633.33]
          // },
          // {
          //   x: new Date(1538780400000),
          //   y: [6632.01, 6643.59, 6620, 6630.11]
          // },
          // {
          //   x: new Date(1538782200000),
          //   y: [6630.71, 6648.95, 6623.34, 6635.65]
          // },
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

    axios.get('http://127.0.0.1:8000/api/getHistoricalData2')
      .then(res => {
        for (var i = 0; i < res.data.length; i++) {
          this.seriesCandle_stick[0].data.push({
            x: moment(res.data[i][4])
              .valueOf(),
            y: [res.data[i][0], res.data[i][1], res.data[i][2], res.data[i][3]]
          });
        }
        this.$refs.candlestick.updateSeries([{
          data: this.seriesCandle_stick[0].data,
        }]);
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
