import './bootstrap';
import {createApp} from "vue";
import i18n from './localization/i18n';
import PrimeVue from 'primevue/config';
import ConfirmationService from 'primevue/confirmationservice';
import { DatePicker } from 'ant-design-vue';
import 'maz-ui/css/main.css';
import 'ant-design-vue/dist/reset.css';

import 'primevue/resources/themes/saga-blue/theme.css';
import 'primevue/resources/primevue.min.css';
import 'bootstrap/dist/css/bootstrap.min.css';
import '../sass/index.scss';

import router from "./routes";
import {store, key} from './store';
import custom_components from './components/global';
import custom_directives from './Directives';
import ui from './components/ui';
import layouts from './layouts';

import App from './components/App.vue';
import Plugins from "./Plugins/Admin";

const app = createApp(App)
  .use(store, key)
  .use(router)
  .use(Plugins)
  .use(PrimeVue)
  .use(ConfirmationService)
  .use(DatePicker)
  .use(i18n);

custom_components.forEach((component, key) => {
  app.component(key, component);
})

custom_directives.forEach((directive, key) => {
  app.directive(key, directive);
})

layouts.forEach((layout, key) => {
  app.component(key, layout);
})

ui.forEach((component, key) => {
  app.component(key, component);
})

app.mount('#app');