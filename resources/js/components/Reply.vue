<template>
    <div class="media reply">
        <div class="media-left reply">
                <img :src="'/images/' + reply.user.profile.profile_image"  class="media-object comment-user-image" style="width:40px">
                </div>
                <div class = "media-body comment-body">
                <h4 class="media-heading title">{{reply.user.name}}</h4>
                <p class="komen">
                {{reply.description}}
                <br>
                <small>{{reply.created_at}}</small>
                <a  href="#!"  class="card-link"><i class="fa fa-gittip"></i> Like</a>
            <!--<a  href="#!"  @click="showReplySection()" class="card-link"><i class="fa fa-comment"></i>Reply</a>-->
                <a v-if="loggedInUser.id == reply.user.id" href="#!" @click="deleteReply(reply.id)"  class="card-link"><i class="fa fa-trash"></i>Delete</a>
                <a v-if="loggedInUser.id == reply.user.id" href="#!" @click="EditReply(reply.id)"  class="card-link"><i class="fa fa-edit"></i>Edit</a> 
                </p>
        </div> 
    </div>   
</template>
<script>

export default {
    props: {
        reply: Object
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
    },

    data() {
        return {
            comment_reply: "",
            
            reply_section: {
                display: "none"
            },
            
           
        }
    },
    methods: {
        
        deleteReply: function(id){
            this.$store.dispatch('posts/deletePostReply',{
                
                user_id : this.loggedInUser.id,
                reply_id : id,
                
            }).then(response => {
                console.log(response);
            }).catch(error => {
                console.log(error);
            })
        }
    }
}


</script>
<style scoped>
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
</style>