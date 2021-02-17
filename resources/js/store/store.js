import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'
import {users} from './modules/users'
import {posts} from './modules/posts'
import {sexes} from './modules/sexes'

Vue.use(Vuex)

export const store = new Vuex.Store({
    
    modules: {
        users,
        posts,
        sexes
    },
   
    state: {
        token: localStorage.getItem('access_token') || null,
        current_user: JSON.parse(localStorage.getItem('user')) || null,
    },
    getters: {
        
        loggedIn(state){
            return state.token != null
        },

        loggedInUser(state){
            return state.current_user;
        },
        
    },  
    mutations: {
        
        retrieveToken(state,token){
            state.token = token;
        },
        
        destroyToken(state){
            state.token = null
        },

        retrieveLoggedInUser(state,user){
            state.current_user = user;
        },

        destroyLoggedInUser(state){
            state.current_user = null;
        }
        
      
    },
    actions: {
        

        retrieveToken(context,user){

          return new Promise((resolve,reject) => {
            axios.post('/api/auth/login',{
                email : user.email,
                password: user.password
            })
            .then(response => {
               
                const token = response.data.access_token
                const user = response.data.user;
                localStorage.setItem('access_token',token);
                localStorage.setItem('user',JSON.stringify(user));
                context.commit('retrieveToken',token);
                context.commit('retrieveLoggedInUser',user);
                resolve(response)
            })
            .catch(error => {
                
                reject(error)
            })
          });

          
        },

        destroyToken(context){
            axios.defaults.headers.common['Authorization'] = 'Bearer' + context.state.token
            
            if(context.getters.loggedIn){
                return new Promise((resolve,reject) => {
                    axios.post('/api/auth/logout')
                    .then(response => {
                        localStorage.removeItem('access_token')
                        localStorage.removeItem('user')
                        context.commit('destroyToken')
                        context.commit('destroyLoggedInUser');
                        resolve(response)
                    })
                    .catch(error => {
                        localStorage.removeItem('access_token')
                        context.commit('destroyToken')
                        context.commit('destroyLoggedInUser');
                        reject(error)
                    })
                });
            }
        },

        register(context,data){
            return new Promise((resolve,reject) => {
                
                let user_data = new FormData();
                
                user_data.append('name',data.username);
                user_data.append('email',data.email);
                user_data.append('password',data.password);
                user_data.append('profile_description',data.profile_description);
                user_data.append('image',data.image);
                user_data.append('sex_id',data.sex_id);

                axios.post('/api/auth/register',user_data)
                .then(response => {
                   resolve(response)
                })
                .catch(error => {
                    console.log(error);
                    reject(error)
                })
            });
        }
    }
})