import { store } from '../../store/index.js';

const request = config => {
  const accessToken = store.getters['getAccessToken'];
  window.console.log(`Interceptor (request)  => { method: ${config.method}, url: ${config.url} }: `);

  if (accessToken) {
    config.headers['Authorization'] = `Bearer ${accessToken}`;
  }

  return config;
}

const requestError = error => {
  return Promise.reject(error);
}

export default {
  request,
  requestError,
};