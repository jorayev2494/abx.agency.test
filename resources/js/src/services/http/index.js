import axios from 'axios'
import request from './interceptors/request'
import response from './interceptors/response';

// const apiServerEndpoint = process.env.VUE_APP_API_SERVER_ENDPOINT ?? 'http://127.0.0.1:8011';
const apiServerEndpoint = window.location.origin ?? 'http://127.0.0.1:8011';
const baseURL = `${apiServerEndpoint}/api`;

const httpClient = axios.create({
  baseURL,
  // timeout: 1000,
  // headers: {
  //   "Content-Type": "application/json",
  //   Accept: "application/json",
  //   "X-Socket-Id": () => window.Echo.socketId(),
  // },
});

httpClient.interceptors.request.use(request.request, request.requestError);
httpClient.interceptors.response.use(response.response, response.responseError);

export default httpClient;
