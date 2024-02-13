import Home from "../pages/Home.vue";
import SignIn from "../pages/SignIn.vue";
import SignUp from "../pages/SignUp.vue";
import Room from "../pages/Room.vue";
import NotFound from "../pages/NotFound.vue";
import ResetPassword from "../pages/ResetPassword.vue";
import ForgotPassword from "../pages/ForgotPassword.vue";
import User from '../pages/User.vue';
import Exception from '../pages/Exception.vue';
import Overview from "../pages/Admin/Overview.vue";
import UserProfile from "../pages/Admin/UserProfile.vue";
import TableList from "../pages/Admin/TableList.vue";
import Typography from "../pages/Admin/Typography.vue";
import Icons from "../pages/Admin/Icons.vue";
import Notifications from "../pages/Admin/Notifications.vue";
import Upgrade from "../pages/Admin/Upgrade.vue";
import DashboardLayout from "../layouts/Admin/DashboardLayout.vue";
import {NavigationGuardNext, RouteLocationNormalized, RouteRecordRaw} from "vue-router";
import {LayoutsName, TLayoutsName} from "./types";
import {store} from '../store';
import {Role} from "../types";

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
    path: '/admin',
    component: DashboardLayout,
    redirect: '/admin/overview',
    //beforeEnter: [checkAdminRole],
    meta: {
      layout: LayoutsName.BLANK
    },
    children: [
      {
        path: 'overview',
        name: 'Overview',
        component: Overview
      },
      {
        path: 'user',
        name: 'User',
        component: UserProfile
      },
      {
        path: 'table-list',
        name: 'Table List',
        component: TableList
      },
      {
        path: 'typography',
        name: 'Typography',
        component: Typography
      },
      {
        path: 'icons',
        name: 'Icons',
        component: Icons
      },
      {
        path: 'notifications',
        name: 'Notifications',
        component: Notifications
      },
      {
        path: 'upgrade',
        name: 'Upgrade to PRO',
        component: Upgrade
      }
    ]
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

function checkAdminRole(
  next: NavigationGuardNext
) {
  if (store.getters.getAuthUser
    && (store.getters.getAuthUser.roles as string[]).find((role: Role) => {
      return role === 'admin' || role === 'super-admin';
    })) {
    next();
  } else {
    next({path: '/sign-in'});
  }
}

export default routes;