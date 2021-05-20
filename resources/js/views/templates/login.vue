<template>
    <div class="container-fluid hvh-100">
        <div class="row hvh-100">
            <div class="col-12 col-lg-6 hvh-100 login-left-sidebar">
                <div class="row justify-content-center hvh-100 align-items-center">
                    <div class="col-12 col-md-9 text-center">
                        <div class="mb-4">
                            <router-link to="/"><img src="/img/logo2b.png" alt="" width="200px"></router-link>
                        </div>
                        <h2 class="text-white text-center">Acceder</h2>
                        <form autocomplete="off" @submit.prevent="login" method="POST">

                            <div class="alert alert-danger" role="alert" v-if="error">
                                {{error}}
                            </div>

                            <div class="form-group">
                                <input type="email" name="email" placeholder="Email" class="form-control" required autocomplete="off" v-model="email">

                               <!-- <span class="invalid-feedback" role="alert">
                                   <strong></strong>
                                </span>-->

                            </div>
                            <div class="form-group">
                                <input type="password" name="password" placeholder="Contraseña" class="form-control" required v-model="password" autocomplete="off">

                                <!-- <span class="invalid-feedback" role="alert">
                                     <strong></strong>
                                </span>-->

                            </div>
                            <div class="form-row">
                                <div class="col">
                                    <label class="text-white"><input type="checkbox"> Mantenerme Conectado</label>
                                </div>
                                <div class="col text-right">
                                    <router-link to="/reset-password" class="text-white">¿Olvidaste tu Contraseña?</router-link>
                                </div>
                            </div>
                            <div class="form-group text-center mt-4">
                                <button type="submit" class="btn btn-rounded btn-custom-blue">INGRESAR</button>
                               <router-link to="/register-v" class="btn btn-rounded btn-custom white">REGÍSTRATE</router-link>
                            </div>
                        </form>
                            <hr class="login-divider">

                            <div class="form-row">
                                <div class="col mb-3">
                                    <!-- <button @click="AuthProvider('facebook')" type="button" class="btn btn-custom-social facebook"><img src="/img/facebook-icon.png"> Ingresar con Facebook</button> -->
                                    <!-- <v-facebook-login v-model="fv" @sdk-init="handleSdkInit" app-id="349863049774991" login="Continuar con Facebook"></v-facebook-login> -->
                                    <div id="fb-root"></div>
                                    <button @click="logInWithFacebook" type="button" class="btn btn-custom-social facebook"><img src="/img/facebook-icon.png"> Ingresar con Facebook</button>
                                </div>
                                <div class="col text-right d-flex justify-content-center justify-content-lg-end">
                                    <!-- <button data-onsuccess="onSignIn" type="button" class="g-signin2 btn btn-custom-social google"><img src="/img/google-icon.png"> Ingresar con Google</button> -->
                                    <GoogleLogin :params="params" :onSuccess="onSuccess" :onFailure="onFailure" class="btn btn-custom-social google"><img src="/img/google-icon.png">Ingresar con Google</GoogleLogin>
                                    <!-- <button @click="AuthProvider('google')" type="button" class="btn btn-custom-social google"><img src="/img/google-icon.png"> Ingresar con Google</button> -->
                                </div>
                            </div>
                        
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6 login-right-sidebar"></div>
        </div>
    </div>

</template>

<script>
    import VFacebookLogin from 'vue-facebook-login-component';
    import GoogleLogin from 'vue-google-login';

    export default {
        components: {VFacebookLogin, GoogleLogin},
        data(){
            return{
                email: null,
                password:null,
                error: null,
                FB: {},
                fv: {},
                scope: {},
                params: {
                    client_id: "817457635916-0ud4ctt9vrcq6scnodbejhm7ut43gqal.apps.googleusercontent.com",
                },
                renderParams: {
                    width: 250,
                    height: 50,
                    longtitle: true
                },
                prevRoute: localStorage.getItem('prev_route')
            };
        },
        mounted: function () {
            window.fbAsyncInit = function () {
                FB.init({
                    appId: '349863049774991',
                    cookie: true,
                    xfbml: true,
                    version: 'v2.7'
                });
            };
            (((d, s, id) => {
                const fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) {
                    return;
                }
                const js = d.createElement(s);
                js.id = id;
                js.src = 'https://connect.facebook.net/en_US/sdk.js#version=v2.2&appId=myAppId&xfbml=true&autoLogAppEvents=true';
                fjs.parentNode.insertBefore(js, fjs);
            })(document, 'script', 'facebook-jssdk'));

        },
        created() {
            //document.querySelector('.abcRioButtonContents').innerHTML = 'Ingresar con Google';
        },
        methods:{
            logInWithFacebook() {
                let self = this;
                window.FB.login(function(response) {
                    if (response.authResponse) {
                        axios.post('/sociallogin', {
                            type: 3,
                            grant_type: 'social',
                            provider: 'facebook',
                            access_token: response.authResponse.accessToken
                        }).then(response => {
                            if (response.data.status == 'REGISTER') {
                                self.error = 'No se encontro una cuenta, Registrese'
                                self.$router.push({name:"register-v"});
                            } else {
                                let rsp = response;
                                self.$store
                                .dispatch("retrieveSocialToken", rsp)
                                .then(response => {
                                    let prevroute = localStorage.getItem('prev_route')
                                    if (prevroute == null){
                                        //alert('Hola');
                                        window.location.href = "/dashboard-profile"
                                    } else{
                                        //alert('Removiendo')
                                        localStorage.removeItem('prev_route')
                                        window.location.href = prevroute;
                                    }
                                })
                                .catch(error =>{
                                    this.error="Ha ocurrido un error inesperado";
                                    console.log(this.error)
                                });
                            }
                            
                        }).catch(err => {
                            console.log({err:err})
                        })
                    } else {
                        toastr.error('El usuario canceló el inicio de sesión o no lo autorizó por completo.', 'Mensaje del Sistema')

                        //alert("User cancelled login or did not fully authorize.");
                    }
                });
                return false;
            },
            onSuccess(googleUser) {
                let self = this;
                console.log(googleUser, 'Login Google');
                //alert('Google User');
                let access_token;
                if (typeof googleUser.Bc !== 'undefined'){
                    access_token = googleUser.Bc.access_token;
                }else if (typeof googleUser.uc !== 'undefined'){
                    access_token = googleUser.uc.access_token;
                }else if (typeof googleUser.cp !== 'undefined'){
                    access_token = googleUser.cp.access_token;
                }else if (typeof googleUser.tc!== 'undefined'){
                  access_token = googleUser.tc.access_token;
                }

                //if (googleUser.Bc)
                //console.log(access_token, 'TOKEN');
                axios.post('/sociallogin', {
                    type: 3,
                    grant_type: 'social',
                    provider: 'google',
                    access_token: access_token
                }).then(response => {
                    if (response.data.status == 'REGISTER') {
                        self.error = 'No se encontro una cuenta, Registrese'
                        self.$router.push({name:"register-v"});
                    } else if (response.data.status == false) {
                        this.error= response.data.message;
                    } else {
                        let rsp = response;
                        self.$store
                        .dispatch("retrieveSocialToken", rsp)
                        .then(response => {
                            let prevroute = localStorage.getItem('prev_route')
                            if (prevroute == null){
                                //alert('Hola');
                                window.location.href = "/dashboard-profile"
                            } else{
                                //alert('Removiendo')
                                localStorage.removeItem('prev_route')
                                window.location.href = prevroute;
                            }
                        })
                        .catch(error =>{
                            this.error=error;
                            console.log(this.error)
                        });
                    }
                    
                }).catch(err => {
                    console.log({err:err})
                })
            },
            onFailure() {

            },
            login(){
                this.$store
                    .dispatch("retrieveToken", {
                        email:  this.email,
                        password: this.password
                    })
                    .then(response => {
                        if (this.prevRoute == null){
                            window.location.href = "/dashboard-profile"
                        } else{
                            localStorage.removeItem('prev_route')
                            window.location.href = this.prevRoute
                        }
                    })
                    .catch(error =>{
                        //alert("Ha ocurrido un error" + error);
                       // console.log(error)
                        this.error=error.response.data;
                    });
            },
            AuthProvider(provider) {
                var self = this
                self.$auth.authenticate(provider).then(response =>{
                    self.SocialLogin(provider,response)
                }).catch(err => {
                    console.log({err: err})
                })
            },
            SocialLogin(provider,response){
                console.log(provider);
                this.$http.post('/sociallogin/'+provider + '?type=3',response).then(response => {
                    console.log(response)
                    if (response.data.status == 'REGISTER') {
                        this.error = 'No se encontro una cuenta, Registrese'
                        this.$router.push({name:"register-v"});
                    } else {
                        this.$store
                        .dispatch("retrieveSocialToken", response)
                        .then(response => {
                            // this.$router.push({name:"dashboard-user"});
                            // window.location.href = "/dashboard-user"
                        })
                        .catch(error =>{
                            this.error=error.response.data;
                        });
                    }
                }).catch(err => {
                    console.log({err:err})
                })
            },
        }
    }
</script>

<style scoped>
    @import '../css/auth.css';

    .white{
        background: rgba(60, 89, 159, .4) !important;
        color : white;
    }
</style>