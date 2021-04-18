<template>
<div class="temperature mt-page">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <v-lazy :options="{
        threshold: .4
      }" min-height="100vh" transition-group="scale-transition">
    <v-card class="v-content" elevation="0" tile>
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
      <v-card class="m-3">
        <v-sheet class="v-sheet--offset mx-auto rounded-lg" color="grey lighten-5" elevation="0" max-width="calc(100% - 32px)">
          <div id="chart">
            <apexchart type="line" height="350" ref="chart" :options="chartOptions" :series="series"></apexchart>
          </div>
        </v-sheet>

        <v-card-text class="pt-0">
          <div class="title font-weight-light mb-2">
            Vlhkosť
          </div>
          <!-- <v-divider class="my-2"></v-divider>
          <v-icon class="mr-2" small>
            mdi-clock
          </v-icon>
          <span class="caption grey--text font-weight-light">Posledná aktualizácia pred 26 minutami</span> -->
        </v-card-text>
      </v-card>
    </v-card>
  </v-lazy>
  <NavigationDrawer :drawer="drawer" />
  <Footer />
</div>
</template>
<script>
import moment from 'moment'
import mqtt from 'mqtt'
import VueApexCharts from 'vue-apexcharts'
import Footer from "../components/Footer.vue";
import NavigationDrawer from "../components/NavigationDrawer.vue";

var lastDate = 0;
var data = []
var TICKINTERVAL = 86400000
let XAXISRANGE = 777600000

function getDayWiseTimeSeries(baseval, count, yrange) {
  var i = 0;
  while (i < count) {
    var x = baseval;
    var y = Math.floor(Math.random() * (yrange.max - yrange.min + 1)) + yrange.min;

    data.push({
      x,
      y
    });
    lastDate = baseval
    baseval += TICKINTERVAL;
    i++;
  }
}

getDayWiseTimeSeries(new Date('11 Feb 2017 GMT')
  .getTime(), 10, {
    min: 10,
    max: 90
  })

function getNewSeries(baseval, yrange) {
  var newDate = baseval + TICKINTERVAL;
  lastDate = newDate

  for (var i = 0; i < data.length - 10; i++) {
    // IMPORTANT
    // we reset the x and y of the data which is out of drawing area
    // to prevent memory leaks
    data[i].x = newDate - XAXISRANGE - TICKINTERVAL
    data[i].y = 0
  }

  data.push({
    x: newDate,
    y: Math.floor(Math.random() * (yrange.max - yrange.min + 1)) + yrange.min
  })
}

function resetData() {
  // Alternatively, you can also reset the data at certain intervals to prevent creating a huge series
  data = data.slice(data.length - 10, data.length);
}

export default {
  name: "Temperature",
  components: {
    Footer,
    NavigationDrawer,
    apexchart: VueApexCharts,
  },
  props: ['drawerNew'],
  data() {
    return {
      drawer: false,

      //mqtt settings
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
      //realtime apexgraph
      series: [{
        data: data.slice()
      }],
      chartOptions: {
        chart: {
          id: 'realtime',
          height: 350,
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
          },
          zoom: {
            enabled: false
          }
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          curve: 'smooth'
        },
        // title: {
        //   text: 'Vlhkosť',
        //   align: 'center'
        // },
        markers: {
          size: 0
        },
        xaxis: {
          type: 'datetime',
          range: XAXISRANGE,
        },
        yaxis: {
          max: 100
        },
        legend: {
          show: false
        },
      },
      //
    }
  },

  updated() {
    this.drawer = this.drawerNew;
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
        this.series[0].data.push([moment()
          .valueOf(), `${message}`
        ])

        this.data.push([moment()
          .valueOf(), `${message}`
        ]);
        // console.log(`Received message ${message} from topic ${topic}`)
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

  watch: {},

  mounted() {
    this.createConnection();
    var me = this
    window.setInterval(function() {
      getNewSeries(lastDate, {
        min: 10,
        max: 90
      })

      me.$refs.chart.updateSeries([{
        data: data
      }])
    }, 1000)

    // every 60 seconds, we reset the data to prevent memory leaks
    window.setInterval(function() {
      resetData()
      me.$refs.chart.updateSeries([{
        data
      }], false, true)
    }, 60000)
    //do something after mounting vue instance
    console.log('Component Welcome mounted.')
  },

  created() {
    console.log('Component Welcome created')
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
