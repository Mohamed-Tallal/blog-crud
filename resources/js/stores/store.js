import Vuex from 'vuex';
import Vue from 'vue';

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    userData: JSON.parse(localStorage.getItem("authUser")), // Parse the JSON data
  },
  getters: {
    isLogged(state) {
      return !!state.userData;
    },
    getUserId(state) {
      return state.userData ? state.userData.id : null;
    }
  },
  mutations: {
  },
  actions: {
  }
});

