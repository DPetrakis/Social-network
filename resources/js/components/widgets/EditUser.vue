<template>
    
<!-- Modal -->
<div class="modal fade" :id="'user' + user_id" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit your profile</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    
      <div class="modal-body">
       
          <div class="form-group">
          <h6>Your name</h6>
          <input v-model="updatedUser.name" type="text" class="form-control" placeholder="Enter name">
          <div v-if="errors">
            <div v-for="name in errors.name" v-bind:key ="name" class="alert alert-danger mt-2" role="alert">
              {{name}}  
            </div>
          </div>
          </div>
          <div class="form-group">
          <h6>Profile description</h6>
          <textarea v-model="updatedUser.profile.description"  type="text" class="form-control"></textarea>
          <div v-if="errors">
            <div v-for="profile_description in errors.profile_description" v-bind:key ="profile_description" class="alert alert-danger mt-2" role="alert">
              {{profile_description}}  
            </div>
          </div>
          </div>
          <div v-if="sexes" class="form-group">
            <h6 for="inputState">Gender</h6>
            <select v-model="updatedUser.sex.id"  id="inputState" class="form-control">
            <option selected>Gender</option>
            <option v-for="sex in sexes" v-bind:key="sex.id" v-bind:value="sex.id">{{sex.description}}</option>
            </select> 
          </div>
         
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" @click="editUser()" class="btn btn-primary" :data-dismiss = modal>Update</button>
      </div>
     
    </div>
  </div>
</div>
</template>
<script>
export default {
    
    props: ['user_id'],

    data() {
      return {
        
        image: "",
        modal: "",
        errors: null
        
      }
    },

    created(){
        
        this.$store.dispatch('sexes/retrieveSexes');
        this.$store.dispatch('users/retrieveUserToUpdate',this.user_id);
    
    },

    computed: {
        
        sexes(){
            return this.$store.getters['sexes/sexes']
        },

        updatedUser(){

          return this.$store.getters['users/updatedUser']
        
        }

    },

    methods: {
        
        editUser: function(){
            
            this.$store.dispatch('users/updateUser',{
                  
                id: this.user_id,
                name: this.updatedUser.name,
                profile_description: this.updatedUser.profile.description,
                sex: this.updatedUser.sex.id,
              
              
            }).then(response => {
                this.modal = "modal";
            }).catch(error => {
                  if(error.response.status == 422){
                    this.errors = error.response.data; 
                    console.log(this.errors);
                  }
            });
        
        },

        selectFile: function(event){
          
          this.image = event.target.files[0];
        
        }

      
    },

   

   
  

   
}
</script>
<style scoped>

</style>