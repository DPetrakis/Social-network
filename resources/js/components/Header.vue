<template>
  <div>
    <!--Navbar blue-->
    <nav class="navbar navbar-expand-lg navbar-dark primary-color">
      <router-link class="navbar-brand" to="/">Epcom</router-link>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          
          <li v-if="!loggedIn" class="nav-item">
           <router-link to="/login"  href="#!" class="nav-link waves-effect waves-light">Login</router-link>
          </li>
          <li v-if="!loggedIn"  class="nav-item">
           <router-link class="nav-link waves-effect waves-light" to="/register">Register</router-link>
          </li>
        
        
          <li v-if="loggedIn" class="nav-item dropdown">
            <a class="nav-link dropdown-toggle waves-effect waves-light" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user fa-lg"></i>
            </a>
            <div class="dropdown-menu dropdown-primary" aria-labelledby="navbarDropdownMenuLink">
              <router-link v-if="loggedInUser" class="dropdown-item waves-effect waves-light" :to="'users/' + loggedInUser.id">{{loggedInUser.name}}</router-link>
              <router-link class="dropdown-item waves-effect waves-light" to="/logout">Logout</router-link>
            </div>
          </li>
          <li v-if="loggedIn" class="nav-item">
            <a class="nav-link " id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-comment fa-lg"></i>
            </a>
           
          </li>
         
   
        </ul>
          
          <SearchUser /> 

        
      </div>
    </nav>
    <!--/.Navbar blue-->
  </div>    
</template>
<script>

import SearchUser from './widgets/SearchUser.vue';

export default {

    components: {
      SearchUser
    },

    computed: {
    
      loggedIn(){
        return this.$store.getters.loggedIn
      },

      loggedInUser(){
        
        if(this.loggedIn){
          return this.$store.getters.loggedInUser
        }
        
      }

    },

    created(){
       console.log(this.loggedInUser);
    }
    
    
}
</script>
<style scoped>
  .navbar {
      background-color: cornflowerblue;
  }
</style>