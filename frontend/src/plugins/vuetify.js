import Vue from 'vue';
// import Vuetify from 'vuetify/lib';
import Vuetify from 'vuetify';
import 'roboto-fontface/css/roboto/roboto-fontface.css';
import '@mdi/font/css/materialdesignicons.css';
import 'vuetify/dist/vuetify.min.css';
import {
  Ripple
} from 'vuetify/lib/directives';

Vue.use(Vuetify, {
  directives: {
    Ripple
  }
});
// import colors from 'vuetify/lib/util/colors'
// https://lobotuerto.com/vuetify-color-theme-builder/#generated-code

const opts = {
  theme: {
    themes: {
      dark: {
        // primary: '#21CFF3',
        primary: '#0D47A1',
        accent: '#E0E0E0',
        secondary: '#EEEEEE',
        success: '#4CAF50',
        info: '#2196F3',
        warning: '#FB8C00',
        error: '#EA1616',
        // background: '#1E1E1E',
        background: '#333333',

        // facebook: '#4CAF50',
        // google: '#4CAF50',
        // twitter: '#4CAF50',
        // github: '#4CAF50'
      },
      light: {
        primary: '#0D47A1',
        accent: '#212121',
        secondary: '#ffffff',
        success: '#4CAF50',
        info: '#2196F3',
        warning: '#FB8C00',
        error: '#EA1616',
        background: '#FFFFFF'
      }
    },
  }
}
export default new Vuetify({
  opts
});