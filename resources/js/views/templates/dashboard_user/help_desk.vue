<template>
    <div>
        <v-nav></v-nav>
        <div class="body-container">
            <!-- <carousel-component></carousel-component> -->
            <information-component></information-component>
            <div class="container-lg">
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card-white">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-12">
                                        <dasboard-link :help_desk="true" ></dasboard-link>
                                        <div class="tab-content" id="nav-tabContent">
                                            <div class="tab-pane fade show active" id="nav-help" role="tabpanel" aria-labelledby="nav-help-tab">
                                                <div class="row mt-4">
                                                    <div class="col-12">
                                                        <button type="button" class="btn btn-custom-blue" data-toggle="modal" data-target="#newRequest">
                                                            Nueva Consulta
                                                        </button>
                                                    </div>
                                                    <div class="col-12 mt-4">
                                                        <button class="btn btn-custom-blue">Historial</button>
                                                    </div>
                                                    <div class="col-12 mt-4">
                                                        <div class="table-responsive">
                                                            <table class="table">
                                                                <thead class="thead-dark">
                                                                <tr>
                                                                    <th scope="col">Fecha</th>
                                                                    <th scope="col">Título</th>
                                                                    <th scope="col">Mensaje</th>
                                                                    <th scope="col">Estado</th>
                                                                    <th scope="col">*</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <tr v-for="item in Help_desks">
                                                                    <td>{{item.created_at | moment }}</td>
                                                                    <td>{{item.title}}</td>
                                                                    <td>{{item.description}}</td>
                                                                    <td>{{ getStateHelpDesk(item.state)}}</td>
                                                                    <td><button @click="viewHelpDesk(item)" class="btn btn-custom-blue">Ver</button></td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal fade" id="newRequest" tabindex="-1" aria-labelledby="newRequestLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="newRequestLabel">Nueva Consulta</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="col-12 mt-3">
                                                        <input v-model="Helpdesk.title" class="form-control" placeholder="Escribe el título de tu consulta">
                                                    </div>
                                                    <div class="col-12 mt-3">
                                                        <textarea v-model="Helpdesk.description" name="" id="" cols="30" rows="10" class="form-control" placeholder="Escribe aquí tu duda y pronto se pondrán en contacto contigo"></textarea>
                                                    </div>
                                                    <div class="col-12 mt-4">
                                                        <h4>Respuestas</h4>
                                                        <div v-if="Help_desks_response.length>0" >
                                                            <div v-for="item in Help_desks_response">
                                                                <div class="col-12 mt-3">
                                                                    <input v-model="item.title" class="form-control" readonly>
                                                                </div>
                                                                <div class="col-12 mt-3">
                                                                    <textarea v-model="item.description" name="" id="" cols="30" rows="10" class="form-control" readonly></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div v-else>
                                                            <span>Sin respuestas</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                    <button type="button" class="btn btn-custom-red" @click="saveHelpDesk">Enviar</button>
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
    import VNav from "../../partials/v-nav";
    import VFooter from "../../partials/v-footer";
    import CarouselComponent from "../../../components/CarouselComponent";
    import InformationComponent from "../../../components/InformationComponent";
    import DasboardLink from "../../../components/DasboardLink";
    import moment from 'moment';
    export default {
        components: { DasboardLink,VFooter, VNav, CarouselComponent, InformationComponent},
        name: "help.vue",
        data(){
            return {
                Helpdesk: {},
                Help_desks: [],
                Help_desks_response: [],
            }
        },
        mounted() {
            this.getHelpDeksUser();
        },
        methods:{
            saveHelpDesk(){
                let url ="/api/saveHelpDesk";

                axios.post(url, this.Helpdesk , {
                    headers:{Authorization: "Bearer " + this.$store.state.token}
                }).then(response =>{
               //     console.log(response, 'Que paso');
                    if (response.data==true) {
                        this.getHelpDeksUser();
                        toastr.success('Se ha grabado correctamente', 'Mensaje del sistema');
                        $('#newRequest').modal('hide');
                        this.Helpdesk.description = '';
                        this.Helpdesk.title = '';
                    } else{
                        toastr.error('Ha ocurrido un error inesperado.', 'Mensaje del sistema');
                    }
                }).catch(error => {
                    console.log(error, 'Error telible');
                    toastr.error('Ha ocurrido un error inesperado.', 'Mensaje del sistema');
                })
            },

            getHelpDeksUser (){
                let url ="/api/getHelpDeksUser";

                axios.get(url,  {
                    headers:{Authorization: "Bearer " + this.$store.state.token}
                }).then(response =>{
                    //console.log(response.data, 'Respuesta');
                    this.Help_desks =response.data;
                }).catch(error => {
                    toastr.error('Ha ocurrido un error inesperado.', 'Mensaje del sistema');
                    console.log(error);
                })
            },

            getStateHelpDesk(state){
                if(state==1)
                    return 'Pendiente';
                else if (state==2)
                    return 'Respondido'
                else
                    return 'Cerrado';

            },
            viewHelpDesk(item){
                let url ="/api/editHelpDesk";
                axios.get(url, {
                    headers:{Authorization: "Bearer " + this.$store.state.token},
                    params:item
                }).then(response =>{
                    this.Helpdesk = response.data;
                    this.Help_desks_response = response.data.helpdesks;
                    $('#newRequest').modal('show');
                    //console.log(this.Help_desks_response, 'Response Desk');
                }).catch(error => {
                    console.log(error, 'error view help');
                })
            },
        },
        filters: {
            moment: function (date) {
                return moment(date).format('DD/MM/YYYY , h:mm:ss a');
            }
        },
    }
</script>

<style scoped>

</style>