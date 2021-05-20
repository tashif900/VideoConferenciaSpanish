<template>
    <div class="container-fluid hvh-100">
        <div class="row hvh-100">
            <div class="col-12 col-lg-6 hvh-100 login-left-sidebar">
                <div class="row justify-content-center hvh-100 align-items-center">
                    <div class="col-12 col-md-9 text-center">
                        <div class="mb-4">
                            <router-link to="/"><img src="/img/logo2b.png" alt="" width="200px"></router-link>
                        </div>
                        <h2 class="text-white text-center">Recuperar Contraseña</h2>
                        <form autocomplete="off" @submit.prevent="requestResetPassword" method="POST">

                            <div class="alert alert-danger" role="alert" v-if="has_error">
                                {{has_error}}
                            </div>
                            
                            <div class="alert alert-warning" role="alert" v-if="success == 2">
                                {{message}}
                            </div>

                            <div class="alert alert-success" role="alert" v-if="success == 1">
                                {{message}}
                            </div>

                            <div class="form-group">
                                <input type="email" name="email" placeholder="Email" class="form-control" required autocomplete="email" v-model="email">
                            </div>
                            <div class="form-group text-center mt-4">
                                <button type="submit" class="btn btn-rounded btn-custom-blue">Enviar enlace de restablecimiento de contraseña</button>
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
                email: null,
                has_error: false,
                success: false,
                message: null,
            }
        },
        methods:{
            requestResetPassword() {
                axios.post("/api/reset-password", {email: this.email}).then(result => {
                    if (result.data == 'passwords.sent') {
                        this.success = 1;
                        this.message = result.data.message
                    } else {
                        this.success = 2;
                        this.message = result.data.message
                    }
                }).catch(err => {
                    console.log({err:err})
                });
            },
        }
    }
</script>

<style scoped>
    @import '../css/auth.css';
</style>