import Home from "../pages/Home.vue";
import SignIn from "../pages/SignIn.vue";
import SignUp from "../pages/SignUp.vue";
import Room from "../pages/Room.vue";
import NotFound from "../pages/NotFound.vue";
import ResetPassword from "../pages/ResetPassword.vue";
import ForgotPassword from "../pages/ForgotPassword.vue";
import User from '../pages/User.vue';
import Exception from '../pages/Exception.vue';
import {NavigationGuardNext, RouteLocationNormalized, RouteRecordRaw} from "vue-router";
import {LayoutsName, TLayoutsName} from "./types";
import {store} from '../store';

type TRoutes = {
  meta?: {
    layout: TLayoutsName
  }
} & RouteRecordRaw

const routes: TRoutes[] = [
  {
    path: '/',
    component: Home,
    name: 'home',
    meta: {
      layout: LayoutsName.LOGIN
    }
  },
  {
    path: '/exception',
    component: Exception,
    name: 'exception'
  },
  {
    path: '/sign-in',
    component: SignIn,
    name: 'login'
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
    path: '/user/:id',
    component: User,
    beforeEnter: [checkAuthorizedUser]
  },
  {
    path: '/password/forgot',
    component: ForgotPassword
  },
  {
    path: '/password/reset/:token',
    component: ResetPassword
  },
  {
    path: '/:catchAll(.*)',
    component: NotFound
  }
]

function checkAuthorizedUser(
  to: RouteLocationNormalized,
  from: RouteLocationNormalized,
  next: NavigationGuardNext
): void {
  if (!store.getters.getAuthUser) {
    next({path: '/sign-in'});
  } else {
    next();
  }
}

export default routes;