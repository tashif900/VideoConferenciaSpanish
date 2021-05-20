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
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <div class="alert alert-danger" v-if="classerrors != ''">
                                            <ul>
                                                <li v-for="error in classerrors" :key="error">{{ error }}</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <fieldset>
                                            <legend id="cabecera_hiden" >Nueva Clase</legend>
                                            <form action="" method="POST" enctype="multipart/form-data">
                                                <div class="row mb-4">
                                                    <div class="col">
                                                        <label>Nombre de la Clase</label>
                                                        <input type="text" name="name" class="form-control" v-model="className" placeholder="Nombre de la Clase" required>
                                                    </div>
                                                </div>
                                                <div class="row mb-4">
                                                    <div class="col">
                                                        <label>Descripción</label>
                                                        <textarea name="description" maxlength="1000" class="form-control" v-model="classDescription" placeholder="Descripción" required></textarea>
                                                    </div>
                                                </div>
                                                <div class="row mb-4">
                                                    <div class="col-12 col-md-4">
                                                        <label>Temática</label>
                                                        <select name="thematic" @change="getSubThemetic" class="form-control" v-model="cThematic" required>
                                                            <option value="">Seleccione una Temática</option>
                                                            <option v-for="thematic in thematics" :key="thematic.id" :value="thematic.id">{{ thematic.name }}</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-12 col-md-4">
                                                        <label>Sub-Tema</label>
                                                        <select name="thematic" class="form-control" v-model="cSubtopic" required>
                                                            <option value="">Seleccione un Sub Tema</option>
                                                            <option v-for="s in subthematics" :key="s.id" :value="s.id">{{ s.name }}</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-12 col-md-4">
                                                        <label>Tipo de Clase</label>
                                                        <select name="course_type" class="form-control" @change="stateDropzone" v-model="type" required>
                                                            <option value="0">Seleccione un Tipo de Curso</option>
                                                            <option value="1">Grabada</option>
                                                            <option value="2">Online</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row mb-4">
                                                    <div class="col-md-4">
                                                        <label>Hora de Inicio</label>
                                                        <div v-if="verificaBrowser==='Firefox' || verificaBrowser==='Safari'">
                                                            <datetime format="YYYY-MM-DD H:i:s" class="form-control2"  v-model="classStart" id="start_hour" name="start_hour"></datetime>
                                                        </div>
                                                        <div v-else>
                                                            <input type="datetime-local" class="form-control" id="star" v-model="classStart" placeholder="" name="start_hour" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Hora de Fin</label>
                                                        <div v-if="verificaBrowser==='Firefox' || verificaBrowser==='Safari'">
                                                            <datetime format="YYYY-MM-DD H:i:s" class="form-control2"  v-model="classEnd" id="start_hour" name="start_hour"></datetime>
                                                        </div>
                                                        <div v-else>
                                                            <input type="datetime-local" class="form-control" id="end" v-model="classEnd" placeholder="" name="start_hour" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Dificultad (1 al 5)</label>
                                                        <input type="number" class="form-control" max="5" min="1" v-model="difficulty" required>
                                                    </div>
                                                </div>
                                                <div class="row mb-4">
                                                    <div class="col-12 col-md-4">
                                                        <label>Precio</label>
                                                        <input type="number" min="1" step="0.01" class="form-control" v-model="price" @keyup="calculatePromotionalPrice"  placeholder="" name="price" required>
                                                    </div>
                                                    <div class="col-12 col-md-4">
                                                        <label>Descuento</label>
                                                        <div class="input-group mb-2">
                                                            <input type="number" class="form-control" min="1" step="0.01" id="inlineFormInputGroup" @keyup="calculatePromotionalPrice" v-model="discount">
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
                                                <div class="row mb-4">
                                                    <div class="col">
                                                        <label>Inicio Promoción</label>
                                                        <div v-if="verificaBrowser==='Safari'">
                                                            <datetime format="YYYY-MM-DD" class="form-control2" id="startP"  v-model="promotionStart"></datetime>
                                                        </div>
                                                        <div v-else>
                                                            <input type="date" class="form-control dates" id="startP" v-model="promotionStart">
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <label>Fin Promoción</label>
                                                        <div v-if="verificaBrowser==='Safari'">
                                                            <datetime format="YYYY-MM-DD" class="form-control2" id="endP"  v-model="promotionEnd"></datetime>
                                                        </div>
                                                        <div v-else>
                                                            <input type="date" class="form-control dates" id="endP" v-model="promotionEnd">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mb-4">
                                                    <div class="col-12">
                                                        <label>Imagen de Portada</label>
                                                        <input type="file" class="form-control" id="file" ref="file" v-on:change="onFileChange" accept="image/*" name="image" required>
                                                    </div>
                                                </div>
                                                <div class="row mb-4">
                                                    <div class="col-12">
                                                        <label>Previsualización de la Clase</label>
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                      <!--  <div class="mb-3">-->
                                                        <label><input @click="stateDropzonePreview(true)" type="radio" v-model="previewType" value="2" name="previewType"> Imagen(<small>La Imagen debe de tener 1901 x 500 pixeles de tamaño</small>)</label>
                                                        <input type="file" class="form-control" id="preview"  v-on:change="onFilePreview" accept="image/*" name="preview" required>
                                                    <!--</div>-->
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <label><input @click="stateDropzonePreview(false)" type="radio" v-model="previewType" value="1" name="previewType"> Video (<small>Tamaño máximo de archivo de video 500 MB. Tiempo máximo 30 segundos.</small> )</label>
                                                        <vue-dropzone
                                                                ref="myVueDropzone2"
                                                                id="dropzone2"
                                                                :options="dropzoneOptions"
                                                                :useCustomSlot="true"
                                                                v-on:vdropzone-success="uploadSuccessPreview"
                                                                v-on:vdropzone-error="uploadError"
                                                                v-on:vdropzone-removed-file="fileRemoved"
                                                        >
                                                            <div class="dropzone-custom-content">
                                                                <h3 class="dropzone-custom-title">Arrastra tu video o haz clic aquí</h3>
                                                                <div class="subtitle">Archivos Permitidos: videos max. 500 mb</div>
                                                            </div>
                                                        </vue-dropzone>
                                                    </div>
                                                </div>
                                                <div class="row mb-4">
                                                    <div class="col-12">
                                                        <label>Video de la clase</label>
                                                        <vue-dropzone
                                                            ref="myVueDropzone"
                                                            id="dropzone"
                                                            :options="dropzoneOptions"
                                                            :useCustomSlot="true"
                                                            v-on:vdropzone-success="uploadSuccess"
                                                            v-on:vdropzone-error="uploadError"
                                                            v-on:vdropzone-removed-file="fileRemoved"
                                                            >
                                                            <div class="dropzone-custom-content">
                                                                <h3 class="dropzone-custom-title">Arrastra tu video o haz clic aquí</h3>
                                                                <div class="subtitle">Archivos Permitidos: videos</div>
                                                            </div>
                                                        </vue-dropzone>
                                                    </div>
                                                </div>
                                                <div class="row mb-4 justify-content-center">
                                                    <button class="btn btn-dark" @click="storeClass" type="button">Guardar</button>
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
    import InformationComponent from "../../components/InformationComponent";

    import vue2Dropzone from "vue2-dropzone";
    import "vue2-dropzone/dist/vue2Dropzone.min.css";
    import datetime from 'vuejs-datetimepicker';
    let uuid = require("uuid");

    export default {
        name: "add-class",
        components: {VFooter, VNav, CarouselComponent, vueDropzone: vue2Dropzone, InformationComponent, datetime},
        mounted: function () {
            this.getThematic();
            document.getElementsByClassName('dates').min = moment().format('YYYY-MM-DD');
            document.getElementById('star').min = moment().format('YYYY-MM-DD') + 'T' + "00:00:00"
            document.getElementById('end').min = moment().format('YYYY-MM-DD') + 'T' + "00:00:00"
            document.getElementById('startP').min = moment().format('YYYY-MM-DD')

            $('#startP').change(function() {
                document.getElementById('endP').min = moment($('#startP').val()).format('YYYY-MM-DD');
            });
            $("html, body").animate({ scrollTop: $("#cabecera_hiden").offset().top }, 1000);
            this.$refs.myVueDropzone2.disable();
        },
        data: function () {
            return {
                thematics: [],
                dropzoneOptions: {
                    url: "/api/store/files",
                    maxFilesize: 2048,
                    addRemoveLinks: true,
                    maxFiles: 1,
                    thumbnailWidth: 150,
                    thumbnailHeight: 150,
                    acceptedFiles: "video/*",
                    dictDefaultMessage: `<p class='text-default'><i class='fa fa-cloud-upload mr-2'></i> Arrastra tu video o haz clic aquí</p>
                    <p class="form-text">Archivos Permitidos: *.mp4</p>
                    `,
                    headers: {
                        "X-CSRF-TOKEN": document.head.querySelector("[name=csrf-token]").content
                    },
                    timeout: 180000000,
                },
                fileName: null,
                className: null,
                classDescription: null,
                classStart: null,
                classEnd: null,
                classPassword: null,
                classUrl: null,
                classType: null,
                classerrors: [],
                classSubtopic: null,
                cThematic: null,
                price: null,
                type: null,
                photo: null,
                subthematics: [],
                cSubtopic: null,
                filePhoto: null,
                discount: 0,
                promotionalPrice: null,
                promotionStart: null,
                promotionEnd: null,
                validatePhoto: false,
                previewType: 2,
                filePreview: null,
                uidfilename: null,
                uidfilePreview: null,
                validatePreviewFile: false,
                verificador:0,
                difficulty:0
            }
        },
        methods: {
            uploadSuccessPreview(file, response){
                toastr.success('El video preview se subió correctamente', "Mensaje del Sistema");
               // console.log('Video preview cargado correctamente: ' + response.file);
                this.filePreview = response.file.preview;
                this.uidfilePreview = response.file.uid;
            },
            stateDropzonePreview (validate){
                if (validate){
                    this.$refs.myVueDropzone2.disable();
                    $('#preview').attr('disabled', false);
                }else{
                    this.$refs.myVueDropzone2.enable();
                    $('#preview').attr('disabled', true);
                }
            },
            stateDropzone() {
                if (this.type == '1') {
                    this.$refs.myVueDropzone.enable()
                    $('#star').attr('disabled', true);
                    $('#end').attr('disabled', true);
                } else if (this.type == '2') {
                    this.$refs.myVueDropzone.disable()
                    $('#star').attr('disabled', false);
                    $('#end').attr('disabled', false);
                } 
            },
            getThematic: function() {
                var urlThematic = '/api/get-thematics';
                axios.get(urlThematic).then(response => {
                    this.thematics = response.data
                });
            },
            uploadSuccess(file, response) {
                toastr.success('El video se subió correctamente', "Mensaje del Sistema");
               // console.log('File Successfully Uploaded with file name: ' + response.file);
                this.fileName = response.file.preview;
                this.uidfilename = response.file.uid;
            },
            uploadError(file, message) {
                console.log('An Error Occurred');
            },
            onFileChange(e) {
                this.filePhoto = e.target.files[0];

                // if (!(/\.(jpg|png|gif)$/i).test(this.filePhoto.name)) {
                //     this.classerrors.push('Archivo subido no es una imagen');
                //     return false
                // } else {
                //     var img = new Image();
                //     img.onload = function () {
                //         if (this.width.toFixed(0) < 1901 && this.height.toFixed(0) < 500) {
                //             this.classerrors.push('La Imagen debe de tener 1901 x 500 pixeles de tamaño');
                //         }
                //         else {
                //             this.validatePhoto = true;           
                //         }
                //     };
                //     img.src = URL.createObjectURL(this.filePhoto);
                // } 
            },
            onFilePreview(e) {
                this.filePreview = e.target.files[0];

                if (this.previewType == 1) {
                    if (e.target.files[0].size > 4500000) {
                        this.classerrors.push('El video debe de tener un tamaño máximo de 500 Mb.');
                        this.validatePreviewFile = true;
                    }
                } else {
                    this.validatePreviewFile = true;
                }

                // if (!(/\.(jpg|png|gif)$/i).test(this.filePhoto.name)) {
                //     this.classerrors.push('Archivo subido no es una imagen');
                //     return false
                // } else {
                //     var img = new Image();
                //     img.onload = function () {
                //         if (this.width.toFixed(0) < 1901 && this.height.toFixed(0) < 500) {
                //             this.classerrors.push('La Imagen debe de tener 1901 x 500 pixeles de tamaño');
                //         }
                //         else {
                //             this.validatePhoto = true;           
                //         }
                //     };
                //     img.src = URL.createObjectURL(this.filePhoto);
                // } 
            },
            fileRemoved() {},

            saveClass: function (){
                let config = { headers: { 'Content-Type': 'multipart/form-data','Authorization': "Bearer " + this.$store.state.token } }
                let formData = new FormData();
                formData.append('file', this.filePhoto);
                formData.append('name', this.className);
                formData.append('description', this.classDescription);
                formData.append('hour_start', this.classStart);
                formData.append('hour_end', this.classEnd);
                formData.append('photo', this.classEnd);
                formData.append('url_video', this.fileName);
                formData.append('url_room', this.uidfilename);
                formData.append('type_class', this.type);
                formData.append('thematic', this.cSubtopic);
                formData.append('state', 1);
                formData.append('user', this.$store.state.user.id);
                formData.append('price', this.price);
                formData.append('discount', this.discount);
                formData.append('promotional_price', this.promotionalPrice);
                formData.append('start_promotion', this.promotionStart);
                formData.append('end_promotion', this.promotionEnd);
                formData.append('filePreview', this.filePreview);
                formData.append('url_presentation', this.uidfilePreview)
                formData.append('previewType', this.previewType);
                formData.append('difficulty', this.difficulty);

                let url = '/api/store-class';
                axios.post(url,formData, config).then(response => {
              //      console.log(response);
                    toastr.success('Se creó la clase correctamente', "Mensaje del Sistema");

                    if (this.type==='1')
                        toastr.info('El video subido puede demorar unos instantes procesándose, por favor espere', "Mensaje del Sistema");

                    this.className = null,
                        this.classDescription = null,
                        this.classCourse = null,
                        this.classStart = null,
                        this.classEnd = null,
                        this.fileName = null,
                        this.type = null,
                        this.cThematic = '',
                        this.classerrors = [],
                        this.classUrl = null,
                        this.classPassword = null,
                        this.price = null,
                        this.discount = null

                    this.$refs.myVueDropzone.removeAllFiles()

                    this.$router.push('/mis-clases');
                }).catch(error => {
                    if (error.response.data.name[0] == 'El nombre de la clase no esta disponible.') {
                        this.classerrors.push('El nombre de la clase no esta disponible.');
                    } else {
                        this.classerrors.push(error.response.data);
                    }
                });
            },

            verificaClass: function (){
                this.classerrors = [];
                let verifica =false;
                if (this.type === '1'){
                    if (this.className && this.classDescription && this.cSubtopic && this.filePhoto && this.price && this.price >= 1 && this.difficulty
                        && this.difficulty>0 && this.difficulty<6 && this.fileName != null){
                        verifica = true;
                    }
                }else if(this.type==='2'){
                    if (this.className && this.classDescription && this.classStart && this.classEnd && this.cSubtopic && this.filePhoto && this.price && this.price >= 1 && this.difficulty
                        && this.difficulty>0 && this.difficulty<6 && this.fileName == null){
                        verifica = true;
                    }
                }

                if (verifica == false){
                    this.verificador=0;
                    if (!this.className) {
                        this.classerrors.push('El nombre de la clase es obligatorio.');
                        this.scrollTop()
                    }

                    if (!this.cSubtopic) {
                        this.classerrors.push('Elige un subtema de Clase');
                        this.scrollTop()
                    }

                    if (!this.filePhoto) {
                        this.classerrors.push('La foto de la clase es obligatoria.');
                        this.scrollTop()
                    }
                    if (!this.classDescription) {
                        this.classerrors.push('La descripción de la clase es obligatoria.');
                        this.scrollTop()
                    }
                    if (!this.classStart && this.type === '2') {
                        this.classerrors.push('La hora de inicio es obligatoria.');
                        this.scrollTop()
                    }
                    if (!this.classEnd && this.type === '2') {
                        this.classerrors.push('La hora de fin es obligatoria.');
                        this.scrollTop()
                    }
                    if (!this.type) {
                        this.classerrors.push('El tipo de clase obligatorio.');
                        this.scrollTop()
                    }
                    if (!this.price) {
                        this.classerrors.push('El precio de clase obligatorio.');
                        this.scrollTop()
                    }
                    if (this.price < 1) {
                        this.classerrors.push('El precio debe de ser mayor a 0.');
                        this.scrollTop()
                    }

                    if (!this.validatePhoto) {
                        this.classerrors.push('La Imagen debe de tener 1901 x 500 pixeles de tamaño');
                        this.scrollTop()
                    }

                    if(!this.difficulty){
                        this.classerrors.push('La dificultad es obligatoria');
                        this.scrollTop();
                    }

                    if (!(this.difficulty>0 && this.difficulty<6)){
                        this.classerrors.push("La dificultad debe estar entre 1 y 5");
                        this.scrollTop();
                    }

                    if (!this.type){
                        this.classerrors.push("Debe elegir un tipo de clase");
                        this.scrollTop();
                    }
                }
                return verifica;
            },
            storeClass: function() {
                if (this.verificaClass())
                    this.saveClass()
                else
                    toastr.warning('Ha ocurrido un error', 'Mensaje del Sistema')
            },
            scrollTop: function () {
                if (this.verificador === 0){
                    this.intervalId = setInterval(() => {
                        if (window.pageYOffset === 0) {
                            clearInterval(this.intervalId)
                        }
                        window.scroll(0, window.pageYOffset - 50)
                    }, 20)
                    this.verificador=1;
                }

            },
            getSubThemetic: function() {
                var url = '/api/get-sub-thematics?thematic=' + this.cThematic;
                axios.get(url).then(response => {
                    this.subthematics = [];
                    this.subthematics = response.data;
                });
            },
            handleFileUpload(){
                this.photo = this.$refs.file.files[0];
            },
            calculatePromotionalPrice() {
                let price = parseFloat(this.price);
                let discount = parseFloat(this.discount) / 100;

                this.promotionalPrice = (price - (price * discount)).toFixed(2);
            }
        },
        computed:{
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
        }
    }
</script>

<style scoped>
</style>