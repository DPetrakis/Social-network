export const sexes = {
    
    namespaced: true,
    
    state: {
       sexes: []
    },

    getters: {
        
        sexes(state){
            return state.sexes;
        }
    },

    mutations: {
        retrieveSexes(state,sexes){ 
            state.sexes = sexes;
        }
    },

    actions: {
        
        retrieveSexes(context){
            
            axios.defaults.headers.common['Authorization'] = 'Bearer' + context.rootState.token
          
                axios.get('/api/sexes')
                .then(response => {
                    context.commit('retrieveSexes',response.data.data)
                })
                .catch(error => {
                    
                    console.log(error);
                    
                })
            
        }
  
    }
}