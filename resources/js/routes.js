import Home from "./pages/Home.vue";
import Room from "./pages/Room.vue";
import NotFound from "./pages/NotFound.vue";
import LogIn from "./pages/LogIn.vue";


const routes = [
  {
    path: '/',
    component: Home
  },
  {
    path: '/log-in',
    component: LogIn
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

