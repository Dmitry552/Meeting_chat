import routes from "./routes";
import {createRouter, createWebHistory, RouteLocationNormalized, Router} from "vue-router";
import {getLayout} from "../utils/router";
import {TLayoutsName} from "./types";

const router: Router = createRouter({
  history: createWebHistory(),
  routes
});

router.beforeEach(async (route: RouteLocationNormalized): Promise<void> => {
  const {layout} = route.meta;

  route.meta.layout = await getLayout(layout as TLayoutsName);
});

export default router;

