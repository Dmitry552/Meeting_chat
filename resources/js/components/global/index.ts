import Header from "./Header.vue";
import BaseInput from "./Inputs/BaseInput.vue";
import BaseCheckbox from "./Inputs/BaseCheckbox.vue";
import BaseRadio from "./Inputs/BaseRadio.vue";
import BaseDropdown from "./BaseDropdown.vue";
import Card from "../Admin/Cards/Card.vue";

const custom_components = new Map<string, any>([
  ['m-header', Header],
  [BaseInput.name, BaseInput],
  [BaseCheckbox.name, BaseCheckbox],
  [BaseRadio.name, BaseRadio],
  [BaseDropdown.name, BaseDropdown],
  ['card', Card],
]);

export default custom_components;