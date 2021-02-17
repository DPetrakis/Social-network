<template>
  <!-- Modal -->
  <div
    class="modal fade"
    :id="'editReply' + reply_id"
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
              :src="'images/' + updateReply.user.profile.profile_image"
              alt=""
            />
          </div>
          <div class="ml-2">
            <div class="h5 m-0">{{updateReply.user.name}}</div>
            <div style="color: #3490dc" class="h7">{{updateReply.user.email}}</div>
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
                <textarea v-model="updateReply.description" style="height:150px;"  type="text" class="form-control"/>
                 <div>
               
                </div>
              </div>
             
              <label>Do you want to upload a new image?</label>
              <input @change="selectFile()"  type="file" accept="image/*" ref="file" class="form-control-file mt-4">

        
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">
            Close
          </button>
          <button @click="editReply()"  type="sumbit" :data-dismiss = modal class="btn btn-primary">Edit</button>
        </div>
      
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    
    reply_id: Number,
   
  },

  data(){
    
    return {
      
      updateReply:Object,
      modal: "",
      errors: null,
      image: ""
    
    }
  },

  created(){
    
    this.$store.dispatch('posts/retrieveReplyToUpdate',{
        id: this.reply_id
    }).then((response =>{
      this.updateReply = response.data.data
    })).catch((error =>{
        console.log(error);
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
    
    editReply: function(){
     
      this.$store
      .dispatch("posts/editPostComment", {
          
          id: this.reply_id,
          description: this.updateReply.description,
          image: this.image,
          user_id: this.loggedInUser.id,
          comment_id: this.updateReply.comment_id

      })
      .then((response) => {
        
        this.modal = "modal";
         
      })
      .catch((error) => {
          
        if(error.response.status == 422){
            this.errors = error.response.data;
        }
        
      })

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