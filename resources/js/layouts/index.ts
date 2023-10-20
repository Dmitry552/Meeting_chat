import MainLayout from "./MainLayout.vue";
import LoginLayout from "./LoginLayout.vue";

const layouts: Map<string, {name: string}> = new Map([
  ['MainLayout', MainLayout],
  ['LoginLayout', LoginLayout],
]);

export default layouts;