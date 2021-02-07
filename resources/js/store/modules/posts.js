export const posts = {
    
    namespaced: true,
    state: {
       posts: []
    },
    getters: {
        
        posts(state){
            return state.posts;
        },

        post(state,id){
            return state.posts[id];
        }

      
    },
    mutations: {

        retrievePosts(state,posts){
            state.posts = posts;
        },

        createPostComments(state,comment){
            for(var i=0; i <state.posts.length; i++)
            {
                if(state.posts[i].id== comment.post_id)
                {
                    state.posts[i].comments.unshift(comment);
                    break;
                }
            }
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
            
            for(var i=0; i <state.posts.length; i++)
            {
                if(state.posts[i].id == deletedcomment.post_id) {
                    state.posts[i].comments = state.posts[i].comments.filter(comment => comment.id != deletedcomment.id)
                    break;
                }    
            }
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


        editPost(state,post){
           
            state.posts = state.posts.filter(post => post.id != post.id)
            state.posts.unshift(post);
        
        },


        likePost(state,like){
             
            for(var i=0; i < state.posts.length; i++)
            
            {
                if(state.posts[i].id == like.post_id){
                    state.posts[i].likes.push(like);
                    break;
                }
            } 

           
        
        },

        dislikePost(state,liked){
            
            for(var i=0; i < state.posts.length; i++)
            {
                if(state.posts[i].id == liked.post_id){
                    
                    state.posts[i].likes = state.posts[i].likes.filter(like => like.id != liked.id)                    
                    break;
                }
            }

        },

        likeComment(state,likecomment){
            
            console.log(likecomment);
        },

        dislikeComment(state,dislikedcomment){
            console.log(dislikedcomment);
        }

        


        
        
    },
    actions: {
        
        retrievePosts(context,id){
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
                    context.commit('likePost',response.data.data);
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
                
                axios.post('/api/posts/' + data.id,{
                    
                    description : data.description,
                    image: data.image,
                    user_id : data.user_id
                
                })
                .then(response => {
                      console.log(response);
                      context.commit('editPost',response.data.data);
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
                    console.log(response);
                    context.commit('likeComment',response.data.data)
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
        }
        

       
        
       
  
    }
}