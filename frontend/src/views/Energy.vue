<template>
<div class="energy custom-margin-page">
  <v-lazy :options="{
            threshold: .4
          }" min-height="100vh" transition-group="scale-transition">
    <div class="">
      <v-card class="mx-auto ml-3 mr-3" elevation="0" tile>
        <v-app-bar fixed flat>
          <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>

          <v-toolbar-title class="title_toolbar">OpenLab FEI Tuke</v-toolbar-title>

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
        <!-- char for I -->
        <v-col cols="12" lg="6" md="12" sm="12">
          <v-card class="rounded" elevation="0" loader-height="6" :loading="loaderStateDashedI">
            <div class="pt-3" id="chart">
              <apexchart type="line" height="350" ref="dashedChart" :options="chartOptionsDashedI" :series="seriesDashedI"></apexchart>
            </div>

            <v-card-text class="pt-0">
              <div class="title font-weight-light mb-2">
                <span>Hodnoty </span><span class="font-weight-bold">prúdu (I) </span><span>z 3 fáz za poslednú hodinu</span>
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
        <!-- char for U -->
        <v-col cols="12" lg="6" md="12" sm="12">
          <v-card class="rounded" elevation="0" loader-height="6" :loading="loaderStateDashedU">
            <div class="pt-3" id="chart">
              <apexchart type="line" height="350" ref="dashedChart" :options="chartOptionsDashedU" :series="seriesDashedU"></apexchart>
            </div>

            <v-card-text class="pt-0">
              <div class="title font-weight-light mb-2">
                <span>Hodnoty </span><span class="font-weight-bold">napätia (U) </span><span>z 3 fáz za poslednú hodinu</span>
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
        <!-- char for P -->
        <v-col cols="12" lg="6" md="12" sm="12">
          <v-card class="rounded" elevation="0" loader-height="6" :loading="loaderStateDashedP">
            <div class="pt-3" id="chart">
              <apexchart type="line" height="350" ref="dashedChart" :options="chartOptionsDashedP" :series="seriesDashedP"></apexchart>
            </div>

            <v-card-text class="pt-0">
              <div class="title font-weight-light mb-2">
                <span>Hodnoty </span><span class="font-weight-bold">činného výkonu (P) </span><span>z 3 fáz za poslednú hodinu</span>
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
        <!-- char for Q -->
        <v-col cols="12" lg="6" md="12" sm="12">
          <v-card class="rounded" elevation="0" loader-height="6" :loading="loaderStateDashedQ">
            <div class="pt-3" id="chart">
              <apexchart type="line" height="350" ref="dashedChart" :options="chartOptionsDashedQ" :series="seriesDashedQ"></apexchart>
            </div>

            <v-card-text class="pt-0">
              <div class="title font-weight-light mb-2">
                <span>Hodnoty </span><span class="font-weight-bold">jalového výkonu (Q) </span><span>z 3 fáz za poslednú hodinu</span>
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
        <!-- char for S -->
        <v-col cols="12" lg="12" md="12" sm="12">
          <v-card class="rounded" elevation="0" loader-height="6" :loading="loaderStateDashedS">
            <div class="pt-3" id="chart">
              <apexchart type="line" height="350" ref="dashedChart" :options="chartOptionsDashedS" :series="seriesDashedS"></apexchart>
            </div>

            <v-card-text class="pt-0">
              <div class="title font-weight-light mb-2">
                <span>Hodnoty </span><span class="font-weight-bold">komplexného napájania (S) </span><span>z 3 fáz za poslednú hodinu</span>
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
        <!-- char for E_E -->
        <v-col cols="12" lg="6" md="12" sm="12">
          <v-card class="rounded" elevation="0" loader-height="6" :loading="loaderStateDashedE_E">
            <div class="pt-3" id="chart">
              <apexchart type="line" height="350" ref="dashedChart" :options="chartOptionsDashedE_E" :series="seriesDashedE_E"></apexchart>
            </div>

            <v-card-text class="pt-0">
              <div class="title font-weight-light mb-2">
                <span>Hodnoty </span><span class="font-weight-bold">exportu energie (E_E) </span><span>z 3 fázy za poslednú hodinu</span>
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
        <!-- char for E_I -->
        <v-col class="mb-5" cols="12" lg="6" md="12" sm="12">
          <v-card class="rounded" elevation="0" loader-height="6" :loading="loaderStateDashedE_I">
            <div class="pt-3" id="chart">
              <apexchart type="line" height="350" ref="dashedChart" :options="chartOptionsDashedE_I" :series="seriesDashedE_I"></apexchart>
            </div>

            <v-card-text class="pt-0">
              <div class="title font-weight-light mb-2">
                <span>Hodnoty </span><span class="font-weight-bold">importu energie (E_I) </span><span>z 3 fázy za poslednú hodinu</span>
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
import axios from 'axios';
import moment from 'moment';
import VueApexCharts from 'vue-apexcharts';
import Footer from "../components/Footer.vue";
import NavigationDrawer from "../components/NavigationDrawer.vue";
import BottomNavigation from "../components/BottomNavigation.vue";
import SpeedDial from "../components/SpeedDial.vue";

export default {
  name: "Energy",
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
      loaderStateDashedI: true,
      loaderStateDashedU: true,
      loaderStateDashedP: true,
      loaderStateDashedS: true,
      loaderStateDashedQ: true,
      loaderStateDashedE_E: true,
      loaderStateDashedE_I: true,
      lastUpdate: localStorage.getItem('lastUpdateEnergy'),
      //dashed chart for I
      seriesDashedI: [{
          name: "L1:",
          data: []
        },
        {
          name: "L2:",
          data: []
        },
        {
          name: 'L3:',
          data: []
        }
      ],
      chartOptionsDashedI: {
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
          dashArray: [0, 8, 5],
          colors: ["#ff0000", "#ff6600", "#0066ff"],
        },
        colors: ["#ff0000", "#ff6600", "#0066ff"],
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

      //dashed chart for U
      seriesDashedU: [{
          name: "L1:",
          data: []
        },
        {
          name: "L2:",
          data: []
        },
        {
          name: 'L3:',
          data: []
        }
      ],
      chartOptionsDashedU: {
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
          dashArray: [0, 8, 5],
          colors: ["#ff0000", "#ff6600", "#0066ff"],
        },
        colors: ["#ff0000", "#ff6600", "#0066ff"],
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

      //dashed chart for P
      seriesDashedP: [{
          name: "L1:",
          data: []
        },
        {
          name: "L2:",
          data: []
        },
        {
          name: 'L3:',
          data: []
        }
      ],
      chartOptionsDashedP: {
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
          dashArray: [0, 8, 5],
          colors: ["#ff0000", "#ff6600", "#0066ff"],
        },
        colors: ["#ff0000", "#ff6600", "#0066ff"],
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

      //dashed chart for Q
      seriesDashedQ: [{
          name: "L1:",
          data: []
        },
        {
          name: "L2:",
          data: []
        },
        {
          name: 'L3:',
          data: []
        }
      ],
      chartOptionsDashedQ: {
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
          dashArray: [0, 8, 5],
          colors: ["#ff0000", "#ff6600", "#0066ff"],
        },
        colors: ["#ff0000", "#ff6600", "#0066ff"],
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

      //dashed chart for S
      seriesDashedS: [{
          name: "L1:",
          data: []
        },
        {
          name: "L2:",
          data: []
        },
        {
          name: 'L3:',
          data: []
        }
      ],
      chartOptionsDashedS: {
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
          dashArray: [0, 8, 5],
          colors: ["#ff0000", "#ff6600", "#0066ff"],
        },
        colors: ["#ff0000", "#ff6600", "#0066ff"],
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

      //dashed chart for E_E
      seriesDashedE_E: [{
          name: "L1:",
          data: []
        },
        {
          name: "L2:",
          data: []
        },
        {
          name: 'L3:',
          data: []
        }
      ],

      chartOptionsDashedE_E: {
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
          dashArray: [0, 8, 5],
          colors: ["#ff0000", "#ff6600", "#0066ff"],
        },
        colors: ["#ff0000", "#ff6600", "#0066ff"],
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

      //dashed chart for E_I
      seriesDashedE_I: [{
          name: "L1:",
          data: []
        },
        {
          name: "L2:",
          data: []
        },
        {
          name: 'L3:',
          data: []
        }
      ],
      chartOptionsDashedE_I: {
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
          dashArray: [0, 8, 5],
          colors: ["#ff0000", "#ff6600", "#0066ff"],
        },
        colors: ["#ff0000", "#ff6600", "#0066ff"],
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

    }
  },

  updated() {
    this.drawer = this.drawerNew;
  },

  methods: {
    getDataDashedU() {
      axios.get('http://127.0.0.1:8000/api/getDataDashedU')
        .then(res => {
          this.lastUpdate = moment(new Date)
            .format('YYYY-MM-DD HH:mm:ss');
          localStorage.setItem("lastUpdateEnergy", moment(new Date)
            .format('YYYY-MM-DD HH:mm:ss'));
          this.seriesDashedU[0].data = res.data[0][0]
          this.seriesDashedU[1].data = res.data[0][1]
          this.seriesDashedU[2].data = res.data[0][2]

          this.chartOptionsDashedU.xaxis.categories = res.data[0][3];
          this.chartOptionsDashedU = {
            ...this.chartOptionsDashedU,
            ...{
              xaxis: {
                categories: this.chartOptionsDashedU.xaxis.categories,
                tooltip: {
                  enabled: false,
                },
              }
            }
          }
          this.loaderStateDashedU = false;
        })
    },
    getDataDashedI() {
      axios.get('http://127.0.0.1:8000/api/getDataDashedI')
        .then(res => {
          this.seriesDashedI[0].data = res.data[0][0]
          this.seriesDashedI[1].data = res.data[0][1]
          this.seriesDashedI[2].data = res.data[0][2]

          this.chartOptionsDashedI.xaxis.categories = res.data[0][3];
          this.chartOptionsDashedI = {
            ...this.chartOptionsDashedI,
            ...{
              xaxis: {
                categories: this.chartOptionsDashedI.xaxis.categories,
                tooltip: {
                  enabled: false,
                },
              }
            }
          }
          this.loaderStateDashedI = false;
        })
    },
    getDataDashedP() {
      axios.get('http://127.0.0.1:8000/api/getDataDashedP')
        .then(res => {
          this.seriesDashedP[0].data = res.data[0][0]
          this.seriesDashedP[1].data = res.data[0][1]
          this.seriesDashedP[2].data = res.data[0][2]

          this.chartOptionsDashedP.xaxis.categories = res.data[0][3];
          this.chartOptionsDashedP = {
            ...this.chartOptionsDashedP,
            ...{
              xaxis: {
                categories: this.chartOptionsDashedP.xaxis.categories,
                tooltip: {
                  enabled: false,
                },
              }
            }
          }
          this.loaderStateDashedP = false;
        })
    },
    getDataDashedS() {
      axios.get('http://127.0.0.1:8000/api/getDataDashedS')
        .then(res => {
          this.seriesDashedS[0].data = res.data[0][0]
          this.seriesDashedS[1].data = res.data[0][1]
          this.seriesDashedS[2].data = res.data[0][2]

          this.chartOptionsDashedS.xaxis.categories = res.data[0][3];
          this.chartOptionsDashedS = {
            ...this.chartOptionsDashedS,
            ...{
              xaxis: {
                categories: this.chartOptionsDashedS.xaxis.categories,
                tooltip: {
                  enabled: false,
                },
              }
            }
          }
          this.loaderStateDashedS = false;
        })
    },
    getDataDashedQ() {
      axios.get('http://127.0.0.1:8000/api/getDataDashedQ')
        .then(res => {
          this.seriesDashedQ[0].data = res.data[0][0]
          this.seriesDashedQ[1].data = res.data[0][1]
          this.seriesDashedQ[2].data = res.data[0][2]

          this.chartOptionsDashedQ.xaxis.categories = res.data[0][3];
          this.chartOptionsDashedQ = {
            ...this.chartOptionsDashedQ,
            ...{
              xaxis: {
                categories: this.chartOptionsDashedQ.xaxis.categories,
                tooltip: {
                  enabled: false,
                },
              }
            }
          }
          this.loaderStateDashedQ = false;
        })
    },
    getDataDashedE_I() {
      axios.get('http://127.0.0.1:8000/api/getDataDashedE_I')
        .then(res => {
          this.seriesDashedE_I[0].data = res.data[0][0]
          this.seriesDashedE_I[1].data = res.data[0][1]
          this.seriesDashedE_I[2].data = res.data[0][2]

          this.chartOptionsDashedE_I.xaxis.categories = res.data[0][3];
          this.chartOptionsDashedE_I = {
            ...this.chartOptionsDashedE_I,
            ...{
              xaxis: {
                categories: this.chartOptionsDashedE_I.xaxis.categories,
                tooltip: {
                  enabled: false,
                },
              }
            }
          }
          this.loaderStateDashedE_I = false;
        })
    },
    getDataDashedE_E() {
      axios.get('http://127.0.0.1:8000/api/getDataDashedE_E')
        .then(res => {
          this.seriesDashedE_E[0].data = res.data[0][0]
          this.seriesDashedE_E[1].data = res.data[0][1]
          this.seriesDashedE_E[2].data = res.data[0][2]

          this.chartOptionsDashedE_E.xaxis.categories = res.data[0][3];
          this.chartOptionsDashedE_E = {
            ...this.chartOptionsDashedE_E,
            ...{
              xaxis: {
                categories: this.chartOptionsDashedE_E.xaxis.categories,
                tooltip: {
                  enabled: false,
                },
              }
            }
          }
          this.loaderStateDashedE_E = false;
        })
    }
  },

  mounted() {
    //do something after mounting vue instance
    this.getDataDashedU();
    this.getDataDashedI();
    this.getDataDashedP();
    this.getDataDashedQ();
    this.getDataDashedS();
    this.getDataDashedE_I();
    this.getDataDashedE_E();
  },

  created() {
    //do something after creating vue instance
    window.Echo.channel('PowerConsumption')
      .listen('PowerConsumptionEvent', (e) => {
        //last update datetime
        this.lastUpdate = moment(e.allData[0].U.created_at)
          .format('YYYY-MM-DD HH:mm:ss');
        localStorage.setItem("lastUpdateEnergy", moment(e.allData[0].U.created_at)
          .format('YYYY-MM-DD HH:mm:ss'));
        this.getDataDashedU();
        this.getDataDashedI();
        this.getDataDashedP();
        this.getDataDashedQ();
        this.getDataDashedS();
        this.getDataDashedE_I();
        this.getDataDashedE_E();
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
</style>
