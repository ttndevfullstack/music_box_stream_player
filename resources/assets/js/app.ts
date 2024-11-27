import { createApp } from "vue";
import { FontAwesomeIcon, FontAwesomeLayers } from '@fortawesome/vue-fontawesome'
import App from "./App.vue";
import '../css/app.pcss'

createApp(App)
  .component('Icon', FontAwesomeIcon)
  .component('IconLayers', FontAwesomeLayers)
  .mount("#app");
