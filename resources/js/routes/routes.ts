import Home from "../pages/Home.vue";
import SignIn from "../pages/SignIn.vue";
import SignUp from "../pages/SignUp.vue";
import Room from "../pages/Room.vue";
import NotFound from "../pages/NotFound.vue";
import {RouteRecordRaw} from "vue-router";
import {LayoutsName, TLayoutsName} from "./types";

type TRoutes = {
  meta?: {
    layout: TLayoutsName
  }
} & RouteRecordRaw

const routes: TRoutes[] = [
  {
    path: '/',
    component: Home,
    meta: {
      layout: LayoutsName.LOGIN
    }
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