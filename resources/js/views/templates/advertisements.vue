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
                                    <div class="col-12 mb-4 mt-4">
                                        <form action="">
                                            <fieldset>
                                                <legend class="title-red">{{titlewindow}}</legend>
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
                                                            <label>Tema</label>
                                                            <div class="row">
                                                                <div class="col-12 col-md-3">
                                                                    <label> <input type="radio" class="tema" @change="setThemeToAd" name="type" v-model="type" :value="1"> Mi Perfil</label>
                                                                </div>
                                                                <div class="col-12 col-md-3">
                                                                    <label> <input type="radio" class="tema" @change="setThemeToAd" name="type" v-model="type" :value="2"> Curso</label>
                                                                </div>
                                                                <div class="col-12 col-md-3">
                                                                    <label> <input type="radio" class="tema" @change="setThemeToAd" name="type" v-model="type" :value="3"> Clase</label>
                                                                </div>
                                                                <div class="col-12 col-md-3">
                                                                    <label> <input type="radio" class="tema" @change="setThemeToAd" name="type" v-model="type" :value="4"> Sesión</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-4">
                                                        <div class="col to-publish">
                                                            <div class="form-group">
                                                                <label>Selecciona el item a anunciar</label>
                                                                <select name="" v-model="item" class="form-control">
                                                                    <option v-for="d in items" :key="d.ud" :value="d.id">{{ d.name }}</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row mb-4">
                                                        <div class="col-12 col-md-6">
                                                            <label>Duración</label>
                                                            <select name="" id="duracion" class="form-control" @change="getVigency" v-model="vigency">
                                                                <option v-for="v in vigencies" :key="v.id" :value="v.id" :data-days="v.time" :data-price="v.mount">{{ v.description }}</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-12 col-md-6">
                                                            <strong>Vigencia</strong> {{ vigencyDays }} días<br>
                                                            <strong>Fecha de Inicio</strong> {{ startdate }} - <strong>Fecha de Termino</strong> {{ enddate }}
                                                        </div>
                                                    </div>
                                                    <div class="row mb-4">
                                                        <div class="col-md-6">
                                                            <label>Imagen de Banner Web</label>
                                                            <input type="file" ref="file" v-on:change="onFileChange" accept="image/*" class="form-control">
                                                            <small>Tamaño de Imagen: 1920 píxeles x 500 píxeles</small>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label>Imagen de Banner Móvil</label>
                                                            <input type="file" ref="file" v-on:change="onFileChange2" accept="image/*" class="form-control">
                                                            <small>Tamaño de Imagen: 900 píxeles x 500 píxeles</small>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-4">
                                                        <div class="col">
                                                            <label>Titulo</label>
                                                            <input type="text" v-model="title" class="form-control" maxlength="34">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-4">
                                                        <div class="col">
                                                            <label>Descripción Corta</label>
                                                            <textarea name="" id="" v-model="description" style="height: 75px;" class="form-control" maxlength="232"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <button class="btn btn-custom-red" type="button" @click="store">ANÚNCIATE</button>
                                                        </div>
                                                    </div>
                                                </form>
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
        <v-footer></v-footer>
    </div>


</template>

<script>
    import VNav from "../partials/v-nav";
    import VFooter from "../partials/v-footer";
    import CarouselComponent from "../../components/CarouselComponent";
    import InformationComponent from "../../components/InformationComponent";
    export default {
        components: {VFooter, VNav, CarouselComponent, InformationComponent},
        name: "advertisements",
        data: function() {
            return {
                advertisement_id: null,
                type: null,
                items: [],
                item: null,
                from: null,
                to: null,
                title: null,
                description: null,
                filePhoto: null,
                filePhotoMovil:null,
                errors: [],
                endDay: null,
                startDay: null,
                vigency: null,
                startdate: null,
                enddate: null,
                vigencyDays: null,
                vigencies: [],
                price: null,
                titlewindow: null,
                advertisement: {
                    type:"",
                    vigency:0
                },
            };
        },
        mounted: function() {
            $('.to-publish').hide();
            this.getVigencies();
            this.getLoadData();
            //this.getAdvertisement();
        },
        methods: {
            getLoadData(){
                let id = this.$route.params.id;

                if (typeof id === 'undefined'){
                    this.titlewindow= "ANÚNCIATE"
                }else{
                    this.advertisement_id = id;
                    this.getAdvertisement();

                    //this.getVigency();
                    //console.log(this.advertisement, 'Anuncios')
                }
            },
            async getAdvertisement (){
                let url = '/api/get-advertisement';
                let config = { headers: { 'Authorization': "Bearer " + this.$store.state.token }};
                await axios.post(url,{id: this.advertisement_id}, config).then(response => {
                    this.advertisement = response.data;
                    let status = this.advertisement.status;
                    if (status == '3'){
                        this.advertisement_id = this.advertisement.id;
                        this.vigencyDays = this.advertisement.prices_advertisements['time'];
                        //Recalculando tiempo
                        this.startdate = moment(moment().add('days', 1).format('DD-MM-YYYY'), 'DD-MM-YYYY').format('DD-MM-YYYY');
                        this.enddate = moment(this.startdate,'DD-MM-YYYY').add('days', this.vigencyDays).format('DD-MM-YYYY');
                        this.type = this.advertisement.type;
                        this.vigency = this.advertisement.prices_advertisements['id'];
                        this.title = this.advertisement.title;
                        this.description = this.advertisement.description;
                        this.titlewindow= "EDITANDO ANUNCIO";
                        this.filePhoto= "edit";
                        this.isEdit(true);
                   //     console.log(response.data, 'Anuncios');
                    }else{
                        toastr.info('No puedes editar este anuncio');
                        this.$router.push('/mis-anuncios');
                    }
                }).catch(error => {
                    console.log(error, 'Error')
                    this.advertisement = null;
                });
            },
            isEdit (result){
                $('.tema').attr('disabled', result);
                $('#duracion').attr('disabled', result);
            },
            getVigency(e) {
                if (e.target.options.selectedIndex > -1) {
                    const theTarget = e.target.options[e.target.options.selectedIndex].dataset;
                    let days = theTarget.days;
                    this.vigencyDays = days;
                    this.price = theTarget.price
                    this.startdate = moment(moment().add('days', 1).format('DD-MM-YYYY'), 'DD-MM-YYYY').format('DD-MM-YYYY');
                    this.enddate = moment(this.startdate,'DD-MM-YYYY').add('days', days).format('DD-MM-YYYY');
                }
            },
            setThemeToAd: function() {
                let url = '/api/get-to-publish';
                let config = { headers: { 'Authorization': "Bearer " + this.$store.state.token } }

                let data = {
                    type: this.type,
                }

                axios.post(url,data, config).then(response => {
                    this.items = response.data;
                }).catch(error =>{
                    console.log(error.response, 'Set');
                });

                if (this.type == 1) {
                    $('.to-publish').hide();
                } else {
                    $('.to-publish').show();
                }
                
            },
            getVigencies() {
                let url = '/api/get-vigencies';
                let config = { headers: { 'Authorization': "Bearer " + this.$store.state.token }};
                axios.post(url,{}, config).then(response => {
                    this.vigencies = response.data;
                 //   console.log(this.vigencies, 'Vigenses')
                });
            },
            onFileChange(e) {
                this.filePhoto = e.target.files[0];
            },

            onFileChange2(e) {
                this.filePhotoMovil = e.target.files[0];
            },


            store: function() { 
                let config = { headers: { 'Content-Type': 'multipart/form-data','Authorization': "Bearer " + this.$store.state.token } };
                if (this.title && this.description && this.vigency && this.filePhoto && this.filePhotoMovil) {
                    let formData = new FormData()
                        formData.append('id', this.advertisement_id);
                        formData.append('file', this.filePhoto);
                        formData.append('file_photo', this.filePhotoMovil);
                        formData.append('from', this.startdate);
                        formData.append('to', this.enddate);
                        formData.append('vigency', this.vigencyDays);
                        formData.append('prices_advertisement_id', this.vigency);
                        formData.append('description', this.description);
                        formData.append('type', this.type);
                        formData.append('item', this.item);
                        formData.append('title', this.title);
                        formData.append('price', this.price);
                    //console.log(formData, 'FormData');
                    let url = '/api/store-advertisement';
                    axios.post(url,formData, config).then(response => {
                        this.from = null
                        this.to = null
                        this.title = null
                        this.description = null
                        this.item = null
                        this.type = null
                        this.price = null
                        //console.log(response.data);
                        if (response.data.status === 0){
                            toastr.info('Se ha actualizado el anuncio correctamente. Espera su aprobación', 'Mensaje del Sistema');
                            this.$router.push('/mis-anuncios');
                        }else{
                            toastr.success('El anuncio ha sido creado y esta pendiente de Pago.', "Mensaje del Sistema");
                            let url = '/paid?item=' + this.vigency + '&type=5';
                            this.$router.push(url);
                        }
                    }).catch(error => {
                        console.log(error.response);
                        // this.errors = error.response.data
                    });
                }

                this.errors = [];

                if (!this.title) {
                    this.errors.push('El título del anuncio es obligatorio.');
                }
                if (!this.description) {
                    this.errors.push('La descripción es obligatoria.');
                }
                if (!this.vigency) {
                    this.errors.push('La duración es obligatoria.');
                }
                if (!this.filePhoto) {
                    this.errors.push('La imagen web es obligatoria.');
                }
                if (!this.filePhotoMovil) {
                    this.errors.push('La imagen movil es obligatoria.');
                }
            },
        }
    }
</script>

<style scoped>

</style>