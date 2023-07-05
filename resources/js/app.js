import './bootstrap';
import {createApp} from "vue";
import {createRouter, createWebHistory} from "vue-router/dist/vue-router";
import routes from "./routes";
import App from './components/App.vue';


const route = createRouter({
  history: createWebHistory(),
  routes
});

createApp(App)
  .use(route)
  .mount('#app');