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

import router from "./routes";
import {store, key} from './store';
import custom_components from './components/global';
import ui from './components/ui';
import layouts from './layouts';

import App from './components/App.vue';

const app = createApp(App)
  .use(store, key)
  .use(router)
  .use(PrimeVue)
  .use(ConfirmationService)
  .use(DatePicker)
  .use(i18n);

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