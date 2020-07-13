import Vue from "vue";
import VueRouter from "vue-router";
import Home from "../views/Home.vue";
import Favorite from "../views/Favorite.vue";

Vue.use(VueRouter);

const routes = [
  {
    path: "/",
    name: "Home",
    component: Home
  },
  {
    path: "/favorites",
    name: "Fav",
    component: Favorite,
    beforeEnter: guardMyroute
  }
];

const router = new VueRouter({
  mode: "history",
  base: process.env.BASE_URL,
  routes
});

// router.beforeEach((to, from, next) => {
//   if (to.name === "Fav" && !localStorage.getItem("token"))
//     next({ name: "Home" });
//   else next();
// });

function guardMyroute(to, from, next) {
  var isAuthenticated = false;
  if (localStorage.getItem("token")) isAuthenticated = true;
  else isAuthenticated = false;
  if (isAuthenticated) {
    next(); // allow to enter route
  } else {
    next("/"); // go to '/login';
  }
}

export default router;
