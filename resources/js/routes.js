import VueRouter from "vue-router";
import Register from './components/auth/Register.vue';
import Login from './components/auth/Login.vue';
import Logout from './components/auth/Logout.vue';
import Home from './components/Home.vue';
import Profile from './components/Profile.vue';


const routes = [
    
    {
        path: "/",
        component: Home,
        name: "home",
        meta: {
            requiresAuth: true
        }
        
    },
    {
        path: "/register",
        component: Register,
        name: "register"    
    },
    {
        path: "/login",
        component: Login,
        name: "login"
    },
    {
        path: "/logout",
        component: Logout,
        name: "logout",
        meta: {
            requiresAuth: true
        }
    },
    
    {
        path: "/users/:id",
        component: Profile,
        name: "profile"
    },

   
  
];

const router = new VueRouter({
    routes,
    mode: "history"
});

export default router;