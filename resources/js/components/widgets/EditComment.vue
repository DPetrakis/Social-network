<template>
  <!-- Modal -->
  <div
    class="modal fade"
    :id="'editComment' + comment_id"
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
              :src="'images/' + updateComment.user.profile.profile_image"
              alt=""
            />
          </div>
          <div class="ml-2">
            <div class="h5 m-0">{{updateComment.user.name}}</div>
            <div style="color: #3490dc" class="h7">{{updateComment.user.email}}</div>
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
                <label for="exampleInputEmail1">Decription</label>
                <textarea v-model="updateComment.description" style="height:150px;"  type="text" class="form-control"/>
                <div v-if="errors">
                <div v-for="description in errors.description" v-bind:key ="description" class="alert alert-danger mt-2" role="alert">
                  {{description}}  
                </div>
                </div>
              </div>
             
              <label>Do you want to upload a new image?</label>
              <input @change="selectFile"  type="file" accept="image/*" ref="file" class="form-control-file mt-4">
              <div v-if="errors">
                <div v-for="image in errors.image" v-bind:key ="image" class="alert alert-danger mt-2" role="alert">
                  {{image}}  
                </div>
              </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">
            Close
          </button>
          <button @click="editComment()" type="sumbit" :data-dismiss = modal class="btn btn-primary">Edit</button>
        </div>
      
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    comment_id: Number
  },
  
  data() {
    
    return {
      updateComment:Object,
      errors: null,
      modal: "",
      image: ""
    }
  
  },

  created(){
    this.$store.dispatch('posts/retrieveCommentToUpdate',{
        id: this.comment_id,
      
    }).then((response =>{
      this.updateComment = response.data.data
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

    editComment: function(){
     
      this.$store
      .dispatch("posts/editPostComment", {
          
          id: this.comment_id,
          description: this.updateComment.description,
          image: this.image,
          user_id: this.loggedInUser.id,
          post_id: this.updateComment.post_id

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

</style>