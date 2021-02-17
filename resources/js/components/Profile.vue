<template>
    <div>
        <div class="container emp-profile">
            <form method="post">
                <div class="row">
                    <div class="col-md-4">
                        <div class="profile-img">
                            <img :src="'/images/' + user.profile.profile_image"  alt=""/>
                            <div v-if="loggedInUser.id == user.id" class="file btn btn-lg btn-primary">
                                Change Photo
                                <input @change="selectFile" accept="image/*" type="file" name="file"/>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="profile-head">
                                    <h5>
                                        {{user.name}}
                                    </h5>
                                    <h6>
                                       {{user.profile.description}}
                                    </h6>
                                    <h6>{{user.sex.description}}<span><i style="padding-left:4px" class="fa fa-male fa-lg"></i></span></h6>
                                    <p class="proile-rating"><span></span></p>
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Posts</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Pics</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div v-if="loggedInUser.id == user.id" class="col-md-2">
                   
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" data-toggle="modal"  :data-target="'#user'+ user.id">
                            Edit Profile
                        </button>
                        <EditUser :user_id="user.id" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                       
                    </div>
                    <div class="col-md-8">
                    <div class="tab-content profile-tab" id="myTabContent">
                     <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div v-if="user.posts.length">
                            <div v-for="post in user.posts" v-bind:key="post.id" class="card gedf-card">
                                <Post :post = post />
                            </div>
                        </div>
                        <div v-else> 
                            <h4>{{user.name}} hasn't made any posts yet!</h4>
                        </div>
                     </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                        
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>Your Bio</label><br/>
                                        <p>Your detail description</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>           
        </div>

    </div>
</template>
<script>


import Post from './Post.vue'
import EditUser from './widgets/EditUser.vue'

export default {

    components: {
        Post,
        EditUser
    },
    computed: {
        
        user(){
            return this.$store.getters['users/user'];
        },

        loggedIn() {
            return this.$store.getters.loggedIn;
        },

        loggedInUser() {
            if (this.loggedIn) {
               return this.$store.getters.loggedInUser;
            }
        },

    },

    data(){
        
        return {
              image: ""
        }
      
    },

    created() {
      
       this.$store.dispatch('users/retrieveUser',this.$route.params.id);
       
    },

    methods: {
        
        selectFile: function(event){
            
            this.image = event.target.files[0];
            this.$store.dispatch('users/updatePic',{
                
                image: this.image,
                id: this.$route.params.id
            
            }).then((response) => {
               this.user.profile.profile_image = response.data;
            })
            .catch((error) => {
                console.log(error);
            });

        }

        
    }

   
   
}
</script>
<style scoped>
    body{
        background: -webkit-linear-gradient(left, #3931af, #00c6ff);
    }   
    .emp-profile{
        padding: 3%;
        margin-top: 3%;
        margin-bottom: 3%;
        border-radius: 0.5rem;
        background: #fff;
    }
    .profile-img{
        text-align: center;
    }
    .profile-img img{
      width: 70%;
      height: 100%;
    }
    .profile-img .file {
        position: relative;
        overflow: hidden;
        margin-top: -20%;
        width: 70%;
        border: none;
        border-radius: 0;
        font-size: 15px;
        background: #212529b8;
    }
    .profile-img .file input {
        position: absolute;
        opacity: 0;
        right: 0;
        top: 0;
    }
    .profile-head h5{
        color: #333;
    }
    .profile-head h6{
        color: #0062cc;
    }
    .profile-edit-btn{
        border: none;
        border-radius: 1.5rem;
        width: 70%;
        padding: 2%;
        font-weight: 600;
        color: #6c757d;
        cursor: pointer;
    }
    .proile-rating{
        font-size: 12px;
        color: #818182;
        margin-top: 5%;
    }
    .proile-rating span{
        color: #495057;
        font-size: 15px;
        font-weight: 600;
    }
    .profile-head .nav-tabs{
        margin-bottom:5%;
    }
    .profile-head .nav-tabs .nav-link{
        font-weight:600;
        border: none;
    }
    .profile-head .nav-tabs .nav-link.active{
        border: none;
        border-bottom:2px solid #0062cc;
    }
    .profile-work{
        padding: 14%;
        margin-top: -15%;
    }
    .profile-work p{
        font-size: 12px;
        color: #818182;
        font-weight: 600;
        margin-top: 10%;
    }
    .profile-work a{
        text-decoration: none;
        color: #495057;
        font-weight: 600;
        font-size: 14px;
    }
    .profile-work ul{
        list-style: none;
    }
    .profile-tab label{
        font-weight: 600;
    }
    .profile-tab p{
      font-weight: 600;
      color: #0062cc;
    }

    img {
        border-radius: 10%;
    }

</style>