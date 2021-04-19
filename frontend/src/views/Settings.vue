<template>
<v-lazy :options="{
        threshold: .4
      }" min-height="100vh" transition-group="scale-transition">
  <div class="settings mt-page-settings_notif">
    <v-card class="mx-auto" elevation="0" tile>
      <v-app-bar fixed app tile>
        <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>

        <v-toolbar-title>OpenLab FEI Tuke</v-toolbar-title>

        <v-spacer></v-spacer>

        <v-btn icon to="/notifications">
          <v-icon>mdi-bell</v-icon>
        </v-btn>
      </v-app-bar>
    </v-card>
    <v-row class="mx-auto">
      <v-col class="mb-5">
        <!-- <v-card> -->
        <v-list flat subheader>
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
                    <v-btn v-on="on" @click="toggle_dark_mode" block large>
                      <v-icon>mdi-theme-light-dark</v-icon>
                    </v-btn>
                  </template>
                  <span>Zapnúť dark mód</span>
                </v-tooltip>

                <v-tooltip v-else bottom>
                  <template v-slot:activator="{ on }">
                    <v-btn v-on="on" @click="toggle_dark_mode" block large>
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
                  <v-list-item-subtitle>Automatické nastavenie tmavého/svetlého režimu</v-list-item-subtitle>
                </v-list-item-content>
              </template>
            </v-list-item>
          </v-list-item-group>

          <v-divider></v-divider>

          <v-list-item-group v-model="sd" multiple active-class="">
            <v-list-item>
              <template v-slot:default="{ active }">
                <v-list-item-action>
                  <v-switch color="primary" :input-value="active" @click="speedDial()" inset></v-switch>
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
            <v-list-item>
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
        <!-- <span class="secondary--color">Dark/Light mod</span>
      <v-card-text>
        <v-row justify="center">
          <v-col class="d-flex" cols="12" sm="6">
            <v-tooltip v-if="!$vuetify.theme.dark" bottom>
              <template v-slot:activator="{ on }">
                <v-btn v-on="on" @click="toggle_dark_mode" block large>
                  <v-icon>mdi-theme-light-dark</v-icon>
                </v-btn>
              </template>
              <span>Zapnúť dark mód</span>
            </v-tooltip>

            <v-tooltip v-else bottom>
              <template v-slot:activator="{ on }">
                <v-btn v-on="on" @click="toggle_dark_mode" block large>
                  <v-icon>mdi-theme-light-dark</v-icon>
                </v-btn>
              </template>
              <span>Vypnúť dark mód</span>
            </v-tooltip>
          </v-col>
        </v-row>

      </v-card-text>

      <v-divider class="secondary" />

      <span class="secondary--color">Speed dial (<v-icon medium>mdi-web</v-icon>)</span>

      <v-card-text>
        <v-row justify="center">
          <v-col class="d-flex" cols="12" sm="6">
            <v-btn :ripple="false" class="speed_dial_switch" block large>
              <span class="pr-4">skryť</span>
              <v-switch color="primary" v-model="switch1" inset @click="speedDial()"></v-switch>
              <span>Zobraziť</span>
            </v-btn>
          </v-col>
        </v-row>
      </v-card-text>

      <v-divider class="secondary" />

      <span class="secondary--color">Notifikácie</span>

      <v-card-text>
        <v-row justify="center">
          <v-col class="d-flex pb-0" cols="12" sm="6">
            <v-btn :ripple="false" class="speed_dial_switch" block large>
              <span class="pr-4">vypnúť</span>
              <v-switch color="primary" v-model="switch2" inset></v-switch>
              <span>Zapnúť</span>
            </v-btn>
          </v-col>
        </v-row>
      </v-card-text>

      <v-divider class="secondary" />

      <span class="secondary--color">spodná navigačná lišta (<v-icon medium>mdi-cellphone-cog</v-icon>)</span>

      <v-card-text>
        <v-row justify="center">
          <v-col class="d-flex pb-0" cols="12" sm="6">
            <v-btn :ripple="false" class="speed_dial_switch" block large>
              <span class="pr-4">skryt</span>
              <v-switch color="primary" v-model="switch3" @click="bottomNavigation()" inset></v-switch>
              <span>Zobraziť</span>
            </v-btn>
          </v-col>
        </v-row>
      </v-card-text>

      <v-divider class="secondary" />

      <span class="secondary--color">Jazyk aplikácie</span>

      <v-card-text class="select_country">
        <v-row justify="center">
          <v-col class="d-flex pb-0" cols="12" sm="6">
            <v-select v-model="select" :items="countries" item-text="name" label="Jazyk" solo>

              <template class="select_language" v-slot:item="slotProps">
                <CountryFlag class="mr-2" :country='slotProps.item.flag' size='medium' />
                {{slotProps.item.name}}
              </template>
              <span>Vybrať jayzk</span>
            </v-select>
          </v-col>
        </v-row>
      </v-card-text> -->
        <!-- </v-card> -->
      </v-col>
    </v-row>
    <NavigationDrawer :drawer="drawer" />
    <BottomNavigation />
    <Footer />
  </div>
</v-lazy>
</template>
<script>
// import axios from 'axios';
import Footer from "../components/Footer.vue";
import NavigationDrawer from "../components/NavigationDrawer.vue";
import BottomNavigation from "../components/BottomNavigation.vue";
import CountryFlag from 'vue-country-flag';

export default {
  name: "Settings",
  components: {
    Footer,
    NavigationDrawer,
    BottomNavigation,
    CountryFlag,
  },
  props: ['drawerNew'],
  data() {
    return {
      settings: [],
      drawer: false,
      select: localStorage.getItem('language'),
      countries: [{
          name: "Slovensky",
          flag: "sk"
        },
        {
          name: "Anglicky",
          flag: "gb"
        },
        {
          name: "Nemecky",
          flag: "de"
        },
      ],
      ntf: [],
      dlm: [],
      sd: [],
      bn: [],
      switch1: JSON.parse(localStorage.getItem("speed_dial")),
      switch2: true,
      switch3: JSON.parse(localStorage.getItem("bottom_navigation")),
    }
  },

  mounted() {
    const theme = localStorage.getItem("dark_theme");
    if (theme) {
      if (theme === "true") {
        this.$vuetify.theme.dark = true;
      } else {
        this.$vuetify.theme.dark = false;
      }
    } else if (
      window.matchMedia &&
      window.matchMedia("(prefers-color-scheme: dark)")
      .matches
    ) {
      this.$vuetify.theme.dark = true;
      localStorage.setItem(
        "dark_theme",
        this.$vuetify.theme.dark.toString()
      );
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
      console.log("tusom");
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
    },

    // speedDial() {
    //   if (JSON.parse(localStorage.getItem('speed_dial')) == true) {
    //     localStorage.setItem('speed_dial', false);
    //     this.switch1 = false;
    //     this.$store.dispatch('speedDialState', {
    //       status: false
    //     });
    //   } else {
    //     localStorage.setItem('speed_dial', true);
    //     this.switch1 = true;
    //     this.$store.dispatch('speedDialState', {
    //       status: true
    //     });
    //   }
    // },

    // bottomNavigation() {
    //   console.log("cc");
    //   if (JSON.parse(localStorage.getItem('bottom_navigation')) == true) {
    //     localStorage.setItem('bottom_navigation', false);
    //     this.switch3 = false;
    //     this.$store.dispatch('bottomNavigationState', {
    //       status: false
    //     });
    //   } else {
    //     localStorage.setItem('bottom_navigation', true);
    //     this.switch3 = true;
    //     this.$store.dispatch('bottomNavigationState', {
    //       status: true
    //     });
    //   }
    // },
  },

  updated() {
    //do something after updating vue instance
    if (this.sd.length != 0) {
      localStorage.setItem('speed_dial', true);
      this.switch1 = true;
      this.$store.dispatch('speedDialState', {
        status: true
      });
    } else {
      localStorage.setItem('speed_dial', false);
      this.switch1 = false;
      this.$store.dispatch('speedDialState', {
        status: false
      });
    }


    if (this.bn.length != 0) {
      localStorage.setItem('bottom_navigation', true);
      this.switch3 = true;
      this.$store.dispatch('bottomNavigationState', {
        status: true
      });
    } else {
      localStorage.setItem('bottom_navigation', false);
      this.switch3 = false;
      this.$store.dispatch('bottomNavigationState', {
        status: false
      });
    }
    localStorage.setItem('language', this.select);
    this.drawer = this.drawerNew;
    console.log(this.$store.getters['speedDialState'].state);
    console.log(this.$store.getters['bottomNavigationState'].state);
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

.speed_dial_switch .v-input--selection-controls {
  margin-top: 22px !important;
}
</style>
