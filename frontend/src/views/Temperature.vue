<template>
<div class="temperature custom-margin-page">
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
        <!-- circle chart fot gtmp -->
        <v-col cols="12" lg="6" md="12" sm="12">
          <v-card class="rounded" elevation="0" loader-height="6" :loading="loaderStateCircle">
            <div class="pt-3" id="chart">
              <apexchart type="radialBar" height="365" :options="chartOptionsCircle" :series="seriesCircle"></apexchart>
            </div>

            <v-card-text class="pt-0">
              <div class="title font-weight-light mb-2">
                Aktuálna teplota okolia
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
        <!-- circle chart fot atmp -->
        <v-col cols="12" lg="6" md="12" sm="12">
          <v-card class="rounded" elevation="0" loader-height="6" :loading="loaderStateCircleAtmp">
            <div class="pt-3" id="chart">
              <apexchart type="radialBar" height="365" :options="chartOptionsCircleAtmp" :series="seriesCircleAtmp"></apexchart>
            </div>

            <v-card-text class="pt-0">
              <div class="title font-weight-light mb-2">
                Aktuálna teplota na čipe
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

        <!-- column chart gtmp-->
        <v-col cols="12" lg="6" md="12" sm="12">
          <v-card class="rounded" elevation="0" loader-height="6" :loading="loaderStateColumn">
            <div class="pt-3" id="chart">
              <apexchart type="bar" height="350" :options="chartOptionsColumn" :series="seriesColumn"></apexchart>
            </div>

            <v-card-text class="pt-0">
              <div class="title font-weight-light mb-2">
                Priemerná teplota okolia za jednotlivé mesiace v roku
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
        <!-- column chart atmp-->
        <v-col cols="12" lg="6" md="12" sm="12">
          <v-card class="rounded" elevation="0" loader-height="6" :loading="loaderStateColumnAtmp">
            <div class="pt-3" id="chart">
              <apexchart type="bar" height="350" :options="chartOptionsColumnAtmp" :series="seriesColumnAtmp"></apexchart>
            </div>

            <v-card-text class="pt-0">
              <div class="title font-weight-light mb-2">
                Priemerná teplota na čipe za jednotlivé mesiace v roku
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

        <!-- realtime chart gtmp-->
        <v-col cols="12" lg="12" md="12" sm="12">
          <v-card class="rounded" elevation="0" loader-height="6" :loading="loaderStateRealtime">
            <div class="pt-3" id="chart">
              <apexchart type="line" height="200" :options="chartOptionsRealtime" :series="seriesRealtime" />
            </div>

            <v-card-text class="pt-0">
              <div class="title font-weight-light mb-2">
                Teplota okolia posledných 5 minút
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
        <!-- realtime chart atmp-->
        <v-col cols="12" lg="12" md="12" sm="12">
          <v-card class="rounded" elevation="0" loader-height="6" :loading="loaderStateRealtimeAtmp">
            <div class="pt-3" id="chart">
              <apexchart type="line" height="200" :options="chartOptionsRealtimeAtmp" :series="seriesRealtimeAtmp" />
            </div>

            <v-card-text class="pt-0">
              <div class="title font-weight-light mb-2">
                Teplota na čipe posledných 5 minút
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

        <!-- candlestick chart gtmp-->
        <v-col cols="12" lg="12" md="12" sm="12">
          <v-card class="rounded" elevation="0" loader-height="6" :loading="loaderStateCandle_stick">
            <div class="pt-3" id="chart">
              <apexchart type="candlestick" height="350" :options="chartOptionsCandle_stick" :series="seriesCandle_stick"></apexchart>
            </div>


            <v-card-text class="pt-0">
              <div class="title font-weight-light mb-2">
                <span>Najvyššia, najnižšia, prvá a posledná hodnota </span><span class="font-weight-bold">teploty okolia </span><span>za 1-hodinové intervaly</span>
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
        <!-- candlestick chart atmp-->
        <v-col cols="12" lg="12" md="12" sm="12">
          <v-card class="rounded" elevation="0" loader-height="6" :loading="loaderStateCandle_stickAtmp">
            <div class="pt-3" id="chart">
              <apexchart type="candlestick" height="350" :options="chartOptionsCandle_stickAtmp" :series="seriesCandle_stickAtmp"></apexchart>
            </div>

            <v-card-text class="pt-0">
              <div class="title font-weight-light mb-2">
                <span>Najvyššia, najnižšia, prvá a posledná hodnota </span><span class="font-weight-bold">teploty na čipe </span><span>za 1-hodinové intervaly</span>
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

        <!-- historical chart gtmp-->
        <v-col cols="12" lg="12" md="12" sm="12">
          <v-card class="rounded" elevation="0" loader-height="6" :loading="loaderStateSeries">
            <div class="pt-3" id="chart">
              <div class="toolbar pt-3">
                <v-btn icon color="#ff0000" id="one_hour" @click="updateData('one_hour')" class="mr-2" :class="{active: selection==='one_hour'}">
                  1H
                </v-btn>
                <v-btn icon color="#ff0000" id="one_day" @click="updateData('one_day')" class="mr-2" :class="{active: selection==='one_day'}">
                  1D
                </v-btn>
                <v-btn icon color="#ff0000" id="one_month" @click="updateData('one_month')" class="mr-2" :class="{active: selection==='one_month'}">
                  1M
                </v-btn>

                <v-btn icon color="#ff0000" id="six_months" @click="updateData('six_months')" class="mr-2" :class="{active: selection==='six_months'}">
                  6M
                </v-btn>

                <v-btn icon color="#ff0000" id="one_year" @click="updateData('one_year')" class="mr-2" :class="{active: selection==='one_year'}">
                  1Y
                </v-btn>

                <v-btn icon color="#ff0000" id="ytd" @click="updateData('ytd')" class="mr-2" :class="{active: selection==='ytd'}">
                  YTD
                </v-btn>

                <v-btn icon color="#ff0000" id="all" @click="updateData('all')" :class="{active: selection==='all'}">
                  ALL
                </v-btn>
              </div>

              <div id="chart-timeline">
                <apexchart type="area" height="350" ref="historicalChart" :options="chartOptions" :series="series"></apexchart>
              </div>
            </div>

            <v-card-text class="pt-0">
              <div class="title font-weight-light mb-2">
                Historický graf teploty okolia
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
        <!-- historical chart atmp-->
        <v-col class="mb-5" cols="12" lg="12" md="12" sm="12">
          <v-card class="rounded" elevation="0" loader-height="6" :loading="loaderStateSeriesAtmp">
            <div class="pt-3" id="chart">
              <div class="toolbar pt-3">
                <v-btn icon color="#ff6600" id="one_hour" @click="updateDataAtmp('one_hour')" class="mr-2" :class="{active: selectionAtmp==='one_hour'}">
                  1H
                </v-btn>
                <v-btn icon color="#ff6600" id="one_day" @click="updateDataAtmp('one_day')" class="mr-2" :class="{active: selectionAtmp==='one_day'}">
                  1D
                </v-btn>
                <v-btn icon color="#ff6600" id="one_month" @click="updateDataAtmp('one_month')" class="mr-2" :class="{active: selectionAtmp==='one_month'}">
                  1M
                </v-btn>

                <v-btn icon color="#ff6600" id="six_months" @click="updateDataAtmp('six_months')" class="mr-2" :class="{active: selectionAtmp==='six_months'}">
                  6M
                </v-btn>

                <v-btn icon color="#ff6600" id="one_year" @click="updateDataAtmp('one_year')" class="mr-2" :class="{active: selectionAtmp==='one_year'}">
                  1Y
                </v-btn>

                <v-btn icon color="#ff6600" id="ytd" @click="updateDataAtmp('ytd')" class="mr-2" :class="{active: selectionAtmp==='ytd'}">
                  YTD
                </v-btn>

                <v-btn icon color="#ff6600" id="all" @click="updateDataAtmp('all')" :class="{active: selectionAtmp==='all'}">
                  ALL
                </v-btn>
              </div>

              <div id="chart-timeline">
                <apexchart type="area" height="350" ref="historicalChartAtmp" :options="chartOptionsAtmp" :series="seriesAtmp"></apexchart>
              </div>
            </div>


            <v-card-text class="pt-0">
              <div class="title font-weight-light mb-2">
                Historický graf teploty na čipe
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
  name: "Temperature",
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
      loaderStateCircle: true,
      loaderStateColumn: true,
      loaderStateRealtime: true,
      loaderStateCandle_stick: true,
      loaderStateSeries: true,
      loaderStateCircleAtmp: true,
      loaderStateColumnAtmp: true,
      loaderStateRealtimeAtmp: true,
      loaderStateCandle_stickAtmp: true,
      loaderStateSeriesAtmp: true,
      lastUpdate: localStorage.getItem('lastUpdateTemperatures'),
      //circle chart gtmp
      seriesCircle: [],
      chartOptionsCircle: {
        chart: {
          foreColor: localStorage.getItem('graph_text_color'),
          // height: 350,
          type: 'radialBar',
          toolbar: {
            show: false
          }
        },
        plotOptions: {
          radialBar: {
            startAngle: -135,
            endAngle: 225,
            offsetY: 31,
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
                color: '#ff0000',
                fontSize: '36px',
                show: true,
              }
            }
          }
        },
        grid: {
          padding: {
            top: -31,
            bottom: 21
          },
        },
        stroke: {
          lineCap: 'round'
        },
        labels: ['°C'],
        colors: ['#ff0000'],
      },

      //column chart
      seriesColumn: [{
        name: 'Teplota okolia (°C)',
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
            return val;
          },
          offsetY: -20,
          style: {
            fontSize: '12px',
            colors: ["#ff0000"]
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
              return val;
            }
          }

        },
        title: {
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
        colors: ['#ff0000'],
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
        name: 'Teplota okolia (°C)',
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
        colors: ['#ff0000'],
      },
      selection: '',

      // realtime
      seriesRealtime: [{
        name: 'Teplota okolia (°C)',
        data: [],
      }],
      chartOptionsRealtime: {
        // colors: ['#FCCF31', '#17ead9', '#f02fc2'],
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
        colors: ['#ff0000'],
      },




      ///////////////////////charts atmp///////////////////////////////////////
      //circle atmp
      seriesCircleAtmp: [],
      chartOptionsCircleAtmp: {
        chart: {
          foreColor: localStorage.getItem('graph_text_color'),
          // height: 350,
          type: 'radialBar',
          toolbar: {
            show: false
          }
        },
        plotOptions: {
          radialBar: {
            startAngle: -135,
            endAngle: 225,
            offsetY: 31,
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
                color: '#ff6600',
                fontSize: '36px',
                show: true,
              }
            }
          }
        },
        grid: {
          padding: {
            top: -31,
            bottom: 21
          },
        },
        stroke: {
          lineCap: 'round'
        },
        labels: ['°C'],
        colors: ['#ff6600'],
      },
      //column chart atmp
      seriesColumnAtmp: [{
        name: 'Teplota na čipe (°C)',
        data: []
      }],
      chartOptionsColumnAtmp: {
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
            return val;
          },
          offsetY: -20,
          style: {
            fontSize: '12px',
            colors: ["#ff6600"]
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
              return val;
            }
          }

        },
        title: {
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
        colors: ['#ff6600'],
      },
      // realtime
      seriesRealtimeAtmp: [{
        name: 'Teplota na čipe (°C)',
        data: [],
      }],
      chartOptionsRealtimeAtmp: {
        // colors: ['#FCCF31', '#17ead9', '#f02fc2'],
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
        colors: ['#ff6600'],
      },

      //candlestick chart
      seriesCandle_stickAtmp: [{
        data: []
      }],
      chartOptionsCandle_stickAtmp: {
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
      seriesAtmp: [{
        name: 'Teplota na čipe (°C)',
        data: []
      }],
      chartOptionsAtmp: {
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
        colors: ['#ff6600'],
      },
      selectionAtmp: '',
    }
  },

  updated() {
    this.drawer = this.drawerNew;
  },
  computed: {},

  methods: {
    //for area historical chart gtmp
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

    //for area historical chart atmp
    updateDataAtmp(timeline) {
      this.selectionAtmp = timeline;

      switch (timeline) {
        case 'one_hour':
          this.$refs.historicalChartAtmp.zoomX(
            moment(new Date())
            .subtract(1, 'hours')
            .valueOf(),
            new Date()
            .getTime()
          )
          break
        case 'one_day':
          this.$refs.historicalChartAtmp.zoomX(
            moment(new Date())
            .subtract(1, 'days')
            .valueOf(),
            new Date()
            .getTime()
          )
          break
        case 'one_month':
          this.$refs.historicalChartAtmp.zoomX(
            moment(new Date())
            .subtract(1, 'months')
            .valueOf(),
            new Date()
            .getTime()
          )
          break
        case 'six_months':
          this.$refs.historicalChartAtmp.zoomX(
            moment(new Date())
            .subtract(6, 'months')
            .valueOf(),
            new Date()
            .getTime()
          )
          break
        case 'one_year':
          this.$refs.historicalChartAtmp.zoomX(
            moment(new Date())
            .subtract(1, 'years')
            .valueOf(),
            new Date()
            .getTime()
          )
          break
        case 'ytd':
          this.$refs.historicalChartAtmp.zoomX(
            moment()
            .startOf('year')
            .valueOf(),
            new Date()
            .getTime())
          break
        case 'all':
          this.$refs.historicalChartAtmp.zoomX(
            new Date('01 Jan 2012')
            .getTime(),
            new Date()
            .getTime()
          )
          break
        default:
      }
    },

    //gets for gtmp value of temperature
    getHistoricalDataGtmp() {
      axios.get('http://openlabbe2021.azurewebsites.net/api/getHistoricalDataTemperatureGtmp')
        .then(res => {
          this.series[0].data.splice(0, res.data.length);
          for (var i = 0; i < res.data.length; i++) {
            this.series[0].data.push([
              moment(res.data[i].created_at)
              .valueOf(),
              parseFloat(`${res.data[i].gtmp}`)
            ]);
          }
          this.series = [{
            name: 'Teplota okolia (°C)',
            data: this.series[0].data
          }];

          this.loaderStateSeries = false;
        })
    },

    getHistoricalData2Gtmp() {
      axios.get('http://openlabbe2021.azurewebsites.net/api/getHistoricalData2TemperatureGtmp')
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

          this.loaderStateCandle_stick = false;
        })
    },

    getHistoricalData3Gtmp() {
      axios.get('http://openlabbe2021.azurewebsites.net/api/getHistoricalData3TemperatureGtmp')
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

          this.loaderStateColumn = false;
        });
    },

    getDataRealtimeGtmp() {
      axios.get('http://openlabbe2021.azurewebsites.net/api/getDataRealtimeTemperatureGtmp')
        .then(res => {
          this.lastUpdate = moment(new Date)
            .format('YYYY-MM-DD HH:mm:ss');
          localStorage.setItem("lastUpdateTemperatures", moment(new Date)
            .format('YYYY-MM-DD HH:mm:ss'));
          this.seriesRealtime[0].data.splice(0, 10);
          for (var i = 0; i < res.data.length; i++) {
            this.seriesRealtime[0].data.push([
              moment(res.data[i].created_at)
              .valueOf(),
              parseFloat(`${res.data[i].gtmp}`)
            ]);
          }

          this.seriesRealtime = [{
            name: 'Teplota okolia (°C)',
            data: this.seriesRealtime[0].data
          }];
          this.seriesCircle.splice(0, 1);
          this.seriesCircle.push(parseFloat(res.data[res.data.length - 1].gtmp));

          this.loaderStateRealtime = false;
          this.loaderStateCircle = false;
        })
    },



    //gets for atmp value of temperature
    getHistoricalDataAtmp() {
      axios.get('http://openlabbe2021.azurewebsites.net/api/getHistoricalDataTemperatureAtmp')
        .then(res => {
          this.seriesAtmp[0].data.splice(0, res.data.length);
          for (var i = 0; i < res.data.length; i++) {
            this.seriesAtmp[0].data.push([
              moment(res.data[i].created_at)
              .valueOf(),
              parseFloat(`${res.data[i].atmp}`)
            ]);
          }
          this.seriesAtmp = [{
            name: 'Teplota na čipe (°C)',
            data: this.seriesAtmp[0].data
          }];

          this.loaderStateSeriesAtmp = false;
        })
    },

    getHistoricalData2Atmp() {
      axios.get('http://openlabbe2021.azurewebsites.net/api/getHistoricalData2TemperatureAtmp')
        .then(res => {
          this.seriesCandle_stickAtmp[0].data.splice(0, 1)
          for (var i = 0; i < res.data.length; i++) {
            this.seriesCandle_stickAtmp[0].data.push({
              x: moment(res.data[i].timekey)
                .valueOf(),
              y: [res.data[i].first_open, res.data[i].max_value, res.data[i].min_value, res.data[i].last_close]
            });
          }
          this.seriesCandle_stickAtmp = [{
            data: this.seriesCandle_stickAtmp[0].data
          }];

          this.loaderStateCandle_stickAtmp = false;
        })
    },

    getHistoricalData3Atmp() {
      axios.get('http://openlabbe2021.azurewebsites.net/api/getHistoricalData3TemperatureAtmp')
        .then(res => {
          // this.seriesColumn[0].data = [];
          this.seriesColumnAtmp[0].data.splice(0, 12);
          this.seriesColumnAtmp[0].data.push(
            res.data[0].Jan, res.data[0].Feb,
            res.data[0].Mar, res.data[0].Apr,
            res.data[0].May, res.data[0].Jun,
            res.data[0].Jul, res.data[0].Aug,
            res.data[0].Sep, res.data[0].Oct,
            res.data[0].Nov, res.data[0].Dec,
          );

          this.seriesColumnAtmp = [{
            data: this.seriesColumnAtmp[0].data
          }];

          this.loaderStateColumnAtmp = false;
        });
    },

    getDataRealtimeAtmp() {
      axios.get('http://openlabbe2021.azurewebsites.net/api/getDataRealtimeTemperatureAtmp')
        .then(res => {
          this.lastUpdate = moment(new Date)
            .format('YYYY-MM-DD HH:mm:ss');
          localStorage.setItem("lastUpdateTemperatures", moment(new Date)
            .format('YYYY-MM-DD HH:mm:ss'));
          this.seriesRealtimeAtmp[0].data.splice(0, 10);
          for (var i = 0; i < res.data.length; i++) {
            this.seriesRealtimeAtmp[0].data.push([
              moment(res.data[i].created_at)
              .valueOf(),
              parseFloat(`${res.data[i].atmp}`)
            ]);
          }

          this.seriesRealtimeAtmp = [{
            name: 'Teplota okolia (°C)',
            data: this.seriesRealtimeAtmp[0].data
          }];

          this.seriesCircleAtmp.splice(0, 1);
          this.seriesCircleAtmp.push(parseFloat(res.data[res.data.length - 1].atmp));

          this.loaderStateRealtimeAtmp = false;
          this.loaderStateCircleAtmp = false;
        })
    },
  },

  watch: {},

  mounted() {
    //do something after mounting vue instance
    this.getDataRealtimeGtmp();
    this.getDataRealtimeAtmp();
    this.getHistoricalDataGtmp();
    this.getHistoricalDataAtmp();
    this.getHistoricalData2Gtmp();
    this.getHistoricalData2Atmp();
    this.getHistoricalData3Gtmp();
    this.getHistoricalData3Atmp();
  },

  created() {
    //do something after creating vue instance
    window.Echo.channel('dataAllSensors')
      .listen('AllSensorsEvent', (e) => {
        //last update datetime
        this.lastUpdate = moment(e.dataAllSensors.created_at)
          .format('YYYY-MM-DD HH:mm:ss');
        localStorage.setItem("lastUpdateTemperatures", moment(e.dataAllSensors.created_at)
          .format('YYYY-MM-DD HH:mm:ss'));
        //
        this.series[0].data.push([
          moment(e.dataAllSensors.created_at)
          .valueOf(),
          parseFloat(`${e.dataAllSensors.gtmp}`)
        ]);
        this.series = [{
          data: this.series[0].data
        }];
        //
        this.seriesAtmp[0].data.push([
          moment(e.dataAllSensors.created_at)
          .valueOf(),
          parseFloat(`${e.dataAllSensors.atmp}`)
        ]);
        this.seriesAtmp = [{
          data: this.seriesAtmp[0].data
        }];
        //
        this.getDataRealtimeGtmp();
        this.getHistoricalData2Gtmp();
        this.getHistoricalData3Gtmp();
        //
        this.getDataRealtimeAtmp();
        this.getHistoricalData2Atmp();
        this.getHistoricalData3Atmp();
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
