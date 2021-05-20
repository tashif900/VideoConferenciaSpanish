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
                                    <dasboard-user></dasboard-user>
                                    <div class="col-12">
                                        <div class="row find-date my-4">
                                            <div class="col-12 col-md-6 find-date-leftside py-2 ">
                                                <div class="row d-flex align-items-center" style="height: 100%">
                                                    <div class="col-12">
                                                        <h4 class="text-center mb-4"><strong>Encontrar Cita</strong></h4>

                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-10"><input type="text" placeholder="Ingresa el Código de tu cita" v-model="code" class="form-control transparent"></div>
                                                                <div class="col-2"><button class="btn btn-custom-blue btn-rounded" type="button" @click="searchMeeting"><i class="ti-search"></i></button></div>
                                                            </div>
                                                        </div>

                                                        <hr class="my-4" style="border-top: 1px solid #fff;">

                                                        <div class="form-group">
                                                            <input type="text" placeholder="Fecha de la cita" v-model="hour" class="form-control text-white transparent" readonly>
                                                        </div>
                                                        <div class="form-group">
                                                            <input type="text" placeholder="La cita es con" v-model="instructor" class="form-control transparent" readonly>
                                                        </div>
                                                        <div class="form-group">
                                                            <input type="text" placeholder="Enlace a la Cita" v-model="link" class="form-control transparent" readonly>
                                                        </div>
                                                        <div class="form-group">
                                                            <button class="btn btn-custom-red btn-rounded" @click="checkout">ENTRAR</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 find-date-rightside"></div>
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
    import DasboardUser from "../../components/DasboardUser";
    export default {
        components: {DasboardUser, VFooter, VNav, CarouselComponent, InformationComponent},
        name: "findmeeting",
        data: function () {
            return {
                code: null,
                name: null,
                instructor: null,
                hour: null,
                price: null,
                room: null,
                link: null,
                isToday: null,
                can: false,
                id: null,
            }
        },
        methods: {
            searchMeeting: function () {
                if (!this.code) {
                    toastr.error('Debe de ingresar un código válido', "Mensaje del sistema");
                } else {
                    let config = { headers: { 'Authorization': "Bearer " + this.$store.state.token } };

                    var url = '/api/search-meeting-secure';
                    axios.post(url,{code: this.code}, config).then(response => {
                      //  console.log(response);
                        if (response.data == false) {
                            toastr.info('Cita no encontrada', "Mensaje del sistema");
                        } else {
                            this.id = response.data.meeting.id;
                            this.name = response.data.meeting.name;
                            this.instructor = response.data.meeting.user.name;
                            this.hour = moment(response.data.meeting.hour_start).format('DD-MM-YYYY HH:MM');
                            this.price = response.data.meeting.price;
                            this.room = response.data.meeting.room_id;

                            if (response.data.can) {
                                this.can = true;
                            }

                            this.link = '/meeting/' + this.room;
        
                            if (moment().format('DD-MM-YYYY HH:MM') < moment(response.data.hour_start).format('DD-MM-YYYY HH:MM')) {
                                this.isToday = false;
                            }
                        }
                    });
                }
            },
            checkout: function() {
                if (this.can) {
                    let link = this.link
                    window.location.href = link
                }
                var url = '/paid?item=' + this.id + '&type=4';
                this.$router.push(url);
            },
        }
    }
</script>

<style scoped>

</style>