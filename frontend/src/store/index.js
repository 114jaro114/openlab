import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    // test: null,
  },
  getters: {
    // test: state => {
    //   return state.test;
    // },
  },
  mutations: {
    // mutationTest: (state, payload) => {
    //   Vue.set(state.test, 'test', payload.test);
    //   Vue.set(state.test2, 'test2', payload.test2);
    // },
    //
    // mutationTest2: (state, payload) => {
    //   state.test = payload.test;
    // },
  },
  actions: {
    // test: (context, payload) => {
    //   context.commit('mutationtest', payload)
    // },
  }
});