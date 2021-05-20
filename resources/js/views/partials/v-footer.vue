<template>
        <footer>
            <div class="container">
                <div class="row py-4">
                    <div class="col-12 col-md-6 col-lg-4 text-center text-md-left mb-4">
                        <h5 class="text-white">Mi Empresa</h5>
                        <ul class="footer-link-list">
                            <li><router-link to="/nosotros">Nosotros</router-link></li>
                            <li><router-link to="/politica-privacidad#">Politicas de Privacidad</router-link></li>
                            <li><router-link to="/terminos-condiciones">Terminos y Condiciones</router-link></li>
                            <li><router-link to="/preguntas-frecuentes">Preguntas Frecuentes</router-link></li>
                        </ul>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4 text-center mb-4">
                        <h5 class="text-white"><router-link class="text-white" to="/register-teacher">Da sesiones con Nosotros</router-link></h5>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4 text-center text-md-right mb-4">
                        <h5 class="text-white">¿Necesitas Ayuda?</h5>
                        <ul class="footer-social-link-list">
                            <li v-for="social in socials" :key="social.name"><a :href="social.link" target="_blank"><i :class="'ti-' + social.name"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="row py-4">
                    <div class="col-12 text-white text-center">
                        Copyright &copy; 2021
                    </div>
                </div>
            </div>
        </footer>
</template>

<script>
    export default {
        name: "v-footer",
        data(){
            return{
                socials: [],
            }
        },
        mounted: function() {
            this.getSocial()
            this.getLogin();
        },
        methods: {
            getSocial: function() {
                var url = '/api/get-site-social-footer';
                axios.post(url).then(response => {
                    this.socials = response.data
                });
            },

            getLogin (){
                let user = this.$store.state.user;
            }
        },
    }
</script>

<style scoped>

</style>