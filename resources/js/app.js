import './bootstrap';
import {createApp} from "vue";
import {createRouter, createWebHistory} from "vue-router/dist/vue-router";
import {createStore} from "vuex";
import i18n from './localization/i18n.js';

import routes from "./routes";
import modules from './store/modules/index';
import components from './components/global';
import ui from './components/ui';

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

const app = createApp(App)
  .use(route)
  .use(store)
  .use(i18n);

components.forEach((component, key) => {
  app.component(key, component);
})

ui.forEach((component, key) => {
  app.component(key, component);
})

app.mount('#app');