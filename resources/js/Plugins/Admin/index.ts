import SidebarPlugin from "./SidebarPlugin";
import NotificationPlugin from "./NotificationPlugin";


const Plugins =  {
  install (app) {
    app.use(SidebarPlugin);
    app.use(NotificationPlugin)
  }
}

export default Plugins;