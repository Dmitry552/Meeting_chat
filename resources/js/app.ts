import './bootstrap';
import {createApp} from "vue";

import router from "./routes";
import {store, key} from './store';
import custom_components from './components/global';
import ui from './components/ui';
import layouts from './layouts';

import App from './components/App.vue';
import Plugins from "./plugins";

const app = createApp(App)
  .use(store, key)
  .use(router)
  .use(Plugins)

custom_components.forEach((component, key) => {
  app.component(key, component);
})

layouts.forEach((layout, key) => {
  app.component(key, layout);
})

ui.forEach((component, key) => {
  app.component(key, component);
})

app.mount('#app');