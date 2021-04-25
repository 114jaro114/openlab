<template>
<v-lazy :options="{
        threshold: .4
      }" min-height="100vh" transition-group="scale-transition">
  <div class="energy custom-margin-page">
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
      <v-col class="mb-5" cols="12" lg="6" md="12" sm="12">
        <v-card class="rounded" elevation="0">
          <v-sheet class="v-sheet--offset mx-auto rounded" elevation="0" max-width="calc(100% - 32px)">
            <div id="chart">
              <apexchart type="bar" height="350" :options="chartOptionsBar" :series="seriesBar"></apexchart>
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
    <NavigationDrawer :drawer="drawer" />
    <BottomNavigation />
    <Footer />
  </div>
</v-lazy>
</template>
<script>
// import moment from 'moment'
import mqtt from 'mqtt'
import VueApexCharts from 'vue-apexcharts'
import Footer from "../components/Footer.vue";
import NavigationDrawer from "../components/NavigationDrawer.vue";
import BottomNavigation from "../components/BottomNavigation.vue";

var _seed = 42;
Math.random = function() {
  _seed = _seed * 16807 % 2147483647;
  return (_seed - 1) / 2147483646;
};

export default {
  name: "Energy",
  components: {
    Footer,
    NavigationDrawer,
    BottomNavigation,
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
      //bar chart
      series: [{
        name: 'Net Profit',
        data: [44, 55, 57, 56, 61, 58, 63, 60, 66]
      }, {
        name: 'Revenue',
        data: [76, 85, 101, 98, 87, 105, 91, 114, 94]
      }, {
        name: 'Free Cash Flow',
        data: [35, 41, 36, 26, 45, 48, 52, 53, 41]
      }],
      chartOptions: {
        chart: {
          type: 'bar',
          height: 350
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
          width: 2,
          colors: ['transparent']
        },
        xaxis: {
          categories: ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
        },
        yaxis: {
          title: {
            text: '$ (thousands)'
          }
        },
        fill: {
          opacity: 1
        },
        tooltip: {
          y: {
            formatter: function(val) {
              return "$ " + val + " thousands"
            }
          }
        }
      },
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
