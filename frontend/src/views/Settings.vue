<template>
<div class="settings mt-page-settings_notif">
  <v-lazy :options="{
            threshold: .4
          }" min-height="100vh" transition-group="scale-transition">
    <div class="">
      <v-card class="mx-auto" elevation="0" tile>
        <v-app-bar fixed flat>
          <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>

          <v-toolbar-title class="title_toolbar">OpenLab FEI Tuke</v-toolbar-title>

          <v-spacer></v-spacer>

          <v-btn icon to="/notifications">
            <v-badge :content="this.$store.getters['notificationCounter']" :value="this.$store.getters['notificationCounter']" :offset-x="11" :offset-y="12" color="orange" overlap left bordered>
              <v-icon>mdi-bell</v-icon>
            </v-badge>
          </v-btn>
        </v-app-bar>
      </v-card>

      <v-row class="m-0">
        <v-col class="mb-5">
          <!-- <v-card> -->
          <v-list class="rounded" flat subheader three-line>
            <v-list-item-group v-model="ntf" multiple active-class="">
              <v-subheader>Notifikácie</v-subheader>
              <v-list-item>
                <template v-slot:default="{ active }">
                  <v-list-item-action>
                    <v-checkbox :input-value="active"></v-checkbox>
                  </v-list-item-action>

                  <v-list-item-content>
                    <v-list-item-title>Notifikácie</v-list-item-title>
                    <v-list-item-subtitle>Informovať ma o nových udalostiach</v-list-item-subtitle>
                  </v-list-item-content>
                </template>
              </v-list-item>
            </v-list-item-group>
            <v-list-item-group v-model="ntfs" multiple active-class="">
              <v-list-item>
                <template v-slot:default="{ active }">
                  <v-list-item-action>
                    <v-checkbox :input-value="active"></v-checkbox>
                  </v-list-item-action>

                  <v-list-item-content>
                    <v-list-item-title>Zvuky</v-list-item-title>
                    <v-list-item-subtitle>Zapnúť alebo vypnúť zvuky k notifikáciám</v-list-item-subtitle>
                  </v-list-item-content>
                </template>
              </v-list-item>
            </v-list-item-group>

            <v-divider></v-divider>


            <v-list-item-group v-model="dlm" multiple active-class="">
              <v-subheader>Nastavenie režimu</v-subheader>
              <!-- <v-list-item-title>Tmavý/Svetlý režim</v-list-item-title> -->
              <v-row class="pl-3 pr-3 pb-3" justify="center">
                <v-col class="d-flex" cols="12" sm="6">
                  <v-tooltip v-if="!$vuetify.theme.dark" bottom>
                    <template v-slot:activator="{ on }">
                      <v-btn :disabled="autoDLMon" v-on="on" @click="toggle_dark_mode" block large>
                        <v-icon>mdi-theme-light-dark</v-icon>
                      </v-btn>
                    </template>
                    <span>Zapnúť dark mód</span>
                  </v-tooltip>

                  <v-tooltip v-else bottom>
                    <template v-slot:activator="{ on }">
                      <v-btn :disabled="autoDLMon" v-on="on" @click="toggle_dark_mode" block large>
                        <v-icon>mdi-theme-light-dark</v-icon>
                      </v-btn>
                    </template>
                    <span>Vypnúť dark mód</span>
                  </v-tooltip>
                </v-col>
              </v-row>
              <!-- <v-list-item>
            <template v-slot:default="{ active }">
              <v-list-item-action>
                <v-switch color="primary" :input-value="active" @click="bottomNavigation()" inset></v-switch>
              </v-list-item-action>

              <v-list-item-content>
                <v-list-item-title>Tmavý/Svetlý režim</v-list-item-title>
                <v-list-item-subtitle>Notify me about updates to apps or games that I downloaded</v-list-item-subtitle>
              </v-list-item-content>
            </template>
          </v-list-item> -->

              <v-list-item>
                <template v-slot:default="{ active }">
                  <v-list-item-action>
                    <v-switch color="primary" :input-value="active" inset></v-switch>
                  </v-list-item-action>

                  <v-list-item-content>
                    <v-list-item-title>Automatický režim </v-list-item-title>
                    <v-list-item-subtitle>Automatické nastavenie tmavého/svetlého režimu (nemusí fungovať na všetkých prehliadačoch)</v-list-item-subtitle>
                  </v-list-item-content>
                </template>
              </v-list-item>
            </v-list-item-group>

            <v-divider></v-divider>

            <v-subheader>Nastavenie hraničných hodnôt</v-subheader>
            <v-row class="pl-3 pr-3 pb-3" justify="center">
              <v-col cols="12" sm="12">
                <v-expansion-panels color="primary">
                  <v-expansion-panel>
                    <v-expansion-panel-header>
                      Teplota okolia
                      <div class="ml-3" v-if="switch1 == true">
                        <v-icon color="green">mdi-check-circle</v-icon>
                      </div>
                      <div class="ml-3" v-else>
                        <v-icon color="red">mdi-close-circle</v-icon>
                      </div>
                    </v-expansion-panel-header>
                    <v-expansion-panel-content>
                      <v-switch v-model="switch1" color="#ff0000" inset></v-switch>
                      <v-range-slider class="mt-5" :disabled="!switch1" color="#ff0000" track-color="#ff0000" track-fill-color="#ff0000" v-model="slider1" thumb-label="always" :thumb-size="28" max="100" min="-20"></v-range-slider>
                      <span>Nastavenie hraničných hodnôt pre teplotu okolia</span>
                    </v-expansion-panel-content>
                  </v-expansion-panel>

                  <v-expansion-panel>
                    <v-expansion-panel-header>
                      Teplota na čipe
                      <div class="ml-3" v-if="switch2 == true">
                        <v-icon color="green">mdi-check-circle</v-icon>
                      </div>
                      <div class="ml-3" v-else>
                        <v-icon color="red">mdi-close-circle</v-icon>
                      </div>
                    </v-expansion-panel-header>
                    <v-expansion-panel-content>
                      <v-switch v-model="switch2" color="#ff6600" inset></v-switch>
                      <v-range-slider class="mt-5" :disabled="!switch2" color="#ff6600" track-color="#ff6600" track-fill-color="#ff6600" v-model="slider2" thumb-label="always" :thumb-size="28" max="100" min="-20"></v-range-slider>
                      <span>Nastavenie hraničných hodnôt pre teplotu na čipe</span>
                    </v-expansion-panel-content>
                  </v-expansion-panel>

                  <v-expansion-panel>
                    <v-expansion-panel-header>
                      Vlhkosť
                      <div class="ml-3" v-if="switch3 == true">
                        <v-icon color="green">mdi-check-circle</v-icon>
                      </div>
                      <div class="ml-3" v-else>
                        <v-icon color="red">mdi-close-circle</v-icon>
                      </div>
                    </v-expansion-panel-header>
                    <v-expansion-panel-content>
                      <v-switch v-model="switch3" color="#0066ff" inset></v-switch>
                      <v-range-slider class="mt-5" :disabled="!switch3" color="#0066ff" track-color="#0066ff" track-fill-color="#0066ff" v-model="slider3" thumb-label="always" :thumb-size="28" max="100" min="0"></v-range-slider>
                      <span>Nastavenie hraničných hodnôt pre vlhkosť</span>
                    </v-expansion-panel-content>
                  </v-expansion-panel>

                  <v-expansion-panel>
                    <v-expansion-panel-header>
                      Hlasitosť
                      <div class="ml-3" v-if="switch4 == true">
                        <v-icon color="green">mdi-check-circle</v-icon>
                      </div>
                      <div class="ml-3" v-else>
                        <v-icon color="red">mdi-close-circle</v-icon>
                      </div>
                    </v-expansion-panel-header>
                    <v-expansion-panel-content>
                      <v-switch v-model="switch4" color="#ffcc00" inset></v-switch>
                      <v-range-slider class="mt-5" :disabled="!switch4" color="#ffcc00" track-color="#ffcc00" track-fill-color="#ffcc00" v-model="slider4" thumb-label="always" :thumb-size="28" max="100" min="0"></v-range-slider>
                      <span>Nastavenie hraničných hodnôt pre hlasitosť</span>
                    </v-expansion-panel-content>
                  </v-expansion-panel>

                  <v-expansion-panel>
                    <v-expansion-panel-header>
                      Osvetlenie
                      <div class="ml-3" v-if="switch5 == true">
                        <v-icon color="green">mdi-check-circle</v-icon>
                      </div>
                      <div class="ml-3" v-else>
                        <v-icon color="red">mdi-close-circle</v-icon>
                      </div>
                    </v-expansion-panel-header>
                    <v-expansion-panel-content>
                      <v-switch v-model="switch5" color="#737373" inset></v-switch>
                      <v-range-slider class="mt-5" :disabled="!switch5" color="#737373" track-color="#737373" track-fill-color="#737373" v-model="slider5" thumb-label="always" :thumb-size="28" max="1000" min="0"></v-range-slider>
                      <span>Nastavenie hraničných hodnôt pre osvetlenie</span>
                    </v-expansion-panel-content>
                  </v-expansion-panel>

                  <v-expansion-panel>
                    <v-expansion-panel-header>
                      Tlak
                      <div class="ml-3" v-if="switch6 == true">
                        <v-icon color="green">mdi-check-circle</v-icon>
                      </div>
                      <div class="ml-3" v-else>
                        <v-icon color="red">mdi-close-circle</v-icon>
                      </div>
                    </v-expansion-panel-header>
                    <v-expansion-panel-content>
                      <v-col cols="2" class="pl-0 pr-0">
                        <v-switch v-model="switch6" color="#00b300" inset></v-switch>
                      </v-col>

                      <v-range-slider class="mt-5" :disabled="!switch6" color="#00b300" track-color="#00b300" track-fill-color="#00b300" v-model="slider6" thumb-label="always" :thumb-size="28" max="1500" min="0"></v-range-slider>
                      <span>Nastavenie hraničných hodnôt pre tlak</span>
                    </v-expansion-panel-content>
                  </v-expansion-panel>
                </v-expansion-panels>
              </v-col>
            </v-row>

            <v-divider></v-divider>

            <v-list-item-group v-model="sd" multiple active-class="">
              <v-list-item :disabled="lockSpeedDial">
                <template v-slot:default="{ active }">
                  <v-list-item-action>
                    <v-switch color="primary" :input-value="active" inset></v-switch>
                  </v-list-item-action>

                  <v-list-item-content>
                    <v-list-item-title>Speed dial (<v-icon medium>mdi-web</v-icon>)</v-list-item-title>
                    <v-list-item-subtitle>Zapnúť alebo vypnúť zobrazenie speed dialu (len rozlíšenie webu)</v-list-item-subtitle>
                  </v-list-item-content>
                </template>
              </v-list-item>
            </v-list-item-group>

            <v-divider></v-divider>

            <v-list-item-group v-model="bn" multiple active-class="">
              <v-list-item :disabled="lockBottomNavigation">
                <template v-slot:default="{ active }">
                  <v-list-item-action>
                    <v-switch color="primary" :input-value="active" inset></v-switch>
                  </v-list-item-action>

                  <v-list-item-content>
                    <v-list-item-title>spodná navigačná lišta (<v-icon medium>mdi-cellphone-cog</v-icon>)</v-list-item-title>
                    <v-list-item-subtitle>Zapnúť alebo vypnúť zobrazenie spodnej lišty (len pre mobily)</v-list-item-subtitle>
                  </v-list-item-content>
                </template>
              </v-list-item>
            </v-list-item-group>

            <v-divider></v-divider>

            <v-subheader>Jazyk aplikácie</v-subheader>
            <!-- <v-list-item-title>Jazyk aplikácie</v-list-item-title> -->
            <v-row class="pr-3 pl-3" justify="center">
              <v-col class="d-flex pb-0" cols="12" sm="6">
                <v-select v-model="select" :items="countries" item-text="name" label="Jazyk" solo :menu-props="{ top: true, offsetY: true }">
                  <template class="select_language" slot="selection" slot-scope="slotProps">
                    <CountryFlag class="mr-2" :country='slotProps.item.flag' size='normal' />
                    {{slotProps.item.name}}
                  </template>
                  <template class="select_language" v-slot:item="slotProps">
                    <CountryFlag class="mr-2" :country='slotProps.item.flag' size='normal' />
                    {{slotProps.item.name}}
                  </template>
                  <span>Vybrať jayzk</span>
                </v-select>
              </v-col>
            </v-row>
          </v-list>
        </v-col>
      </v-row>
    </div>
  </v-lazy>
  <NavigationDrawer :drawer="drawer" />
  <SpeedDial />
  <Footer />
</div>
</template>
<script>
// import axios from 'axios';
import Footer from "../components/Footer.vue";
import NavigationDrawer from "../components/NavigationDrawer.vue";
import SpeedDial from "../components/SpeedDial.vue";
import CountryFlag from 'vue-country-flag';

export default {
  name: "Settings",
  components: {
    Footer,
    NavigationDrawer,
    SpeedDial,
    CountryFlag,
  },
  props: ['drawerNew'],
  data() {
    return {
      // windowHeight: window.innerHeight,
      windowWidth: window.innerWidth,
      txt: '',
      lockSpeedDial: false,
      lockBottomNavigation: false,
      autoDLMon: false,
      settings: [],
      drawer: false,
      select: localStorage.getItem('language'),
      countries: [{
          name: "Slovenský jazyk",
          flag: "sk"
        },
        {
          name: "Anglický jazyk",
          flag: "gb"
        },
        {
          name: "Ruský jazyk",
          flag: "rus"
        },
      ],
      ntf: [],
      ntfs: [],
      dlm: [],
      sd: [],
      bn: [],

      switch1: false,
      switch2: false,
      switch3: false,
      switch4: false,
      switch5: false,
      switch6: false,

      slider1: [0, 45],
      slider2: [0, 45],
      slider3: [0, 70],
      slider4: [0, 50],
      slider5: [0, 100],
      slider6: [0, 1000],

      arraySwitchesSliders: [],
    }
  },
  mounted() {

    //get value of sliders and switches from localstorage
    if (localStorage.getItem('arraySwitchesSliders')) {
      this.arraySwitchesSliders = JSON.parse(localStorage.getItem('arraySwitchesSliders'));
      for (var x = 1; x < 7; x++) {
        this["switch" + x] = this.arraySwitchesSliders[this.arraySwitchesSliders.length - x].["switch" + x];
        this["slider" + x] = this.arraySwitchesSliders[this.arraySwitchesSliders.length - x].["slider" + x];
      }
    }

    if (!(localStorage.getItem('language'))) {
      localStorage.setItem('language', 'Slovenský jazyk');
    }

    if (this.windowWidth <= 480) {
      this.lockSpeedDial = true;
      this.lockBottomNavigation = false;
    } else {
      this.lockSpeedDial = false;
      this.lockBottomNavigation = true;
    }
    window.addEventListener('resize', () => {
      this.windowWidth = window.innerWidth
      if (this.windowWidth <= 480) {
        this.lockSpeedDial = true;
        this.lockBottomNavigation = false;
      } else {
        this.lockSpeedDial = false;
        this.lockBottomNavigation = true;
      }
    });

    const theme = localStorage.getItem("dark_theme");
    if (theme) {
      if (theme === "true") {
        this.$vuetify.theme.dark = true;
        localStorage.setItem('graph_theme', 'dark');
        localStorage.setItem('graph_text_color', '#ffffff');
      } else {
        this.$vuetify.theme.dark = false;
        localStorage.setItem('graph_theme', 'light');
        localStorage.setItem('graph_text_color', '#2c3e50');
      }
    }

    if (JSON.parse(localStorage.getItem("auto_dlm")) == true) {
      this.autoDLMon = true;
      this.dlm.push(0);
      this.$store.dispatch('autoDarkLightModeState', {
        status: true
      });
    } else {
      this.autoDLMon = false;
      this.dlm.splice(0, 1);
      this.$store.dispatch('autoDarkLightModeState', {
        status: false
      });
    }

    if (JSON.parse(localStorage.getItem("notifState")) == true) {
      this.ntf.push(0);
    }

    if (JSON.parse(localStorage.getItem("notifSoundState")) == true) {
      this.ntfs.push(0);
    }

    if (JSON.parse(localStorage.getItem("speed_dial")) == true) {
      this.sd.push(0);
      this.$store.dispatch('speedDialState', {
        status: true
      });
    } else {
      this.sd.splice(0, 1);
      this.$store.dispatch('speedDialState', {
        status: false
      });
    }

    if (JSON.parse(localStorage.getItem("bottom_navigation")) == true) {
      this.bn.push(0);
      this.$store.dispatch('bottomNavigationState', {
        status: true
      });
    } else {
      this.bn.splice(0, 1);
      this.$store.dispatch('bottomNavigationState', {
        status: false
      });
    }
    this.select = localStorage.getItem('language');
  },

  methods: {
    toggle_dark_mode() {
      this.$vuetify.theme.dark = !this.$vuetify.theme.dark;
      localStorage.setItem("dark_theme", this.$vuetify.theme.dark.toString());
      if (this.$vuetify.theme.dark == true) {
        localStorage.setItem('graph_theme', 'dark');
        localStorage.setItem('graph_text_color', '#ffffff');
      } else {
        localStorage.setItem('graph_theme', 'light');
        localStorage.setItem('graph_text_color', '#2c3e50');
      }
    },
  },

  updated() {
    //do something after updating vue instance

    //save value of sliders and switches to localstorage
    if (this.arraySwitchesSliders.length != 0) {
      this.arraySwitchesSliders.splice(0, this.arraySwitchesSliders.length);
    }
    for (var i = 1; i < 7; i++) {
      this.arraySwitchesSliders.unshift({
        ["switch" + i]: this["switch" + i],
        ["slider" + i]: this["slider" + i],
      })
    }
    localStorage.setItem('arraySwitchesSliders', JSON.stringify(this.arraySwitchesSliders));
    //
    if (this.ntf.length != 0) {
      localStorage.setItem('notifState', true);
    } else {
      localStorage.setItem('notifState', false);
    }

    if (this.ntfs.length != 0) {
      localStorage.setItem('notifSoundState', true);
    } else {
      localStorage.setItem('notifSoundState', false);
    }
    if (this.dlm.length != 0) {
      this.autoDLMon = true;
      localStorage.setItem('auto_dlm', true);
      this.$store.dispatch('autoDarkLightModeState', {
        status: true
      });
      if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)')
        .matches) {
        this.$vuetify.theme.dark = true;
        localStorage.setItem("dark_theme", this.$vuetify.theme.dark.toString());
        localStorage.setItem('graph_theme', 'dark');
        localStorage.setItem('graph_text_color', '#ffffff');
      } else {
        this.$vuetify.theme.dark = false;
        localStorage.setItem("dark_theme", this.$vuetify.theme.dark.toString());
        localStorage.setItem('graph_theme', 'light');
        localStorage.setItem('graph_text_color', '#2c3e50');
      }
    } else {
      this.autoDLMon = false;
      localStorage.setItem('auto_dlm', false);
      this.$store.dispatch('autoDarkLightModeState', {
        status: false
      });
    }

    if (this.sd.length != 0) {
      localStorage.setItem('speed_dial', true);
      this.$store.dispatch('speedDialState', {
        status: true
      });
    } else {
      localStorage.setItem('speed_dial', false);
      this.$store.dispatch('speedDialState', {
        status: false
      });
    }

    if (this.bn.length != 0) {
      localStorage.setItem('bottom_navigation', true);
      this.$store.dispatch('bottomNavigationState', {
        status: true
      });
    } else {
      localStorage.setItem('bottom_navigation', false);
      this.$store.dispatch('bottomNavigationState', {
        status: false
      });
    }

    localStorage.setItem('language', this.select);

    this.drawer = this.drawerNew;
  },

  created() {
    // console.log('Component Settings created')
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

.speed_dial_switch .v-input--selection-controls {
  margin-top: 22px !important;
}
</style>
