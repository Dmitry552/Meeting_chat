import {createI18n} from 'vue-i18n';
import getLocalization from '../utils/localization.js';
import messages from './lang/index.js';

const i18n = createI18n({
  locale: getLocalization(),
  fallbackLocale: 'en',
  globalInjection: true,
  messages,
});

export default i18n;