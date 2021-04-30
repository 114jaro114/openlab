<template>
<div class="notifications mt-page-settings_notif">
  <v-lazy :options="{
        threshold: .4
      }" min-height="100vh" transition-group="scale-transition">
    <div class="">
      <v-card class="mx-auto ml-3 mr-3" elevation="0" tile>
        <v-app-bar fixed flat>
          <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>

          <v-toolbar-title class="title_toolbar">OpenLab FEI Tuke</v-toolbar-title>

          <v-spacer></v-spacer>

          <v-btn icon to="/settings">
            <v-icon>mdi-cog</v-icon>
          </v-btn>
        </v-app-bar>
      </v-card>

      <v-row class="m-0">
        <v-col class="mb-5" cols="12" lg="12" md="12" sm="12">
          <v-card rounded>
            <v-toolbar class="notiftoolbar rounded-top" extended extension-height="4" color="primary" flat dark>
              <div class="w-75" v-if="selected.length == '0'">
                <v-text-field color="white white--color" v-model="search" append-icon="mdi-magnify" label="Vyhľadať" single-line hide-details clearable disabled v-if="myloadingvariable || notif.length == 0"></v-text-field>
                <v-text-field color="white white--color" v-model="search" append-icon="mdi-magnify" label="Vyhľadať" single-line hide-details clearable v-if="!myloadingvariable &&  notif.length != 0"></v-text-field>
              </div>

              <div v-else>
                <v-tooltip bottom>
                  <template v-slot:activator="{ on, attrs }">
                    <v-btn color="white white--color" fab icon small @click="deleteNotif = !deleteNotif" v-bind="attrs" v-on="on">
                      <v-icon>mdi-delete</v-icon>
                    </v-btn>
                  </template>
                  <span>Vymazať</span>
                </v-tooltip>
              </div>

              <v-spacer></v-spacer>

              <span style="font-size:12px">Označiť všetko</span>
              <v-checkbox class="mt-5 ml-3" color="white white--color" @change="checkUncheckAll($event);" disabled v-if="myloadingvariable || notif.length == 0"></v-checkbox>
              <v-checkbox class=" mt-5 ml-3" color="white white--color" @change="checkUncheckAll($event);" v-model=" item_1.checked" :indeterminate="item_1.indeterminate" v-if="!myloadingvariable && notif.length != 0"></v-checkbox>

              <v-progress-linear v-if=" myloadingvariable" color="white" style="height:4px" slot="extension" :indeterminate="true">
              </v-progress-linear>
            </v-toolbar>

            <v-list class="pt-0 pb-0" three-line>
              <v-list-item-group v-model="selected" active-class="primary--text" multiple>
                <v-list-item style="height:95px" class="justify-center" v-if="myloadingvariable" disabled>
                  Načítavanie... Prosím počkajte
                </v-list-item>
                <v-list-item style="height:95px" class="justify-center" v-if="filteredItems.length == 0 && !myloadingvariable && notif.length != 0" disabled>
                  <v-btn color="primary" icon width="50px" height="50px">
                    <v-icon style="font-size: 50px">mdi-cancel</v-icon>
                    <span class="ml-3">Žiadne výsledky</span>
                  </v-btn>
                </v-list-item>

                <v-list-item style="height:95px" class="justify-center" v-else-if="notif.length == 0 && !myloadingvariable" disabled>
                  <v-btn color="primary" icon width="50px" height="50px">
                    <v-icon style="font-size: 50px">mdi-bell-cancel</v-icon>
                    <span class="ml-3">Žiadne nové notifikácie</span>
                  </v-btn>
                </v-list-item>
                <template v-else v-for="(item, index) in filteredItems">
                  <!-- list notif -->
                  <v-list-item class="p-0" :key="item.id" v-if="!myloadingvariable">
                    <template v-slot:default="{ active }">
                      <v-list-item-content class="pt-5 pb-5 pl-3" @click="checkUncheck(item, active)">
                        <v-list-item-title v-text="item.title"></v-list-item-title>

                        <v-list-item-subtitle class="text--primary">
                          <v-icon>mdi-alert-circle-outline</v-icon> {{ item.subtitle}}
                        </v-list-item-subtitle>

                        <v-list-item-subtitle v-text="item.text"></v-list-item-subtitle>
                      </v-list-item-content>

                      <v-list-item-action class="m-0 p-3" @click="checkUncheck(item, active)">
                        <v-list-item-action-text class="pb-3" v-text="item.date"></v-list-item-action-text>

                        <v-checkbox value v-if="!active"></v-checkbox>

                        <v-checkbox input-value="true" value v-else></v-checkbox>
                      </v-list-item-action>
                    </template>
                  </v-list-item>
                  <v-divider class="m-0" v-if="item < notif.length - 1 && !myloadingvariable" :key="index"></v-divider>
                </template>
                <!-- snackbar deleteNotif-->
                <v-snackbar :timeout="-1" :value="deleteNotif" absolute centered color="primary" elevation="24" :top="true">
                  <div v-if="selectedAll.length == 1">
                    <span>Naozaj chcete vymazať túto notifikáciu?</span>
                  </div>
                  <div v-else>
                    <span>Naozaj chcete vymazať tieto notifikácie?</span>
                  </div>
                  <v-btn class="ml-2 mt-3" color="secondary green--text" fab x-small @click="deleteNotif = false; deleteNotification()">
                    <v-icon>mdi-check</v-icon>
                  </v-btn>
                  <v-btn class="ml-2 mt-3" color="secondary red--text" fab x-small medium @click="deleteNotif = false">
                    <v-icon>mdi-close</v-icon>
                  </v-btn>
                </v-snackbar>
                <v-snackbar v-model="snackbar" :multi-line="multiLine" color="success" :left="true">
                  <v-icon>mdi-check-circle</v-icon>
                  {{ text }}
                  <template v-slot:action="{ attrs }">
                    <v-btn fab small color="white" text v-bind="attrs" @click="snackbar = false">
                      <v-icon>mdi-close-circle</v-icon>
                    </v-btn>
                  </template>
                </v-snackbar>
                <!-- ///////// -->
              </v-list-item-group>
            </v-list>
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
import Footer from "../components/Footer.vue";
import NavigationDrawer from "../components/NavigationDrawer.vue";
import BottomNavigation from "../components/BottomNavigation.vue";
import SpeedDial from "../components/SpeedDial.vue";
import _ from 'lodash';
export default {
  name: "Notifications",
  components: {
    Footer,
    NavigationDrawer,
    BottomNavigation,
    SpeedDial
  },
  props: ['drawerNew'],
  data() {
    return {
      drawer: false,

      //
      search: '',
      selected: [],
      selectedAll: [],
      myloadingvariable: true,
      checkbox: true,
      item_1: {
        name: 'test 1',
        checked: false,
        indeterminate: false
      },
      notif: [],
      notifCount: 0,
      // notif snackbars
      deleteNotif: false,
      addToRelevant: false,
      snackbar: false,
      multiLine: true,
      text: '',


      new_notif: ''
    }
  },

  computed: {
    filteredItems() {
      return _.orderBy(this.notif.filter(item => {
        if (!this.search) return this.notif;
        return (item.title.toLowerCase()
          .includes(this.search.toLowerCase()) ||
          item.date.toLowerCase()
          .includes(this.search.toLowerCase()) ||
          item.text.toLowerCase()
          .includes(this.search.toLowerCase()) ||
          item.subtitle.toLowerCase()
          .includes(this.search.toLowerCase()));
      }), 'headline');
    }
  },

  methods: {
    checkUncheck(item, active) {
      if (active) {
        for (var i = 0; i < this.selectedAll.length; i++) {
          if (this.selectedAll[i] == item.id) {
            this.selectedAll.splice(i, 1);
          }
        }
        if (this.item_1.checked == true) {
          this.deleteNotif = false;
          this.item_1.checked = false;
          this.item_1.indeterminate = true;
        }
        if (this.selectedAll.length == this.notif.length) {
          this.item_1.indeterminate = false;
          this.item_1.checked = true;
        }
        if (this.selectedAll.length == "0") {
          this.item_1.indeterminate = false;
          this.item_1.checked = false;
          this.deleteNotif = false;
        }
      } else {
        this.selectedAll.push(item.id);
        if (this.selectedAll.length == this.notif.length) {
          this.item_1.indeterminate = false;
          this.item_1.checked = true;
        }
      }
    },

    checkUncheckAll(event) {
      if (event == true) {
        this.item_1.checked = true;
        this.item_1.indeterminate = false;

        for (var i = 0; i < this.notif.length; i++) {
          this.selected.push(i);
        }

        for (var x = 0; x < this.notif.length; x++) {
          this.selectedAll.push(this.notif[x].id);
        }
      } else {
        this.item_1.checked = false;
        this.item_1.indeterminate = false;
        this.deleteNotif = false;
        this.selected = [];
        this.selectedAll = [];
      }
    },

    // get all todos when loading the page
    getTodos() {
      if (localStorage.getItem('notifications')) {
        this.notif = JSON.parse(localStorage.getItem('notifications'));
        if (this.notif.length < 20) {
          setInterval(() => {
            this.myloadingvariable = false;
          }, 1000);
        } else {
          this.myloadingvariable = false;
        }

      } else {
        this.notif = [];
        if (this.notif.length < 20) {
          setInterval(() => {
            this.myloadingvariable = false;
          }, 1000);
        } else {
          this.myloadingvariable = false;
        }
      }
    },

    deleteNotification() {
      for (var x = 0; x < this.selected.length; x++) {
        this.notif.splice(this.notif.indexOf(this.selected[x]), 1);
      }
      if (this.selected.length == 1) {
        this.snackbar = true;
        this.text = "Notifikácia bola úspešne vymazaná";
      } else {
        this.snackbar = true;
        this.text = "Notifikácie boli úspešne vymazané";
      }
      localStorage.setItem('notifications', JSON.stringify(this.notif));
      for (var z = 0; z < this.notif.length; z++) {
        this.notif[z].id = z;
      }
      localStorage.setItem('notifications', JSON.stringify(this.notif));
    },

    updatenotifStatus() {
      for (var i = 0; i < this.notif.length; i++) {
        this.notif[i].status = 'read'
      }
      localStorage.setItem('notifications', JSON.stringify(this.notif));
      localStorage.setItem('notifCounter', 0);
      this.$store.dispatch('notificationCounter', {
        notifCounter: 0
      });
    }
  },

  mounted() {
    //do something after mounting vue instance
    // console.log('Component Notifications mounted.')
    this.getTodos();
    this.updatenotifStatus();
  },

  updated() {
    this.drawer = this.drawerNew;
    this.updatenotifStatus();
  },

  created() {
    // console.log('Component Notifications created')
    window.Echo.channel('dataAllSensors')
      .listen('AllSensorsEvent', () => {

        if (localStorage.getItem('notifications')) {
          this.notif = JSON.parse(localStorage.getItem('notifications'));
        } else {
          this.notif = [];
        }
      })
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

.notiftoolbar .v-toolbar__extension {
  padding: 0px !important;
}
</style>
