import Home from "./pages/Home.vue";
import Room from "./pages/Room.vue";
import NotFound from "./pages/NotFound.vue";
import SignIn from "./pages/SignIn.vue";
import SignUp from "./pages/SignUp.vue";


const routes = [
  {
    path: '/',
    component: Home
  },
  {
    path: '/sign-in',
    component: SignIn
  },
  {
    path: '/sign-up',
    component: SignUp
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

