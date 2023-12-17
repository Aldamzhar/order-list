import { createApp } from 'vue/dist/vue.esm-bundler';
import { BootstrapVue3 } from 'bootstrap-vue-3';
import OrdersList from './components/OrdersList.vue';
import Login from './components/Login.vue'
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue-3/dist/bootstrap-vue-3.css';

const app = createApp({});

// Use BootstrapVue
app.use(BootstrapVue3);

app.component('login', Login);
app.component('orders-list', OrdersList);
app.mount('#app');
