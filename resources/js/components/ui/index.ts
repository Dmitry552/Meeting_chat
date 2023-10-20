import Button from "./Button.vue";
import InputPassword from "./InputPassword.vue";
import InputText from './InputText.vue';

const ui = new Map<string, any>([
  ['ui-button', Button],
  ['ui-password', InputPassword],
  ['ui-input-text', InputText]
]);

export default ui;