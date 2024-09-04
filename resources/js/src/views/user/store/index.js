import httpClient from '../../../services/http/index.js'
import { store } from '../../../services/store/index.js'

const state = {

}

const getters = {

}

const mutations = {

}

const actions = {
  async loadUsersAsync(_, { params = {} }) {
    return await new Promise((resolve, reject) => {
      return httpClient.get('/users', { params })
        .then(resolve)
        .catch(reject);
    })
  },
  async showUserAsync(_, { uuid }) {
    return await new Promise((resolve, reject) => {
      return httpClient.get(`/users/${uuid}`)
        .then(resolve)
        .catch(reject);
    })
  },
  async createUserAsync(_, { data }) {
    return await new Promise((resolve, reject) => {
      return httpClient.post('/users', data)
        .then(response => {
          store.commit('clearAccessToken');

          return response(response);
        })
        .catch(reject);
    })
  },
  async updateUserAsync(_, { uuid, data }) {
    return await new Promise((resolve, reject) => {
      return httpClient.post(`/users/${uuid}`, data)
        .then(resolve)
        .catch(reject);
    })
  },
  async deleteUsersAsync(_, { uuid }){
    return await new Promise((resolve, reject) => {
      return httpClient.delete(`/users/${uuid}`)
        .then(resolve)
        .catch(reject);
    })
  },
}

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions,
}