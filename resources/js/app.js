require('./bootstrap');

import Axios from "axios";
import VueRouter from "vue-router";
import router from "./routes";
import {store} from "./store/store";
window.Vue = require('vue');

Vue.component('mainapp', require('./components/mainapp.vue').default);

Vue.use(VueRouter);

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
      if (!store.getters.loggedIn) {
        next({
          name: 'login',
        })
      } else {
        next()
      }
    } else {
      next()
    }
})


/*Axios.interceptors.response.use(null,(error) => {
    
    if(error.response.status == 401)
    {
        store.dispatch('logout');
    }


}) */

const app = new Vue({
    el: '#app',
    router,
    store
});
