<template>
    <div>
    <div style="height:50px;"></div>   

         <div class="container-fluid gedf-wrapper">
        <div class="row">
            <div class="col-md-3">
                
              <Search />
            
            </div>
            <div class="col-md-6 gedf-main">
                <CreatePost />
                <div v-for="post in posts" v-bind:key="post.id" class="card gedf-card mb-4">
                  <Post :post = post />
                </div>
               
            </div>
       
            <div class="col-md-3">
              
            </div>
           
        </div>
          
    </div>
    
    </div>
</template>
<script>
import Search from './widgets/Search.vue'
import Post from './Post.vue'
import CreatePost from './widgets/CreatePost.vue'

export default {

    components: {
        Search,
        Post,
        CreatePost
    },

    data() {
        
        return {
            
            comment_section: {
                display : "none"
            },

            reply_section: {
                display: "none"
            },
            
            comment_description : "",
            
            comment_reply: ""

        }
    },
    computed: {
        
        posts(){
            return this.$store.getters['posts/posts']
        },

     
    },
    created(){
        this.$store.dispatch('posts/retrievePosts');
    },

    methods: {
        
        showMorePosts: function(){

            alert('i am the best ill never give up');
        
        }

    }

    
}
</script>
<style scoped>
        body {
            background-color: #eeeeee;
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

        .comment-image {
            border-radius: 50%;
        }

        @media (min-width: 320px) and (max-width: 480px) {
            .post-image {
                    width: 300px;
                    height: 200px;
            }

           
        }

       
  
</style>