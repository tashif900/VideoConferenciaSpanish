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
                                    <div class="col-12" id="cabecera_hiden">
                                        <dasboard-link></dasboard-link>
                                        <div class="col-12 mt-4">
                                            <form action="">
                                                <fieldset>
                                                    <legend>PROGRAMAR SESIÓN</legend>
                                                    <div class="row mb-4">
                                                        <div class="col-12">
                                                            <div class="alert alert-danger" v-if="errors != ''">
                                                                <ul>
                                                                    <li v-for="error in errors" :key="error">{{ error }}</li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <form action="" method="POST" enctype="multipart/form-data">
                                                        <div class="row mb-4">
                                                            <div class="col">
                                                                <label>Nombre de la Sesión (*)</label>
                                                                <input type="text" name="name" v-model="name" class="form-control" required>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-4">
                                                            <div class="col-12 col-md-6">
                                                                <label>Categoria (*)</label>
                                                                <select name="" id="" class="form-control" v-model="category">
                                                                    <option value="">Seleccione una Categoría</option>
                                                                    <option v-for="thematic in thematics" :key="thematic.id" :value="thematic.id">{{ thematic.name }}</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-12 col-md-6">
                                                                <label>Fecha (*)</label>
                                                                <div v-if="verificaBrowser==='Firefox' || verificaBrowser==='Safari'">
                                                                    <datetime format="YYYY-MM-DD H:i:s" class="form-control2"  v-model="start_hour" id="end_hour" name="start_hour"></datetime>
                                                                </div>
                                                                <div v-else>
                                                                    <input type="datetime-local" class="form-control" v-model="start_hour" id="start_hour" placeholder="" name="start_hour" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-4">
                                                            <div class="col">
                                                                <label>Descripción</label>
                                                                <textarea name="" id="" maxlength="1000" cols="30" rows="5" class="form-control" v-model="description"></textarea>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-4">
                                                            <div class="col-12 col-md-6">
                                                                <label>Tipo de Cita</label>
                                                                <select name="" class="form-control" id="" v-model="type" v-on:change="changeSession()">
                                                                    <option value="">Seleccione un Tipo de Sesión</option>
                                                                    <option value="1">Individual</option>
                                                                    <option value="2">Múltiple</option>
                                                                </select>
                                                            </div>
                                                            <!-- <div class="col-12 col-md-4">
                                                                <label># de Participantes</label>
                                                                <input type="text" class="form-control" v-model="participants" name="price" required>
                                                            </div> -->
                                                            <div class="col-12 col-md-6">
                                                                <label># de Sesiones</label>
                                                                <input type="text" v-on:keyup="constructDates()" name="number_class" v-model="sessions" class="form-control" placeholder="" required :disabled="validated == 1">
                                                            </div>
                                                        </div>
                                                        <div class="row mt-4" v-if="sessions >1">
                                                            <div class="col-12">
                                                                <div class="table-responsive">
                                                                    <table class="table table-striped">
                                                                        <thead class="thead-dark">
                                                                        <tr>
                                                                            <th scope="col">Sesión</th>
                                                                            <th scope="col">Fecha - Hora</th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        <tr v-for="item in dates" >

                                                                            <td>{{ item.session }}</td>

                                                                            <td v-if="verificaBrowser==='Firefox' || verificaBrowser==='Safari'">
                                                                                <datetime format="YYYY-MM-DD H:i:s" class="form-control2"  v-model="item.date" id="" name="start_hour"></datetime>
                                                                            </td>
                                                                            <td v-else>
                                                                                <input type="datetime-local" class="form-control" v-model="item.date">
                                                                            </td>
                                                                        </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-12 col-md-4">
                                                                <label>Precio (*)</label>
                                                                <input type="number" class="form-control" min="0" v-model="price"  placeholder="" name="price" required>
                                                            </div>
                                                            <div class="col-12 col-md-4">
                                                                <label>Descuento</label>
                                                                <div class="input-group mb-2">
                                                                    <input type="text" class="form-control" min="0" id="inlineFormInputGroup" @keyup="calculatePromotionalPrice" v-model="discount">
                                                                    <div class="input-group-prepend">
                                                                        <div class="input-group-text">%</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-md-4">
                                                                <label>Precio Promocional</label>
                                                                <input type="number" class="form-control" min="0"  v-model="promotionalPrice"  placeholder="" name="price" required>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col">
                                                                <label>Inicio Promoción</label>
                                                                <div v-if="verificaBrowser==='Safari'">
                                                                    <datetime format="YYYY-MM-DD" class="form-control2"  v-model="promotionStart"></datetime>
                                                                </div>
                                                                <div v-else>
                                                                    <input type="date" class="form-control dates" id="pend" v-model="promotionStart">
                                                                </div>

                                                            </div>
                                                            <div class="col">
                                                                <label>Fin Promoción</label>
                                                                <div v-if="verificaBrowser==='Safari'">
                                                                    <datetime format="YYYY-MM-DD" class="form-control2"  v-model="promotionStart"></datetime>
                                                                </div>
                                                                <div v-else>
                                                                    <input type="date" class="form-control dates" id="pstar" v-model="promotionEnd">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </fieldset>
                                                <fieldset>
                                                    <div id="title_inv">
                                                        <legend><strong>Invitar participantes (*)</strong></legend>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-12 col-md-5">
                                                            <input type="text" class="form-control" v-model="iName" placeholder="Nombre">
                                                        </div>
                                                        <div class="col-12 col-md-5">
                                                            <input type="text" class="form-control" v-model="iEmail" placeholder="Correo">
                                                        </div>
                                                        <div class="col-12 col-md-2">
                                                            <button class="btn btn-custom-blue" type="button" @click="addInvitation()"><i class="ti-plus"></i></button>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-4">
                                                        <div class="col-12">
                                                            <div class="table-responsive">
                                                                <table class="table table-striped">
                                                                    <thead class="thead-dark">
                                                                    <tr>
                                                                        <th scope="col">Nombres</th>
                                                                        <th scope="col">Correo Electronico</th>
                                                                        <th scope="col">*</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    <tr v-for="item in invitations" :key="item.name">
                                                                        <td>{{ item.name }}</td>
                                                                        <td>{{ item.email }}</td>
                                                                        <td><button class="btn btn-custom-blue tbbutton" type="button" @click="deleteParticipant(item)"><i class="ti-trash"></i></button></td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-4 justify-content-center">
                                                        <button class="btn btn-dark" type="button" @click="store">Guardar</button>
                                                    </div>
                                                </fieldset>
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
        <v-footer></v-footer>

         <div class="modal fade" id="invitationModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="invitationModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-4">
                        <div class="col text-center">
                            <h3 class="title-red">COPIA EL ENLACE SI QUIERES MANDARLO DIRECTAMENTE</h3>
                            <p>Si ingresaste un correo se auto enviará un correo al invitado</p>
                            <h5 class="title'blue">ENLACES</h5>

                            <p><strong>Codigo de Sesión:</strong> {{ codeResponse }}</p>

                            <div v-if="type==2">
                                <table  class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col">Session</th>
                                        <th scope="col">Enlace</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="item in thingToCopy" :key="item.name">
                                        <td>{{ item.name }}</td>
                                        <td>{{ item.room }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div v-else>
                                <h5 class="title'blue">ENLACE</h5>
                                <p>{{ thingToCopy }}</p>
                            </div>
                            <span class="btn btn-info text-white copy-btn ml-auto" @click.stop.prevent="copyTestingCode">Copiar Enlace</span>
                            <input type="hidden" id="testing-code" :value="thingToCopyH">
                            <!--<input v-else type="hidden" id="testing-code" :value="thingToCopy">-->

                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-custom-blue btn-rounded" @click="redirectTo()">Continuar</button>
                </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import VNav from "../partials/v-nav";
    import VFooter from "../partials/v-footer";
    import CarouselComponent from "../../components/CarouselComponent";
    import InformationComponent from "../../components/InformationComponent";
    import moment from 'moment';
    import DasboardLink from "../../components/DasboardLink";
    import datetime from 'vuejs-datetimepicker';
    import VueClipboard from 'vue-clipboard2';

    export default {
        components: {DasboardLink, VFooter, VNav, CarouselComponent, InformationComponent, datetime, VueClipboard},
        name: "schedulemeeting",
        mounted() {
            this.getThematic();
            this.today();

            document.getElementById("pstar").min = moment().format('YYYY-MM-DD');
            document.getElementById("pend").min = moment().format('YYYY-MM-DD');
            $("html, body").animate({ scrollTop: $("#cabecera_hiden").offset().top }, 1000);
        },
        data: function () {
            return {
                name: null,
                description: null,
                category: null,
                type: 2,
                participants: null,
                price: null,
                errors: [],
                start_hour: null,
                thematics: [],
                state: 1,
                sessions: null,

                iName: null,
                iEmail: null,
                invitations: [],
                copySucceeded: null,
                thingToCopy: [],
                thingToCopyH: null,

                discount: 0,
                promotionalPrice: null,
                promotionStart: null,
                promotionEnd: null,
                codeResponse: null,
                validated:0,
                dates:[]
            }
        },
        computed: {
            islogin: function(){
                return this.$store.getters.loggedIn;
            },

            deleteParticipant(item){
                this.invitations.splice(this.invitations.indexOf(item),1);
                //console.log(this.invitations);
                //alert('hola');
            },
            verificaBrowser (){
                let browser = '';
                let browserVersion = 0;

                if (/Opera[\/\s](\d+\.\d+)/.test(navigator.userAgent)) {
                    browser = 'Opera';
                } else if (/MSIE (\d+\.\d+);/.test(navigator.userAgent)) {
                    browser = 'MSIE';
                } else if (/Navigator[\/\s](\d+\.\d+)/.test(navigator.userAgent)) {
                    browser = 'Netscape';
                } else if (/Chrome[\/\s](\d+\.\d+)/.test(navigator.userAgent)) {
                    browser = 'Chrome';
                } else if (/Safari[\/\s](\d+\.\d+)/.test(navigator.userAgent)) {
                    browser = 'Safari';
                    /Version[\/\s](\d+\.\d+)/.test(navigator.userAgent);
                    browserVersion = new Number(RegExp.$1);
                } else if (/Firefox[\/\s](\d+\.\d+)/.test(navigator.userAgent)) {
                    browser = 'Firefox';
                }
                if(browserVersion === 0){
                    browserVersion = parseFloat(new Number(RegExp.$1));
                }
                return browser;
            }
        },
        methods: {
            changeSession : function(){
               if (this.type==1){
                   this.sessions=1;
                   this.validated=1;
               }else{
                   this.validated=0;
                   this.sessions=2;
               }
            },

            constructDates : function(){
                this.dates=[];
              if (this.type==2){
                  for (let x =1; x <= this.sessions; x++){
                      let date = {
                          session: 'Sesion N° ' + x,
                          date: ''
                      }
                      this.dates.push(date)
                  }
                 // console.log(this.dates);
              }
            },

            getThematic: function() {
                var urlThematic = '/api/get-thematics';
                axios.get(urlThematic).then(response => {
                    // console.log(response.data);
                    this.thematics = response.data
                });
            },
            today: function() {
                let today = moment().format('YYYY-MM-DDTHH:mm')
                $('#start_hour').val(today);
                this.start_hour = today;
                document.getElementById("start_hour").min = today;
                // document.getElementById("end_hour").min = this.start_hour;
            },
            store: function () {
                if (this.name && this.category && this.sessions && this.type && this.start_hour && this.price && this.invitations.length > 0) {
                    let url = '/api/store-meeting-sessions';
                    axios.post(url, {
                        name: this.name,
                        description: this.description,
                        category: this.category,
                        type: this.type,
                        participants: this.participants,
                        price: this.price,
                        discount: this.discount,
                        start_hour: this.start_hour,
                        user: this.$store.state.user.id,
                        invitations: this.invitations,
                        state: 1,
                        sessions: this.sessions,
                        promotional_price: this.promotionalPrice,
                        start_promotion: this.promotionStart,
                        end_promotion: this.promotionEnd,
                        dates: this.dates
                    }).then(response => {

                        this.name = '';
                        this.description = '';
                        this.categoty = '';
                        //this.type = '';
                        this.participants = '';
                        this.price = '';
                        this.discount = '';
                        this.end_hour = '',
                        this.invitations = [],
                        this.errors = [],
                        //this.sessions = '',

                        this.codeResponse = response.data.date.code

                        this.today();
                       // console.log(response.data.date, 'Respuesta Guardado');
                        if (response.data.date.type_meeting == '1'){
                            //alert('Que pasó aquí');
                            this.thingToCopy = 'https://www.zurviz.com/meeting/' + response.data.date.room_id + '/1';

                        }else{
                            this.thingToCopy = response.data.sessions;

                            let textocopiado="";
                            for (let i=0; i< this.thingToCopy.length; i++){
                                textocopiado = textocopiado + this.thingToCopy[i].room + '     \r\n'
                            }
                            this.thingToCopyH = textocopiado;
                          //  console.log(this.thingToCopy, 'Vamos ...')
                            //this.thingToCopyH = response.data.sessions[0].room;
                        }


                        $('#invitationModal').modal('show');

                        toastr.success('Se creó la cita correctamente', 'Mensaje del sistema');
                    }).catch(error => {
                        this.errors = error.response.data
                    });
                }


                this.errors = [];

                if (!this.name) {
                    this.errors.push('El nombre de la reunión es obligatorio.');
                }
                if (!this.category) {
                    this.errors.push('La descripción de la reunión es obligatoria.');
                }
                if (!this.sessions) {
                    this.errors.push('Debe asignar sesiones');
                }
/*                    this.errors.push('La descripción es obligatoria.');
                }*/
                if (!this.type) {
                    this.errors.push('El tipo de reunión obligatorio.');
                }
                if (!this.start_hour) {
                    this.errors.push('La hora de inicio es obligatoria.');
                }
                if (!this.price) {
                    this.errors.push('El precio obligatorio.');
                }

                if (this.invitations.length == 0) {
                    this.errors.push('Debe de agregar al menos un participante.');
                }

                if (this.errors.length > 0) {
                    this.scrollTop();
                }
            },
            scrollTop: function () {
                this.intervalId = setInterval(() => {
                    if (window.pageYOffset === 0) {
                    clearInterval(this.intervalId)
                    }
                    window.scroll(0, window.pageYOffset - 50)
                }, 20)
            },
            addInvitation: function () {
                if (this.iName != null && this.iEmail != null) {
                    if (this.validateEmail(this.iEmail)) {
                        var invitations = {
                            email: this.iEmail,
                            name: this.iName,
                        };
                        this.invitations.push(invitations)
                      //  console.log(this.invitations);
        
                        this.iEmail = null;
                        this.iName = null;
                    } else {
                        toastr.warning('El email del participante debe de ser válido.', 'Mensaje del sistema');
                    }
                } else {
                    toastr.warning('Debe de introducir el email y nombre del participante.', 'Mensaje del sistema');
                }
            },
            validateEmail(email) {
                const re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(email);
            },

            copyTestingCode () {


                let textToCopy = document.querySelector('#testing-code')

               // console.log (textToCopy, 'Texto copiado');

                textToCopy.setAttribute('type', 'text')
                textToCopy.select()

                try {
                    var successful = document.execCommand('copy');
                    var msg = successful ? 'successful' : 'unsuccessful';
                    toastr.success('Se copió el enlace al portapepeles', 'Mensaje del sistema');
                } catch (err) {
                    toastr.success('No se pudo copiar el enlace al portapapeles', 'Mensaje del sistema');
                }

                textToCopy.setAttribute('type', 'hidden')
                window.getSelection().removeAllRanges()


                    /*this.$copyText(textocopiado).then(function (e) {
                        alert('Copiado')
                        console.log(e)
                    }, function (e) {
                        alert('No copiado')
                        console.log(e)
                    })*/

            },
            redirectTo() {
                this.thingToCopy = null;
                
                $('#invitationModal').modal('hide');

                this.$router.push('/dashboard-schedule')
            },
            calculatePromotionalPrice() {
                let price = parseFloat(this.price);
                let discount = parseFloat(this.discount) / 100;

                this.promotionalPrice = (price - (price * discount)).toFixed(2);
            }
        }
    }
</script>

<style scoped>
    #title_inv{
        margin-top: 20px;
    }
</style>