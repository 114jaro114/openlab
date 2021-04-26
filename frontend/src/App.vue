<template>
<div id="app">
  <v-app color="red">
    <router-view />
    <v-fab-transition>
      <v-btn class="goToTop" v-scroll="onScroll" v-show="fab" fab small dark fixed bottom right color="primary" @click="toTop">
        <v-icon>mdi-arrow-up</v-icon>
      </v-btn>
    </v-fab-transition>
  </v-app>
</div>
</template>

<script>
import moment from 'moment';
// import HelloWorld from './components/HelloWorld.vue'

export default {
  name: 'App',
  components: {},

  data() {
    return {
      fab: false,
      arrayValues: [],
      values1: [],
      values2: [],
      values3: [],
      values4: [],
      values5: [],
      values6: [],
      notifCount: localStorage.getItem('notifCounter'),
      notif: [],
      isNewNotif: false,
    }
  },
  created() {
    //do something after creating vue instance
    window.Echo.channel('dataAllSensors')
      .listen('AllSensorsEvent', (e) => {
        console.log(e);
        //getAll current notifications
        if (localStorage.getItem('notifications')) {
          this.notif = JSON.parse(localStorage.getItem('notifications'));
        }
        //get value of switches and slider from settings (limiting values)
        if (localStorage.getItem('arraySwitchesSliders')) {
          this.arrayValues = JSON.parse(localStorage.getItem('arraySwitchesSliders'));
          for (var x = 1; x < 7; x++) {
            this["values" + x] = this.arrayValues[this.arrayValues.length - x];
          }
        }
        //get notifCounter from localstorage and save it to vuex
        if (localStorage.getItem('notifCounter')) {
          this.$store.dispatch('notificationCounter', {
            notifCounter: JSON.parse(localStorage.getItem('notifCounter'))
          });
        }
        //gtmp notif
        if (this.values1.switch1 == true) {
          if (e.dataAllSensors.gtmp > this.values1.slider1[1]) {
            this.notifCount++;
            localStorage.setItem('notifCounter', this.notifCount);
            this.$store.dispatch('notificationCounter', {
              notifCounter: JSON.parse(localStorage.getItem('notifCounter'))
            });
            //
            if (JSON.parse(localStorage.getItem("notifState")) == true) {
              this.notif.unshift({
                id: this.notif.length,
                title: "Teplota okolia",
                subtitle: 'Prekročenie hranice ' + this.values1.slider1[1] + '°C',
                text: 'Teplota okolia prekročila povolený limit!',
                date: moment(new Date)
                  .format('DD MM YYYY HH:mm:ss'),
                status: 'unread',
              });

              this.isNewNotif = true;

              var counterGtmpUp = 0;
              for (var gtmpUp = 0; gtmpUp < this.notif.length; gtmpUp++) {
                if (this.notif[gtmpUp].status == 'unread') {
                  counterGtmpUp++;
                }
              }
              this.$store.dispatch('notificationCounter', {
                notifCounter: counterGtmpUp
              });
              localStorage.setItem('notifCounter', counterGtmpUp);
              localStorage.setItem('notifications', JSON.stringify(this.notif));
            }
            //
          } else if (e.dataAllSensors.gtmp < this.values1.slider1[0]) {
            this.notifCount++;
            localStorage.setItem('notifCounter', this.notifCount);
            this.$store.dispatch('notificationCounter', {
              notifCounter: JSON.parse(localStorage.getItem('notifCounter'))
            });
            //
            if (JSON.parse(localStorage.getItem("notifState")) == true) {
              this.notif.unshift({
                id: this.notif.length,
                title: "Teplota okolia",
                subtitle: 'Pokles pod hranicu ' + this.values1.slider1[0] + '°C',
                text: 'Teplota okolia klesla pod povolený limit!',
                date: moment(new Date)
                  .format('DD MM YYYY HH:mm:ss'),
                status: 'unread',
              });

              this.isNewNotif = true;

              var counterGtmpDown = 0;
              for (var gtmpDown = 0; gtmpDown < this.notif.length; gtmpDown++) {
                if (this.notif[gtmpDown].status == 'unread') {
                  counterGtmpDown++;
                }
              }
              this.$store.dispatch('notificationCounter', {
                notifCounter: counterGtmpDown
              });
              localStorage.setItem('notifCounter', counterGtmpDown);
              localStorage.setItem('notifications', JSON.stringify(this.notif));
            }
          }
        }
        //

        //atmp notif
        if (this.values2.switch2 == true) {
          if (e.dataAllSensors.atmp > this.values2.slider2[1]) {
            this.notifCount++;
            localStorage.setItem('notifCounter', this.notifCount);
            this.$store.dispatch('notificationCounter', {
              notifCounter: JSON.parse(localStorage.getItem('notifCounter'))
            });
            //
            if (JSON.parse(localStorage.getItem("notifState")) == true) {
              this.notif.unshift({
                id: this.notif.length,
                title: "Teplota na čipe",
                subtitle: 'Prekročenie hranice ' + this.values2.slider2[1] + '°C',
                text: 'Teplota na čipe prekročila povolený limit!',
                date: moment(new Date)
                  .format('DD MM YYYY HH:mm:ss'),
                status: 'unread',
              });

              this.isNewNotif = true;

              var counterAtmpUp = 0;
              for (var atmpUp = 0; atmpUp < this.notif.length; atmpUp++) {
                if (this.notif[atmpUp].status == 'unread') {
                  counterAtmpUp++;
                }
              }
              this.$store.dispatch('notificationCounter', {
                notifCounter: counterAtmpUp
              });
              localStorage.setItem('notifCounter', counterAtmpUp);
              localStorage.setItem('notifications', JSON.stringify(this.notif));
            }
            //
          } else if (e.dataAllSensors.atmp < this.values2.slider2[0]) {
            this.notifCount++;
            localStorage.setItem('notifCounter', this.notifCount);
            this.$store.dispatch('notificationCounter', {
              notifCounter: JSON.parse(localStorage.getItem('notifCounter'))
            });
            //
            if (JSON.parse(localStorage.getItem("notifState")) == true) {
              this.notif.unshift({
                id: this.notif.length,
                title: "Teplota na čipe",
                subtitle: 'Pokles pod hranicu ' + this.values2.slider2[0] + '°C',
                text: 'Teplota na čipe klesla pod povolený limit!',
                date: moment(new Date)
                  .format('DD MM YYYY HH:mm:ss'),
                status: 'unread',
              });

              this.isNewNotif = true;

              var counterAtmpDown = 0;
              for (var atmpDown = 0; atmpDown < this.notif.length; atmpDown++) {
                if (this.notif[atmpDown].status == 'unread') {
                  counterAtmpDown++;
                }
              }
              this.$store.dispatch('notificationCounter', {
                notifCounter: counterAtmpDown
              });
              localStorage.setItem('notifCounter', counterAtmpDown);
              localStorage.setItem('notifications', JSON.stringify(this.notif));
            }
          }
        }
        //

        //humi notif
        if (this.values3.switch3 == true) {
          if (e.dataAllSensors.humi > this.values3.slider3[1]) {
            this.notifCount++;
            localStorage.setItem('notifCounter', this.notifCount);
            this.$store.dispatch('notificationCounter', {
              notifCounter: JSON.parse(localStorage.getItem('notifCounter'))
            });
            //
            if (JSON.parse(localStorage.getItem("notifState")) == true) {
              this.notif.unshift({
                id: this.notif.length,
                title: "Vlhkosť",
                subtitle: 'Prekročenie hranice ' + this.values3.slider3[1] + '%',
                text: 'Vlhkosť prekročila povolený limit!',
                date: moment(new Date)
                  .format('DD MM YYYY HH:mm:ss'),
                status: 'unread',
              });

              this.isNewNotif = true;

              var counterHumiUp = 0;
              for (var humiUp = 0; humiUp < this.notif.length; humiUp++) {
                if (this.notif[humiUp].status == 'unread') {
                  counterHumiUp++;
                }
              }
              this.$store.dispatch('notificationCounter', {
                notifCounter: counterHumiUp
              });
              localStorage.setItem('notifCounter', counterHumiUp);
              localStorage.setItem('notifications', JSON.stringify(this.notif));
            }
            //
          } else if (e.dataAllSensors.humi < this.values3.slider3[0]) {
            this.notifCount++;
            localStorage.setItem('notifCounter', this.notifCount);
            this.$store.dispatch('notificationCounter', {
              notifCounter: JSON.parse(localStorage.getItem('notifCounter'))
            });
            //
            if (JSON.parse(localStorage.getItem("notifState")) == true) {
              this.notif.unshift({
                id: this.notif.length,
                title: "Vlhkosť",
                subtitle: 'Pokles pod hranicu ' + this.values3.slider3[0] + '%',
                text: 'Vlhkosť klesla pod povolený limit!',
                date: moment(new Date)
                  .format('DD MM YYYY HH:mm:ss'),
                status: 'unread',
              });

              this.isNewNotif = true;

              var counterHumiDown = 0;
              for (var humiDown = 0; humiDown < this.notif.length; humiDown++) {
                if (this.notif[humiDown].status == 'unread') {
                  counterHumiDown++;
                }
              }
              this.$store.dispatch('notificationCounter', {
                notifCounter: counterHumiDown
              });
              localStorage.setItem('notifCounter', counterHumiDown);
              localStorage.setItem('notifications', JSON.stringify(this.notif));
            }
          }
        }
        //

        //vol notif
        if (this.values4.switch4 == true) {
          if (e.dataAllSensors.vol > this.values4.slider4[1]) {
            this.notifCount++;
            localStorage.setItem('notifCounter', this.notifCount);
            this.$store.dispatch('notificationCounter', {
              notifCounter: JSON.parse(localStorage.getItem('notifCounter'))
            });
            //
            if (JSON.parse(localStorage.getItem("notifState")) == true) {
              this.notif.unshift({
                id: this.notif.length,
                title: "Hlasitosť",
                subtitle: 'Prekročenie hranice ' + this.values4.slider4[1],
                text: 'Hlasitosť prekročila povolený limit!',
                date: moment(new Date)
                  .format('DD MM YYYY HH:mm:ss'),
                status: 'unread',
              });

              this.isNewNotif = true;

              var counterVolUp = 0;
              for (var volUp = 0; volUp < this.notif.length; volUp++) {
                if (this.notif[volUp].status == 'unread') {
                  counterVolUp++;
                }
              }
              this.$store.dispatch('notificationCounter', {
                notifCounter: counterVolUp
              });
              localStorage.setItem('notifCounter', counterVolUp);
              localStorage.setItem('notifications', JSON.stringify(this.notif));
            }
            //
          } else if (e.dataAllSensors.vol < this.values4.slider4[0]) {
            this.notifCount++;
            localStorage.setItem('notifCounter', this.notifCount);
            this.$store.dispatch('notificationCounter', {
              notifCounter: JSON.parse(localStorage.getItem('notifCounter'))
            });
            //
            if (JSON.parse(localStorage.getItem("notifState")) == true) {
              this.notif.unshift({
                id: this.notif.length,
                title: "Hlasitosť",
                subtitle: 'Pokles pod hranicu ' + this.values4.slider4[0],
                text: 'Hlasitosť klesla pod povolený limit!',
                date: moment(new Date)
                  .format('DD MM YYYY HH:mm:ss'),
                status: 'unread',
              });

              this.isNewNotif = true;

              var counterVolDown = 0;
              for (var volDown = 0; volDown < this.notif.length; volDown++) {
                if (this.notif[volDown].status == 'unread') {
                  counterVolDown++;
                }
              }
              this.$store.dispatch('notificationCounter', {
                notifCounter: counterVolDown
              });
              localStorage.setItem('notifCounter', counterVolDown);
              localStorage.setItem('notifications', JSON.stringify(this.notif));
            }
          }
        }
        //

        //light notif
        if (this.values5.switch5 == true) {
          if (e.dataAllSensors.light > this.values5.slider5[1]) {
            this.notifCount++;
            localStorage.setItem('notifCounter', this.notifCount);
            this.$store.dispatch('notificationCounter', {
              notifCounter: JSON.parse(localStorage.getItem('notifCounter'))
            });
            //
            if (JSON.parse(localStorage.getItem("notifState")) == true) {
              this.notif.unshift({
                id: this.notif.length,
                title: "Osvetlenie",
                subtitle: 'Prekročenie hranice ' + this.values5.slider5[1],
                text: 'Hodnota osvetlenia prekročila povolený limit!',
                date: moment(new Date)
                  .format('DD MM YYYY HH:mm:ss'),
                status: 'unread',
              });

              this.isNewNotif = true;

              var counterLightUp = 0;
              for (var lightUp = 0; lightUp < this.notif.length; lightUp++) {
                if (this.notif[lightUp].status == 'unread') {
                  counterLightUp++;
                }
              }
              this.$store.dispatch('notificationCounter', {
                notifCounter: counterLightUp
              });
              localStorage.setItem('notifCounter', counterLightUp);
              localStorage.setItem('notifications', JSON.stringify(this.notif));
            }
            //
          } else if (e.dataAllSensors.light < this.values5.slider5[0]) {
            this.notifCount++;
            localStorage.setItem('notifCounter', this.notifCount);
            this.$store.dispatch('notificationCounter', {
              notifCounter: JSON.parse(localStorage.getItem('notifCounter'))
            });
            //
            if (JSON.parse(localStorage.getItem("notifState")) == true) {
              this.notif.unshift({
                id: this.notif.length,
                title: "Osvetlenie",
                subtitle: 'Pokles pod hranicu ' + this.values5.slider5[0],
                text: 'Hodnota osvetlenia klesla pod povolený limit!',
                date: moment(new Date)
                  .format('DD MM YYYY HH:mm:ss'),
                status: 'unread',
              });

              this.isNewNotif = true;

              var counterLightDown = 0;
              for (var lightDown = 0; lightDown < this.notif.length; lightDown++) {
                if (this.notif[lightDown].status == 'unread') {
                  counterLightDown++;
                }
              }
              this.$store.dispatch('notificationCounter', {
                notifCounter: counterLightDown
              });
              localStorage.setItem('notifCounter', counterLightDown);
              localStorage.setItem('notifications', JSON.stringify(this.notif));
            }
          }
        }
        //

        //pres notif
        if (this.values6.switch6 == true) {
          if (e.dataAllSensors.pres > this.values6.slider6[1]) {
            this.notifCount++;
            localStorage.setItem('notifCounter', this.notifCount);
            this.$store.dispatch('notificationCounter', {
              notifCounter: JSON.parse(localStorage.getItem('notifCounter'))
            });
            //
            if (JSON.parse(localStorage.getItem("notifState")) == true) {
              this.notif.unshift({
                id: this.notif.length,
                title: "Tlak",
                subtitle: 'Prekročenie hranice ' + this.values6.slider6[1],
                text: 'Hodnota tlaku prekročila povolený limit!',
                date: moment(new Date)
                  .format('DD MM YYYY HH:mm:ss'),
                status: 'unread',
              });

              this.isNewNotif = true;

              var counterPresUp = 0;
              for (var presUp = 0; presUp < this.notif.length; presUp++) {
                if (this.notif[presUp].status == 'unread') {
                  counterPresUp++;
                }
              }
              this.$store.dispatch('notificationCounter', {
                notifCounter: counterPresUp
              });
              localStorage.setItem('notifCounter', counterPresUp);
              localStorage.setItem('notifications', JSON.stringify(this.notif));
            }
            //
          } else if (e.dataAllSensors.pres < this.values6.slider6[0]) {
            this.notifCount++;
            localStorage.setItem('notifCounter', this.notifCount);
            this.$store.dispatch('notificationCounter', {
              notifCounter: JSON.parse(localStorage.getItem('notifCounter'))
            });
            //
            if (JSON.parse(localStorage.getItem("notifState")) == true) {
              this.notif.unshift({
                id: this.notif.length,
                title: "Tlak",
                subtitle: 'Pokles pod hranicu ' + this.values6.slider6[0],
                text: 'Hodnota tlaku klesla pod povolený limit!',
                date: moment(new Date)
                  .format('DD MM YYYY HH:mm:ss'),
                status: 'unread',
              });

              this.isNewNotif = true;

              var counterPresDown = 0;
              for (var presDown = 0; presDown < this.notif.length; presDown++) {
                if (this.notif[presDown].status == 'unread') {
                  counterPresDown++;
                }
              }
              this.$store.dispatch('notificationCounter', {
                notifCounter: counterPresDown
              });
              localStorage.setItem('notifCounter', counterPresDown);
              localStorage.setItem('notifications', JSON.stringify(this.notif));
            }
          }
        }
        //
        if (this.isNewNotif == true) {
          this.isNewNotif = false;
          if (JSON.parse(localStorage.getItem("notifSoundState")) == true) {
            var audioPresDown = new Audio(require('./assets/AirPlaneDing.mp3'))
            audioPresDown.play();
          }
        }
      })
  },

  mounted() {
    //do something after mounting vue instance
    const theme = localStorage.getItem("dark_theme");
    if (theme) {
      if (theme === "true") {
        this.$vuetify.theme.dark = true;
        localStorage.setItem('graph_theme', 'dark');
      } else {
        this.$vuetify.theme.dark = false;
        localStorage.setItem('graph_theme', 'light');
      }
    }

    this.initDarkMode();
    if (localStorage.getItem('notifCounter')) {
      this.$store.dispatch('notificationCounter', {
        notifCounter: JSON.parse(localStorage.getItem('notifCounter'))
      });
    }
  },

  updated() {
    //do something after updating vue instance
    this.initDarkMode();
  },

  methods: {
    onScroll(e) {
      if (typeof window === 'undefined') return
      const top = window.pageYOffset || e.target.scrollTop || 0
      this.fab = top > 20
    },
    toTop() {
      this.$vuetify.goTo(0)
    },
    initDarkMode() {
      if (JSON.parse(localStorage.getItem("auto_dlm")) == true) {
        if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)')
          .matches) {
          this.$vuetify.theme.dark = true;
          localStorage.setItem("dark_theme", this.$vuetify.theme.dark.toString());
          localStorage.setItem('graph_theme', 'dark');
        } else {
          this.$vuetify.theme.dark = false;
          localStorage.setItem("dark_theme", this.$vuetify.theme.dark.toString());
          localStorage.setItem('graph_theme', 'light');
        }
        window.matchMedia('(prefers-color-scheme: dark)')
          .addEventListener('change', event => {
            if (event.matches) {
              this.$vuetify.theme.dark = true;
              localStorage.setItem("dark_theme", this.$vuetify.theme.dark.toString());
            } else {
              this.$vuetify.theme.dark = false;
              localStorage.setItem("dark_theme", this.$vuetify.theme.dark.toString());
            }
          })
      }
    },
  }
}
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  /* margin-top: 60px; */
}

.goToTop {
  margin-bottom: 50px;
  z-index: 12 !important;
}
</style>
