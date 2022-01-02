import Vue from "vue";
import VueRouter from "vue-router";
import Products from "./components/products.vue";
import Editor from "./components/editor.vue";

Vue.use(VueRouter);
const routes = [
  { path: "/", component: Products },
  { path: "/add-product", component: Editor },
];

const router = new VueRouter({
  mode: "history",
  routes,
});
export default router;
