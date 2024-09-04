import './bootstrap';
import { createApp } from 'vue';
import router from './src/services/router/index.js'
import { store } from './src/services/store/index.js'

// Import our custom CSS
import '../scss/styles.scss'

import App from "./src/App.vue";

const app = createApp(App);
app.use(router);
app.use(store);
app.mount('#app');
