<template>
<div class="lights custom-margin-page">
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
            <v-icon>mdi-bell</v-icon>
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
                <apexchart type="radialBar" ref="strokedGauge" height="385" :options="chartOptionsStroked_gauge" :series="seriesStroked_gauge"></apexchart>
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
                Priemerná vlhkosť za jednotlivé mesiace v roku
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
                Aktuálna vlhkosť posledných 5 minút
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
                Najvyššia, najnižšia, prvá a posledná hodnota za 1-hodinové intervaly
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
                  <v-btn icon color="primary" id="one_hour" @click="updateData('one_hour')" class="mr-2" :class="{active: selection==='one_hour'}">
                    1H
                  </v-btn>
                  <v-btn icon color="primary" id="one_day" @click="updateData('one_day')" class="mr-2" :class="{active: selection==='one_day'}">
                    1D
                  </v-btn>
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
// import mqtt from 'mqtt'
import VueApexCharts from 'vue-apexcharts'
import Footer from "../components/Footer.vue";
import NavigationDrawer from "../components/NavigationDrawer.vue";
import BottomNavigation from "../components/BottomNavigation.vue";
import SpeedDial from "../components/SpeedDial.vue";

export default {
  name: "Lights",
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
      lastUpdate: localStorage.getItem('lastUpdateLights'),
      //apexchart stroked gauge
      // seriesStroked_gauge: [],
      // chartOptionsStroked_gauge: {
      //   chart: {
      //     type: 'radialBar',
      //   },
      //   plotOptions: {
      //     radialBar: {
      //       startAngle: -135,
      //       endAngle: 135,
      //       dataLabels: {
      //         name: {
      //           fontSize: '16px',
      //           color: undefined,
      //           offsetY: 120
      //         },
      //         value: {
      //           offsetY: 76,
      //           fontSize: '22px',
      //           color: undefined,
      //           formatter: function(val) {
      //             return val + "";
      //           }
      //         }
      //       },
      //     }
      //   },
      //   fill: {
      //     type: 'gradient',
      //     gradient: {
      //       shade: 'dark',
      //       shadeIntensity: 0.15,
      //       inverseColors: false,
      //       opacityFrom: 1,
      //       opacityTo: 1,
      //       stops: [0, 50, 65, 91]
      //     },
      //   },
      //   stroke: {
      //     dashArray: 4
      //   },
      //   labels: ['Vlhkosť (%)'],
      // },
      seriesStroked_gauge: [],
      chartOptionsStroked_gauge: {
        chart: {
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
              position: 'front',
              // dropShadow: {
              //   enabled: true,
              //   top: 3,
              //   left: 0,
              //   blur: 4,
              //   opacity: 0.24
              // }
            },
            // track: {
            //   background: '#fff',
            //   strokeWidth: '67%',
            //   margin: 0, // margin is in pixels
            //   dropShadow: {
            //     enabled: true,
            //     top: -3,
            //     left: 0,
            //     blur: 4,
            //     opacity: 0.35
            //   }
            // },

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
        fill: {
          // type: 'gradient',
          type: 'solid',
          colors: ['#0066ff'],
          // gradient: {
          //   shade: 'dark',
          //   type: 'horizontal',
          //   shadeIntensity: 0.5,
          //   gradientToColors: ['#ABE5A1'],
          //   inverseColors: true,
          //   opacityFrom: 1,
          //   opacityTo: 1,
          //   stops: [0, 100]
          // }
        },
        stroke: {
          lineCap: 'round'
        },
        labels: ['%'],
      },
      //column chart
      seriesColumn: [{
        name: 'Priemerná vlhkosť (%)',
        data: []
      }],
      chartOptionsColumn: {
        chart: {
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
            return val + "%";
          },
          offsetY: -20,
          style: {
            fontSize: '12px',
            colors: ["#304758"]
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
          crosshairs: {
            fill: {
              type: 'gradient',
              gradient: {
                colorFrom: '#D8E3F0',
                colorTo: '#BED1E6',
                stops: [0, 100],
                opacityFrom: 0.4,
                opacityTo: 0.5,
              }
            }
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
              return val + "%";
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
      },
      //candlestick chart
      seriesCandle_stick: [{
        data: []
      }],
      chartOptionsCandle_stick: {
        chart: {
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
        // title: {
        //   text: 'CandleStick graf',
        //   align: 'left'
        // },
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
      },
      selection: '',

      // realtime
      seriesRealtime: [{
        name: 'Vlhkosť (%)',
        data: [],
      }],
      chartOptionsRealtime: {
        // colors: ['#FCCF31', '#17ead9', '#f02fc2'],
        chart: {
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
      },
    }
  },

  updated() {
    this.drawer = this.drawerNew;
  },
  computed: {},

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

    getHis2() {
      axios.get('http://127.0.0.1:8000/api/getHistoricalData2')
        .then(res => {
          this.seriesCandle_stick[0].data.splice(0, 1)
          for (var i = 0; i < res.data.length; i++) {
            this.seriesCandle_stick[0].data.push({
              x: moment(res.data[i].timekey)
                .valueOf(),
              y: [res.data[i].first_open, res.data[i].max_value, res.data[i].min_value, res.data[i].last_close]
            });
          }
          this.$refs.candlestick.updateSeries([{
            data: this.seriesCandle_stick[0].data,
          }]);

          this.$refs.candlestick.updateOptions({
            series: [{
              data: this.seriesCandle_stick[0].data,
            }],
          })
        })
    },

    getHis3() {
      axios.get('http://127.0.0.1:8000/api/getHistoricalData3')
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

          this.$refs.column_chart.updateSeries([{
            data: this.seriesColumn[0].data,
          }]);
        })
    }
  },

  watch: {},

  mounted() {
    //do something after mounting vue instance
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

    this.seriesStroked_gauge.push(0);

    this.getHis2();
    this.getHis3();
  },

  created() {
    //do something after creating vue instance
    // if (localStorage.getItem('lastUpdateLights') == null) {
    //   this.lastUpdate = localStorage.getItem('lastUpdateLights');
    // }
    window.Echo.channel('test')
      .listen('HumEvent', (e) => {
        // console.log(e);
        this.lastUpdate = moment(e.humidity.created_at)
          .format('YYYY-MM-DD HH:mm:ss');
        localStorage.setItem("lastUpdateLights", moment(e.humidity.created_at)
          .format('YYYY-MM-DD HH:mm:ss'));
        if (this.seriesRealtime[0].data.length == 10) {
          this.seriesRealtime[0].data.splice(0, 1);
        }
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
        this.getHis2();
        this.getHis3();
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
