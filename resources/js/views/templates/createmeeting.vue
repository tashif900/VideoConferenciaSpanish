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
                                                    <legend>CITA INDIVIDUAL</legend>
                                                    <div class="row mb-4">
                                                        <div class="col-12">
                                                            <div class="">
                                                                <div v-for="(v, k) in errors" :key="k">
                                                                <span class="text-danger" v-for="error in v" :key="error">
                                                                    {{ error }}
                                                                </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <form action="" method="POST" enctype="multipart/form-data">
                                                        <div class="row mb-4">
                                                            <div class="col">
                                                                <label>Nombre de la Sala (*)</label>
                                                                <input id="name_sala" type="text" name="name" v-model="name" class="form-control" placeholder="Nombre de la sala" required>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-4">
                                                            <div class="col">
                                                                <label>Categoría (*)</label>
                                                                <select name="" id="" class="form-control" v-model="category">
                                                                    <option value="">Seleccione una Categoría</option>
                                                                    <option v-for="thematic in thematics" :key="thematic.id" :value="thematic.id">{{ thematic.name }}</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-4">
                                                            <div class="col">
                                                                <label>Descripción Corta</label>
                                                                <textarea name="" id="" maxlength="1000" class="form-control" v-model="description" placeholder="Descripción Corta"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-4">
                                                            <!--<div class="col">
                                                                <label>Tipo de Cita</label>
                                                                <select name="" class="form-control" id="" v-model="type" disabled>
                                                                    <option value="">Seleccione un Tipo de Sesión</option>
                                                                    <option value="1">Individual</option>
                                                                    <option value="2">Múltiple</option>
                                                                </select>
                                                            </div>-->
                                                            <!-- <div class="col">
                                                                <label>N° de Participantes</label>
                                                                <input type="text" class="form-control" v-model="participants" placeholder="" name="participant" required>
                                                            </div> -->
                                                        </div>
                                                        <div class="row">
                                                            <div class="col">
                                                                <label>Precio (*)</label>
                                                                <input type="number" class="form-control" v-model="price"  placeholder="" name="price" required>
                                                            </div>
                                                            <div class="col">
                                                                <label>Descuento</label>
                                                                <div class="input-group mb-2">
                                                                    <input type="text" class="form-control" id="inlineFormInputGroup" @keyup="calculatePromotionalPrice" v-model="discount">
                                                                    <div class="input-group-prepend">
                                                                        <div class="input-group-text">%</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <label>Precio Promocional</label>
                                                                <input type="number" class="form-control" v-model="promotionalPrice"  placeholder="" name="price" required>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col">
                                                                <label>Inicio Promoción</label>
                                                                <div v-if="verificaBrowser==='Safari'">
                                                                    <datetime format="YYYY-MM-DD" class="form-control2"  v-model="promotionStart"></datetime>
                                                                </div>
                                                                <div v-else>
                                                                    <input type="date" class="form-control dates" v-model="promotionStart">
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <label>Fin Promoción</label>
                                                                <div v-if="verificaBrowser==='Safari'">
                                                                    <datetime format="YYYY-MM-DD" class="form-control2"  v-model="promotionEnd"></datetime>
                                                                </div>
                                                                <div v-else>
                                                                    <input type="date" class="form-control dates" v-model="promotionEnd">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-4">
                                                            <div class="col">
                                                                <label>Hora de Inicio</label>
                                                                <div v-if="verificaBrowser==='Firefox' || verificaBrowser==='Safari'">
                                                                    <datetime format="YYYY-MM-DD H:i:s" class="form-control2"  v-model="start_hour" id="start_hour" name="start_hour"></datetime>
                                                                </div>
                                                                <div v-else>
                                                                    <input type="datetime-local" class="form-control" v-model="start_hour" placeholder="" id="start_hour" name="start_hour" required>
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <label>Hora de Termino</label>
                                                                <div v-if="verificaBrowser==='Firefox' || verificaBrowser==='Safari'">
                                                                    <datetime format="YYYY-MM-DD H:i:s" class="form-control2"  v-model="end_hour" id="end_hour" name="start_hour"></datetime>
                                                                </div>
                                                                <div v-else>
                                                                    <input type="datetime-local" class="form-control" v-model="end_hour" placeholder="" id="end_hour" name="end_hour" required>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </form>
                                                </fieldset>
                                                <fieldset>
                                                    <legend><strong>Invitar participantes (*)</strong></legend>
                                                    <div class="row">
                                                        <div class="col-12 col-md-5">
                                                            <input type="text" class="form-control" v-model="iName" placeholder="Escribe el nombre">
                                                        </div>
                                                        <div class="col-12 col-md-5">
                                                            <input type="text" class="form-control" v-model="iEmail" placeholder="Escribe el correo">
                                                        </div>
                                                        <div class="col-2 col-md-2">
                                                            <button class="btn btn-custom-blue" type="button" @click="addInvitation()"><i class="ti-plus"></i></button>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-4">
                                                        <div class="col-12">
                                                            <div class="table-responsive">
                                                                <table class="table table-striped" id="invitationTable">
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
            <div class="modal-dialog" role="document">
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
                            <h5 class="title'blue">CÓDIGO DE SESIÓN</h5>
                            <p>{{ code }}</p>
                            <h5 class="title'blue">ENLACE</h5>
                            <p>{{ thingToCopy }}</p>
                            <span class="btn btn-info text-white copy-btn ml-auto" @click.stop.prevent="copyTestingCode">Copiar Enlace</span>
                            <input type="hidden" id="testing-code" :value="thingToCopy">
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

    export default {
        components: {DasboardLink, VFooter, VNav, CarouselComponent, InformationComponent, datetime},
        name: "createmeeting",
        mounted() {
            this.getThematic();
            this.today();
            $("html, body").animate({ scrollTop: $("#cabecera_hiden").offset().top }, 1000);
        },
        created() {
            //this.getInitScroll();
        },
        data: function () {
            return {
                name: null,
                description: null,
                category: null,
                type: 1,
                participants: null,
                price: null,
                errors: [],
                start_hour: null,
                end_hour: null,
                thematics: [],
                state: 1,
                iName: null,
                iEmail: null,
                invitations: [],
                copySucceeded: null,
                thingToCopy: null,
                errorName: null,
                errorDescription: null,
                errorCategory: null,
                errorType: null,
                errorParticipants: null,
                errorPrice: null,
                discount: 0,
                promotionalPrice: null,
                promotionStart: null,
                promotionEnd: null,
                code: '',
            }
        },
        computed: {
            islogin: function(){
                return this.$store.getters.loggedIn;
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
            deleteParticipant(item){
                this.invitations.splice(this.invitations.indexOf(item),1);
                //console.log(this.invitations);
                //alert('hola');
            },
            getThematic: function() {
                let urlThematic = '/api/get-thematics';
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
                document.getElementById("end_hour").min = this.start_hour;
            },
            store: function () {
                let url = '/api/store-meeting';
                axios.post(url, {
                    name: this.name,
                    description: this.description,
                    category: this.category,
                    type: this.type,
                    participants: this.participants,
                    price: this.price,
                    start_hour: this.start_hour,
                    end_hour: this.end_hour,
                    user: this.$store.state.user.id,
                    discount: this.discount,
                    promotional_price: this.promotionalPrice,
                    start_promotion: this.promotionStart,
                    end_promotion: this.promotionEnd,
                    invitations: this.invitations,
                    state: 1,
                }).then(response => {
                    this.name = '';
                    this.description = '';
                    this.categoty = '';
                    this.type = '';
                    this.participants = '';
                    this.price = '';
                    this.end_hour = '',
                    this.invitations = [],
                    this.errors = [],
                    this.promotionalPrice = '',
                    this.promotionStart = '',
                    this.promotionEnd = '',
                    this.discount = 0;
                    this.today();

                    /*
                    * No hagan lo que está a continuación, solo fue para poder salir a producción rápido.
                    * Que AAAAASCOOO
                     */
                   // console.log(response.data, 'Create Meeting');
                    this.thingToCopy = 'https://www.zurviz.com/meeting/' + response.data.room_id + '/1';
                    this.code = response.data.code;

                    $('#invitationModal').modal('show');

                    toastr.success('Se creó la cita correctamente', "Mensaje del sistema");

                }).catch(error => {
                    this.errors = error.response.data
                    // this.errorName = error.response.data.error.name;
                    // this.errorDescription = error.response.data.error.description;
                    // this.errorCategory = error.response.data.error.category;
                    // this.errorType = error.response.data.error.type;
                    // this.errorParticipants = error.response.data.error.participants;
                    // this.errorPrice = error.response.data.error.price;
                });
            },
            addInvitation: function () {
              if (this.iEmail === '' || this.iName === '') {
                toastr.error('Debe llenar el email y el nombre', 'Mensaje del sistema');
              } else {
                let invitations = {
                  email: this.iEmail,
                  name: this.iName,
                };
                this.invitations.push(invitations)

                this.iEmail = '';
                this.iName = '';
              }
            },
            copyTestingCode () {
                let textToCopy = document.querySelector('#testing-code')
                textToCopy.setAttribute('type', 'text')   
                textToCopy.select()

                try {
                    var successful = document.execCommand('copy');
                    var msg = successful ? 'successful' : 'unsuccessful';
                    toastr.success('Se copió el enlace al portapepeles', "Mensaje del sistema");
                } catch (err) {
                    toastr.success('No se pudo copiar el enlace al portapapeles', "Mensaje del sistema");
                }

                textToCopy.setAttribute('type', 'hidden')
                window.getSelection().removeAllRanges()
            },
            redirectTo() {
                this.thingToCopy = null;
                $('#invitationModal').modal('hide');
                this.$router.push('/dashboard-schedule');
            },
            calculatePromotionalPrice() {
                let price = parseFloat(this.price);
                let discount = parseFloat(this.discount) / 100;

                this.promotionalPrice = (price - (price * discount)).toFixed(2);
            },
        }
    }
</script>

<style scoped>
    .tbbutton{
        font-size: 0.7rem !important;
    }
</style>