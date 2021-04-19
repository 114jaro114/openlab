<template>
<div class="home w-100 h-100 custom-margin-page">
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

          <v-btn icon>
            <v-icon>mdi-dots-vertical</v-icon>
          </v-btn>
        </v-app-bar>
      </v-card>
      <v-row class="mx-auto">
        <v-col class="mb-5" cols="12" lg="6" md="12" sm="12">
          <v-card elevation="0">
            <v-sheet class="v-sheet--offset mx-auto rounded" elevation="0" max-width="calc(100% - 32px)" rounded>
              <div id="chart">
                <apexchart type="bar" height="350" :options="chartOptionsColumn" :series="seriesColumn"></apexchart>
              </div>
            </v-sheet>

            <v-card-text class="pt-0">
              <div class="title font-weight-light mb-2">
                1
              </div>
              <v-divider class="my-2"></v-divider>
              <v-icon class="mr-2" small>
                mdi-clock
              </v-icon>
              <span class="caption grey--text font-weight-light">Posledná aktualizácia pred 26 minutami</span>
            </v-card-text>
          </v-card>
        </v-col>

        <v-col class="mb-5" cols="12" lg="6" md="12" sm="12">
          <v-card elevation="0">
            <v-sheet class="v-sheet--offset mx-auto rounded" elevation="0" max-width="calc(100% - 32px)" rounded>
              <div id="chart">
                <apexchart type="line" height="350" :options="chartOptionsDashed" :series="seriesDashed"></apexchart>
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

        <v-col class="mb-5" cols="12" lg="12" md="12" sm="12">
          <v-card elevation="0">
            <v-sheet class="v-sheet--offset mx-auto rounded" elevation="0" max-width="calc(100% - 32px)">
              <div id="wrapper">
                <div id="chart-line">
                  <apexchart type="line" height="160" :options="chartOptions" :series="series"></apexchart>
                </div>
                <div id="chart-line2">
                  <apexchart type="line" height="160" :options="chartOptionsLine2" :series="seriesLine2"></apexchart>
                </div>
                <div id="chart-area">
                  <apexchart type="area" height="160" :options="chartOptionsArea" :series="seriesArea"></apexchart>
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

        <v-col class="mb-5" cols="12" lg="6" md="12" sm="12">
          <v-card elevation="0">
            <v-sheet class="v-sheet--offset mx-auto" elevation="0" max-width="calc(100% - 32px)" rounded>
              <div id="chart">
                <apexchart type="radialBar" height="350" :options="chartOptionsCircle_multiple" :series="seriesCircle_multiple"></apexchart>
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
import mqtt from 'mqtt'
import Apex from 'apexcharts'
import VueApexCharts from 'vue-apexcharts'
import Footer from "../components/Footer.vue";
import NavigationDrawer from "../components/NavigationDrawer.vue";
import BottomNavigation from "../components/BottomNavigation.vue";

// Replace Math.random() with a pseudo-random number generator to get reproducible results in e2e tests
// Based on https://gist.github.com/blixt/f17b47c62508be59987b
var _seed = 42;
Math.random = function() {
  _seed = _seed * 16807 % 2147483647;
  return (_seed - 1) / 2147483646;
};

// The global window.Apex variable below can be used to set common options for all charts on the page
// Apex = {
//   chart: {
//     height: 160,
//   },
//   dataLabels: {
//     enabled: false
//   },
//   stroke: {
//     curve: 'straight'
//   },
//   toolbar: {
//     tools: {
//       selection: false
//     }
//   },
//   markers: {
//     size: 6,
//     hover: {
//       size: 10
//     }
//   },
//   tooltip: {
//     followCursor: false,
//     theme: 'dark',
//     x: {
//       show: false
//     },
//     marker: {
//       show: false
//     },
//     y: {
//       title: {
//         formatter: function() {
//           return ''
//         }
//       }
//     }
//   },
//   grid: {
//     clipMarkers: false
//   },
//   yaxis: {
//     tickAmount: 2
//   },
// }

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

export default {
  name: "Home",
  props: ['drawerState'],
  components: {
    Footer,
    NavigationDrawer,
    BottomNavigation,
    apexchart: VueApexCharts,
  },
  data() {
    return {
      connection: {
        host: 'openlab.kpi.fei.tuke.sk',
        port: 80,
        endpoint: '/mqtt',
        clean: true, // Reserved session
        connectTimeout: 4000, // Time out
        reconnectPeriod: 4000, // Reconnection interval
        // Certification Information
        // clientId: 'mqttjs_3be2c321',
        // username: 'emqx_test',
        // password: 'emqx_test',
      },
      receiveNews: '',
      subscription: {
        topic: 'openlab/sensorkits/B8:27:EB:2F:7B:7D/humi',
        qos: 0,
      },
      client: {
        connected: false,
      },
      subscribeSuccess: false,
      drawer: false,
      group: null,

      //apexcharts synchronized
      series: [{
        data: generateDayWiseTimeSeries(new Date('11 Feb 2017')
          .getTime(), 20, {
            min: 10,
            max: 60
          })
      }],
      chartOptions: {
        chart: {
          id: 'fb',
          group: 'social',
          type: 'line',
          height: 160
        },
        Apex,
        colors: ['#008FFB'],
        yaxis: {
          labels: {
            minWidth: 40
          }
        },
        xaxis: {
          type: 'datetime',
        },
      },

      seriesLine2: [{
        data: generateDayWiseTimeSeries(new Date('11 Feb 2017')
          .getTime(), 20, {
            min: 10,
            max: 30
          })
      }],
      chartOptionsLine2: {
        chart: {
          id: 'tw',
          group: 'social',
          type: 'line',
          height: 160
        },
        Apex,
        colors: ['#546E7A'],
        yaxis: {
          labels: {
            minWidth: 40
          }
        },
        xaxis: {
          type: 'datetime',
        },
      },

      seriesArea: [{
        data: generateDayWiseTimeSeries(new Date('11 Feb 2017')
          .getTime(), 20, {
            min: 10,
            max: 60
          })
      }],
      chartOptionsArea: {
        chart: {
          id: 'yt',
          group: 'social',
          type: 'area',
          height: 160
        },
        Apex,
        colors: ['#00E396'],
        yaxis: {
          labels: {
            minWidth: 40
          }
        },
        xaxis: {
          type: 'datetime',
        },
      },
      //
      seriesDashed: [{
          name: "Session Duration",
          data: [45, 52, 38, 24, 33, 26, 21, 20, 6, 8, 15, 10]
        },
        {
          name: "Page Views",
          data: [35, 41, 62, 42, 13, 18, 29, 37, 36, 51, 32, 35]
        },
        {
          name: 'Total Visits',
          data: [87, 57, 74, 99, 75, 38, 62, 47, 82, 56, 45, 47]
        }
      ],
      chartOptionsDashed: {
        chart: {
          height: 350,
          type: 'line',
          zoom: {
            enabled: false
          },
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          width: [5, 7, 5],
          curve: 'straight',
          dashArray: [0, 8, 5]
        },
        title: {
          text: 'Page Statistics',
          align: 'left'
        },
        legend: {
          tooltipHoverFormatter: function(val, opts) {
            return val + ' - <strong>' + opts.w.globals.series[opts.seriesIndex][opts.dataPointIndex] + '</strong>'
          }
        },
        markers: {
          size: 0,
          hover: {
            sizeOffset: 6
          }
        },
        xaxis: {
          categories: ['01 Jan', '02 Jan', '03 Jan', '04 Jan', '05 Jan', '06 Jan', '07 Jan', '08 Jan', '09 Jan',
            '10 Jan', '11 Jan', '12 Jan'
          ],
        },
        tooltip: {
          y: [{
              title: {
                formatter: function(val) {
                  return val + " (mins)"
                }
              }
            },
            {
              title: {
                formatter: function(val) {
                  return val + " per session"
                }
              }
            },
            {
              title: {
                formatter: function(val) {
                  return val;
                }
              }
            }
          ]
        },
        grid: {
          borderColor: '#f1f1f1',
        }
      },
      //column chart
      seriesColumn: [{
        name: 'Inflation',
        data: [2.3, 3.1, 4.0, 10.1, 4.0, 3.6, 3.2, 2.3, 1.4, 0.8, 0.5, 0.2]
      }],
      chartOptionsColumn: {
        chart: {
          height: 350,
          type: 'bar',
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
          enabled: true,
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
            show: false,
            formatter: function(val) {
              return val + "%";
            }
          }

        },
        title: {
          text: 'Monthly Inflation in Argentina, 2002',
          floating: true,
          offsetY: 330,
          align: 'center',
          style: {
            color: '#444'
          }
        }
      },
      // circle multiple chart
      seriesCircle_multiple: [44, 55, 67, 83],
      chartOptionsCircle_multiple: {
        chart: {
          height: 350,
          type: 'radialBar',
        },
        plotOptions: {
          radialBar: {
            dataLabels: {
              name: {
                fontSize: '22px',
              },
              value: {
                fontSize: '16px',
              },
              total: {
                show: true,
                label: 'Total',
                formatter: function() {
                  // By default this function returns the average of all series. The below is just an example to show the use of custom formatter function
                  return 249
                }
              }
            }
          }
        },
        labels: ['Apples', 'Oranges', 'Bananas', 'Berries'],
      },
      //
    }
  },

  methods: {
    // Create connection
    createConnection() {
      // Connect string, and specify the connection method used through protocol
      // ws unencrypted WebSocket connection
      // wss encrypted WebSocket connection
      // mqtt unencrypted TCP connection
      // mqtts encrypted TCP connection
      // wxs WeChat mini app connection
      // alis Alipay mini app connection
      const {
        host,
        port,
        endpoint,
        ...options
      } = this.connection
      const connectUrl = `ws://${host}:${port}${endpoint}`
      try {
        this.client = mqtt.connect(connectUrl, options)
      } catch (error) {
        console.log('mqtt.connect error', error)
      }
      this.client.on('connect', () => {
        console.log('Connection succeeded!')
        this.doSubscribe();
      })
      this.client.on('error', error => {
        console.log('Connection failed', error)
      })
      this.client.on('message', (topic, message) => {
        this.receiveNews = this.receiveNews.concat(message)
        console.log(`Received message ${message} from topic ${topic}`)
      })
    },

    doSubscribe() {
      const {
        topic,
        qos
      } = this.subscription
      this.client.subscribe(topic, {
        qos
      }, (error, res) => {
        if (error) {
          console.log('Subscribe to topics error', error)
          return
        }
        this.subscribeSuccess = true
        console.log('Subscribe to topics res', res)
      })
    },
  },

  watch: {
    group() {
      this.drawer = false
    },
  },

  updated() {
    this.drawer = this.drawerState;
  },

  mounted() {
    //do something after mounting vue instance
    console.log('Component Welcome mounted.')
  },

  created() {
    console.log('Component Welcome created')
  },
};
</script>

<style>

</style>
