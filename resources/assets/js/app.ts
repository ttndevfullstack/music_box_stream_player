import '../css/app.pcss'
import App from "./App.vue";
import Router from "@/router";
import { createApp } from "vue";
import { FontAwesomeIcon, FontAwesomeLayers } from '@fortawesome/vue-fontawesome'
import { RouterKey } from "@/symbols";
import { routes } from "@/config";

createApp(App)
  .provide(RouterKey, new Router(routes))
  .component('Icon', FontAwesomeIcon)
  .component('IconLayers', FontAwesomeLayers)
  .mount("#app");
