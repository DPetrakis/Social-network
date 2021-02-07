<template>
  <!-- Modal -->
  <div
    class="modal fade"
    :id="'editPost' + post.id"
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
              :src="'/images/' + post.user.profile.profile_image"
              alt=""
            />
          </div>
          <div class="ml-2">
            <div class="h5 m-0">{{ post.user.name }}</div>
            <div style="color: #3490dc" class="h7">{{ post.user.email }}</div>
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
        <form @submit.prevent="editPost(post.id)" enctype="multipart/form-data">
        <div class="modal-body">
            
              <div class="form-group">
                <label for="exampleInputEmail1">Description</label>
                <textarea v-model="post.description"  style="height:150px;"  type="text" class="form-control"/>
              </div>
              <img class="edit-post-image" :src="'/images/' + post.image">
              <label>Do you want to upload a new image?</label>
              <input @change="selectFile"  type="file" ref="file" class="form-control-file mt-4">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">
            Close
          </button>
          <button type="sumbit" :data-dismiss = modal class="btn btn-primary">Edit</button>
        </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    post: Object,
  },

  data(){
    return {
      
      image: "",
      modal : ""
      
    }
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
    
    editPost: function(id){
     
      this.$store
      .dispatch("posts/editPost", {
          
          id: id,
          description: this.post.description,
          image: this.image,
          user_id: this.loggedInUser.id,
      
      })
      .then((response) => {
          this.description = "";
          this.image = "";
          //Close the modal 
          this.modal = "modal";
      })
      .catch((error) => {
          
        console.log(error);
        
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