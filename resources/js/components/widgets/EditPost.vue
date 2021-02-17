<template>
  <!-- Modal -->
  <div
    class="modal fade"
    :id="'editPost' + post_id"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <div class="mr-2">
            <img
              class="rounded-circle"
              width="45"
              :src="'images' + updatePost.user.profile.profile_image"
              alt=""
            />
          </div>
          <div class="ml-2">
            <div class="h5 m-0">{{updatePost.user.name }}</div>
            <div style="color: #3490dc" class="h7">{{updatePost.user.email}}</div>
          </div>
          <button
            type="button"
            class="close"
            data-dismiss="modal"
            aria-label="Close"
          >
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
       
        <div class="modal-body">
            
              <div class="form-group">
                <label for="exampleInputEmail1">Description</label>
                <textarea v-model="updatePost.description"  style="height:150px;"  type="text" class="form-control"/>
                 <div v-if="errors">
                <div v-for="description in errors.description" v-bind:key ="description" class="alert alert-danger mt-2" role="alert">
                  {{description}}  
                </div>
                </div>
              </div>
             
              <label>Do you want to upload a new image?</label>
              <input @change="selectFile" type="file" accept="image/*" class="form-control-file mt-4">

        
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">
            Close
          </button>
          <button @click="editPost()" type="sumbit" :data-dismiss = modal class="btn btn-primary">Edit</button>
        </div>
      
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    post_id: Number,
  },

  data(){
    
    return {
      
      updatePost:Object,
      modal: "",
      errors: null,
      image: ""
    
    }
  },

  created(){
    
    this.$store.dispatch('posts/retrievePostToUpdate',{
        id: this.post_id
    }).then((response =>{
      this.updatePost = response.data.data
    }))
  
  },
  
  computed: {
      
      loggedIn() {
        return this.$store.getters.loggedIn;
      },

      loggedInUser() {
        if (this.loggedIn) {
          return this.$store.getters.loggedInUser;
        }
      },

   
  },

  methods: {
    
    editPost: function(){
     
      this.$store
      .dispatch("posts/editPost", {
          
          id: this.post_id,
          description: this.updatePost.description,
          image: this.image,
          user_id: this.loggedInUser.id
      
      })
      .then((response) => {
         this.modal = "modal";
         
      })
      .catch((error) => {
          
        if(error.response.status == 422){
            this.errors = error.response.data;
        }
        
      });

    },
    
    
    selectFile: function(event){
      
      this.image = event.target.files[0];
       
    }

  }
}
</script>


<style scoped>
    
    .edit-post-image {
       width: 100%;
       height: 300px;
    }

</style>