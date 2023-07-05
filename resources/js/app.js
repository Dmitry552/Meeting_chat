import './bootstrap';
import {createApp} from "vue";
import {createRouter, createWebHistory} from "vue-router/dist/vue-router";
import {createStore} from "vuex";

import routes from "./routes";
import modules from './store/modules/index';

import App from './components/App.vue';



const route = createRouter({
  history: createWebHistory(),
  routes
});

const store = createStore({
  modules: {
    modules
  }
});

createApp(App)
  .use(route)
  .use(store)
  .mount('#app');