<template>
    <div>
        <v-nav></v-nav>
        <div class="body-container">
            <!-- <carousel-component></carousel-component> -->
            <information-component></information-component>
            <div class="container">
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card-white">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-12">
                                        <dasboard-link></dasboard-link>
                                        <div class="col-12">
                                            <div class="row my-4">
                                                <div class="col-12">
                                                    <div class="alert alert-danger" v-if="errors != ''">
                                                        <ul>
                                                            <li v-for="error in errors" :key="error">{{ error }}</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row my-4 mb-4  mt-4">
                                                <div class="col-12 my-4">
                                                    <h4 class="title-red">Reportar Usuario</h4>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group row">
                                                        <label for="inputPassword" class="col-sm-2 col-form-label">Encontrar</label>
                                                        <div class="col-sm-10">
                                                            <div class="row">
                                                                <div class="col-10 col-md-11"><input type="text" class="form-control" id="inputPasswor" v-model="user" placeholder="Escribe ID / Correo"></div>
                                                                <div class="col-2 col-md-1"><button class="btn btn-custom-blue btn-rounded" @click="searchUser"><i class="ti-search"></i></button></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="inputPassword" class="col-sm-2 col-form-label">Nombre</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control w" v-model="data" id="inputPassword" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="inputPassword" class="col-sm-2 col-form-label">Comentarios</label>
                                                        <div class="col-sm-10">
                                                            <textarea name="" class="form-control" v-model="comment"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <button class="btn btn-custom-blue" @click="clear">Cancelar</button>
                                                        <button class="btn btn-custom-red" @click="store">Enviar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <v-footer></v-footer>
    </div>


</template>

<script>
    import VNav from "../partials/v-nav";
    import VFooter from "../partials/v-footer";
    import CarouselComponent from "../../components/CarouselComponent";
    import InformationComponent from "../../components/InformationComponent";
    import DasboardLink from "../../components/DasboardLink";
    export default {
        components: {DasboardLink, VFooter, VNav, CarouselComponent, InformationComponent},
        name: "reporuser",
        data: function () {
            return {
                user: null,
                data: null,
                comment: null,
                userId: null,
                errors: []
            }
        },
        methods: {
            searchUser: function() {
                var url = '/api/search-user';
                axios.post(url,{user: this.user}).then(response => {
                    if (Object.entries(response.data).length == 0) {
                        toastr.info('No se encontro al usuario, intentelo nuevamente', 'Mensaje del sistema');
                    } else {
                        this.data = response.data.name;
                        this.userId = response.data.id;
                    }
                });
            },
            store: function() {
                if (this.userId && this.comment) {
                    var url = '/api/report-user-store';
                    axios.post(url,{
                        user_report: this.$store.state.user.id,
                        comment: this.comment,
                        reported_user: this.userId
                    }).then(response => {
                        if (response.data == true) {
                            toastr.success('Se envio correctamente su reporte de usuario.', 'Mensaje del sistema');
    
                            this.user = null;
                            this.data = null;
                            this.comment = null;
                            this.userId = null;
                        } else {
                            toastr.danger('No se puedo enviar su solicitud. Intentelo nuevamente', 'Mensaje del sistema');
                        }
                    });
                }

                this.errors = [];

                if (!this.userId) {
                    this.errors.push('El usuario a reportar es obligatorio.');
                }

                if (!this.comment) {
                    this.errors.push('El comentario es obligatorio');
                }
            },
            clear: function() {
                this.user = null;
                this.data = null;
                this.comment = null;
                this.userId = null;
            }
        }
    }
</script>

<style scoped>

</style>