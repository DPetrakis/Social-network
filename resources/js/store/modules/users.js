
export const users = {
    namespaced: true,
    state: {
       user: Object
    },
    getters: {
        user(state){
            return state.user;
        }
    },
    mutations: {
        retrieveUser(state,user){
            state.user = user;
        }
    },
    actions: {
        
        retrieveUser(context,id){
            
            axios.get('/api/users/' + id)
            .then(response => {
               
                context.commit('retrieveUser',response.data.data)
                      
            })
            .catch(error => {
                console.log(error);
            })
            
      
        }
  
    }
}