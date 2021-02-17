<template>
    
    <div class="media">
         
        <div class="media-left">
            <img :src="'/images/' + comment.user.profile.profile_image"  class="media-object comment-user-image" style="width:40px">
        </div>
        <div class = "media-body comment-body">
            <h4 class="media-heading title">{{comment.user.name}}</h4>
            <div class="komen">
               
                <span class="comment-description">{{comment.description}}</span>
                <br>
                <small>{{comment.created_at}}</small><span><a data-toggle="modal" :data-target="'#commentLikesModal' + comment.id" href="#!" class="text-muted"><small>/Likes({{ comment.commentlikes.length }})</small></a>
                </span><br>
                <img v-if="comment.image" :src="'/images/' + comment.image" class="comment-image mt-2 mb-2"><br>
                <a v-if="message == 'Like'"  href="#!" @click="likeComment(comment.id)" class="card-link"><i class="fa fa-gittip"></i>Like</a>
                 <a v-else-if="message == 'Dislike'"  href="#!" @click="dislikeComment(comment.id)" class="card-link"><i class="fa fa-gittip"></i>Dislike</a>
                <a  href="#!" @click="showReplySection()"  class="card-link"><i class="fa fa-comment"></i>Reply</a>
                <a v-if="loggedInUser.id == comment.user.id" href="#!" @click="deleteComment(comment.id)"  class="card-link"><i class="fa fa-trash"></i>Delete</a>
                <a v-if="loggedInUser.id == comment.user.id" href="#!"   data-toggle="modal" :data-target="'#editComment' + comment.id" class="card-link"><i class="fa fa-edit"></i>Edit</a> 
                <EditComment :comment_id="comment.id"/>
            </div>
          
      
            
            <form enctype="multipart/form-data" @submit.prevent="createCommentReply(comment.id)" class="mb-4">
              <input v-model="comment_reply" :style="reply_section"  type="text"  class="form-control mt-2"  placeholder="Make a reply">
              <input @change="selectFile" type="file" ref="file" :style="reply_section" class="form-control-file mt-4">
              <button  :style="reply_section"  type="submit"  class="btn btn-primary btn-sm mt-2">Submit</button>
            </form>
            <div v-if="errors">
                <div v-for="error in errors" v-bind:key="error.id" class="alert alert-danger" role="alert">
                    {{error[0]}}
                </div> 
            </div>      
            <div  v-for="reply in repliesToShow" v-bind:key="reply.id">
            
                <Reply :reply = reply />
            
            </div>
           <!-- <a v-if="comment.replies.length" class="load-more-replies" href="#!" @click="increaseLimit()">Load more replies..</a> -->
        </div> 
        <CommentLikes :comment ="comment" />
      
    </div>
           
    
   
</template>
<script>

import Reply from './Reply.vue'
import EditComment from './widgets/EditComment.vue';
import CommentLikes from './widgets/CommentLikes.vue';


export default {
    
    components: {
        Reply,
        EditComment,
        CommentLikes
    },

    props: {
        comment: Object
    },

    computed: {
        
        loggedIn(){
            return this.$store.getters.loggedIn
        },

        loggedInUser(){
            
            if(this.loggedIn){
               return this.$store.getters.loggedInUser
            }
        
        },

        repliesToShow(){
            
            return this.comment.replies.slice(0,this.limitNumber);
        
        }
    },

    data(){
        
        return {

          message: "Like",
          
          limitNumber: 2,

          reply_section: {
             display: "none"
          },
            
          comment_reply: "",

          reply_image: null,

          errors: null
       
        }
    },
    
    methods: {
        
        deleteComment: function(id){
            
            this.$store.dispatch('posts/deletePostComment',{
                comment_id : id,
                user_id : this.loggedInUser.id
            }).then(response => {
                console.log(response);
            }).catch(error => {
                console.log(error);
            })
          
        },


        showReplySection :function(){
            
            this.reply_section = ""
        
        },

        createCommentReply: function(id){
            
            this.$store.dispatch('posts/makePostReply',{
                
                user_id : this.loggedInUser.id,
                comment_id : id,
                description : this.comment_reply,
                image: this.reply_image

            }).then(response => {
                this.comment_reply = "";
                this.reply_section = "display:none";
                this.reply_image = null;
                this.errors = "";
            }).catch(error => {
                if(error.response.status == 422){

                    this.errors = error.response.data;
                }
            }) 
        },

        likeComment: function(id){
            
            this.$store.dispatch('posts/likeComment',{
               
               user_id : this.loggedInUser.id,
               post_id: this.comment.post_id,
               comment_id: id
            
            }).then(response => {
                console.log(response);
                this.message = 'Dislike';
            }).catch(error => {
                console.log(error);
            })
        }, 

        dislikeComment: function(id){
            
            this.$store.dispatch('posts/dislikeComment',{
               
               user_id : this.loggedInUser.id,
               comment_id: id
            
            }).then(response => {
                console.log(response);
                this.message = 'Like';
            }).catch(error => {
                console.log(error);
            })

        },

        selectFile: function(event){
            
            this.reply_image = event.target.files[0];
        
        },

        increaseLimit: function(){

            this.limitNumber = this.limitNumber + 5;
        },

        

        
    
    }
}
</script>
<style scoped>

    .comment-description {
        word-break: break-all;
    }
    
    .post-image {
        width: 550px;
        height: 300px;
    }

    .comment-body {
        padding-left: 10px !important;
    }

    .comment-user-image {
       border-radius: 50%;
    }

    @media (min-width: 320px) and (max-width: 480px) {
        .post-image {
            width: 300px;
            height: 200px;
        }
    }

    .h7 {
        font-size: 0.8rem;
    }

    .gedf-wrapper {
        margin-top: 0.97rem;
    }

    @media (min-width: 992px) {
        .gedf-main {
            padding-left: 4rem;
            padding-right: 4rem;
        }
        .gedf-card {
            margin-bottom: 2.77rem;
        }
    }

    /**Reset Bootstrap*/
    .dropdown-toggle::after {
        content: none;
        display: none;
    }

    #custom-search-input {
        margin:0;
        margin-top: 10px;
        padding: 0;
    }
 
    #custom-search-input .search-query {
        padding-right: 3px;
        padding-right: 4px \9;
        padding-left: 3px;
        padding-left: 4px \9;
        /* IE7-8 doesn't have border-radius, so don't indent the padding */
 
        margin-bottom: 0;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        border-radius: 3px;
    }
 
    #custom-search-input button {
        border: 0;
        background: none;
        /** belows styles are working good */
        padding: 2px 5px;
        margin-top: 2px;
        position: relative;
        left: -28px;
        /* IE7-8 doesn't have border-radius, so don't indent the padding */
        margin-bottom: 0;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        border-radius: 3px;
        color:#D9230F;
    }
 
    .search-query:focus + button {
        z-index: 3;   
    }   

    .post-image {
        width: 550px;
        height: 300px;
    }

    .title {
        font-size: 14px;
        font-weight:bold;
    }
        
    .komen {
        font-size:14px;
    }

    .geser {
        margin-left:55px;
        margin-top:5px;
    }

    .comment-body {
        padding-left: 10px !important;
    }

    .comment-user-image {
        border-radius: 50%;
    }

    .comment-image {
        width: 100%;
    }

    @media (min-width: 320px) and (max-width: 480px) {
        .post-image {
            width: 300px;
            height: 200px;
        }
    }

    .load-more-replies {
        padding-left: 20px;
    }


</style>