import router from './../../router/index.js'
import { store } from './../../store/index.js'

const response = response => {
  window.console.log(`Interceptor (response)  => { method: ${response.method}, url: ${response.url} }: `, response);

  return response;
}

const responseError = error => {
  const accessToken = localStorage.getItem('access_token');
  const { config, response } = error

  console.log('response.data: ', response.data);
  if (response && response.status === 401) {
    store.commit('clearAccessToken');
    router.push({ name: 'user-index' });
  }

  if (response && response.status === 422) {
    console.log('422', response.data)
    const { fails } = response.data;

    let msg = '';
    for (const property in fails) {
      msg += `${property}: \r\n`
      fails[property].forEach(error => {
        msg += `${error} \r\n`
      })
      msg += `\r\n`
    }

    alert(msg);
  }

  if (response && [400, 403, 404].includes(response.status)) {
    const { message } = response.data;

    alert(message);
  }

  return Promise.reject(error);
};

export default {
  response,
  responseError,
};