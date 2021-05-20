<template>
    <div class="container-fluid hvh-100">
        <div class="row hvh-100">
            <div class="col-12 col-lg-6 hvh-100 login-left-sidebar">
                <div class="row justify-content-center hvh-100 align-items-center">
                    <div class="col-12 col-md-9 text-center">
                        <div class="mb-4">
                            <img src="/img/logo2b.png" alt="" width="200px">
                        </div>
                        <h2 class="text-white text-center">Restablecer Contraseña</h2>
                        <form autocomplete="off" @submit.prevent="resetPassword" method="POST">

                            <div class="alert alert-danger" role="alert" v-if="has_error">
                                {{has_error}}
                            </div>

                            <div class="form-group">
                                <input type="email" name="email" placeholder="Email" class="form-control" required autocomplete="email" v-model="email">
                            </div>
                            <div class="form-group">
                                <input type="password" @input="checkPassword" name="password" placeholder="Contraseña" class="form-control" required v-model="password">
                                <ul class="text-white text-left" style="font-size: 13px">
                                    <li v-bind:class="{ is_valid: contains_eight_characters }">Min 10 Caracteres</li>
                                    <li v-bind:class="{ is_valid: contains_number }">Contiene un número</li>
                                    <li v-bind:class="{ is_valid: contains_uppercase }">Contiene una mayúscula</li>
                                    <li v-bind:class="{ is_valid: contains_lowercase }">Contiene una minúscula</li>
                                    <li v-bind:class="{ is_valid: contains_special_character }">Contiene carácter especial</li>
                                </ul>
                            </div>
                            <div class="form-group">
                                <input type="password" id="password_confirmation" @input="comparePassword" placeholder="Confirmar Contraseña" class="form-control" v-model="password_confirmation" required>
                            </div>
                            <div class="form-group text-center mt-4">
                                <button type="submit" class="btn btn-rounded btn-custom-blue">Cambiar contraseña</button>
                            </div>
                        </form>                        
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6 login-right-sidebar"></div>
        </div>
    </div>

</template>

<script>
      export default {
        data(){
            return {
                token: null,
                email: null,
                password: null,
                password_confirmation: null,
                has_error: null,
                password_length: 0,
                contains_eight_characters: false,
                contains_number: false,
                contains_uppercase: false,
                contains_lowercase: false,
                contains_special_character: false,
                valid_password: false,
            }
        },
        methods:{
            resetPassword() {
                let self = this;
                if (this.valid_password) {
                    axios.post("/api/reset/password", {
                        token: this.$route.params.token,
                        email: this.email,
                        password: this.password,
                        password_confirmation: this.password_confirmation
                    }).then(result => {
                        if (result.data.errors) {
                            this.has_error = result.data.errors.password[0]
                        } else {
                            toastr.success(result.data.message, 'Mensaje del sistema');
                            window.setTimeout(function(){
                                self.$router.push({name: 'login-v'})
                            }, 3000);
                        }
                    }).catch(err => {
                        console.log({err:err})
                    });
                } else {
                    this.has_error = 'Las contraseñas no cumplen con los requisitos.'
                }
            },
            checkPassword() {
                this.password_length = this.password.length;
                        const format = /[ !@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/;

                if (this.password_length > 10) {
                    this.contains_eight_characters = true;
                } else {
                    this.contains_eight_characters = false;
                }

                this.contains_number = /\d/.test(this.password);
                this.contains_uppercase = /[A-Z]/.test(this.password);
                this.contains_lowercase = /[a-z]/.test(this.password);
                this.contains_special_character = format.test(this.password);

                if (this.contains_eight_characters === true &&
                    this.contains_special_character === true &&
                    this.contains_uppercase === true &&
                    this.contains_lowercase === true &&
                    this.contains_number === true) {
                    this.valid_password = true;
                } else {
                    this.valid_password = false;
                }
                this.comparePassword();
            },
            comparePassword() {
                if (this.password != this.password_confirmation) {
                    this.has_error = 'Las contraseñas no coinciden';
                    this.valid_password = false;
                } else {
                    this.has_error = null;
                    this.valid_password = true;
                }
            }
        }
    }
</script>

<style scoped>
    @import '../css/auth.css';
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
</style>