<template>
<div>
       <form @submit.prevent="register()">
        <div style="height:50px;"></div>
        <h1>Sign Up</h1>
        
        <fieldset>
          <legend><span class="number">1</span>Your basic info</legend>
          <label for="name">Name:</label>
          <input type="text" id="name" name="user_name" v-model="user.username">
          
          <label for="mail">Email:</label>
          <input type="email" id="mail" name="user_email" v-model="user.email">
          
          <label for="password">Password:</label>
          <input type="password" id="password" name="user_password" v-model="user.password">

          <label for="password">Profile description</label>
          <textarea type="text" v-model="user.profile.description"></textarea>
            
          <label>Select Gender</label>
          <select v-model="user.sex_id" id="inputState" class="form-control">
           <option v-for="sex in sexes" v-bind:key="sex.id" v-bind:value="sex.id">{{sex.description}}</option>
          </select>


          <label for="password">Upload profile picture</label>
          <input @change="selectFile" type="file" accept="image/*">
          
        
       
        </fieldset>
        
       
        <button type="submit">Sign Up</button>
      </form>

</div>
</template>
<script>
export default {
    data(){
      return {
        user: {
          username: "",
          email: "",
          password: "",
          sex_id: Number,
          profile: {
            description: "",
            profile_pic: ""
          },

          
        }
      }
    },

    computed: {
        
        sexes(){
            return this.$store.getters['sexes/sexes']
        },

    },

    created(){
        
        this.$store.dispatch('sexes/retrieveSexes');
     
    },

    methods: {
      
      register:function(){
        this.$store.dispatch('register',{

           username: this.user.username,
           email: this.user.email,
           password: this.user.password,
           profile_description: this.user.profile.description,
           image: this.user.profile.profile_pic,
           sex_id: this.user.sex_id
        })
        .then(response => {
           this.$router.push('/login');
        })
        .catch(error =>{
           console.log(error.response.data);
        })
      },

      selectFile: function(event){

          this.user.profile.profile_pic = event.target.files[0];
      
      }

    
    }
}
</script>
<style scoped>
*, *:before, *:after {
  -moz-box-sizing: border-box;
  -webkit-box-sizing: border-box;
  box-sizing: border-box;
}

body {
  font-family: 'Nunito', sans-serif;
  color: #384047;
}

form {
  max-width: 300px;
  margin: 10px auto;
  padding: 10px 20px;
  background: #f4f7f8;
  border-radius: 8px;
}

h1 {
  margin: 0 0 30px 0;
  text-align: center;
}

input[type="text"],
input[type="password"],
input[type="date"],
input[type="datetime"],
input[type="email"],
input[type="number"],
input[type="search"],
input[type="tel"],
input[type="time"],
input[type="url"],
textarea,
select {
  background: rgba(255,255,255,0.1);
  border: none;
  font-size: 16px;
  height: auto;
  margin: 0;
  outline: 0;
  padding: 15px;
  width: 100%;
  background-color: #e8eeef;
  color: #8a97a0;
  box-shadow: 0 1px 0 rgba(0,0,0,0.03) inset;
  margin-bottom: 30px;
}

input[type="radio"],
input[type="checkbox"] {
  margin: 0 4px 8px 0;
}

select {
  padding: 6px;
  height: 32px;
  border-radius: 2px;
}

button {
  padding: 19px 39px 18px 39px;
  color: #FFF;
  background-color: #4bc970;
  font-size: 18px;
  text-align: center;
  font-style: normal;
  border-radius: 5px;
  width: 100%;
  border: 1px solid #3ac162;
  border-width: 1px 1px 3px;
  box-shadow: 0 -1px 0 rgba(255,255,255,0.1) inset;
  margin-bottom: 10px;
}

fieldset {
  margin-bottom: 30px;
  border: none;
}

legend {
  font-size: 1.4em;
  margin-bottom: 10px;
}

label {
  display: block;
  margin-bottom: 8px;
}

label.light {
  font-weight: 300;
  display: inline;
}

.number {
  background-color: #5fcf80;
  color: #fff;
  height: 30px;
  width: 30px;
  display: inline-block;
  font-size: 0.8em;
  margin-right: 4px;
  line-height: 30px;
  text-align: center;
  text-shadow: 0 1px 0 rgba(255,255,255,0.2);
  border-radius: 100%;
}

@media screen and (min-width: 480px) {

  form {
    max-width: 480px;
  }

}
</style>