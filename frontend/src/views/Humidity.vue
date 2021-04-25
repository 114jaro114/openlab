<template>
<div class="humidity custom-margin-page">
  <v-lazy :options="{
        threshold: .4
      }" min-height="100vh" transition-group="scale-transition">
    <div>
      <v-card class="mx-auto ml-3 mr-3" elevation="0" tile>
        <v-app-bar fixed app tile>
          <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>

          <v-toolbar-title>OpenLab FEI Tuke</v-toolbar-title>

          <v-spacer></v-spacer>

          <v-btn icon to="/notifications">
            <v-badge :content="this.$store.getters['notificationCounter']" :value="this.$store.getters['notificationCounter']" color="orange" overlap bordered>
              <v-icon>mdi-bell</v-icon>
            </v-badge>
          </v-btn>

          <v-btn icon to="/settings">
            <v-icon>mdi-cog</v-icon>
          </v-btn>
        </v-app-bar>
      </v-card>

      <v-row class="m-0">
        <!-- stroked gauge chart -->
        <v-col class="mb-5" cols="12" lg="6" md="12" sm="12">
          <v-card class="rounded" elevation="0">
            <v-sheet class="v-sheet--offset mx-auto rounded" elevation="0" max-width="calc(100% - 32px)">
              <div id="chart">
                <apexchart type="radialBar" height="385" :options="chartOptionsCircle" :series="seriesCircle"></apexchart>
              </div>
            </v-sheet>

            <v-card-text class="pt-0">
              <div class="title font-weight-light mb-2">
                Aktuálna vlhkosť
              </div>
              <v-divider class="my-2"></v-divider>
              <v-icon class="mr-2" small>
                mdi-clock
              </v-icon>
              <span class="caption grey--text font-weight-light">Posledná aktualizácia: </span>
              <span class="font-weight-bold">{{lastUpdate}}</span>
            </v-card-text>
          </v-card>
        </v-col>
        <!-- column chart -->
        <v-col class="mb-5" cols="12" lg="6" md="12" sm="12">
          <v-card class="rounded" elevation="0">
            <v-sheet class="v-sheet--offset mx-auto rounded" elevation="0" max-width="calc(100% - 32px)" rounded>
              <div id="chart">
                <apexchart type="bar" ref="column_chart" height="350" :options="chartOptionsColumn" :series="seriesColumn"></apexchart>
              </div>
            </v-sheet>

            <v-card-text class="pt-0">
              <div class="title font-weight-light mb-2">
                Vlhkosť za jednotlivé mesiace v roku
              </div>
              <v-divider class="my-2"></v-divider>
              <v-icon class="mr-2" small>
                mdi-clock
              </v-icon>
              <span class="caption grey--text font-weight-light">Posledná aktualizácia: </span>
              <span class="font-weight-bold">{{lastUpdate}}</span>
            </v-card-text>
          </v-card>
        </v-col>
        <!-- realtime chart -->
        <v-col class="mb-5" cols="12" lg="12" md="12" sm="12">
          <v-card class="rounded" elevation="0">
            <v-sheet class="v-sheet--offset mx-auto rounded" elevation="0" max-width="calc(100% - 32px)">
              <div id="chart">
                <apexchart ref="realtimeChart" type="line" height="200" :options="chartOptionsRealtime" :series="seriesRealtime" />
              </div>
            </v-sheet>

            <v-card-text class="pt-0">
              <div class="title font-weight-light mb-2">
                Vlhkosť posledných 5 minút
              </div>
              <v-divider class="my-2"></v-divider>
              <v-icon class="mr-2" small>
                mdi-clock
              </v-icon>
              <span class="caption grey--text font-weight-light">Posledná aktualizácia: </span>
              <span class="font-weight-bold">{{lastUpdate}}</span>
            </v-card-text>
          </v-card>
        </v-col>
        <!-- candlestick chart -->
        <v-col class="mb-5" cols="12" lg="12" md="12" sm="12">
          <v-card class="rounded" elevation="0">
            <v-sheet class="v-sheet--offset mx-auto rounded" elevation="0" max-width="calc(100% - 32px)">
              <div id="chart">
                <apexchart type="candlestick" ref="candlestick" height="350" :options="chartOptionsCandle_stick" :series="seriesCandle_stick"></apexchart>
              </div>
            </v-sheet>

            <v-card-text class="pt-0">
              <div class="title font-weight-light mb-2">
                Najvyššia, najnižšia, prvá a posledná hodnota vlhkosti za 1-hodinové intervaly
              </div>
              <v-divider class="my-2"></v-divider>
              <v-icon class="mr-2" small>
                mdi-clock
              </v-icon>
              <span class="caption grey--text font-weight-light">Posledná aktualizácia: </span>
              <span class="font-weight-bold">{{lastUpdate}}</span>
            </v-card-text>
          </v-card>
        </v-col>
        <!-- historical chart -->
        <v-col class="mb-5" cols="12" lg="12" md="12" sm="12">
          <v-card class="rounded" elevation="0">
            <v-sheet class="v-sheet--offset mx-auto rounded" elevation="0" max-width="calc(100% - 32px)" rounded>
              <div id="chart">
                <div class="toolbar pt-3">
                  <v-btn icon color="#0066ff" id="one_hour" @click="updateData('one_hour')" class="mr-2" :class="{active: selection==='one_hour'}">
                    1H
                  </v-btn>
                  <v-btn icon color="#0066ff" id="one_day" @click="updateData('one_day')" class="mr-2" :class="{active: selection==='one_day'}">
                    1D
                  </v-btn>
                  <v-btn icon color="#0066ff" id="one_month" @click="updateData('one_month')" class="mr-2" :class="{active: selection==='one_month'}">
                    1M
                  </v-btn>

                  <v-btn icon color="#0066ff" id="six_months" @click="updateData('six_months')" class="mr-2" :class="{active: selection==='six_months'}">
                    6M
                  </v-btn>

                  <v-btn icon color="#0066ff" id="one_year" @click="updateData('one_year')" class="mr-2" :class="{active: selection==='one_year'}">
                    1Y
                  </v-btn>

                  <v-btn icon color="#0066ff" id="ytd" @click="updateData('ytd')" class="mr-2" :class="{active: selection==='ytd'}">
                    YTD
                  </v-btn>

                  <v-btn icon color="#0066ff" id="all" @click="updateData('all')" :class="{active: selection==='all'}">
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
                Historický graf vlhkosti
              </div>
              <v-divider class="my-2"></v-divider>
              <v-icon class="mr-2" small>
                mdi-clock
              </v-icon>
              <span class="caption grey--text font-weight-light">Posledná aktualizácia: </span>
              <span class="font-weight-bold">{{lastUpdate}}</span>
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>
    </div>
  </v-lazy>
  <NavigationDrawer :drawer="drawer" />
  <BottomNavigation />
  <SpeedDial />
  <Footer />
</div>
</template>
<script>
import axios from 'axios'
import moment from 'moment'
import VueApexCharts from 'vue-apexcharts'
import Footer from "../components/Footer.vue";
import NavigationDrawer from "../components/NavigationDrawer.vue";
import BottomNavigation from "../components/BottomNavigation.vue";
import SpeedDial from "../components/SpeedDial.vue";

export default {
  name: "Humidity",
  components: {
    Footer,
    NavigationDrawer,
    BottomNavigation,
    SpeedDial,
    apexchart: VueApexCharts,
  },
  props: ['drawerNew'],
  data() {
    return {
      drawer: false,
      lastUpdate: localStorage.getItem('lastUpdateHumidity'),
      seriesCircle: [],
      chartOptionsCircle: {
        chart: {
          foreColor: localStorage.getItem('graph_text_color'),
          height: 350,
          type: 'radialBar',
          toolbar: {
            show: false
          }
        },
        plotOptions: {
          radialBar: {
            startAngle: -135,
            endAngle: 225,
            hollow: {
              margin: 0,
              size: '70%',
              background: 'rgba(255,255,255, 0)',
              image: undefined,
              imageOffsetX: 0,
              imageOffsetY: 0,
              position: 'front'
            },
            dataLabels: {
              show: true,
              name: {
                offsetY: -10,
                show: true,
                color: '#888',
                fontSize: '17px'
              },
              value: {
                formatter: function(val) {
                  return parseInt(val * 100) / 100;
                },
                color: '#0066ff',
                fontSize: '36px',
                show: true,
              }
            }
          }
        },
        stroke: {
          lineCap: 'round'
        },
        labels: ['%'],
        colors: ['#0066ff'],
      },
      //column chart
      seriesColumn: [{
        name: 'Priemerná vlhkosť (%)',
        data: []
      }],
      chartOptionsColumn: {
        chart: {
          foreColor: localStorage.getItem('graph_text_color'),
          type: 'bar',
          toolbar: {
            show: false,
            tools: {
              download: false,
              selection: false,
              zoom: false,
              zoomin: false,
              zoomout: false,
              pan: false,
              reset: false | '<img src="/static/icons/reset.png" width="20">',
              //customIcons: []
            }
          }
        },
        plotOptions: {
          bar: {
            borderRadius: 10,
            dataLabels: {
              position: 'top', // top, center, bottom
            },
          }
        },
        dataLabels: {
          enabled: false,
          formatter: function(val) {
            return val + "";
          },
          offsetY: -20,
          style: {
            fontSize: '12px',
            colors: ["#0066ff"]
          }
        },

        xaxis: {
          categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
          position: 'top',
          axisBorder: {
            show: false
          },
          axisTicks: {
            show: false
          },
          tooltip: {
            enabled: false,
          }
        },
        yaxis: {
          axisBorder: {
            show: false
          },
          axisTicks: {
            show: false,
          },
          labels: {
            show: true,
            formatter: function(val) {
              return val + "";
            }
          }

        },
        title: {
          //text: 'Mesačná priemerná vlhkosť',
          floating: true,
          offsetY: 330,
          align: 'center',
          style: {
            color: '#444'
          }
        },
        tooltip: {
          theme: localStorage.getItem('graph_theme'),
        },
        colors: ['#0066ff'],
      },
      //candlestick chart
      seriesCandle_stick: [{
        data: []
      }],
      chartOptionsCandle_stick: {
        chart: {
          foreColor: localStorage.getItem('graph_text_color'),
          type: 'candlestick',
          toolbar: {
            tools: {
              download: false,
            }
          },
          animations: {
            enabled: false,
          }
        },
        xaxis: {
          type: 'datetime',
          labels: {
            datetimeUTC: false,
          },
          // type: 'category',
          // labels: {
          //   formatter: function(value) {
          //     return moment(value)
          //       .format('HH:mm');
          //   },
          // },
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
          theme: localStorage.getItem('graph_theme'),
          custom: function({
            // seriesStroked_gauge,
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

              '<div class="apexcharts-tooltip-candlestick">' +
              '<div class="p-2">Dátum: <span class="font-weight-bold">' +
              moment(d)
              .format("D MMMM YYYY HH:mm") +
              '</span></div>' +
              '<div>Open: <span class="font-weight-bold value">' +
              o +
              '</span></div>' +
              '<div>High: <span class="font-weight-bold value">' +
              h +
              '</span></div>' +
              '<div>Low: <span class="font-weight-bold value">' +
              l +
              '</span></div>' +
              '<div>Close: <span class="font-weight-bold value">' +
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
          foreColor: localStorage.getItem('graph_text_color'),
          id: 'area-datetime',
          type: 'area',
          height: 350,
          zoom: {
            autoScaleYaxis: true
          },
          dynamicAnimation: {
            speed: 1000
          },
          toolbar: {
            tools: {
              download: false,
            }
          }
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
          labels: {
            datetimeUTC: false,
            formatter: function(value) {
              return moment(value)
                .format('HH:mm');
            },
          },
          // type: 'category',
          // labels: {
          //   formatter: function(value) {
          //     return moment(value)
          //       .format('YYYY-MM-DD HH:mm:ss');
          //   },
          //   show: true,
          // },
          tickAmount: 6,
          tooltip: {
            enabled: false,
          }
        },
        tooltip: {
          theme: localStorage.getItem('graph_theme'),
          x: {
            datetimeUTC: false,
            formatter: function(value) {
              return moment(value)
                .format('DD MMM yy HH:mm');
            },
          },
        },
        colors: ['#0066ff'],
      },
      selection: '',

      // realtime
      seriesRealtime: [{
        name: 'Vlhkosť (%)',
        data: [],
      }],
      chartOptionsRealtime: {
        chart: {
          foreColor: localStorage.getItem('graph_text_color'),
          type: 'line',
          animations: {
            enabled: true,
            easing: 'linear',
            dynamicAnimation: {
              speed: 1000
            }
          },
          toolbar: {
            show: false
          }
        },
        grid: {
          show: true,
          strokeDashArray: 0,
          yaxis: {
            lines: {
              show: true,
            },
          },
          xaxis: {
            lines: {
              show: false,
            },
          },
        },
        stroke: {
          curve: 'smooth',
          width: 5,
        },
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
        title: {},
        xaxis: {
          // show: false,
          // type: 'category',
          // labels: {
          //   formatter: function(value) {
          //     return moment(value)
          //       .format('YYYY-MM-DD HH:mm:ss');
          //   },
          //   show: false,
          // },
          type: 'datetime',
          labels: {
            datetimeUTC: false,
            formatter: function(value) {
              return moment(value)
                .format('HH:mm:ss');
            },
          },
          tickAmount: 6,
          tooltip: {
            enabled: false,
          },
        },
        tooltip: {
          theme: localStorage.getItem('graph_theme'),
          x: {
            datetimeUTC: false,
            formatter: function(value) {
              return moment(value)
                .format('DD MMM yy HH:mm:ss');
            },
          }
        },
        legend: {
          show: false
        },
        colors: ['#0066ff'],
      },
    }
  },

  updated() {
    this.drawer = this.drawerNew;
  },
  computed: {},

  methods: {
    //for area historical chart
    updateData(timeline) {
      this.selection = timeline;

      switch (timeline) {
        case 'one_hour':
          this.$refs.historicalChart.zoomX(
            moment(new Date())
            .subtract(1, 'hours')
            .valueOf(),
            new Date()
            .getTime()
          )
          break
        case 'one_day':
          this.$refs.historicalChart.zoomX(
            moment(new Date())
            .subtract(1, 'days')
            .valueOf(),
            new Date()
            .getTime()
          )
          break
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

    getHistoricalData2() {
      axios.get('http://127.0.0.1:8000/api/getHistoricalData2Humidity')
        .then(res => {
          this.seriesCandle_stick[0].data.splice(0, 1)
          for (var i = 0; i < res.data.length; i++) {
            this.seriesCandle_stick[0].data.push({
              x: moment(res.data[i].timekey)
                .valueOf(),
              y: [res.data[i].first_open, res.data[i].max_value, res.data[i].min_value, res.data[i].last_close]
            });
          }
          this.seriesCandle_stick = [{
            data: this.seriesCandle_stick[0].data
          }];
        })
    },

    getHistoricalData3() {
      axios.get('http://127.0.0.1:8000/api/getHistoricalData3Humidity')
        .then(res => {
          // this.seriesColumn[0].data = [];
          this.seriesColumn[0].data.splice(0, 12);
          this.seriesColumn[0].data.push(
            res.data[0].Jan, res.data[0].Feb,
            res.data[0].Mar, res.data[0].Apr,
            res.data[0].May, res.data[0].Jun,
            res.data[0].Jul, res.data[0].Aug,
            res.data[0].Sep, res.data[0].Oct,
            res.data[0].Nov, res.data[0].Dec,
          );

          this.seriesColumn = [{
            data: this.seriesColumn[0].data
          }];
        });
    },

    getDataRealtime() {
      axios.get('http://127.0.0.1:8000/api/getDataRealtimeHumidity')
        .then(res => {
          localStorage.setItem("lastUpdateHumidity", moment(res.data[res.data.length - 1].created_at)
            .format('YYYY-MM-DD HH:mm:ss'));
          this.seriesRealtime[0].data.splice(0, 10);
          for (var i = 0; i < res.data.length; i++) {
            this.seriesRealtime[0].data.push([
              moment(res.data[i].created_at)
              .valueOf(),
              parseFloat(`${res.data[i].humi}`)
            ]);
          }

          this.seriesRealtime = [{
            name: 'Vlhkosť (%)',
            data: this.seriesRealtime[0].data
          }];

          this.seriesCircle.splice(0, 1);
          this.seriesCircle.push(parseFloat(res.data[res.data.length - 1].humi));
        })
    },

    getHistoricalData() {
      axios.get('http://127.0.0.1:8000/api/getHistoricalDataHumidity')
        .then(res => {
          this.series[0].data.splice(0, res.data.length);
          for (var i = 0; i < res.data.length; i++) {
            this.series[0].data.push([
              moment(res.data[i].created_at)
              .valueOf(),
              parseFloat(`${res.data[i].humi}`)
            ]);
          }
          this.series = [{
            name: 'Vlhkosť (%)',
            data: this.series[0].data
          }];
        })
    },
  },

  watch: {},

  mounted() {
    //do something after mounting vue instance
    this.getDataRealtime();
    this.getHistoricalData();
    this.getHistoricalData2();
    this.getHistoricalData3();
  },

  created() {
    //do something after creating vue instance
    window.Echo.channel('dataAllSensors')
      .listen('AllSensorsEvent', (e) => {
        //last update datetime
        this.lastUpdate = moment(e.dataAllSensors.created_at)
          .format('YYYY-MM-DD HH:mm:ss');
        localStorage.setItem("lastUpdateHumidity", moment(e.dataAllSensors.created_at)
          .format('YYYY-MM-DD HH:mm:ss'));
        //
        this.series[0].data.push([
          moment(e.dataAllSensors.created_at)
          .valueOf(),
          parseFloat(`${e.dataAllSensors.humi}`)
        ]);
        this.series = [{
          data: this.series[0].data
        }];
        //
        this.getDataRealtime();
        this.getHistoricalData2();
        this.getHistoricalData3();
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
