import { post } from "jquery";
import * as immutable from 'object-path-immutable'
export const posts = {
    
    namespaced: true,
    
    state: {
       
        posts: [],
      
    },



    getters: {
        
        posts(state){
            
          return state.posts;
        
        },

    
       
    },

    mutations: {

        retrievePosts(state,posts){
            state.posts = posts;
        },

        createPostComments(state,comment){
            
            const postIndex = state.posts.findIndex(post => post.id == comment.post_id)
            state.posts[postIndex].comments.unshift(comment);
        
        },
        
        createPostReplies(state,reply){
            
            for(var i=0; i <state.posts.length; i++)
                {
                    for(var j=0; j < state.posts[i].comments.length; j++)
                    {
                   
                        if(state.posts[i].comments[j].id == reply.comment_id){
                        state.posts[i].comments[j].replies.push(reply);
                        break;
                    }
                }
            }  
        
        },

        createPost(state,post){
            
            state.posts.unshift(post);
           
        },

        deletePost(state,deletedpost){
           
           state.posts = state.posts.filter(post =>post.id != deletedpost.id)
        },
        
        
        deletePostComment(state,deletedcomment){
            
            const postIndex = state.posts.findIndex(post => post.id == deletedcomment.post_id)
            state.posts[postIndex].comments = state.posts[postIndex].comments.filter(comment => comment.id != deletedcomment.id)
                   
        },

        deletePostReply(state,deletedreply){
            
            for(var i=0; i < state.posts.length; i++)
            {
                for(var j=0; j < state.posts[i].comments.length; j++)
                {
                    if(state.posts[i].comments[j].id == deletedreply.comment_id){
                        state.posts[i].comments[j].replies = state.posts[i].comments[j].replies.filter(reply => reply.id != deletedreply.id)  
                        break;
                    }
                }
            }

        },


        editPost(state,updatedpost){
           
          state.posts = state.posts.filter(post => post.id != updatedpost.id)
          state.posts.unshift(updatedpost);
          
        },

        editPostComment(state,updatedcomment){
           
            const postIndex = state.posts.findIndex(post => post.id == updatedcomment.post_id)
            state.posts[postIndex].comments = state.posts[postIndex].comments.filter(comment => comment.id != updatedcomment.id)
            state.posts[postIndex].comments.unshift(updatedcomment);
           
        },

        likePost(state,like){
            
            const postIndex = state.posts.findIndex(post => post.id == like.post_id)
            state.posts[postIndex].likes.push(like);
        
        },

        dislikePost(state,liked){

            const postIndex = state.posts.findIndex(post => post.id == liked.post_id)
            state.posts[postIndex].likes = state.posts[postIndex].likes.filter(like => like.id != liked.id)                    
        },

      

    },
    

    
    actions: {
        
        retrievePosts(context){

          axios.defaults.headers.common['Authorization'] = 'Bearer' + context.rootState.token
          return new Promise((resolve,reject) => {
            
            axios.get('/api/posts/')
            .then(response => {
                console.log(response.data.data);
                context.commit('retrievePosts',response.data.data)
                resolve(response)           
            })

            .catch(error => {
                console.log(error);
                reject(error)
            })

          });
      
        },


        retrievePostToUpdate(context,data){
            axios.defaults.headers.common['Authorization'] = 'Bearer' + context.rootState.token
            
            return new Promise((resolve,reject) => {
            
                axios.get('/api/posts/' + data.id)
                .then(response => {
                   resolve(response)           
                }).catch(error => {
                    console.log(error);
                    reject(error)
                })
    
            });
        },

        

        makePostComment(context,data){
            
            axios.defaults.headers.common['Authorization'] = 'Bearer' + context.rootState.token
            
            
            return new Promise((resolve,reject) => {
          
            
            let comment_data = new FormData();
            comment_data.append('description',data.description);
            comment_data.append('image',data.image);
            comment_data.append('user_id',data.user_id);
            comment_data.append('post_id',data.post_id);

            axios.post('/api/comments/',comment_data)
            .then(response => {
               context.commit('createPostComments',response.data.data)
               resolve(response);
            })
            .catch(error => {
               reject(error);
            })

            })
        },


        makePostReply(context,data){
           
            axios.defaults.headers.common['Authorization'] = 'Bearer' + context.rootState.token
            return new Promise((resolve,reject) => { 
                axios.post('/api/replies/',{
                    
                    user_id: data.user_id,
                    comment_id: data.comment_id,
                    description : data.description,
                    image: data.image
                
                })
                .then(response => {
                    
                    context.commit('createPostReplies',response.data.data);
                    resolve(response)

                })
                .catch(error => {
                   
                    reject(error);
                })
            })
        },

        createPost(context,data){
           
            axios.defaults.headers.common['Authorization'] = 'Bearer' + context.rootState.token
            let post_data = new FormData();
            post_data.append('description',data.description);
            post_data.append('image',data.image);
            post_data.append('user_id',data.user_id);

            return new Promise((resolve,reject) => { 
                axios.post('/api/posts/',post_data)
                .then(response => {
                    
                    context.commit('createPost',response.data.data);
                    resolve(response)
                
                })
                .catch(error => {
                    reject(error);
                })
            })

        },


        deletePost(context,data){
            
            axios.defaults.headers.common['Authorization'] = 'Bearer' + context.rootState.token
            return new Promise((resolve,reject) => { 
                axios.delete('/api/posts/'+ data.post_id,{
                    data: {
                        
                        user_id: data.user_id,
                       
                    }
                })
                .then(response => {
                    console.log(response);
                    context.commit('deletePost',response.data.data);
                    resolve(response)
                })
                .catch(error => {
                    console.log(error);
                    reject(error);
                })
            })
        },


        deletePostComment(context,comment){
           
            axios.defaults.headers.common['Authorization'] = 'Bearer' + context.rootState.token
            return new Promise((resolve,reject) => { 
                axios.delete('/api/comments/' + comment.comment_id,{
                    data: {
                        user_id: comment.user_id
                    }
                })
                .then(response => {
                      console.log(response);
                      context.commit('deletePostComment',response.data.data);
                      resolve(response)
                })
                .catch(error => {
                    console.log(error);
                    reject(error);
                })
            })
           
        },


        deletePostReply(context,reply){
            axios.defaults.headers.common['Authorization'] = 'Bearer' + context.rootState.token
            return new Promise((resolve,reject) => { 
                axios.delete('/api/replies/' + reply.reply_id,{
                    data: {
                        user_id: reply.user_id
                    }
                })
                .then(response => {
                      console.log(response);
                      context.commit('deletePostReply',response.data.data);
                      resolve(response)
                })
                .catch(error => {
                    console.log(error);
                    reject(error);
                })
            })
        },


        likePost(context,data){
            
            axios.defaults.headers.common['Authorization'] = 'Bearer' + context.rootState.token
            return new Promise((resolve,reject) => { 
                
                axios.post('/api/likes/',{
                    user_id : data.user_id,
                    post_id: data.post_id
                })
                .then(response => {
                  if(response.data.data != null){
                    context.commit('likePost',response.data.data,[1]);
                  }
                  resolve(response)
                })
                .catch(error => {
                    console.log(error);
                    reject(error);
                })
            
            })
        
        },

        dislikePost(context,data){

            axios.defaults.headers.common['Authorization'] = 'Bearer' + context.rootState.token
            return new Promise((resolve,reject) => { 
                
                axios.delete('/api/likes',{
                    data: {
                        user_id: data.user_id,
                        post_id: data.post_id
                    }
                })
                .then(response => {
                    
                    console.log(response);
                    context.commit('dislikePost',response.data.data);
                    resolve(response)
                
                })
                .catch(error => {
                    console.log(error);
                    reject(error);
                })
            
            })

        },


        editPost(context,data){
           
            axios.defaults.headers.common['Authorization'] = 'Bearer' + context.rootState.token
            
            return new Promise((resolve,reject) => { 
                
                let post_data = new FormData();
                
                post_data.append('description',data.description);
                post_data.append('image',data.image);
                post_data.append('user_id',data.user_id);

                axios.post('/api/posts/' + data.id,post_data)
                .then(response => {
                    context.commit('editPost',response.data.data);
                    resolve(response)
                })
                .catch(error => {
                    console.log(error);
                    reject(error);
                })
            
            })
        },


        editPostComment(context,data){

            axios.defaults.headers.common['Authorization'] = 'Bearer' + context.rootState.token
            
            return new Promise((resolve,reject) => { 
                
                let comment_data = new FormData();
                
                comment_data.append('description',data.description);
                comment_data.append('image',data.image);
                comment_data.append('user_id',data.user_id);
                comment_data.append('post_id',data.post_id);

                axios.post('/api/comments/' + data.id,comment_data)
                .then(response => {
                    context.commit('editPostComment',response.data.data);
                    resolve(response)
                })
                .catch(error => {
                    console.log(error);
                    reject(error);
                })
            
            })
        
        },


        getPostLikes(context,data){
            
            axios.defaults.headers.common['Authorization'] = 'Bearer' + context.rootState.token
            
            return new Promise((resolve,reject) => { 
                
                axios.get('/api/posts/' + data.post_id + '/likes')
                .then(response => {
                    
                    console.log(response);
                    resolve(response)
                })
                .catch(error => {
                    console.log(error);
                    reject(error);
                })
            
            })
        },

        likeComment(context,data){
            
            axios.defaults.headers.common['Authorization'] = 'Bearer' + context.rootState.token
           
            return new Promise((resolve,reject) => { 
               
                axios.post('/api/commentlikes',{
                    user_id : data.user_id,
                    comment_id: data.comment_id,
                })
                .then(response => {
                    var likedcomment = response.data.data
                    var number = data.post_id
                    context.commit('likeComment',{
                        likedcomment,
                        number
                    })
                    resolve(response)
                })
                .catch(error => {
                    console.log(error);
                    reject(error);
                })
            
            })
            
        },


        dislikeComment(context,data){
            
            axios.defaults.headers.common['Authorization'] = 'Bearer' + context.rootState.token
            
            return new Promise((resolve,reject) => { 
                
                axios.delete('/api/commentlikes',{
                  data:{
                    user_id : data.user_id,
                    comment_id: data.comment_id,
                  }  
                })
                .then(response => {
                    console.log(response);
                    context.commit('dislikeComment',response.data.data)
                    resolve(response)
                })
                .catch(error => {
                    console.log(error);
                    reject(error);
                })
            
            })
        },

        retrieveCommentToUpdate(context,data){
            
            axios.defaults.headers.common['Authorization'] = 'Bearer' + context.rootState.token
            return new Promise((resolve,reject) => { 
            
                axios.get('/api/comments/' + data.id)
                .then(response => {
                    resolve(response)
                })
                .catch(error => {
                    reject(error);
                })
            })
        },

        retrieveReplyToUpdate(context,data){
            axios.defaults.headers.common['Authorization'] = 'Bearer' + context.rootState.token
            return new Promise((resolve,reject) => { 
            
                axios.get('/api/replies/' + data.id)
                .then(response => {
                    resolve(response)
                })
                .catch(error => {
                    reject(error);
                })
            })
        
        }
        

       
        
       
  
    }
}