import Home from "./pages/Home.vue";
import Room from "./pages/Room.vue";
import NotFound from "./pages/NotFound.vue";


const routes = [
  {
    path: '/',
    component: Home
  },
  {
    path: '/room/:id',
    component: Room
  },
  {
    path: '/:catchAll(.*)',
    component: NotFound
  }
]

export default routes;

