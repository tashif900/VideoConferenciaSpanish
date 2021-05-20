import Vue from 'vue';
import Router from 'vue-router';
import welcome from "./views/templates/welcome";
import adddate from "./views/templates/add-date";
import login from "./views/templates/login";
import register from "./views/templates/register";
import ForgotPassword from "./views/templates/forgot-password";
import ResetPasswordForm from "./views/templates/reset-password";
import logout from "./views/templates/logout";
import addclass from "./views/templates/add-class"
import editclass from "./views/templates/edit-class"
import addcourse from "./views/templates/add-course"
import editcourse from "./views/templates/edit-course"
import paid from "./views/templates/paid";
import personaldata from "./views/templates/personal-data"

import dashboarduser from "./views/templates/dashboard_user/home";
import dashboardprofile from "./views/templates/dashboard_user/profile";
import dashboardpayment from "./views/templates/dashboard_user/payment";
import dashboardhelp from "./views/templates/dashboard_user/help_desk";
import dashboardincome from "./views/templates/dashboard_user/income";
import dashboardschedule from "./views/templates/dashboard_user/schedule";
import dashboardmessages from "./views/templates/dashboard_user/message";

import registerteacher from "./views/templates/register-teacher"
import preview from "./views/templates/preview"
import room from "./views/templates/room"
import plans from "./views/templates/plans";
import search from "./views/templates/search";
import nosotros from "./views/templates/nosotros";
import politicas from "./views/templates/politicas";
import terminos from "./views/templates/terminos";
import faq from "./views/templates/faqs";

import advertisements from "./views/templates/advertisements";
import reportuser from "./views/templates/reportuser";
import meetingtype from "./views/templates/meetingtype";
import createmeeting from "./views/templates/createmeeting";
import schedulemeeting from "./views/templates/schedulemeeting";
import findmeeting from "./views/templates/findmeeting";

import myCourses from "./views/templates/my-courses";
import myClass from "./views/templates/my-class";
import publicProfile from "./views/templates/public-profile";
import showClass from "./views/templates/show-class";
import showCourse from "./views/templates/show-course";

import showSession from "./views/templates/show-meeting";

import myads from "./views/templates/my-advertisaments";
import { trimEnd } from 'lodash';

Vue.use(Router);

export default new Router({
    routes: [
        {
            path: '/',
            name: 'home',
            component: welcome
        },
        {
            path: '/add-date',
            name: 'add-date',
            component: adddate
        },
        {
            path: '/login-v',
            name: 'login-v',
            component: login,
            meta: {
                requiresAuth: true,
            }
        },
        {
            path: '/register-v',
            name: 'register-v',
            component: register
        },
        {
            path: '/register-teacher',
            name: 'register-teacher',
            component: registerteacher
        },
        {
            path: '/logout-v',
            name: 'logout-v',
            component: logout,
            meta: {
                requiresAuth: true,
            }
        },
        {
            path: '/add-class',
            name: 'add-class',
            component: addclass,
            meta: {
                requiresAuth: true,
            }
        },
        {
            path: '/edit-class/:id',
            name: 'editclass',
            component: editclass,
            props: true,
            meta: {
                requiresAuth: true,
            }
        },
        {
            path: '/add-course',
            name: 'add-course',
            component: addcourse,
            meta: {
                requiresAuth: true,
            }
        },
        {
            path: '/edit-course/:id',
            name: 'editcourse',
            component: editcourse,
            props: true,
            meta: {
                requiresAuth: true,
            }
        },
        {
            path: '/paid',
            name: 'paid',
            component: paid,
            meta: {
                requiresAuth: true,
            }
        },

        {
            path: '/personal-data',
            name: 'personal-data',
            component: personaldata,
            meta: {
                requiresAuth: true,
            }
        },

        {
            path: '/dashboard-user',
            name: 'dashboard-user',
            component: dashboarduser,
            meta: {
                requiresAuth: true,
            }
        },
        {
            path: '/dashboard-profile',
            name: 'dashboard-profile',
            component: dashboardprofile,
            meta: {
                requiresAuth: true,
            }
        },

        {
            path: '/dashboard-payment',
            name: 'dashboard-payment',
            component: dashboardpayment,
            meta: {
                requiresAuth: true,
            }
        },

        {
            path: '/dashboard-help',
            name: 'dashboard-help',
            component: dashboardhelp,
            meta: {
                requiresAuth: true,
            }
        },

        {
            path: '/dashboard-income',
            name: 'dashboard-income',
            component: dashboardincome,
            meta: {
                requiresAuth: true,
            }
        },

        {
            path: '/dashboard-schedule',
            name: 'dashboard-schedule',
            component: dashboardschedule,
            meta: {
                requiresAuth: true,
            }
        },
        {
            path: '/dashboard-messages',
            name: 'dashboard-messages',
            component: dashboardmessages,
            meta: {
                requiresAuth: true,
            }
        },

        {
            path: '/room',
            name: 'room',
            component: room,
            meta: {
                requiresAuth: true,
            }
        },
        {
            path: '/preview/:type/:id',
            name: 'preview',
            props: true,
            component: preview,

        },
        {
            path: '/plans',
            name: 'plans',
            component: plans,
            meta: {
                requiresAuth: true,
            }
        },

        {
            path: '/advertisements',
            name: 'advertisements',
            component: advertisements,
            meta: {
                requiresAuth: true,
            }
        },

        {
            path: '/advertisements/:id',
            name: 'advertisementsedit',
            component: advertisements,
            meta: {
                requiresAuth: true,
            }
        },

        {
            path: '/reportuser',
            name: 'reportuser',
            component: reportuser,
            meta: {
                requiresAuth: true,
            }
        },

        {
            path: '/meetingtype',
            name: 'meetingtype',
            component: meetingtype,
            meta: {
                requiresAuth: true,
            }
        },

        {
            path: '/createmeeting',
            name: 'createmeeting',
            component: createmeeting,
            meta: {
                requiresAuth: true,
            }
        },

        {
            path: '/schedulemeeting',
            name: 'schedulemeeting',
            component: schedulemeeting,
            meta: {
                requiresAuth: true,
            }
        },

        {
            path: '/findmeeting',
            name: 'findmeeting',
            component: findmeeting,
            meta: {
                requiresAuth: true,
            }
        },
        {
            path: '/search',
            name: 'search',
            component: search,
            props: true,
            params: true,
            meta: {
                requiresAuth: false,
            }
        },
        {
            path: '/nosotros',
            name: 'nosotros',
            component: nosotros,
            meta: {
                requiresAuth: false,
            }
        },
        {
            path: '/politica-privacidad',
            name: 'politicas',
            component: politicas,
            meta: {
                requiresAuth: false,
            }
        },
        {
            path: '/terminos-condiciones',
            name: 'terminos',
            component: terminos,
            meta: {
                requiresAuth: false,
            }
        },
        {
            path: '/preguntas-frecuentes',
            name: 'faq',
            component: faq,
            meta: {
                requiresAuth: false,
            }
        },
        {
            path: '/mis-cursos',
            name: 'my-courses',
            component: myCourses,
            meta: {
                requiresAuth: true,
            }
        },
        {
            path: '/mis-clases',
            name: 'my-class',
            component: myClass,
            meta: {
                requiresAuth: true,
            }
        },
        {
            path: '/perfil-publico/:id',
            name: 'public-profile',
            component: publicProfile,
            props: true
        },
        {
            path: '/class/:slug',
            name: 'showClass',
            component: showClass,
            props: true,
            meta: {
                requiresAuth: true,
            }
        },
        {
            path: '/curso/:course/:class',
            name: 'showCourse',
            component: showCourse,
            props: true,
            meta: {
                requiresAuth: true,
            }
        },
        {
            path: '/mis-anuncios',
            name: 'myads',
            component: myads,
            props: true,
            meta: {
                requiresAuth: true,
            }
        },
        {
            path: '/auth/:provider/callback',
            component: {
              template: '<div class="auth-component"></div>'
            }
        },
        {
            path: '/meeting/:uuid/:type',
            name: 'show-session',
            component: showSession,
            props: true,
            meta: {
                requiresAuth: true,
            }
        },
        { 
            path: '/reset-password', 
            name: 'reset-password', 
            component: ForgotPassword, 
            meta: { 
              auth:false 
            } 
          },
          { 
            path: '/reset-password/:token', 
            name: 'reset-password-form', 
            component: ResetPasswordForm, 
            meta: { 
              auth:false 
            } 
          }
    ],
    mode:'history' //elimina #
})