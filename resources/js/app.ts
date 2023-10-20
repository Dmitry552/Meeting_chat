import './bootstrap';
import {createApp} from "vue";
import {createRouter, createWebHistory} from "vue-router/dist/vue-router";
import {Router} from 'vue-router'
import i18n from './localization/i18n';

import router from "./routes";
import store from './store/index';
import components from './components/global';
import ui from './components/ui';
import layouts from './layouts';

import App from './components/App.vue';

// const router: Router = createRouter({
//   history: createWebHistory(),
//   routes
// });

const app = createApp(App)
  .use(router)
  .use(store)
  .use(i18n);

components.forEach((component, key) => {
  app.component(key, component);
})

layouts.forEach((layout, key) => {
  app.component(key, layout);
})

ui.forEach((component, key) => {
  app.component(key, component);
})

app.mount('#app');