import {createI18n} from 'vue-i18n';
import getLocalization from '../utils/localization.js';
import messages from './lang/index.js';

console.log(messages)
const i18n = createI18n({
  locale: getLocalization(),
  fallbackLocale: 'en',
  messages,
});

export default i18n;