import {createI18n, I18n} from 'vue-i18n';
import getLocalization from '../utils/localization';
import messages from './lang';

type MessageType<T> = {
  [P in keyof T]: T[P]
}

const i18n: I18n<MessageType<typeof messages>> = createI18n({
  locale: getLocalization(),
  fallbackLocale: 'en',
  globalInjection: true,
  messages,
});

export default i18n;
