<template>
    <div class="container-fluid" style="padding: 0">
        <div class="container my-4">
            <div class="row justify-content-center">
                <div class="col-12 col-md-6">
                     <div class="form-group d-flex justify-content-center">
                        <input type="text" class="form-control-lg form-control-white text-center" v-model="code">
                     </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-6 col-md-12 d-flex justify-content-center">
                    <button class="btn btn-custom-blue" type="button" @click="searchMeeting">Entra a tu Sesión</button>
                </div>
            </div>
        </div>
        <div class="header-banner">
                <carousel v-if="ads.length>0" :autoplay="true" :nav="false" :touchDrag="true" :dots="false" :items="1">
                    <div class="row" v-for="ad in ads" style="margin-right: 0; margin-left: 0;">
                        <div class="col-12 header-banner-slide d-flex align-items-center" :style="'background: url('+ ad.image+ '); background-size: cover; background-repeat: no-repeat; background-position: center;'">
                            <div class="row copy-desktop" style="width: 100%">
                                <div class="col-12 col-md-6 col-lg-5 offset-7 d-flex align-items-center">
                                    <div class="copy">
                                        <h1>{{ ad.title }}</h1>
                                        <h5>{{ ad.description }}</h5>
                                        <a :href='ad.link' class="banner-btn">Mas Informacion</a>
                                        <!--<router-link :to="ad.link" class="banner-btn">Mas Informacion</router-link>-->
                                    </div>
                                </div>
                               <!-- <div class="col-12 col-md-6 header-banner-slide-image d-none d-md-block">
                                </div>-->
                            </div>
                        </div>
                        <div class="col-12 copy-mobile">
                            <div class="row">
                                <div class="col-12 d-flex align-items-center">
                                    <div class="copy">
                                        <h1>{{ ad.title }}</h1>
                                        <h5>{{ ad.description }}</h5>
                                        <a :href='ad.link' class="banner-btn">Mas Informacion</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </carousel>
                <div v-else>
                    <carousel :autoplay="true" :nav="false" :touchDrag="true" :dots="false" :items="1">
                        <div class="row" style="margin-right: 0; margin-left: 0;">
                            <div class="col-12 header-banner-slide d-flex align-items-center" :style="'background: url(/img/001.jpg); background-size: cover; background-repeat: no-repeat; background-position: center;'">
                                <div class="row copy-desktop" style="width: 100%">
                                    <div class="col-12 col-md-6 col-lg-5 offset-7 d-flex align-items-center">
                                        <div class="copy">
                                            <h1>Disfruta de nuestras clases online</h1>
                                            <h5>y nuestras promociones</h5>
                                            <a href="#" class="banner-btn">Mas Informacion</a>
                                        </div>
                                    </div>
                                    <!-- <div class="col-12 col-md-6 header-banner-slide-image d-none d-md-block">
                                        <img src="/img/banner.png" alt="">
                                    </div> -->
                                </div>
                            </div>
                            <div class="col-12 copy-mobile">
                                <div class="row">
                                    <div class="col-12 d-flex align-items-center">
                                        <div class="copy">
                                            <h1>Disfruta de nuestras clases online</h1>
                                            <h5>y nuestras promociones</h5>
                                            <a href="#" class="banner-btn">Mas Informacion</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-right: 0; margin-left: 0;">
                            <div class="col-12 header-banner-slide d-flex align-items-center" :style="'background: url(/img/002.jpg); background-size: cover; background-repeat: no-repeat; background-position: center;'">
                                <div class="row copy-desktop" style="width: 100%">
                                    <div class="col-12 col-md-6 col-lg-5 offset-7 d-flex align-items-center">
                                        <div class="copy">
                                            <h1>Disfruta de nuestras clases online</h1>
                                            <h5>y nuestras promociones</h5>
                                            <a href="#" class="banner-btn">Mas Informacion</a>
                                        </div>
                                    </div>
                                    <!-- <div class="col-12 col-md-6 header-banner-slide-image d-none d-md-block">
                                        <img src="/img/banner.png" alt="">
                                    </div> -->
                                </div>
                            </div>
                            <div class="col-12 copy-mobile">
                                <div class="row">
                                    <div class="col-12 d-flex align-items-center">
                                        <div class="copy">
                                            <h1>Disfruta de nuestras clases online</h1>
                                            <h5>y nuestras promociones</h5>
                                            <a href="#" class="banner-btn">Mas Informacion</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-right: 0; margin-left: 0;">
                            <div class="col-12 header-banner-slide d-flex align-items-center" :style="'background: url(/img/003.jpg); background-size: cover; background-repeat: no-repeat; background-position: center;'">
                                <div class="row copy-desktop" style="width: 100%">
                                    <div class="col-12 col-md-6 col-lg-5 offset-7 d-flex align-items-center">
                                        <div class="copy">
                                            <h1>Disfruta de nuestras clases online</h1>
                                            <h5>y nuestras promociones</h5>
                                            <a href="#" class="banner-btn">Mas Informacion</a>
                                        </div>
                                    </div>
                                    <!-- <div class="col-12 col-md-6 header-banner-slide-image d-none d-md-block">
                                        <img src="/img/banner.png" alt="">
                                    </div> -->
                                </div>
                            </div>
                            <div class="col-12 copy-mobile">
                                <div class="row">
                                    <div class="col-12 d-flex align-items-center">
                                        <div class="copy">
                                            <h1>Disfruta de nuestras clases online</h1>
                                            <h5>y nuestras promociones</h5>
                                            <a href="#" class="banner-btn">Mas Informacion</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-right: 0; margin-left: 0;">
                            <div class="col-12 header-banner-slide d-flex align-items-center" :style="'background: url(/img/004.jpg); background-size: cover; background-repeat: no-repeat; background-position: center;'">
                                <div class="row copy-desktop" style="width: 100%">
                                    <div class="col-12 col-md-6 col-lg-5 offset-7 d-flex align-items-center">
                                        <div class="copy">
                                            <h1>Disfruta de nuestras clases online</h1>
                                            <h5>y nuestras promociones</h5>
                                            <a href="#" class="banner-btn">Mas Informacion</a>
                                        </div>
                                    </div>
                                    <!-- <div class="col-12 col-md-6 header-banner-slide-image d-none d-md-block">
                                        <img src="/img/banner.png" alt="">
                                    </div> -->
                                </div>
                            </div>
                            <div class="col-12 copy-mobile">
                                <div class="row">
                                    <div class="col-12 d-flex align-items-center">
                                        <div class="copy">
                                            <h1>Disfruta de nuestras clases online</h1>
                                            <h5>y nuestras promociones</h5>
                                            <a href="#" class="banner-btn">Mas Informacion</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </carousel>
                </div>
        </div>
        <div class="modal fade" id="modaldate3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ingresar a la cita</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-black">
                        <!-- <div class="row text-center">
                            <div class="col-12">
                                <p>Escribe el código brindado por tu profesor para unirte a la cita</p>
                                <div class="form-group">
                                    <input type="text" class="form-control-lg form-control-white text-center" v-model="code">
                                    <button class="btn btn-custom-blue btn-rounded" type="button" @click="searchMeeting"><i class="ti-search"></i></button>
                                </div>
                                <small>Recuerda para entrar a una cita privada, deberás realizar un pago según lo establecido por el profesor.</small>
                            </div>
                        </div> -->
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
                                        <input type="text" class="form-control" id="cost" readonly v-model="price">
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
                                <button class="btn btn-custom-blue btn-rounded" v-if="hasPurchase" @click="checkout">PAGAR</button>
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
    import carousel from 'vue-owl-carousel'
    export default {
        components: {carousel},
        name: "CarouselComponent",
        mounted: function(){
            this.getAdvertisements();
        },
        data: function () {
            return {
                ads: [],
                code: null,
                name: null,
                instructor: null,
                hour: null,
                price: null,
                room: null,
                typemeeting: null,
                status: true,
                state: null,
                id: null,
                hasPurchase: true,
                can: false,
            }
        },
        methods: {
            async getAdvertisements() {
                let url = '/api/get-slider-item';
                let withscreen = screen.width;
                let heighscren = screen.height;

                /*if (withscreen <= 1099){
                    alert('Vamos bien');
                }*/
               // console.log(withscreen, 'pantalla', heighscren);

                await axios.post(url).then(response => {

                    let ads_temp = response.data

                    for (let i=0 ; i < ads_temp.length; i++){
                        if (withscreen < 1100 && ads_temp[i].image_movil !=null){
                            ads_temp[i].image = ads_temp[i].image_movil;
                        }
                    }
                    this.ads = ads_temp;

                    //this.$forceUpdate();
                 //   console.log(this.ads, 'Anuncios');
                }).catch(error =>{
                    console.log(error.response, 'Anuncios');
                });
            },

            searchMeeting: function () {
                var url = '/api/search-meeting';
                let config = null;
                if (this.islogin) {
                    var url = '/api/search-meeting-secure';
                    config = { headers: { 'Authorization': "Bearer " + this.$store.state.token } };
                }
                axios.post(url,{code: this.code}, config).then(response => {
                    let meeting = response.data
                //    console.log(meeting)
                    if (meeting){
                        if (this.islogin) {
                            meeting = response.data.meeting
                            this.hasPurchase = response.data.hasPurchase
                            this.can = response.data.can
                            this.typemeeting = meeting.type_meeting;
                        }
                        this.id = meeting.id;
                        this.name = meeting.name;

                        this.instructor = meeting.user.name;
                        this.hour = moment(meeting.hour_start).format('DD-MM-YYYY HH:MM');

                        //Validar precio promocional
                        let validate_price = response.data.val_promo_price;
                        //console.log(validate_price);
                        if (validate_price)
                            this.price = meeting.promotional_price;
                        else
                            this.price = meeting.price;
                        //Validar precio promocional

                        this.room = meeting.room_id;
                        this.status = meeting.state == 1 ? true : meeting.state == 2 ? true : meeting.state == 3 ? false : false;
                        this.state = meeting.state == 1 ? 'Por Iniciar' : meeting.state == 2 ? 'Iniciado' : meeting.state == 3 ? 'Finalizado' : '-';
                        $('#modaldate3').modal('show');
                    }else{
                        toastr.info('No se ha encontrado la sesión o ha finalizado', ":(");
                    }

                });

                 //
            },
            checkout: function() {
                if (!this.name) {
                    toastr.warning('Debe de ingresar un código de cita válido :(');
                } else {
                    $('#modaldate3').modal('hide');
                    if (this.can) {
                        let link = this.room;
                        let type = this.typemeeting;
                        if (type == 2){
                            this.$router.push('dashboard-schedule');
                        }else {
                            window.location.href = '/meeting/' + link + '/' + type
                        }

                    }else {
                        let url = '/paid?item=' + this.id + '&type=4';
                        if (!this.islogin) {
                            localStorage.setItem('prev_route', url);
                        }
                        this.$router.push(url);
                    }


                    // var url = '/paid?item=' + this.id + '&type=4';
                    // localStorage.setItem('access_token', token);
                    // this.$router.push(url);
                    // this.$router.push({name: "paid"})
                }
            },
        },
        computed:{
            islogin: function(){
                return this.$store.getters.loggedIn;
            },
        }
    }
</script>

<style scoped>
    .header-banner-slide {
        height: 500px;
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
    }
    @media (max-width: 992px) {
        .header-banner-slide {
            height: 300px;
        }

        /* .header-banner-slide .row div {
            padding-left: 100px !important;
            margin-left: 100px !important;
        } */
    }
</style>