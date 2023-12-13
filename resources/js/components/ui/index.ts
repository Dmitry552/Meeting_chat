import Button from "./Button.vue";
import Input from "./Input.vue";
import InputField from './InputField.vue';
import Textarea from "./Textarea.vue";

const ui = new Map<string, any>([
  ['ui-button', Button],
  ['ui-input', Input],
  ['ui-input-text', InputField],
  ['ui-textarea', Textarea],
]);

export default ui;