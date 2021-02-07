<template>
    
    <div class="modal fade" :id="'commentLikesModal' + comment.id" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Liked By</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body">
            <div class="mt-2" v-for="like in comment.commentlikes" v-bind:key="like.id" >
              <img  class="rounded-circle"
              width="45" :src="'/images/' + like.user.profile.profile_image"> 
              <span  style="color: #3490dc" class="h7">{{like.user.name}}</span><br>
             
            </div>
            
        </div>
    
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss = "modal">Close</button>
      </div>
    </div>
    </div>
    </div>  
</template>

<script>
export default {
    
    props: ['comment']

}
</script>
<style scoped>

</style>