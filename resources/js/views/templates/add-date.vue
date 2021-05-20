<template>
    <div>
        <v-nav></v-nav>
        <div class="body-container">
            <!-- <carousel-component></carousel-component> -->
            <information-component v-if="isInstructor"></information-component>
            <div class="container">
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card-white">
                            <div class="container-fluid">
                                <!-- <div class="row">
                                     <div class="col-12">
                                         <div class="alert alert-success" role="alert">
                                         </div>
                                         <div class="alert alert-danger" role="alert">
                                         </div>
                                     </div>
                                 </div>-->
                                <div v-if="islogin">
                                    <div class="row">
                                        <div class="col-12">

                                            <!--<div class="alert alert-success" role="alert">

                                            </div>

                                            <div class="alert alert-danger" role="alert">

                                            </div>-->

                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <fieldset>
                                            <legend>NUEVA SESIÓN</legend>
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
                                                        <label>Nombre de la Sala</label>
                                                        <input type="text" name="name" v-model="name" class="form-control" placeholder="Nombre de la sala" required>
                                                    </div>
                                                </div>
                                                <div class="row mb-4">
                                                    <div class="col">
                                                        <label>Categoría</label>
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
                                                    <div class="col-12 col-md-6">
                                                        <label>Tipo de Sesión</label>
                                                        <select name="" class="form-control" id="" v-model="type">
                                                            <option value="">Seleccione un Tipo de Sesión</option>
                                                            <option value="1">Individual</option>
                                                            <option value="2">Múltiple</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <label>N° de Participantes</label>
                                                        <input type="text" class="form-control" v-model="participants" placeholder="" name="participant" required>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12 col-md-4">
                                                        <label>Precio</label>
                                                        <input type="number" min="0" step="0.01" class="form-control" v-model="price"  placeholder="" name="price" required>
                                                    </div>
                                                    <div class="col-12 col-md-4">
                                                        <label>Descuento</label>
                                                        <div class="input-group mb-2">
                                                            <input type="number" min="0" step="0.01" class="form-control" id="inlineFormInputGroup" @keyup="calculatePromotionalPrice" v-model="discount">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text">%</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-4">
                                                        <label>Precio Promocional</label>
                                                        <input type="number" min="1" step="0.01" class="form-control" v-model="promotionalPrice"  placeholder="" name="price" required>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <label>Inicio Promoción</label>
                                                        <input type="date" class="form-control dates" id="pstar" v-model="promotionStart">
                                                    </div>
                                                    <div class="col">
                                                        <label>Fin Promoción</label>
                                                        <input type="date" class="form-control dates" id="pend" v-model="promotionEnd">
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
                                                            <datetime format="YYYY-MM-DD H:i:s" class="form-control2"  v-model="end_hour" id="end_hour" name="end_hour"></datetime>
                                                        </div>
                                                        <div v-else>
                                                            <input type="datetime-local" class="form-control" v-model="end_hour" placeholder="" id="end_hour" name="end_hour" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mb-4">
                                                    <div class="col-12">
                                                        <button class="btn btn-custom-blue btn-rounded" type="button" @click="store()">Guardar</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </fieldset>
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
    import moment from 'moment';
    import InformationComponent from "../../components/InformationComponent";
    import datetime from 'vuejs-datetimepicker';

    export default {
        components: {VFooter, VNav, CarouselComponent,InformationComponent, datetime},
        mounted() {
            this.getThematic();
            this.today();

            document.getElementById("pstar").min = moment().format('YYYY-MM-DD');
            document.getElementById("pend").min = moment().format('YYYY-MM-DD');
        },
        data: function () {
            return {
                name: null,
                description: null,
                category: null,
                type: null,
                participants: null,
                price: null,
                errors: [],
                start_hour: null,
                end_hour: null,
                thematics: [],
                state: 1,
                discount: 0,
                promotionalPrice: null,
                promotionStart: null,
                promotionEnd: null
            }
        },
        computed: {
            islogin: function(){
                return this.$store.getters.loggedIn;
            },
            Category(){
                return this.$store.getters.getCategories;
            },
            isInstructor (){
                return this.$store.state.user.roles[0].name == "Profesor";
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
                document.getElementById("end_hour").min = this.start_hour;
            },
            store: function () {
                var url = '/api/store-date';
                axios.post(url, {
                    name: this.name,
                    description: this.description,
                    category: this.category,
                    type: this.type,
                    participants: this.participants,
                    price: this.price,
                    discount: this.discount,
                    start_hour: this.start_hour,
                    end_hour: this.end_hour,
                    user: this.$store.state.user.id,
                    promotional_price: this.promotionalPrice,
                    start_promotion: this.promotionStart,
                    end_promotion: this.promotionEnd,
                    state: 1,
                }).then(response => {
                    this.name = '';
                    this.description = '';
                    this.categoty = '';
                    this.type = '';
                    this.participants = '';
                    this.price = '';
                    this.discount = '';
                    this.end_hour = '',
                    this.errors = [],
                    this.promotionalPrice = '',
                    this.promotionStart = '',
                    this.promotionEnd = '',
                    this.discount = 0,

                    this.today();
                    this.$router.push('/dashboard-schedule')

                    toastr.success('Se creó la cita correctamente', "Mensaje del Sistema");
                }).catch(error => {
                    this.errors = error.response.data
                });
            },
            calculatePromotionalPrice() {
                let price = parseFloat(this.price);
                let discount = parseFloat(this.discount) / 100;

                this.promotionalPrice = (price - (price * discount)).toFixed(2);
            }
        },
    }
</script>

<style scoped>

</style>