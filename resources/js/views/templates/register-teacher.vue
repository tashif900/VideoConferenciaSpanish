<template>
    <div>
        <div class="row hvh-100">
            <div class="col-12 col-lg-6 hvh-100 login-left-sidebar">
                <div class="row justify-content-center hvh-100 align-items-center">
                    <div class="col-12 col-md-9 text-center">
                        <div class="mb-4">
                            <router-link to="/"><img src="/img/logo2b.png" alt="" width="200px"></router-link>
                        </div>
                        <h2 class="text-white text-center mb-4">Registro de Profesionales</h2>
                        <form action="">
                            <div class="form-group">
                                <input v-model="teacher.name" name="name" id="name" type="text" placeholder="Nombres y Apellidos" class="form-control">
                            </div>
                            <div class="form-group">
                                <input v-model="teacher.email" name="email" id="email" type="email" placeholder="Correo" class="form-control">
                            </div>
                            <div class="form-group">
                                <input v-model="teacher.password" @input="checkPassword" name="password" id="password" type="password" placeholder="Contraseña" class="form-control">
                                <ul class="text-white text-left" style="font-size: 13px;">
                                    <li v-bind:class="{ is_valid: contains_eight_characters }">Min 8 Caracteres</li>
                                    <li v-bind:class="{ is_valid: contains_number }">Contiene un número</li>
                                    <li v-bind:class="{ is_valid: contains_uppercase }">Contiene una mayúscula</li>
                                    <li v-bind:class="{ is_valid: contains_lowercase }">Contiene una minúscula</li>
                                    <li v-bind:class="{ is_valid: contains_special_character }">Contiene carácter especial</li>
                                </ul>
                            </div>
                            <div class="form-group">
                                <input v-model="teacher.profession" name="profession" id="profession" type="text" placeholder="Profesión" class="form-control">
                            </div>
                            <div class="form-group">
                                <select v-model="teacher.thematic_id" class="form-control">
                                    <option value="0" selected>Elige una categoría</option>
                                    <option v-for="cat in Category" :value =cat.id>{{cat.name}}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <multiselect v-model="interests" @change="addTag" @remove="removeTag" :options="interesetsOptions" :multiple="true" :taggable="false" label="name" track-by="id" @select="addTag" placeholder="Seleccione sus intereses"></multiselect>
                            </div>
                            <div class="form-group text-center mt-4">
                                <button v-on:click.prevent="save" class="btn btn-rounded btn-custom-blue">Registrarme</button>
                            </div>
                        </form>
                            <hr class="login-divider">

                            <div class="form-row">
                                <div class="col mb-3">
                                    <!-- <button @click="AuthProvider('facebook')" type="button" class="btn btn-custom-social facebook"><img src="/img/facebook-icon.png"> Ingresar con Facebook</button> -->
                                    <div id="fb-root"></div>
                                    <button @click="logInWithFacebook" type="button" class="btn btn-custom-social facebook"><img src="/img/facebook-icon.png"> Ingresar con Facebook</button>
                                </div>
                                <div class="col">
                                    <!-- <button @click="AuthProvider('google')" type="button" class="btn btn-custom-social google"><img src="/img/google-icon.png"> Ingresar con Google</button> -->
                                    <GoogleLogin :params="params" :onSuccess="onSuccess" :onFailure="onFailure" class="btn btn-custom-social google"><img src="/img/google-icon.png">Ingresar con Google</GoogleLogin>
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
    import Multiselect from 'vue-multiselect';
    import GoogleLogin from 'vue-google-login';

    export default {
        components: {'multiselect': Multiselect, GoogleLogin},
        mounted() {
            this.getInterests();
            window.fbAsyncInit = function () {
                FB.init({
                    appId: '349863049774991',
                    cookie: true,
                    xfbml: true,
                    version: 'v2.6'
                });
            };
            (((d, s, id) => {
                const fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) {
                    return;
                }
                const js = d.createElement(s);
                js.id = id;
                js.src = 'https://connect.facebook.net/en_US/sdk.js';
                fjs.parentNode.insertBefore(js, fjs);
            })(document, 'script', 'facebook-jssdk'));
        },
        data(){
            return{
                teacher :{
                    name: null,
                    email: null,
                    password: null,
                    profession: null,
                    thematic_id: 0,
                    //interests: [],
                    state:1,
                    userInterestSelected: [],
                },
                interesetsOptions: [],
                interests: [],
                password_length: 0,
                contains_eight_characters: false,
                contains_number: false,
                contains_uppercase: false,
                contains_lowercase: false,
                contains_special_character: false,
                valid_password: false,
                params: {
                    client_id: "817457635916-0ud4ctt9vrcq6scnodbejhm7ut43gqal.apps.googleusercontent.com",

                },
                renderParams: {
                    width: 250,
                    height: 50,
                    longtitle: true
                }
            }
        },
        methods:{
            logInWithFacebook() {
                let self = this;
                window.FB.login(function(response) {
                    if (response.authResponse) {
                     //   console.log(response.authResponse)
                        axios.post('/sociallogin', {
                            type: 2,
                            grant_type: 'social',
                            provider: 'facebook',
                            access_token: response.authResponse.accessToken
                        }).then(response => {
                            let rsp = response;
                                self.$store
                                .dispatch("retrieveSocialToken", rsp)
                                .then(response => {
                                    // this.$router.push({name:"dashboard-user"});
                                    window.location.href = "/dashboard-user"
                                })
                                .catch(error =>{
                                    this.error=error;
                                    console.log(this.error)
                                });
                            // }
                        }).catch(err => {
                            console.log({err:err})
                        })
                        // Now you can redirect the user or do an AJAX request to
                        // a PHP script that grabs the signed request from the cookie.
                    } else {
                        alert("User cancelled login or did not fully authorize.");
                    }
                });
                return false;
            },
            onSuccess(googleUser) {
                let self = this;
                //console.log(googleUser, 'Google User');

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
                axios.post('/sociallogin', {
                    type: 2,
                    grant_type: 'social',
                    provider: 'google',
                    access_token: access_token
                }).then(response => {
                    if (response.data.status == 'REGISTER') {
                        this.error = 'No se encontro una cuenta, Registrese'
                        this.$router.push({name:"register-v"});
                    } else {
                        let rsp = response;
                        self.$store
                        .dispatch("retrieveSocialToken", rsp)
                        .then(response => {
                            window.location.href = "/dashboard-user"
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
           async save(){
                let teacher= this.teacher;
                if (this.teacher.email != null && this.teacher.name != null && this.teacher.thematic_id != null && this.teacher.profession != null && this.teacher.userInterestSelected.length > 0) {
                    if(this.valid_password) {
                        await this.$store
                            .dispatch("registerTeacher", {
                                teacher
                            })
                            .then(response => {
                                if (response.data.state == false) {
                                    if (response.data.code == '23000') {
                                        toastr.error('El correo ya se encuentra registrado', 'Mensaje del sistema');
                                    } else {
                                         toastr.error('Ha un error inesperado', 'Mensaje del sistema');
                                    }
                                } else {
                                    this.$router.push({name:"home"});
                                }
                            })
                            .catch(error =>{
                                toastr.error('Ha un error inesperado', 'Mensaje del sistema');
                            });
                    } else {
                        toastr.error('La contraseña no cumple con los requisitos', 'Mensaje del sistema');
                    }
                } else {
                    toastr.error('Todos los campos son obligatorios.', 'Mensaje del sistema');
                }
            },
            getInterests: function() {
                let url ="/api/get-interests"
                axios.get(url).then(response =>{
                    this.interesetsOptions = response.data;
                  //  console.log(this.interesetsOptions, "Intereses");
                }).catch(error => {
                    console.log(error);
                })
            },
            addTag(newTag) {
                this.teacher.userInterestSelected.push(newTag.id);             
            },
            removeTag(tag) {
                const index = this.teacher.userInterestSelected.indexOf(tag.id);

                if (index > -1) {
                    this.teacher.userInterestSelected.splice(index, 1);
                }
            },
            checkPassword() {
                this.password_length = this.teacher.password.length;
                        const format = /[ !@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/;
                        
                if (this.password_length >= 8) {
                    this.contains_eight_characters = true;
                } else {
                    this.contains_eight_characters = false;
                }
                        
                this.contains_number = /\d/.test(this.teacher.password);
                this.contains_uppercase = /[A-Z]/.test(this.teacher.password);
                this.contains_lowercase = /[a-z]/.test(this.teacher.password);
                this.contains_special_character = format.test(this.teacher.password);
                
                if (this.contains_eight_characters === true &&
                    this.contains_special_character === true &&
                    this.contains_uppercase === true &&
                    this.contains_lowercase === true &&
                    this.contains_number === true) {
                    this.valid_password = true;			
                } else {
                    this.valid_password = false;
                }
            },
            AuthProvider(provider) {
                var self = this
                this.$auth.authenticate(provider).then(response =>{
                    self.SocialLogin(provider,response)
                }).catch(err => {
                    console.log({err:err})
                })
            },
            SocialLogin(provider,response){
                this.$http.post('/sociallogin/'+provider + '?type=2',response).then(response => {
                    this.$store
                        .dispatch("retrieveSocialToken", response)
                        .then(response => {
                            this.$router.push({name:"dashboard-user"});
                        })
                        .catch(error =>{
                            this.error=error.response.data;
                        });
                }).catch(err => {
                    console.log({err:err})
                })
            },
        },
        computed:{
            Category (){
                return this.$store.getters.getCategories;
            }
        }

    }
</script>

<style scoped>
    .is_valid { color: rgba(136, 152, 170, 0.8); }
    .is_valid:before { width: 100%; }
    li { 
	    margin-bottom: 8px;
	    margin-top: 8px;
	    position: relative;
    }
    li:before {
        content: "";
	    width: 0%; height: 2px;
	    background: #dc3545;
	    position: absolute;
	    left: 0; top: 50%;
	    display: block;
	    transition: all .6s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    .form-control {
        color: #fff !important;
    }
</style>