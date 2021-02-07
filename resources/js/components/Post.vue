<template>
  <div>
    <div class="card-header">
      <div class="d-flex justify-content-between align-items-center">
        <div class="d-flex justify-content-between align-items-center">
          <div class="mr-2">
          <img
              class="rounded-circle"
              width="45"
              :src="'/images/' + post.user.profile.profile_image"
              alt=""
            /> 
          </div>
          <div class="ml-2">
            <div class="h5 m-0"><a :href="'/users/' + post.user.id">{{ post.user.name }}</a></div>
            <div style="color: #3490dc" class="h7">{{ post.user.email }}</div>
          </div>
        </div>
        <div>
          <div v-if="loggedInUser.id == post.user.id" class="dropdown">
            <button
              class="btn btn-link dropdown-toggle"
              type="button"
              id="gedf-drop1"
              data-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false"
            >
              <i class="fa fa-ellipsis-h"></i>
            </button>

            <div
              class="dropdown-menu dropdown-menu-right"
              aria-labelledby="gedf-drop1"
            >
              <div class="h6 dropdown-header">Configuration</div>
              <button
                data-toggle="modal"
                :data-target="'#editPost' + post.id"
                class="dropdown-item"
                href="#"
              >
                Edit<i class="fa fa-edit"></i>
              </button>

              <a @click="deletePost(post.id)" class="dropdown-item" href="#"
                >Delete<i class="fa fa-trash"></i
              ></a>
            </div>
            <EditPost :post="post" />
          </div>
        </div>
      </div>
    </div>
    <div class="card-body">
      <div class="h7 text-muted mb-2">
        <i class="fa fa-clock-o"></i>{{post.created_at}}
      </div>
      <a class="card-link" href="#">
        <h5 class="card-title"></h5>
      </a>
      <p class="card-text">
        {{ post.description }}
      </p>
      <img v-if="post.image" class="post-image mb-4" :src="'/images/' + post.image" />
      <a data-toggle="modal" :data-target="'#postLikesModal' + post.id" href="#!" class="text-muted"
        ><i class=""></i>Likes({{ post.likes.length }})</a
      >
      <a href="#!" class="text-muted"
        ><i class=""></i> Comments({{ post.comments.length }})</a
      >
      <hr />
      <div v-for="comment in commentsToShow" v-bind:key="comment.id">
        <Comment :comment="comment" />
      </div>
      <a v-if="post.comments.length" href="#!" @click="IncreaseLimit()">Load more comments..</a>
    </div>
    <div class="card-footer">
    
      <a v-if="message == 'Like'" href="#!" @click="likePost(post.id)" class="card-link"
        ><i class="fa fa-gittip"></i>{{message}}</a
      >

      <a v-else-if="message == 'Dislike'" href="#!" @click="dislikePost(post.id)" class="card-link"
        ><i class="fa fa-gittip"></i>{{message}}</a
      >

     
      <a href="#!" @click="showCommentSection()" class="card-link"
        ><i class="fa fa-comment"></i> Comment</a
      >
      <a href="#!" class="card-link"
        ><i class="fa fa-mail-forward"></i> Share</a
      >
      <div class="form-group mt-4">
        <form
          enctype="multipart/form-data"
          @submit.prevent="createComment(post.id)"
        >
          <input
            v-model="comment_description"
            :style="comment_section"
            type="text"
            class="form-control"
            placeholder="Make a comment"
          />
          <input
            @change="selectFile"
            type="file"
            ref="file"
            :style="comment_section"
            class="form-control-file mt-4"
          />
          <button
            :style="comment_section"
            type="submit"
            class="btn btn-primary btn-sm mt-2"
          >
            Submit
          </button>
          <div v-if="errors" class="mt-4">
            <div v-for="error in errors" v-bind:key="error.id" class="alert alert-danger" role="alert">
                    {{error[0]}}
            </div>
          </div>
        </form>
      </div>
    </div>
  
  
  <PostLikes :post = post  />
  </div>
   
</template>
<script>

import Comment from "./Comment.vue";
import EditPost from "./widgets/EditPost.vue";
import PostLikes from "./widgets/PostLikes.vue";

export default {

  components: {
    
    Comment,
    EditPost,
    PostLikes
  
  },

  props: {
    post: Object,
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

    commentsToShow: function() {
      return this.post.comments.slice(0,this.limitNumber);
    }
  },

  data() {

    return {

      limitNumber: 5,

      comment_section: {
        display: "none",
      },

      message: "Like",

      comment_description: "",

      comment_image: "",

      comment_reply: "",

      errors: null,

    };
  },

  methods: {

   
    
    showCommentSection: function () {
      this.comment_section = "";
    },

    createComment: function (id) {
      this.$store
        .dispatch("posts/makePostComment", {
          user_id: this.loggedInUser.id,
          post_id: id,
          description: this.comment_description,
          image: this.comment_image,
        })
        .then((response) => {
          this.comment_description = "";
          this.comment_image = "";
          this.comment_section = "display:none";
          this.errors = "";
        })
        .catch((error) => {
          if(error.response.status == 422){
            this.errors = error.response.data; 
          }
        });
    },

    deletePost: function (id) {
      this.$store
        .dispatch("posts/deletePost", {
          post_id: id,
          user_id: this.loggedInUser.id,
        })
        .then((response) => {
          console.log(response);
        })
        .catch((error) => {
          console.log(error);
        });
    },

    selectFile: function (event) {
      this.comment_image = event.target.files[0];
    },

    likePost: function (id) {
      this.$store
        .dispatch("posts/likePost", {
          post_id: id,
          user_id: this.loggedInUser.id,
        })
        .then((response) => {
          console.log(response);
          this.message = 'Dislike';
        })
        .catch((error) => {
          console.log(error);
        });
    },

    dislikePost: function(id){
      this.$store
        .dispatch("posts/dislikePost", {
           post_id: id,
           user_id: this.loggedInUser.id
        })
        .then((response) => {
          console.log(response);
          this.message = 'Like';
        })
        .catch((error) => {
          console.log(error);
        });
    },

    IncreaseLimit: function() {
        this.limitNumber = this.limitNumber + 5;
    },
  },
};
</script>
<style scoped>
.post-image {
  width: 550px;
  height: 300px;
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
  margin: 0;
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
  color: #d9230f;
}

.search-query:focus + button {
  z-index: 3;
}

.post-image {
  width: 100%;
  height: 300px;
}

.title {
  font-size: 14px;
  font-weight: bold;
}

.komen {
  font-size: 14px;
}

.geser {
  margin-left: 55px;
  margin-top: 5px;
}

.comment-body {
  padding-left: 10px !important;
}

.comment-image {
  border-radius: 50%;
}

@media (min-width: 320px) and (max-width: 480px) {
  .post-image {
    width: 100%;
    height: 200px;
  }
}
</style>