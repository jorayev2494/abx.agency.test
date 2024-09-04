import { createStore } from 'vuex'
import modules from "./modules/index.js";
import httpClient from "../http/index.js";

// Create a new store instance.
export const store = createStore({
  state () {
    return {
      accessToken: null,
    }
  },
  getters: {
    getAccessToken: state => state.accessToken ?? window.localStorage.getItem('access_token'),
  },
  mutations: {
    setAccessToken (state, value) {
      state.accessToken = value;
      window.localStorage.setItem('access_token', value);
    },
    clearAccessToken (state, value) {
      state.accessToken = null;
      window.localStorage.removeItem('access_token');
      window.location.reload();
    },
  },
  actions: {
    async getToken() {
      return await new Promise((resolve, reject) => {
        return httpClient.post('/token')
          .then(resolve)
          .catch(reject);
      })
    },
  },
  modules,
})
