<template>
    <div>
        <v-nav></v-nav>
        <div class="body-container">
            <information-component></information-component>
            <div class="container">
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card-white">
                            <div class="row">
                                <div class="col-12">
                                    <h4><strong>Adquiriendo:</strong> {{ plan }}</h4>
                                </div>
                                <div class="col-12">
                                    <div class="alert alert-warning" role="alert">
                                        Si estás realizando tu pago desde teléfono móvil recuerda que después de presionar “pagar” debes presionar el botón “launch in web” para tomar la sesión.
                                    </div>
                                </div>
                                <div class="col-12">
                                    <p><strong>Detalle de la Compra</strong></p>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead class="thead-light">
                                            <tr>
                                                <th scope="col">UND</th>
                                                <th scope="col">Descripción</th>
                                                <th scope="col">Monto</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <th scope="row">01</th>
                                                <td id="description">{{ plan }}</td>
                                                <td align="right">$ {{ price }}</td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td align="right"><strong>TOTAL</strong></td>
                                                <td align="right"><strong>$ {{ price }}</strong></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <p><strong>Forma de Pago</strong></p>
                                    <p>Elige un forma de pago</p>
                                    <!-- <form id="payment-form"> -->
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="customRadioInline1" @change="changePaymentType" v-model="typeMethod" value="1" name="customRadioInline1" class="custom-control-input payment-type" data-type="1" required>
                                            <label class="custom-control-label" for="customRadioInline1"><img src="/img/paypal-logo.png" width="120px"></label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="customRadioInline2" @change="changePaymentType" v-model="typeMethod" value="2" name="customRadioInline1" class="custom-control-input payment-type" data-type="2" required>
                                            <label class="custom-control-label" for="customRadioInline2"><img src="/img/cards.png" width="300px"></label>
                                        </div>
                                        <div class="custom-control custom-checkbox mt-4">
                                            <input type="checkbox" class="custom-control-input" v-model="condition" value="0" id="customCheck1" @change="aceptcondition" required>
                                            <label class="custom-control-label" for="customCheck1">Acepto <a href="#"> Términos y Condiciones</a> de la Transacción</label>
                                        </div>
                                        <div class="col-12 mt-4 pl-0 pr-0">
                                            <div class="alert alert-danger" role="alert">
                                                Si estás realizando tu pago desde teléfono móvil recuerda que después de presionar “pagar” debes presionar el botón “launch in web” para tomar la sesión.
                                            </div>
                                        </div>
                                        <div class="row justify-content-center my-4" id="card-container">
                                            <div class="col-12 col-md-7">
                                                <h6>Datos de tu Tarjeta de Crédito</h6>
                                                <form action="" method="POST" id="card-form">
                                                    <span class="card-errors alert-danger"></span>
                                                    <div class="row">
                                                        <div class="col-12 col-md-6">
                                                            <div class="form-group">
                                                                <label>Nombre del Titular</label>
                                                                <input type="text" size="20" class="form-control" data-conekta="card[name]" v-model="card.name" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-6">
                                                            <div class="row">
                                                                <div class="form-group col-md-6">
                                                                    <label>Código País</label>
                                                                    <select class="form-control" v-model="country">
                                                                        <option v-for="c in countries" :value="c.dial_code">{{c.dial_code}} - {{c.code}}</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label>Teléfono</label>
                                                                    <input type="text" size="20" class="form-control" data-conekta="card[phone]" v-model="card.phone" required>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12 col-md-6">
                                                            <div class="form-group">
                                                                <label>Número de tarjeta de crédito</label>
                                                                <input type="text" size="20" class="form-control" data-conekta="card[number]" v-model="card.number" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-6">
                                                            <div class="form-group">
                                                                <label>CVC</label>
                                                                <input type="password" size="4" class="form-control" data-conekta="card[cvc]" v-model="card.cvc" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12 col-md-6">
                                                            <div class="form-group">
                                                                <label>Fecha de expiración (MM/AAAA)</label>
                                                                <div class="row">
                                                                    <div class="col-6">
                                                                        <input type="text" size="2" class="form-control" data-conekta="card[exp_month]" v-model="card.exp_month" required>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <input type="text" size="4" class="form-control" data-conekta="card[exp_year]" v-model="card.exp_year" required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group text-center mt-4">
                                                        <button type="submit" @click="loadConekta()" id="cardPay" class="btn btn-dark">Pagar</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="form-group text-center mt-4">
                                            <button class="btn btn-dark" type="button" id="pay" @click="paid">Pagar</button>
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

    export default {
        name: "paide",
        components: {VFooter, VNav, CarouselComponent, InformationComponent},
        mounted() {
            this.getInformationPlan();
            this.getStatus();
            this.getCountries();
            // this.loadConekta();
            const script = document.createElement('script')
            script.src = 'https://cdn.conekta.io/js/latest/conekta.js'
            script.async = true
            document.body.appendChild(script)

            $('#card-container').hide();
        },
        data: function() {
            return {
                plan: null,
                id: null,
                description: null,
                price: null,
                typeMethod: null,
                condition: null,
                token: null,
                meeting: [],
                card: {
                    name: null,
                    number: null,
                    cvc: null,
                    exp_month: null,
                    exp_year: null,
                    phone: null,
                },
                country:'+52',
                countries:{
                  id:"",
                  name:"",
                  name_en:"",
                  dial_code:""

                },
                item: null,
                type: null,
            }
        },
        methods: {
            aceptcondition () {
                if (this.typeMethod == 2 && this.condition) {
                    $('#card-container').show();
                }else{
                    $('#card-container').hide();
                }

                if (this.condition===false){
                    toastr.info('Para continuar debe aceptar los Términos y Condiciones', 'Mensaje del Sistema');
                }
               // console.log(this.condition);
            },
            sendCard: function() {
                
            },
            getCountries (){
                let url ="/api/getCountries"
                axios.get(url).then(response =>{
                    //console.log(response.data, 'Paises')
                    this.countries = response.data;
                }).catch(error => {
                    console.log(error);
                })
            },
            goToPayment: function() {
                this.$router.push('/dashboard-payment');
            },
            loadConekta: function() {
                const self = this;
                if (this.typeMethod == null) {
                    toastr.warning('Debe de Seleccionar un método de Pago', 'Mensaje del sistema');
                    return;
                }

                if (this.condition){
                   // alert('Condition elegido' + this.condition);
                 //   console.log(this.condition, 'Condition');
                    if (this.card.name==null || this.card.number==null || this.card.cvc==null || this.card.exp_month==null
                        || this.card.exp_year ==null || this.card.phone == null) {
                        // alert('Hola')
                        toastr.warning('Debe de completar todos los campos', 'Mensaje del Sistema');
                    }else{
                        function run_waitMe(){
                            $('body').waitMe({
                                effect: 'orbit',
                                text: 'Procesando pago...',
                                bg: 'rgba(255,255,255,0.7)',
                                color:'#000'
                            });
                        }
                        run_waitMe();
                        if (this.typeMethod != null && this.condition != null) {
                            if (this.card.name != null && this.card.number != null && this.card.cvc != null &&
                                this.card.exp_month != null && this.card.exp_year != null && this.card.phone != null) {
                                window.Conekta.setPublicKey('key_T2hRwS8YwGywf7RxA9X72tA');
                                window.Conekta.setLanguage("es");

                                this.type = this.$route.query.type;

                                if (this.type == 1) {
                                    this.item = this.$route.query.plan;
                                } else if (this.type == 2) {
                                    this.item = this.$route.query.item;
                                } else if (this.type == 3) {
                                    this.item = this.$route.query.item;
                                } else if (this.type == 4) {
                                    this.item = this.$route.query.item;
                                }  else if (this.type == 5) {
                                    this.item = this.$route.query.item;
                                }

                                const access_token = this.$store.state.token;
                                const plan = this.item;
                                const type = this.type;
                                const cardName = this.card.name;
                                const phone = this.country + this.card.phone;


                                var conektaSuccessResponseHandler = function(token) {
                                    this.token = token.id;

                                    let url = '/api/payment-card-process';
                                    let params = {
                                        plan: plan,
                                        type: type,
                                        token: this.token,
                                        card: cardName,
                                        phone: phone,
                                    };
                                    let config = { headers: { 'Authorization': "Bearer " + access_token} }

                                    axios.post(url, params, config).then(response => {
                                        if (response.data) {
                                            $('body').waitMe('hide');
                                            toastr.success('Tu pago fue procesado con éxito', 'Mensaje del sistema');

                                            if (type == 1) {
                                                window.location.href = "/dashboard-payment";
                                            } else if (type == 2) {
                                                window.location.href = "/mis-clases";
                                            } else if (type == 3) {
                                                window.location.href = "/mis-cursos";
                                            } else if (type == 4) {
                                                //let start_end;
                                                let meet = self.meeting;
                                               // console.log(meet);
                                                if (meet.type_meeting == '1'){
                                                    let hour_start = moment(meet.hour_start).subtract(10, 'minutes').toDate()
                                                    let hora_actual = moment(new Date()).toDate();
                                                    let state = meet.state;

                                                    if (state==1 && (hour_start <= hora_actual))
                                                        window.location.href = "/meeting/" + meet.room_id + "/1";
                                                    else
                                                        window.location.href = "/dashboard-schedule";

                                                }else{
                                                    window.location.href = "/dashboard-schedule";
                                                }

                                            } else if (type == 5){
                                                window.location.href = "/dashboard-payment";
                                            }
                                        }
                                    });
                                };
                                var conektaErrorResponseHandler = function(response) {
                                  //  console.log(response, 'cokec');
                                    var $form = $("#card-form");
                                    $form.find(".card-errors").text('');
                                    $form.find(".card-errors").text(response.message_to_purchaser);
                                    $form.find("button").prop("disabled", false);
                                    $('body').waitMe('hide');
                                };

                                $("#card-form").submit(function(event) {
                                    event.preventDefault();
                                    var $form = $(this);

                                    // Previene hacer submit más de una vez
                                    $form.find("button").prop("disabled", true);
                                    Conekta.Token.create($form, conektaSuccessResponseHandler, conektaErrorResponseHandler);
                                   // console.log(this.card, 'form')
                                    return false;
                                });
                            } else {
                                toastr.warning('Debe de completar todos los datos de pago', 'Mensaje del sistema');
                            }
                        }
                    }
                }else{
                 //   console.log(this.condition, 'Condition');

                    toastr.warning('Debe de aceptar los Términos y Condiciones', 'Mensaje del Sistema');
                }


            },
            changePaymentType() {
                //alert(this.condition, 'Condicion');

                if (this.typeMethod == 2) {
                    if (this.condition!=true){
                        $('#cardPay').show();
                        $('#pay').hide();
                        toastr.info('Para continuar acepte los Términos y Condiciones', 'Mensaje del Sistema');
                    }else{
                        $('#card-container').show();
                    }
                    //alert('Conecta');
                    //$('#card-container').show();
                } else {
                    $('#pay').show();
                    $('#cardPay').hide();
                    $('#card-container').hide();
                    this.card.name = null;
                    this.card.number = null;
                    this.card.cvc = null;
                    this.card.exp_month = null;
                    this.card.exp_year = null;
                    this.card.token = null;
                }
            },
            getInformationPlan: function() {
                let config = { headers: { 'Authorization': "Bearer " + this.$store.state.token } }
                if (this.$route.query.type == 1) {
                    var url = '/api/get-plan-information';
                    let params = {
                        plan: this.$route.query.plan
                    };
    
                    axios.post(url, params, config).then(response => {
                        this.plan = response.data.name
                        this.id = response.data.id
                        this.description = response.data.description
                        if (response.data.promotion_start != null && response.data.promotion_start >= moment().format('YYYY-MM-DD') && moment().format('YYYY-MM-DD') <= response.data.promotion_end) {
                            this.price = response.data.promotional_price;
                        } else {
                            this.price = response.data.price;
                        }
                    });
                } else if (this.$route.query.type == 2) {
                    var url = '/api/get-class-information';
                    let params = {
                        id: this.$route.query.item
                    };

                    axios.post(url, params, config).then(response => {
                        this.plan = response.data.clase.name
                        this.id = response.data.clase.id
                        this.description = response.data.clase.description
                        if (response.data.clase.promotion_start != null && response.data.clase.promotion_start <= moment().format('YYYY-MM-DD') && moment().format('YYYY-MM-DD') <= response.data.clase.promotion_end) {
                            this.price = response.data.clase.promotional_price;
                            
                        } else {
                            this.price = response.data.clase.price;
                        }
                    });
                } else if (this.$route.query.type == 3) {
                    var url = '/api/get-course-information';
                    let params = {
                        id: this.$route.query.item
                    };

                    axios.post(url, params, config).then(response => {
                        this.plan = response.data.course.name
                        this.id = response.data.course.id
                        this.description = response.data.course.description
                        if (response.data.course.promotion_start != null && response.data.course.promotion_start <= moment().format('YYYY-MM-DD') && moment().format('YYYY-MM-DD') <= response.data.course.promotion_end) {
                            this.price = response.data.course.promotional_price;
                        } else {
                            this.price = response.data.course.price;
                        }
                    });
                } else if (this.$route.query.type == 4) {
                    let url = '/api/get-meeting-information';
                    let params = {
                        id: this.$route.query.item
                    };

                    axios.post(url, params, config).then(response => {
                       // console.log(response.data, 'Data entrante')
                        this.meeting = response.data
                    //    console.log (moment(this.meeting.hour_start).subtract(10, 'minutes').toDate(), 'Hora modificada');

                        this.plan = response.data.name
                        this.id = response.data.id
                        this.description = response.data.description
                        if (response.data.promotion_start != null
                            && response.data.promotion_start <= moment().format('YYYY-MM-DD')
                            && moment().format('YYYY-MM-DD') <= response.data.promotion_end) {
                            this.price = response.data.promotional_price;
                        } else {
                            this.price = response.data.price;
                        }
                    });
                } else if (this.$route.query.type == 5) {
                    var url = '/api/get-ad-information';
                    let params = {
                        id: this.$route.query.item
                    };

                    axios.post(url, params, config).then(response => {
                        this.plan = 'Plan anúnciate ' + response.data.description
                        this.id = response.data.id
                        this.description = 'Plan anúnciate ' + response.data.description
                        this.price = response.data.mount;
                    });
                }
            },
            paid: function() {
                if (this.typeMethod != null && this.condition){
                    if (this.typeMethod == 1) {
                        if (this.$route.query.type == 1) {
                            window.location.href = "/paypal/pay?id="+ this.$store.state.user.id +"&type=1&item=" + this.$route.query.plan;
                        } else if (this.$route.query.type == 2) {
                            window.location.href = "/paypal/pay?id="+ this.$store.state.user.id +"&type=2&item=" + this.$route.query.item;
                        } else if (this.$route.query.type == 3) {
                            window.location.href = "/paypal/pay?id="+ this.$store.state.user.id +"&type=3&item=" + this.$route.query.item;
                        } else if (this.$route.query.type == 4) {
                            window.location.href = "/paypal/pay?id="+ this.$store.state.user.id +"&type=4&item=" + this.$route.query.item;
                        }  else if (this.$route.query.type == 5) {
                            window.location.href = "/paypal/pay?id="+ this.$store.state.user.id +"&type=5&item=" + this.$route.query.item;
                        }
                    }
                } 

                if (this.typeMethod == null) {
                    toastr.warning('Debe de Seleccionar un método de Pago', 'Mensaje del sistema');
                }

                if (this.condition == null || this.condition == false) {
                    toastr.warning('Debe de aceptar los términos y condiciones', 'Mensaje del sistema');
                }
            },
            getStatus: function () {
                if (this.$route.query.status == 'error') {
                    toastr.error('No se pudo completar un pago intentelo nuevamente.', 'Mensaje del sistema');
                }
            }
            
        }
    }
</script>

<style scoped>

</style>