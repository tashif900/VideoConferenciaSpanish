<template>
    <div>
        <v-nav></v-nav>
        <div class="body-container">
<!--            <carousel-component></carousel-component>-->
            <information-component></information-component>
            <div class="container-lg">
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card-white">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-12">
                                        <dasboard-link :income="true" ></dasboard-link>
                                        <div class="tab-content" id="nav-tabContent">
                                            <div class="tab-pane fade show active" id="nav-income" role="tabpanel" aria-labelledby="nav-income-tab">
                                                <form action="">
                                                    <div class="row mt-4">
                                                        <div class="col-12 col-md-3">
                                                            <div class="card card-colors">
                                                                <div class="card-header">
                                                                    Mes
                                                                </div>
                                                                <div class="card-body">
                                                                    <select name="periodo" @change="changePeriod" v-model="activityPeriod"  id="periodo" class="form-control">
                                                                        <option :value="period.period" v-for="period in periods" :key="period.period">{{ period.label }}</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="card card-colors mt-3">
                                                                <div class="card-header">
                                                                    Saldo Actual
                                                                </div>
                                                                <div class="card-body text-center">
                                                                    <p>$ {{ currentIncome }}</p>
                                                                </div>
                                                            </div>
                                                            <div class="card card-colors mt-3">
                                                                <div class="card-header">
                                                                    Último Retiro
                                                                </div>
                                                                <!--<div class="card-body text-center">
                                                                    <p>$ {{ lastRequest }}</p>
                                                                    <button v-if="canRequest && periodsP.length > 0" class="btn btn-custom-blue" @click="showIncomeModal" type="button" data-toggle="none" id="requestOutcome">Solicitar Retiro</button>
                                                                    <p v-else-if="periodsP.length == 0">No tienes Periodos facturables</p>
                                                                    <p v-else>Tiene una solicitud de pago pendiente. El desemblso se realizará durante los días  al  de todos los meses. Se le notificará por correo electrónico el estado de su solicitud.</p>
                                                                </div>-->
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-9">
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <h4>Retiros</h4>
                                                                </div>
                                                                <div class="col-12">
                                                                    <div class="table-responsive">
                                                                        <table class="table">
                                                                            <thead class="thead-dark">
                                                                            <tr>
                                                                                <th align="center">Fecha</th>
                                                                                <th align="center">Mes</th>
                                                                                <th align="center">Monto</th>
                                                                                <th align="center">Estado</th>
                                                                            </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <tr v-for="w in request" :key="w.id">
                                                                                    <td>{{ w.date }}</td>
                                                                                    <td>{{ w.period }}</td>
                                                                                    <td>{{ w.amount }}</td>
                                                                                    <td>{{ w.state }}</td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-3">
                                                            <div class="form-group row">
                                                                <label class="col-sm-8 col-form-label" style="text-align: center; font-weight: bold;">HABILITAR RETIRO</label>
                                                                <div class="col-sm-4">
                                                                    <input type="checkbox" class="form-control" v-model="enable_withdrawal" v-on:change="saveWithdrawal()" name="habretiro">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-9">
                                                            <div v-if="enable_withdrawal" class="alert alert-primary" role="alert">
                                                                Se habilito los depósitos a su cuenta que se realizarán todos los <strong>{{day_policie}} </strong>. Recuerda agregar tus Datos Bancarios en la ficha Métodos de Pago.
                                                                Y que el monto mínimo para recibir un depósito es de <strong>{{amount_policie}} Pesos.</strong>
                                                            </div>
                                                            <div v-else class="alert alert-danger" role="alert">
                                                                Los depósitos a su cuenta están deshabilitados. Si desea recibir sus pagos todos los <strong>{{day_policie}} </strong>debe habilitarlo.
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-3">
                                                        <div class="col-12">
                                                            <h4>Actividad</h4>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="table-responsive">
                                                                <table class="table" id="activityTable">
                                                                    <thead class="thead-dark">
                                                                    <tr>
                                                                        <th class="text-center">Curso/Clase/Sesión</th>
                                                                        <th class="text-center">Participantes</th>
                                                                        <th class="text-center">Monto</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr v-for="ac in activityClass">
                                                                            <td align="center">{{ ac.item }}</td>
                                                                            <td align="center">{{ ac.participants }}</td>
                                                                            <td align="right">$ {{ ac.mount }}</td>
                                                                        </tr>
                                                                        <tr v-for="acc in activityCourse">
                                                                            <td align="center">{{ acc.item }}</td>
                                                                            <td align="center">{{ acc.participants }}</td>
                                                                            <td align="right">$ {{ acc.mount }}</td>
                                                                        </tr>
                                                                        <tr v-for="am in activityMeeting">
                                                                            <td align="center">{{ am.item }}</td>
                                                                            <td align="center">{{ am.participants }}</td>
                                                                            <td align="right">$ {{ am.mount }}</td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="modal fade" id="modal-outcome" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Solicitar Retiro</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form action="" method="POST">
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="form-group mx-sm-3 mb-2">
                                                                    <label >Mes</label>
                                                                    <select name="period" id="period" v-model="rp" class="form-control" style="width: 300px">
                                                                        <option :value="p.period" v-for="p in periodsP" :key="p.period">{{ p.label }}</option>
                                                                    </select>
                                                                    <button type="button" class="btn btn-custom-red mb-2" id="addPeriod" @click="setPeriodRequest(rp)">Agregar</button>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <div class="form-group">
                                                                        <table class="table">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th scope="col">Mes</th>
                                                                                    <th scope="col">Monto</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <tr v-for="row in rowsRequest" :key="row.period">
                                                                                    <td>{{ row.period }}</td>
                                                                                    <td>{{ row.total }}</td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-rounded btn-secondary" data-dismiss="modal">Cerrar</button>
                                                            <button type="button" @click="sendRequest()" class="btn btn-rounded btn-yellow">Enviar</button>
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
    export default {
        components: {DasboardLink, VFooter, VNav, CarouselComponent, InformationComponent},
        name: "income.vue",
        mounted() {
            $('#requestOutcome').click(function() {
                $('#modal-outcome').modal('show');
            })
            this.getUser();
            this.getPeriods();
            this.canWithdraw();
            this.getRequest();
            this.getActivity();
            this.getLastRequest();
            this.getCurrentIncome();
            this.getPolicies();
        },
        data: function () {
            return {
                periods: [],
                canRequest: true,
                request: [],
                activity: [],
                periodsP: [],
                requestPeriods: [],
                rp: null,
                rowsRequest: [],
                lastRequest: 0.00,
                activityPeriod: moment().format('MM-YYYY'),
                currentIncome: 0.00,
                activityClass: [],
                activityCourse: [],
                activityMeeting: [],
                enable_withdrawal: 1,
                User_income: null,
                day_policie: "",
                amount_policie: ""

            }
        },
        methods: {
            async saveWithdrawal(){
              //alert('check change');
              //console.log(this.enable_withdrawal, 'Checked with');
                this.User_income.enable_withdrawal = this.enable_withdrawal;
                let url ="/api/updateWithdrawall";
               // console.log(this.User_income);

               await axios.post(url, this.User_income , {
                    headers:{Authorization: "Bearer " + this.$store.state.token}
                }).then(response =>{
                 //   console.log(response.data, 'Respuesta');
                    let user = response.data;
                    localStorage.setItem('user_login',JSON.stringify(user))
                    this.$store.commit('getUser', user)
                    //toastr.success('Se ha grabado correctamente', 'Mensaje del sistema');
                }).catch(error => {
                    //toastr.error('Ha ocurrido un error inesperado', 'Mensaje del sistema');
                    console.log(error);
                })
            },

            getPolicies (){
                let config = { headers: {'Authorization': "Bearer " + this.$store.state.token } };

                let url = '/api/getPolicies';

                axios.get(url, config).then(response => {
                    this.day_policie = response.data.start_day;
                    this.amount_policie = response.data.amount_max;

                   // console.log(response.data, 'Policies');
                }).catch(error => {
                    console.log(error.response, 'Error policies');
                });
            },
            getUser(){
                this.User_income = this.$store.state.user;
                this.enable_withdrawal= this.User_income.enable_withdrawal;
            },
            changePeriod() {
                this.getActivity();
                this.getCurrentIncome();
            },
            showIncomeModal() {
                $('#requestOutcome').click(function() {
                    $('#modal-outcome').modal('show');
                })
            },
            getPeriods: function() {
                let config = { headers: {'Authorization': "Bearer " + this.$store.state.token } };
                var url = '/api/get-user-periods';
                axios.post(url,{}, config).then(response => {
                    this.periods = response.data.all;
                    this.periodsP = response.data.periods;
                }).catch(error => {
                    this.classerrors = error.response.data
                });
            },
            canWithdraw: function() {
                let config = { headers: {'Authorization': "Bearer " + this.$store.state.token } };
                var url = '/api/can-withdraw';
                axios.post(url,{}, config).then(response => {
                    this.canRequest = response.data;
                }).catch(error => {
                    this.classerrors = error.response.data
                });
            },
            getRequest: function() {
                let config = { headers: {'Authorization': "Bearer " + this.$store.state.token } };
                var url = '/api/get-withdraw-requests';
                axios.post(url,{}, config).then(response => {
                    this.request = response.data;
                }).catch(error => {
                    this.classerrors = error.response.data
                });
            },
            getLastRequest: function() {
                let config = { headers: {'Authorization': "Bearer " + this.$store.state.token } };
                var url = '/api/get-last-request';
                axios.post(url,{}, config).then(response => {
                    this.lastRequest = response.data;
                }).catch(error => {
                    this.classerrors = error.response.data
                });
            },
            getCurrentIncome: function() {
                let config = { headers: {'Authorization': "Bearer " + this.$store.state.token } };
                var url = '/api/get-current-income';
                axios.post(url,{period: this.activityPeriod}, config).then(response => {
                    this.currentIncome = response.data;
                }).catch(error => {
                    this.classerrors = error.response.data
                });
            },
            getActivity: function() {
                let config = { headers: {'Authorization': "Bearer " + this.$store.state.token } };
                var url = '/api/get-activity-instructor';
                axios.post(url,{period: this.activityPeriod}, config).then(response => {
                    this.activityClass = response.data.clases;
                    this.activityCourse = response.data.course;
                    this.activityMeeting = response.data.meeting;

                }).catch(error => {
                    this.classerrors = error.response.data
                });
            },
            setPeriodRequest: function(period) {
                if (period != null) {
                    if (! this.requestPeriods.includes(period)) {
                        this.requestPeriods.push(period);
                        let config = { headers: {'Authorization': "Bearer " + this.$store.state.token } };
                        var url = '/api/get-request-period';
                        axios.post(url,{period: period}, config).then(response => {
                            this.rowsRequest.push(response.data[0])
                            console.log(this.rowsRequest)
                        }).catch(error => {
                            this.classerrors = error.response.data
                        });
                    } else {
                        toastr.warning('El periodo ya fue agregado', 'Mensaje del sistema');
                    }
    
                } else {
                    toastr.error('Periodo no valido', 'Mensaje del sistema');
                }
            },
            sendRequest: function() {
                let config = { headers: {'Authorization': "Bearer " + this.$store.state.token } };
                var url = '/api/store-payment-request';
                axios.post(url,{periods: this.requestPeriods}, config).then(response => {
                    if (response.data == true) {
                        $('#modal-outcome').modal('hide');
                        toastr.success('Se registro su solicitud de retiro. Se le notificara por email.', 'Mensaje del sistema');
                        this.canRequest = false;
                        this.getRequest();
                    }
                }).catch(error => {
                    this.classerrors = error.response.data
                });
            }
        },
    }
</script>

<style scoped>

</style>