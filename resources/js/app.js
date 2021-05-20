
require('./bootstrap');

window.Vue = require('vue');
window.moment = require('moment');

Vue.component('app', require('./components/AppComponent').default);

import router from './routes';
import store from "./store";
import "toastr/build/toastr.css"
import Meta from 'vue-meta'
import VueClipboard from 'vue-clipboard2';
import FunctionalCalendar from 'vue-functional-calendar';
import VueSocialauth from 'vue-social-auth'
import axios from 'axios'
import VueAxios from 'vue-axios'

Vue.use(FunctionalCalendar, {
    dayNames: ['Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa', 'Do'],
    monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre']
});
Vue.use(VueClipboard);
Vue.use(Meta);

Vue.use(VueAxios, axios)
Vue.use(VueSocialauth, {
    providers: {
        google: {
            // clientId: '939404393676-eiq2r30b5jpq5c3mh5qdns82qoeii2i9.apps.googleusercontent.com',
            // clientId: '817457635916-0ud4ctt9vrcq6scnodbejhm7ut43gqal.apps.googleusercontent.com', 
            clientId: '42010604010-hre1unn1gvd1qb8mqfancm0103s4vut3.apps.googleusercontent.com', 
            // client_secret: 'L9lghK2jwtCI8PzGvpaC0Npx',
            client_secret: '08Q18nEbfgBv5sVzKj17RnU4',
            redirectUri: 'http://localhost/auth/google/callback' // Your client app URL
        },
        facebook: {
            clientId: '349863049774991',
            client_secret: 'e38469556b40de91714ea700f7b7b1bd',
            redirectUri: 'https://zurviz.com/auth/facebook/callback' // Your client app URL
        }
    }
})

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        //console.log(to.fullPath, 'TOOOO')

        if (to.fullPath == '/login-v'){
            if (store.getters.loggedIn)
                next('/');
            else
                next();
        }else{
            if (!store.getters.loggedIn) {
                localStorage.setItem('prev_route', to.fullPath);
                next({
                    name: 'login-v',
                })
            }else{
                next();
            }

            /* else {
            const prevRoute = localStorage.getItem('prev_route')
            if (prevRoute != null) {
                localStorage.removeItem('prev_route')
                next(prevRoute)
            } else {
                next()
            }
        }*/
        }

    } else {
        next() // make sure to always call next()!
    }
})

Vue.prototype.$appName = 'Mi aplicación'

const app = new Vue({
    el: '#app',
    router,
    store,
    FunctionalCalendar,

});