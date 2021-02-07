<template>
  <div>
    <form @submit.prevent="createPost()" enctype="multipart/form-data">
      <!--- \\\\\\\Post-->
      <div class="card gedf-card">
        <div class="card-header">
          <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
            <li class="nav-item">
              <a
                class="nav-link active"
                id="posts-tab"
                data-toggle="tab"
                href="#posts"
                role="tab"
                aria-controls="posts"
                aria-selected="true"
              >Make a publication</a
              >
            </li>
            <li class="nav-item">
              <a
                class="nav-link"
                id="images-tab"
                data-toggle="tab"
                role="tab"
                aria-controls="images"
                aria-selected="false"
                href="#images"
                >Images</a
              >
            </li>
          </ul>
        </div>
        <div class="card-body">
          <div class="tab-content" id="myTabContent">
            <div
              class="tab-pane fade show active"
              id="posts"
              role="tabpanel"
              aria-labelledby="posts-tab"
            >
              <div class="form-group">
                <label class="sr-only" for="message">post</label>
                <textarea
                  v-model="post.description"
                  class="form-control"
                  id="message"
                  rows="3"
                  placeholder="What are you thinking?"
                ></textarea>
                <div v-if="errors" class="mt-4">
                <div v-for="error in errors" v-bind:key="error.id" class="alert alert-danger" role="alert">
                    {{error[0]}}
                </div>
                </div>
              </div>
            </div>
            <div
              class="tab-pane fade"
              id="images"
              role="tabpanel"
              aria-labelledby="images-tab"
            >
              <div class="form-group">
                <div class="custom-file">
                  <input @change="selectFile" type="file" ref="file" class="custom-file-input" id="customFile">
                  <label class="custom-file-label" for="customFile">Upload image</label>
                </div>
              </div>
              <div class="py-4"></div>
            </div>
          </div>
          <div class="btn-toolbar justify-content-between">
            <div class="btn-group">
              <button type="submit" class="btn btn-primary">share</button>
            </div>
            <div class="btn-group">
              <button
                id="btnGroupDrop1"
                type="button"
                class="btn btn-link dropdown-toggle"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
              >
                <i class="fa fa-globe"></i>
              </button>
              <div
                class="dropdown-menu dropdown-menu-right"
                aria-labelledby="btnGroupDrop1"
              >
                <a class="dropdown-item" href="#"
                  ><i class="fa fa-globe"></i> Public</a
                >
                <a class="dropdown-item" href="#"
                  ><i class="fa fa-users"></i> Friends</a
                >
                <a class="dropdown-item" href="#"
                  ><i class="fa fa-user"></i> Just me</a
                >
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
    </div>
   
  
</template>
<script>
export default {
  data() {
    return {
      post: {
        image: "",
        description: "",
      },
      
      errors: null,
    
    };
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
    createPost: function () {
      this.$store
        .dispatch("posts/createPost", {
          description: this.post.description,
          image: this.post.image,
          user_id: this.loggedInUser.id,
        })
        .then((response) => {
          this.post.description = "";
          this.post.image = "";
          this.errors = "";
        })
        .catch((error) => {
          if(error.response.status == 422){
            this.errors = error.response.data;
          }
         
        });
    },

    selectFile: function (event) {
     
        this.post.image = event.target.files[0];
     
    },
  },
};
</script>
<style scoped>
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

#custom-search-input {
  margin: 0;
  margin-top: 10px;
  padding: 0;
}
</style>