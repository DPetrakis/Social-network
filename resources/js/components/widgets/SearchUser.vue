<template>
  <div>
    <form class="form-inline">
      <div class="md-form my-0">
          <input v-model="letter" @keypress="searchUser()" class="form-control mr-sm-2" type="text" placeholder="Search for a user" aria-label="Search">
      </div>
    
    </form>
      <div v-if="users">
          <ul class="list-group">
          
            <li v-for="user in users" v-bind:key="user.id" class="list-group-item">{{user.name}}</li>
         
          </ul>
      </div>
  </div>
 
     
   
  
</template>
<script>
export default {
    
    data(){
      return {
          
          letter: "",
          users: []
      }
    
    },

    computed: {

    },

    methods: {
      searchUser: function(){
        
        this.$store.dispatch('users/searchUser',{
            
            letter: this.letter
        
        })
        .then((response) => {
           
            this.users = response.data.data;
            console.log(this.users);
        })
        .catch((error) => {
          
          console.log(error);
        
        });
      
      }
    }
   


}
</script>
<style scoped>

</style>