import routes from "./routes";
import {createRouter, createWebHistory, RouteLocationNormalized, Router} from "vue-router";
import {getLayout} from "../utils/router";
import {TLayoutsName} from "./types";
import {store} from '../store';
import swal from "sweetalert";

const router: Router = createRouter({
  history: createWebHistory(),
  routes
});

router.beforeEach(async (route: RouteLocationNormalized): Promise<void> => {
  const {layout} = route.meta;

  if (localStorage.getItem('token') && !store.getters.getAuthUser) {
    await store.dispatch('getAuthUser').catch(() => {
      swal({
        text: "Unauthorized!",
        icon: "warning",
      })
    });
  }

  route.meta.layout = await getLayout(layout as TLayoutsName);
});

export default router;

