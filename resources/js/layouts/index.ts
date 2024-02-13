import MainLayout from "./MainLayout.vue";
import LoginLayout from "./LoginLayout.vue";
import BlankLayout from "./BlankLayout.vue";

const layouts: Map<string, {name: string}> = new Map([
  ['MainLayout', MainLayout],
  ['LoginLayout', LoginLayout],
  ['blank', BlankLayout]
]);

export default layouts;