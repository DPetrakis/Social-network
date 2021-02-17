
export const users = {
    namespaced: true,
    state: {
       user: Object,
       updateUser: Object
    },
    getters: {
        
        user(state){
            return state.user;
        },

        updatedUser(state){
            return state.updateUser;
        }
    },
    mutations: {
        
        retrieveUser(state,user){
            
            state.user = user;
        
        },

        retrieveUserToUpdate(state,updateUser){
            
            state.updateUser = updateUser;
        
        },

        updateUser(state,updatedUser){
            state.user = updatedUser;
        }
    },
    actions: {
        
        retrieveUser(context,id){
            
            axios.defaults.headers.common['Authorization'] = 'Bearer' + context.rootState.token
            
            axios.get('/api/users/' + id)
            .then(response => {
               
                context.commit('retrieveUser',response.data.data)
                      
            })
            .catch(error => {
                console.log(error);
            })
            
      
        },

        retrieveUserToUpdate(context,id){
            
            axios.get('/api/users/' + id)
            .then(response => {
                
                context.commit('retrieveUserToUpdate',response.data.data)
            })
            .catch(error => {
                console.log(error);
            })
            
      
        },


        updateUser(context,data){
            
            axios.defaults.headers.common['Authorization'] = 'Bearer' + context.rootState.token
            

            return new Promise((resolve,reject) => { 
                axios.put('/api/users/' + data.id,{
                    name: data.name,
                    profile_description: data.profile_description,
                    sex: data.sex
                })
                .then(response => {
                    context.commit('updateUser',response.data.data);
                    resolve(response)
                })
                .catch(error => {
                   
                    reject(error);
                })
            })
        },

        updatePic(context,data){
            
            axios.defaults.headers.common['Authorization'] = 'Bearer' + context.rootState.token
            let user_data = new FormData();
            user_data.append('image',data.image)

            return new Promise((resolve,reject) => { 
                axios.post('/api/users/' + data.id,user_data)
                .then(response => {
                   
                  
                    resolve(response)
                   
                })
                .catch(error => {
                   
                    reject(error);
                })
            })
        },
      

        searchUser(context,data){
            
            axios.defaults.headers.common['Authorization'] = 'Bearer' + context.rootState.token
            return new Promise((resolve,reject) => { 
                axios.post('/api/users/search',{
                
                    letter: data.letter
                })
                .then(response => {
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