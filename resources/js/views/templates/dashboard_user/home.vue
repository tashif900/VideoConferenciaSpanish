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
                                        <dasboard-link :home="true"></dasboard-link>
                                        <div class="tab-content" id="nav-tabContent">
                                            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                                <form action="">
                                                    <div class="row">
                                                        <div class="col-12 col-md-6 mt-4 justify-content-center">
                                                            <h2 class="title-red">entrar en una Sesión</h2>
                                                            <div class="form-group mt-4">
                                                                <input type="text" class="form-control-custom-purple mx-auto" v-model="code" placeholder="id de Sesión">
                                                            </div>
                                                            <div class="form-group text-center">
                                                                <button class="btn btn-custom-red" type="button" @click="searchMeeting">ENTRAR</button>
                                                            </div>

                                                        </div>
                                                        <div class="col-12 col-md-6 mt-4 justify-content-center home" v-if="isInstructor">
                                                            <h2 class="title-red">ANFITRIÓN</h2>
                                                            <div class="form-group mt-4">
                                                                <router-link to="meetingtype">
                                                                    <button class="btn btn-custom-purple mx-auto">CREAR UNA Sesión</button>
                                                                </router-link>
                                                            </div>
                                                            <div class="form-group mt-4">
                                                                <router-link to="findmeeting">
                                                                    <button class="btn btn-custom-purple mx-auto">tengo agendada una Sesión</button>
                                                                </router-link>

                                                            </div>
                                                            <div class="form-group mt-4">
                                                                <router-link to="/add-course">
                                                                    <button class="btn btn-custom-purple mx-auto">crear un curso</button>
                                                                </router-link>

                                                            </div>
                                                            <div class="form-group mt-4">
                                                                <router-link to="/add-class">
                                                                    <button class="btn btn-custom-purple mx-auto">CREAR UNA clase</button>
                                                                </router-link>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </form>
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
        <div class="modal fade" id="modaldate2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ingresar a la cita</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-black">
                        <div class="row mt-4">
                            <div class="col">
                                <div class="form-group row">
                                    <label for="room" class="col-sm-4 col-form-label">Nombre de la Sala:</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="room" readonly v-model="name">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="room" class="col-sm-4 col-form-label">Profesor:</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="instructor" readonly v-model="instructor">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="room" class="col-sm-4 col-form-label">Horario de Inicio:</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="hout" readonly v-model="hour">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="room" class="col-sm-4 col-form-label">Costo:</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="price" readonly v-model="price">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="room" class="col-sm-4 col-form-label">Estado:</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="price" readonly v-model="state">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row my-4">
                            <div class="col text-center">
                                <button class="btn btn-custom-red-outline btn-rounded" data-dismiss="modal">CANCELAR</button>
                                <button class="btn btn-custom-blue btn-rounded" v-if="purchase" @click="checkout">PAGAR</button>
                                <button class="btn btn-custom-blue btn-rounded" v-else-if="can" @click="checkout">ENTRAR</button>
                                <button class="btn btn-custom-blue btn-rounded" v-else @click="checkout">PAGAR</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import VNav from "../../partials/v-nav";
    import VFooter from "../../partials/v-footer";
    import CarouselComponent from "../../../components/CarouselComponent";
    import InformationComponent from "../../../components/InformationComponent";
    import DasboardLink from "../../../components/DasboardLink";

    export default {
        components: {DasboardLink, VFooter, VNav, CarouselComponent, InformationComponent},
        name: "home.vue",
        data: function () {
            return {
                code: null,
                name: null,
                instructor: null,
                hour: null,
                price: null,
                room: null,
                status: true,
                state: null,
                can: null,
                purchase: null,
                id: null,
                link: null,
            }
        },
        methods: {
            searchMeeting: function () {
                var url = '/api/search-meeting-secure';
                let config = { headers: { 'Authorization': "Bearer " + this.$store.state.token } };
                axios.post(url,{code: this.code}, config).then(response => {
                    this.name = response.data.meeting.name;
                    this.instructor = response.data.meeting.user.name;
                    this.hour = moment(response.data.meeting.hour_start).format('DD-MM-YYYY HH:MM');

                    let validate_price = response.data.val_promo_price;
                    //console.log(validate_price);
                    if (validate_price)
                        this.price = response.data.meeting.promotional_price;
                    else
                        this.price = response.data.meeting.price;

                    this.room = response.data.meeting.room_id;
                    this.status = response.data.meeting.state == 1 ? true : response.data.meeting.state == 2 ? true : response.data.meeting.state == 3 ? false : false;
                    this.state = response.data.meeting.state == 1 ? 'Por Iniciar' : response.data.meeting.state == 2 ? 'Iniciado' : response.data.meeting.state == 3 ? 'Finalizado' : '-';
                    this.can = response.data.can;
                    this.purchase = response.data.hasPurchase
                    this.id = response.data.meeting.id;
                    localStorage.room = this.room;

                    $('#modaldate2').modal('show');
                });
            },

            checkout: function() {
                $('#modaldate2').modal('hide');
                if (this.can) {
                    let link = this.room
                    window.location.href = '/meeting/' + link
                }
                var url = '/paid?item=' + this.id + '&type=4';

                this.$router.push(url);
            },
        },
        computed:{
            isInstructor (){
                return this.$store.state.user.roles[0].name == "Profesor";
            },
        }
    }
</script>

<style scoped>

</style>