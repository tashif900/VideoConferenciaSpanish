import Vue from 'vue'
import Vuex from "vuex"
import axios from "axios"

Vue.use(Vuex);

export default new Vuex.Store({
   state : {
       token: localStorage.getItem('access_token') || null,
       user: JSON.parse(localStorage.getItem("user_login")),
       categories: JSON.parse(localStorage.getItem("categories"))
   },
   getters:{
       loggedIn (state){
           return state.token !== null
       },
       getCategories (state){
           return state.categories;
       }
   },

   mutations: {
       retrieveToken (state, token){
           state.token = token
       },
       retrieveSocialToken (state, token){
           state.token = token
       },
       destroyToken (state){
           state.token=null
       },
       getUser (state, user){
           state.user = user
       },
       getCategories(state, categories){
           state.categories = categories;
           //console.log(this.state.categories, 'Mutationcat' )
       }
   },
    actions: {
       retrieveToken (context, credentials){
           return new Promise((resolve, reject) =>{
               axios.post('/api/login', {
                   email: credentials.email,
                   password: credentials.password
               }).then(response => {
                   //console.log(response.data.tokens.access_token, 'retriew');
                   const token = response.data.tokens.access_token;
                   const user = response.data.tokens.user;
                   localStorage.setItem('access_token', token);
                   localStorage.setItem('user_login',JSON.stringify(user))
                   context.commit('retrieveToken', token);
                   context.commit('getUser', user);
                   resolve(response);
               }).catch(error => {
                   reject(error)
               })
           });
       },
        retrieveSocialToken (context, response){
            return new Promise((resolve, reject) =>{
                const token = response.data.tokens.access_token;
                const user = response.data.tokens.user;
                localStorage.setItem('access_token', token);
                localStorage.setItem('user_login',JSON.stringify(user))
                context.commit('retrieveToken', token);
                context.commit('getUser', user);
                resolve(response);
            });
        },
       registerTeacher(context, teacher){
            return new Promise((resolve, reject) =>{
                //console.log(teacher.teacher, 'teacher');
                axios.post('/api/registerTeacher', teacher.teacher
                ).then(response => {
                    if (response.data.state == false) {
                        if (response.data.code == '23000') {
                            resolve(response);
                        }
                    } else {
                        const token = response.data.tokens.access_token;
                        const user = response.data.tokens.user;
                        localStorage.setItem('access_token', token);
                        localStorage.setItem('user_login',JSON.stringify(user))
                        context.commit('retrieveToken', token);
                        context.commit('getUser', user);
                        resolve(response);
                    }
                }).catch(error => {
                    console.log(error, 'error');
                    reject(error)
                })
            });
        },
       registerStudent(context, student){
            return new Promise((resolve, reject) =>{
                //console.log(teacher.teacher, 'teacher');
                axios.post('/api/registerStudent', student.student
                ).then(response => {
                    if (response.data.state == false) {
                        if (response.data.code == '23000') {
                            resolve(response);
                        }
                    } else {
                        const token = response.data.tokens.access_token;
                        const user = response.data.tokens.user;
                        localStorage.setItem('access_token', token);
                        localStorage.setItem('user_login',JSON.stringify(user))
                        context.commit('retrieveToken', token);
                        context.commit('getUser', user);
                        resolve(response);
                    }
                }).catch(error => {
                    console.log(error, 'error');
                    reject(error)
                })
            });
        },
       destroyToken (context){
           //alert('Hola');
           if (context.getters.loggedIn){

               return new Promise((resolve, reject) =>{
                   //console.log(context.state.token, 'token');
                   axios.post('/api/logout','', {
                       headers:{Authorization: "Bearer " + context.state.token}
                   }).then(response =>{
                       //console.log(response, 'Response');
                       localStorage.removeItem('access_token');
                       localStorage.removeItem('user_login');
                       localStorage.removeItem('categories');
                       context.commit('destroyToken');
                       resolve(response);
                   }).catch(error => {
                       console.log(error, 'Error');
                       localStorage.removeItem('access_token');
                       localStorage.removeItem('user_login');
                       localStorage.removeItem('categories');
                       context.commit('destroyToken');
                       reject(error);
                   })
               })
           }
       },
       getCategories(context, categories){
           return new Promise((resolve, reject) => {
              axios.get('/api/getThematics').then(response=>{
                  const categories = response.data;
                  localStorage.setItem('categories',JSON.stringify(categories))
                  context.commit('getCategories', categories);
                  resolve(response);
              }).catch(error=>{
                  reject(error);
              })
           });
       }
    }

});