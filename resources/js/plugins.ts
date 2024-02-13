import PrimeVue from "primevue/config";
import ConfirmationService from "primevue/confirmationservice";
import {DatePicker} from "ant-design-vue";
import i18n from "./localization/i18n";

import 'maz-ui/css/main.css';
import 'ant-design-vue/dist/reset.css';
import 'primevue/resources/themes/saga-blue/theme.css';
import 'primevue/resources/primevue.min.css';

const Plugins =  {
  install (app) {
    app.use(PrimeVue)
    .use(ConfirmationService)
    .use(DatePicker)
    .use(i18n);
  }
}

export default Plugins;