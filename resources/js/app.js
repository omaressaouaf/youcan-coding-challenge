import "./bootstrap";
import "bootstrap/dist/css/bootstrap.min.css";
import feather from "feather-icons";
import { createApp } from "vue";
import App from "@/Components/App.vue";

createApp(App).mount("#app");

feather.replace();
