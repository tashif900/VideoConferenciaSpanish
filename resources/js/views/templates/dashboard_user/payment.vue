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
                                        <dasboard-link :payment="true"></dasboard-link>
                                        <div class="tab-content" id="nav-tabContent">
                                            <div class="tab-pane fade show active" id="nav-payment" role="tabpanel" aria-labelledby="nav-payment-tab">
                                                <div class="row my-4">
                                                    <div class="col-12 col-md-6">
                                                        <h2 class="title-blue mb-4">Tus métodos de pago</h2>
                                                        <div v-for="p in paymentMethods" :key="p.id" class="card-white-item payments-user">
                                                            <div class="payments-user-img">
                                                                <img v-bind:src="p.payment_method.image" alt="">
                                                            </div>
                                                            {{ p.value }}
                                                        </div>
                                                        <div class="card-white-item payments-user">
                                                            <div class="payments-user-img">
                                                                <img src="/img/paypal.png" alt="">
                                                            </div>
                                                            <input type="text" class="form-control" v-model="paypalAccount" style="display: inline-block">
                                                            <button class="btn btn-custom-blue" @click="storePaypalAccount"><div class="ti-save"></div></button>
                                                        </div>

                                                        <div class="row" v-if="isInstructor">
                                                            <div class="col-12">
                                                                <h4 class="title-blue mb-4">Tus movimientos</h4>
                                                                <div class="table-responsive">
                                                                    <table class="table">
                                                                        <thead>
                                                                            <th>Fecha</th>
                                                                            <th>Descripción</th>
                                                                            <th>Operacion</th>
                                                                            <th>Monto</th>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr v-for="movement in movements" :key="movement.id">
                                                                                <td>{{ movement.date }}</td>
                                                                                <td>{{ movement.description }}</td>
                                                                                <td>{{ movement.operation }}</td>
                                                                                <td>$ {{ movement.amount }}</td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div  v-if="isInstructor" class="col-12 col-md-6">
                                                        <h2 class="title-blue mb-4">Tu cuenta para que te paguemos</h2>
                                                        <div class="payment-input-cont">
                                                            <label for="bank" class="payment-input-label">Banco</label>
                                                            <input v-model="Payment_account.bank"  type="text" class="payment-input-control" id="bank">
                                                        </div>
                                                        <div class="payment-input-cont">
                                                            <label for="clabe" class="payment-input-label">Clabe</label>
                                                            <input v-model="Payment_account.clabe"  type="text" class="payment-input-control" id="clabe">
                                                        </div>
                                                        <div class="payment-input-cont">
                                                            <label for="account" class="payment-input-label">N° de Cuenta</label>
                                                            <input v-model="Payment_account.number_account" type="text" class="payment-input-control" id="account">
                                                        </div>
                                                        <div class="payment-input-cont">
                                                            <label for="name" class="payment-input-label">Nombre Titular</label>
                                                            <input v-model="Payment_account.holder_name"  type="text" class="payment-input-control" id="name">
                                                        </div>
                                                        <div class="payment-input-cont">
                                                            <label for="lastname" class="payment-input-label">Apellido Titular</label>
                                                            <input v-model="Payment_account.holder_last_name" type="text" class="payment-input-control" id="lastname">
                                                        </div>
                                                        <div class="form-group text-center">
                                                            <button class="btn btn-custom-red" @click="savePaymentAccount">Guardar</button>
                                                        </div>
                                                    </div>
                                                    <div  v-if="!isInstructor" class="col-12 col-md-6">
                                                        <h2 class="title-blue mb-4">Tus movimientos</h2>
                                                        <div class="table-responsive">
                                                            <table class="table">
                                                                <thead>
                                                                    <th>Fecha</th>
                                                                    <th>Descripción</th>
                                                                    <th>Operacion</th>
                                                                    <th>Monto</th>
                                                                </thead>
                                                                <tbody>
                                                                    <tr v-for="movement in movements" :key="movement.id">
                                                                        <td>{{ movement.date }}</td>
                                                                        <td>{{ movement.description }}</td>
                                                                        <td>{{ movement.operation }}</td>
                                                                        <td>$ {{ movement.amount }}</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
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
        name: "profile.vue",
        data(){
            return {
                User : [],
                Payment_account: {},
                paymentMethods: [],
                paypalAccount: null,
                movements: []
            }
        },
        mounted() {
            this.getPayment();
            this.getLastPaymentMethods();
            this.getPaypalPayment();
            this.getMovements();
            this.afterPayment();
        },
        methods:{
            savePaymentAccount(){
                let url ="/api/updatePaymentAccount";
                axios.post(url, this.Payment_account , {
                    headers:{Authorization: "Bearer " + this.$store.state.token}
                }).then(response =>{
                    //console.log(response.data, 'Respuesta');
                    this.Payment_account = response.data;
                    this.User.payment_account = this.Payment_account;
                    localStorage.setItem('user_login',JSON.stringify(this.User))
                    this.$store.commit('getUser', this.User)
                    toastr.success('Se ha grabado correctamente', 'Mensaje del sistema');
                }).catch(error => {
                    toastr.error('Ha ocurrido un error inesperado :(', 'Mensaje del sistema');
                    console.log(error);
                })
            },
            getPayment(){
                this.User = this.$store.state.user;
                this.Payment_account = this.User.payment_account;
               // console.log(this.Payment_account, 'Payment');
            },
            getLastPaymentMethods() {
                let url ="/api/get-last-payment-methods";
                axios.post(url, {user: this.$store.state.user.id } , {
                    headers:{Authorization: "Bearer " + this.$store.state.token}
                }).then(response =>{
                    this.paymentMethods = response.data;
                }).catch(error => {
                    toastr.error('Ha ocurrido un error inesperado :(', 'Mensaje del sistema');
                    console.log(error);
                })
            },
            getPaypalPayment() {
                let url ="/api/get-paypal-payment-method";
                axios.post(url, {user: this.$store.state.user.id } , {
                    headers:{Authorization: "Bearer " + this.$store.state.token}
                }).then(response =>{
                    this.paypalAccount = response.data.value;
                }).catch(error => {
                    toastr.error('Ha ocurrido un error inesperado :(', 'Mensaje del sistema');
                    console.log(error);
                })
            },
            storePaypalAccount() {
                let url ="/api/get-paypal-payment-method-store";
                axios.post(url, {user: this.$store.state.user.id, account: this.paypalAccount } , {
                    headers:{Authorization: "Bearer " + this.$store.state.token}
                }).then(response =>{
                    if (response.data == true) {
                        toastr.success('Se actualizó su cuenta correctamente.', 'Mensaje del sistema');
                    }
                }).catch(error => {
                    toastr.error('Ha ocurrido un error inesperado', 'Mensaje del sistema', 'Mensaje del sistema');
                    console.log(error);
                })
            },
            getMovements() {
                let url ="/api/get-movements";
                axios.post(url, {user: this.$store.state.user.id } , {
                    headers:{Authorization: "Bearer " + this.$store.state.token}
                }).then(response =>{
                    this.movements = response.data;
                }).catch(error => {
                    toastr.error('Ha ocurrido un error inesperado :(');
                    console.log(error);
                })
            },
            afterPayment: function() {
                if (Object.entries(this.$route.query).length !== 0) {
                    if (this.$route.query.payment == '1' && this.$route.query.status == 'success') {
                        toastr.success('La compra de tu plan fue exitosa', 'Mensaje del sistema');
                    }
                }
            }
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