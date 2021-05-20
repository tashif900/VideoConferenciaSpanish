<template>
    <div class="modal fade" id="modaldate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ingresar a la cita</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-black">
                    <div class="row text-center">
                        <div class="col-12">
                            <p>Escribe el código brindado por tu profesor para unirte a la cita</p>
                            <div class="form-group">
                                <input type="text" class="form-control-lg form-control-white text-center" v-model="code">
                                <button class="btn btn-custom-blue btn-rounded" type="button" @click="searchMeeting"><i class="ti-search"></i></button>
                            </div>
                            <small>Recuerda para entrar a una cita privada, deberás realizar un pago según lo establecido por el profesor.</small>
                        </div>
                    </div>
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
                            <button class="btn btn-custom-blue btn-rounded" v-if="status" @click="checkout">PAGAR</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "DateComponent",
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
            }
        },
        methods: {
            searchMeeting: function () {
                var urlThematic = '/api/search-meeting';
                axios.post(urlThematic,{code: this.code}).then(response => {
                    this.name = response.data.name;
                    this.instructor = response.data.user.name;
                    this.hour = moment(response.data.hour_start).format('DD-MM-YYYY HH:MM');
                    this.price = response.data.price;
                    this.room = response.data.room_id;
                    this.status = response.data.state == 1 ? true : response.data.state == 2 ? true : response.data.state == 3 ? false : false;
                    this.state = response.data.state == 1 ? 'Por Iniciar' : response.data.state == 2 ? 'Iniciado' : response.data.state == 3 ? 'Finalizado' : '-';
                });
            },
            checkout: function() {

                if (!this.name) {
                    toastr.warning('Debe de ingresar un código de cita válido :(');
                } else {
                    $('#modaldate').modal('hide');
                    this.$router.push({name: "paid"})
                }
            },
        }
    }
</script>

<style scoped>

</style>