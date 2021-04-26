<template>
<v-lazy :options="{
        threshold: .1
      }" min-height="100vh" transition-group="scale-transition">
  <div class="home custom-margin-page">
    <v-card class="mx-auto ml-3 mr-3" elevation="0" tile>
      <v-app-bar fixed flat>
        <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>

        <v-toolbar-title>OpenLab FEI Tuke</v-toolbar-title>

        <v-spacer></v-spacer>

        <v-btn icon to="/notifications">
          <v-badge :content="this.$store.getters['notificationCounter']" :value="this.$store.getters['notificationCounter']" :offset-x="11" :offset-y="12" color="orange" overlap left bordered>
            <v-icon>mdi-bell</v-icon>
          </v-badge>
        </v-btn>

        <v-btn icon to="/settings">
          <v-icon>mdi-cog</v-icon>
        </v-btn>
      </v-app-bar>
    </v-card>
    <v-row class="m-0">
      <v-col cols="12" lg="6" md="12" sm="12">
        <v-card class="rounded" elevation="0" loader-height="6" :loading="loaderStateCircle_multiple">
          <div class="pt-3" id="chart">
            <apexchart type="radialBar" height="397" ref="circleMultipleChart" :options="chartOptionsCircle_multiple" :series="seriesCircle_multiple"></apexchart>
          </div>

          <v-card-text class="pt-0">
            <div class="title font-weight-light mb-2">
              Aktuálne hodnoty jednotlivých veličín
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

      <v-col cols="12" lg="6" md="12" sm="12">
        <v-card class="rounded" elevation="0" loader-height="6" :loading="loaderStateDashed">
          <div class="pt-3" id="chart">
            <apexchart type="line" height="350" ref="dashedChart" :options="chartOptionsDashed" :series="seriesDashed"></apexchart>
          </div>

          <v-card-text class="pt-0">
            <div class="title font-weight-light mb-2">
              Hodnoty teplôt a vlhkosti za poslednú hodinu
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

      <v-col cols="12" lg="12" md="12" sm="12">
        <v-card class="rounded" elevation="0" loader-height="6" :loading="loaderStateAreas">
          <div class="pt-3" id="wrapper">
            <div id="chart-area1">
              <apexchart type="area" height="160" ref="area1Chart" :options="chartOptionsArea1" :series="seriesArea1"></apexchart>
            </div>
            <div id="chart-area2">
              <apexchart type="area" height="160" ref="area2Chart" :options="chartOptionsArea2" :series="seriesArea2"></apexchart>
            </div>
            <div id="chart-area3">
              <apexchart type="area" height="160" ref="area3Chart" :options="chartOptionsArea3" :series="seriesArea3"></apexchart>
            </div>
            <div id="chart-area3">
              <apexchart type="area" height="160" ref="area4Chart" :options="chartOptionsArea4" :series="seriesArea4"></apexchart>
            </div>
            <div id="chart-area3">
              <apexchart type="area" height="160" ref="area5Chart" :options="chartOptionsArea5" :series="seriesArea5"></apexchart>
            </div>
            <div id="chart-area3">
              <apexchart type="area" height="160" ref="area6Chart" :options="chartOptionsArea6" :series="seriesArea6"></apexchart>
            </div>
          </div>

          <v-card-text class="pt-0">
            <div class="title font-weight-light mb-2">
              Priemerné hodnoty veličín za 10 minútové intervaly
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
      <v-col class="mb-5" cols="12" lg="12" md="12" sm="12">
        <v-card class="rounded" elevation="0" loader-height="6" :loading="loaderStateBar">

          <div class="pt-3" id="chart">
            <apexchart type="bar" height="350" ref="barChart" :options="chartOptionsBar" :series="seriesBar"></apexchart>
          </div>

          <v-card-text class="pt-0">
            <div class="title font-weight-light mb-2">
              Priemerné hodnoty za jednotlivé mesiace v danom roku
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
    <NavigationDrawer :drawer="drawer" />
    <BottomNavigation />
    <Footer />
  </div>
</v-lazy>
</template>

<script>
import axios from 'axios'
import moment from 'moment'
// import Apex from 'apexcharts'
import VueApexCharts from 'vue-apexcharts'
import Footer from "../components/Footer.vue";
import NavigationDrawer from "../components/NavigationDrawer.vue";
import BottomNavigation from "../components/BottomNavigation.vue";

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
      lastUpdate: localStorage.getItem('lastUpdateHome'),
      drawer: false,
      group: null,
      loaderStateCircle_multiple: true,
      loaderStateDashed: true,
      loaderStateAreas: true,
      loaderStateBar: true,

      //apexcharts synchronized
      seriesArea1: [{
        name: 'Teplota okolia (°C)',
        data: []
      }],
      chartOptionsArea1: {
        chart: {
          foreColor: localStorage.getItem('graph_text_color'),
          id: 'as',
          group: 'AllSensors',
          type: 'area',
          height: 160,
          toolbar: {
            tools: {
              download: false,
            },
          },
          animations: {
            enabled: true,
            easing: 'linear',
            dynamicAnimation: {
              speed: 1000
            }
          },
        },
        colors: ['#ff0000'],
        yaxis: {
          labels: {
            minWidth: 40
          }
        },
        xaxis: {
          type: 'datetime',
          labels: {
            datetimeUTC: false,
          },
          tooltip: {
            enabled: false,
          },
          tickPlacement: 'between',
        },
        tooltip: {
          theme: localStorage.getItem('graph_theme'),
          x: {
            datetimeUTC: false,
            formatter: function(value) {
              return moment(value)
                .format('DD MMM yy HH:mm');
            },
          }
        },
        dataLabels: {
          enabled: false,
        },
      },
      //area 2
      seriesArea2: [{
        name: 'Teplota na čipe (°C)',
        data: []
      }],
      chartOptionsArea2: {
        chart: {
          foreColor: localStorage.getItem('graph_text_color'),
          id: 'as',
          group: 'AllSensors',
          type: 'area',
          height: 160,
          toolbar: {
            tools: {
              download: false,
            },
          },
          animations: {
            enabled: true,
            easing: 'linear',
            dynamicAnimation: {
              speed: 1000
            }
          },
        },
        dataLabels: {
          style: {
            fontSize: '12px',
            fontWeight: 'bold',
          },
          background: {
            enabled: true,
            foreColor: '#fff',
            borderRadius: 2,
            padding: 5,
            opacity: 0.9,
            borderWidth: 0,
            borderColor: '#fff'
          },
          enabled: false,
          offsetY: -8,
          // offsetX: 12
        },
        colors: ['#ff6600'],
        yaxis: {
          labels: {
            minWidth: 40
          },
        },
        xaxis: {
          type: 'datetime',
          labels: {
            datetimeUTC: false,
          },
          tooltip: {
            enabled: false,
          },
          tickPlacement: 'between',
        },
        tooltip: {
          theme: localStorage.getItem('graph_theme'),
          x: {
            datetimeUTC: false,
            formatter: function(value) {
              return moment(value)
                .format('DD MMM yy HH:mm');
            },
          }
        },
      },
      //area3
      seriesArea3: [{
        name: 'Vlhkosť (%)',
        data: []
      }],
      chartOptionsArea3: {
        chart: {
          foreColor: localStorage.getItem('graph_text_color'),
          id: 'as',
          group: 'AllSensors',
          type: 'area',
          height: 160,
          toolbar: {
            tools: {
              download: false,
            },
          },
          animations: {
            enabled: true,
            easing: 'linear',
            dynamicAnimation: {
              speed: 1000
            }
          },
        },
        colors: ['#0066ff'],
        yaxis: {
          labels: {
            minWidth: 40
          }
        },
        xaxis: {
          type: 'datetime',
          labels: {
            datetimeUTC: false,
          },
          tooltip: {
            enabled: false,
          },
          tickPlacement: 'between',
        },
        tooltip: {
          theme: localStorage.getItem('graph_theme'),
          x: {
            datetimeUTC: false,
            formatter: function(value) {
              return moment(value)
                .format('DD MMM yy HH:mm');
            },
          }
        },
        dataLabels: {
          enabled: false,
        },
      },
      //area4
      seriesArea4: [{
        name: 'Hlasitosť',
        data: []
      }],
      chartOptionsArea4: {
        chart: {
          foreColor: localStorage.getItem('graph_text_color'),
          id: 'as',
          group: 'AllSensors',
          type: 'area',
          height: 160,
          toolbar: {
            tools: {
              download: false,
            },
          },
          animations: {
            enabled: true,
            easing: 'linear',
            dynamicAnimation: {
              speed: 1000
            }
          },
        },

        colors: ['#ffcc00'],
        yaxis: {
          labels: {
            minWidth: 40
          }
        },
        xaxis: {
          type: 'datetime',
          labels: {
            datetimeUTC: false,
          },
          tooltip: {
            enabled: false,
          },
          tickPlacement: 'between',
        },
        tooltip: {
          theme: localStorage.getItem('graph_theme'),
          x: {
            datetimeUTC: false,
            formatter: function(value) {
              return moment(value)
                .format('DD MMM yy HH:mm');
            },
          }
        },
        dataLabels: {
          enabled: false,
        },
      },
      //area5
      seriesArea5: [{
        name: 'Svetlo',
        data: []
      }],
      chartOptionsArea5: {
        chart: {
          foreColor: localStorage.getItem('graph_text_color'),
          id: 'as',
          group: 'AllSensors',
          type: 'area',
          height: 160,
          toolbar: {
            tools: {
              download: false,
            },
          },
          animations: {
            enabled: true,
            easing: 'linear',
            dynamicAnimation: {
              speed: 1000
            }
          },
        },
        colors: ['#737373'],
        yaxis: {
          labels: {
            minWidth: 40
          }
        },
        xaxis: {
          type: 'datetime',
          labels: {
            datetimeUTC: false,
          },
          tooltip: {
            enabled: false,
          },
          tickPlacement: 'between',
        },
        tooltip: {
          theme: localStorage.getItem('graph_theme'),
          x: {
            datetimeUTC: false,
            formatter: function(value) {
              return moment(value)
                .format('DD MMM yy HH:mm');
            },
          }
        },
        dataLabels: {
          enabled: false,
        },
      },
      //area6
      seriesArea6: [{
        name: 'Tlak',
        data: []
      }],
      chartOptionsArea6: {
        chart: {
          foreColor: localStorage.getItem('graph_text_color'),
          id: 'as',
          group: 'AllSensors',
          type: 'area',
          height: 160,
          toolbar: {
            tools: {
              download: false,
            },
          },
          animations: {
            enabled: true,
            easing: 'linear',
            dynamicAnimation: {
              speed: 1000
            }
          },
        },
        colors: ['#00b300'],
        yaxis: {
          labels: {
            minWidth: 40
          }
        },
        xaxis: {
          type: 'datetime',
          labels: {
            datetimeUTC: false,
          },
          tooltip: {
            enabled: false,
          },
          tickPlacement: 'on',
        },
        tooltip: {
          theme: localStorage.getItem('graph_theme'),
          x: {
            datetimeUTC: false,
            formatter: function(value) {
              return moment(value)
                .format('DD MMM yy HH:mm');
            },
          }
        },
        dataLabels: {
          enabled: false,
        },
      },
      //dashed chart
      seriesDashed: [{
          name: "Vlhkosť (%)",
          data: []
        },
        {
          name: "Teplota na čipe (°C)",
          data: []
        },
        {
          name: 'Teplota okolia (°C)',
          data: []
        }
      ],
      chartOptionsDashed: {
        chart: {
          foreColor: localStorage.getItem('graph_text_color'),
          height: 350,
          type: 'line',
          zoom: {
            enabled: false
          },
          toolbar: {
            tools: {
              download: false,
            },
          },
          animations: {
            enabled: true,
            easing: 'linear',
            dynamicAnimation: {
              speed: 1000
            }
          },
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          width: [5, 7, 5],
          curve: 'straight',
          dashArray: [5, 8, 0],
          colors: ["#0066ff", "#ff6600", "#ff0000"],
        },
        colors: ["#0066ff", "#ff6600", "#ff0000"],
        legend: {
          tooltipHoverFormatter: function(val, opts) {
            return val + ' - <strong>' + opts.w.globals.series[opts.seriesIndex][opts.dataPointIndex] + '</strong>'
          }
        },
        xaxis: {
          categories: [],
          tooltip: {
            enabled: false,
          },
        },
        tooltip: {
          theme: localStorage.getItem('graph_theme'),

          y: [{
              title: {
                formatter: function(val) {
                  return val + ""
                }
              }
            },
            {
              title: {
                formatter: function(val) {
                  return val + ""
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
      //bar chart
      seriesBar: [{
        name: 'Teplota okolia (°C)',
        data: []
      }, {
        name: 'Teplota na čipe (°C)',
        data: []
      }, {
        name: 'Vlhkosť (%)',
        data: []
      }],
      chartOptionsBar: {
        chart: {
          foreColor: localStorage.getItem('graph_text_color'),
          type: 'bar',
          height: 350,
          toolbar: {
            tools: {
              download: false,
            },
          },
          animations: {
            enabled: true,
            easing: 'linear',
            dynamicAnimation: {
              speed: 1000
            }
          },
        },
        plotOptions: {
          bar: {
            horizontal: false,
            columnWidth: '55%',
            endingShape: 'rounded'
          },
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          show: true,
          width: 1,
          colors: ['transparent']
        },
        xaxis: {
          categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Máj', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
          tooltip: {
            enabled: false,
          },
        },
        yaxis: {
          // title: {
          //   text: 'test'
          // }
        },
        fill: {
          opacity: 1
        },
        colors: ["#ff0000", "#ff6600", "#0066ff"],
        tooltip: {
          theme: localStorage.getItem('graph_theme'),
          // theme: this.tooltip_apex_graphs_theme,
          // y: {
          //   formatter: function(val) {
          //     return val + ""
          //   }
          // }
        }
      },
      // circle multiple chart
      seriesCircle_multiple: [],
      // chartOptionsCircle_multiple: {
      //   chart: {
      //     height: 350,
      //     type: 'radialBar',
      //   },
      //   plotOptions: {
      //     radialBar: {
      //       offsetY: 0,
      //       startAngle: 0,
      //       endAngle: 270,
      //       hollow: {
      //         margin: 5,
      //         size: '30%',
      //         background: 'transparent',
      //         image: undefined,
      //       },
      //       dataLabels: {
      //         name: {
      //           show: false,
      //         },
      //         value: {
      //           show: false,
      //         },
      //       },
      //       // track: {
      //       //   show: false,
      //       // },
      //     }
      //   },
      //   colors: ['#ff0000', '#ff6600', '#0066ff', '#ffcc00', '#737373'],
      //   labels: ['Teplota okolia', 'Teplota na čipe', 'Vlhkosť', 'Hlasitosť', 'Svetlo'],
      //   legend: {
      //     show: true,
      //     floating: true,
      //     fontSize: '16px',
      //     position: 'left',
      //     offsetX: 0,
      //     offsetY: 15,
      //     labels: {
      //       useSeriesColors: true,
      //     },
      //     markers: {
      //       size: 0
      //     },
      //     formatter: function(seriesName, opts) {
      //       return seriesName + ":  " + opts.w.globals.series[opts.seriesIndex]
      //     },
      //     itemMargin: {
      //       vertical: 3
      //     }
      //   },
      //   stroke: {
      //     lineCap: 'round'
      //   },
      //   responsive: [{
      //     breakpoint: 480,
      //     options: {
      //       legend: {
      //         show: false
      //       }
      //     }
      //   }]
      // },
      chartOptionsCircle_multiple: {
        chart: {
          foreColor: localStorage.getItem('graph_text_color'),
          height: 350,
          type: 'radialBar',
          toolbar: {
            tools: {
              download: false,
            },
          },
          animations: {
            enabled: true,
            easing: 'linear',
            dynamicAnimation: {
              speed: 1000
            }
          },
        },
        plotOptions: {
          radialBar: {
            dataLabels: {
              name: {
                fontSize: '22px',
              },
              value: {
                fontSize: '16px',
                formatter: function(val) {
                  return val
                },
              },
              hollow: {
                size: '70%',
              }
              // total: {
              //   show: true,
              //   label: 'Total',
              //   formatter: function() {
              //     // By default this function returns the average of all series. The below is just an example to show the use of custom formatter function
              //     return 249
              //   }
              // }
            },
            // track: {
            //   show: false,
            // },
            startAngle: 0,
            endAngle: 360
          }
        },
        stroke: {
          lineCap: 'round'
        },
        legend: {
          show: true,
          floating: false,
          position: 'bottom',
          horizontalAlign: 'center',
          formatter: function(seriesName, opts) {
            return seriesName + ":  " + opts.w.globals.series[opts.seriesIndex]
          },
        },
        colors: ['#00b300', '#ff0000', '#ff6600', '#0066ff', '#ffcc00', '#737373'],
        labels: ['Tlak', 'Teplota okolia', 'Teplota na čipe', 'Vlhkosť', 'Hlasitosť', 'Svetlo'],
      },
    }
  },

  methods: {
    getDataAreasGroup() {
      axios.get('http://127.0.0.1:8000/api/getDataAreasGroup')
        .then(res => {
          this.lastUpdate = moment(new Date)
            .format('YYYY-MM-DD HH:mm:ss');
          localStorage.setItem("lastUpdateHome", moment(new Date)
            .format('YYYY-MM-DD HH:mm:ss'));
          this.seriesArea1[0].data.splice(0, this.seriesArea1[0].data.length);
          this.seriesArea2[0].data.splice(0, this.seriesArea2[0].data.length);
          this.seriesArea3[0].data.splice(0, this.seriesArea3[0].data.length);
          this.seriesArea4[0].data.splice(0, this.seriesArea4[0].data.length);
          this.seriesArea5[0].data.splice(0, this.seriesArea5[0].data.length);
          this.seriesArea6[0].data.splice(0, this.seriesArea6[0].data.length);
          for (var i = 0; i < res.data[0][0].length; i++) {
            this.seriesArea1[0].data.push({
              x: moment(res.data[0][0][i].timekey)
                .valueOf(),
              y: [res.data[0][0][i].gtmp]
            });
            this.seriesArea2[0].data.push({
              x: moment(res.data[0][1][i].timekey)
                .valueOf(),
              y: [res.data[0][1][i].atmp]
            });
            this.seriesArea3[0].data.push({
              x: moment(res.data[0][2][i].timekey)
                .valueOf(),
              y: [res.data[0][2][i].humi]
            });
            this.seriesArea4[0].data.push({
              x: moment(res.data[0][3][i].timekey)
                .valueOf(),
              y: [res.data[0][3][i].vol]
            });
            this.seriesArea5[0].data.push({
              x: moment(res.data[0][4][i].timekey)
                .valueOf(),
              y: [res.data[0][4][i].light]
            });
            this.seriesArea6[0].data.push({
              x: moment(res.data[0][5][i].timekey)
                .valueOf(),
              y: [res.data[0][5][i].pres]
            });
          }
          this.seriesArea1 = [{
            data: this.seriesArea1[0].data
          }];
          this.seriesArea2 = [{
            data: this.seriesArea2[0].data
          }];
          this.seriesArea3 = [{
            data: this.seriesArea3[0].data
          }];
          this.seriesArea4 = [{
            data: this.seriesArea4[0].data
          }];
          this.seriesArea5 = [{
            data: this.seriesArea5[0].data
          }];
          this.seriesArea6 = [{
            data: this.seriesArea6[0].data
          }];

          this.loaderStateAreas = false;
        });
    },
    getDataDashed() {
      axios.get('http://127.0.0.1:8000/api/getDataHome')
        .then(res => {
          this.seriesDashed[0].data = res.data[0][2]
          this.seriesDashed[1].data = res.data[0][1]
          this.seriesDashed[2].data = res.data[0][0]

          this.chartOptionsDashed.xaxis.categories = res.data[0][3];
          this.chartOptionsDashed = {
            ...this.chartOptionsDashed,
            ...{
              xaxis: {
                categories: this.chartOptionsDashed.xaxis.categories,
                tooltip: {
                  enabled: false,
                },
              }
            }
          };
          this.loaderStateDashed = false;
        })
    },

    getDataLine() {
      axios.get('http://127.0.0.1:8000/api/getDataLine')
        .then(res => {
          this.seriesBar[0].data.splice(0, this.seriesBar[0].data.length);
          this.seriesBar[1].data.splice(0, this.seriesBar[1].data.length);
          this.seriesBar[2].data.splice(0, this.seriesBar[2].data.length);
          this.seriesBar[0].data.push(
            parseFloat(res.data[0][0][0].Jan), parseFloat(res.data[0][0][0].Feb),
            parseFloat(res.data[0][0][0].Mar), parseFloat(res.data[0][0][0].Apr),
            parseFloat(res.data[0][0][0].May), parseFloat(res.data[0][0][0].Jun),
            parseFloat(res.data[0][0][0].Jul), parseFloat(res.data[0][0][0].Aug),
            parseFloat(res.data[0][0][0].Sep), parseFloat(res.data[0][0][0].Oct),
            parseFloat(res.data[0][0][0].Nov), parseFloat(res.data[0][0][0].Dec),
          );
          this.seriesBar[1].data.push(
            parseFloat(res.data[0][1][0].Jan), parseFloat(res.data[0][1][0].Feb),
            parseFloat(res.data[0][1][0].Mar), parseFloat(res.data[0][1][0].Apr),
            parseFloat(res.data[0][1][0].May), parseFloat(res.data[0][1][0].Jun),
            parseFloat(res.data[0][1][0].Jul), parseFloat(res.data[0][1][0].Aug),
            parseFloat(res.data[0][1][0].Sep), parseFloat(res.data[0][1][0].Oct),
            parseFloat(res.data[0][1][0].Nov), parseFloat(res.data[0][1][0].Dec),
          );
          this.seriesBar[2].data.push(
            parseFloat(res.data[0][2][0].Jan), parseFloat(res.data[0][2][0].Feb),
            parseFloat(res.data[0][2][0].Mar), parseFloat(res.data[0][2][0].Apr),
            parseFloat(res.data[0][2][0].May), parseFloat(res.data[0][2][0].Jun),
            parseFloat(res.data[0][2][0].Jul), parseFloat(res.data[0][2][0].Aug),
            parseFloat(res.data[0][2][0].Sep), parseFloat(res.data[0][2][0].Oct),
            parseFloat(res.data[0][2][0].Nov), parseFloat(res.data[0][2][0].Dec),
          );
          this.chartOptionsBar = {
            ...this.chartOptionsBar,
            ...{
              xaxis: {
                categories: this.chartOptionsBar.xaxis.categories,
                tooltip: {
                  enabled: false,
                },
              }
            }
          };

          this.loaderStateBar = false;
        });
    },

    getDataCircleMultiple() {
      axios.get('http://127.0.0.1:8000/api/getDataCircleMultiple')
        .then(res => {
          this.seriesCircle_multiple.splice(0, this.seriesCircle_multiple.length);
          this.seriesCircle_multiple.push(
            parseFloat(res.data[0].pres), parseFloat(res.data[0].gtmp),
            parseFloat(res.data[0].atmp), parseFloat(res.data[0].humi),
            parseFloat(res.data[0].vol), parseFloat(res.data[0].light),
          );

          this.loaderStateCircle_multiple = false;
        });
    }
  },

  watch: {
    group() {
      this.drawer = false
    }
  },

  updated() {
    this.drawer = this.drawerState;
  },

  mounted() {
    //do something after mounting vue instance
    this.getDataAreasGroup();
    this.getDataDashed();
    this.getDataLine();
    this.getDataCircleMultiple();
  },

  created() {
    //do something after creating vue instance
    window.Echo.channel('dataAllSensors')
      .listen('AllSensorsEvent', (e) => {
        console.log(e);
        this.lastUpdate = moment(e.dataAllSensors.created_at)
          .format('YYYY-MM-DD HH:mm:ss');
        localStorage.setItem("lastUpdateHome", moment(e.dataAllSensors.created_at)
          .format('YYYY-MM-DD HH:mm:ss'));

        this.seriesCircle_multiple.splice(0, this.seriesCircle_multiple.length);
        this.seriesCircle_multiple.push(
          parseFloat(e.dataAllSensors.pres), parseFloat(e.dataAllSensors.gtmp),
          parseFloat(e.dataAllSensors.atmp), parseFloat(e.dataAllSensors.humi),
          parseFloat(e.dataAllSensors.vol), parseFloat(e.dataAllSensors.light),
        );

        this.getDataAreasGroup();
        this.getDataDashed();
        this.getDataLine();
      })
  }
};
</script>

<style>

</style>
