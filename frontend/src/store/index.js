import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    speedDialState: {
      state: false,
    },

    bottomNavigationState: {
      state: false,
    },

    autoDarkLightModeState: {
      state: false,
    },
  },
  getters: {
    speedDialState: state => {
      return state.speedDialState
    },

    bottomNavigationState: state => {
      return state.bottomNavigationState
    },

    autoDarkLightModeState: state => {
      return state.autoDarkLightModeState
    },
  },
  mutations: {
    mutationSpeedDialState: (state, payload) => {
      Vue.set(state.speedDialState, 'state', payload.status);
    },

    mutationBottomNavigationState: (state, payload) => {
      Vue.set(state.bottomNavigationState, 'state', payload.status);
    },

    mutationAutoDarkLightModeState: (state, payload) => {
      Vue.set(state.autoDarkLightModeState, 'state', payload.status);
    },
  },
  actions: {
    speedDialState: (context, payload) => {
      context.commit('mutationSpeedDialState', payload)
    },

    bottomNavigationState: (context, payload) => {
      context.commit('mutationBottomNavigationState', payload)
    },

    autoDarkLightModeState: (context, payload) => {
      context.commit('mutationAutoDarkLightModeState', payload)
    },
  }
});