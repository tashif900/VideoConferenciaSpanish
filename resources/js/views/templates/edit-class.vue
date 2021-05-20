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
                                <div class="row">
                                    <div class="col-12">
                                        <!--Info-->
                                        <!--<div class="alert alert-success" role="alert">
                                        </div>
                                        <div class="alert alert-danger" role="alert">
                                        </div>-->
                                    </div>
                                </div>
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
                                            <legend>Editar Clase</legend>
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
                                                        <textarea name="description" class="form-control" v-model="classDescription" placeholder="Descripción" required></textarea>
                                                    </div>
                                                </div>
                                                <div class="row mb-4">
                                                    <div class="col">
                                                        <label>Temática</label>
                                                        <select name="thematic" @change="getSubThemetic" class="form-control" v-model="cThematic" required>
                                                            <option value="">Seleccione una Temática</option>
                                                            <option v-for="thematic in thematics" :key="thematic.id" :value="thematic.id">{{ thematic.name }}</option>
                                                        </select>
                                                    </div>
                                                    <div class="col">
                                                        <label>Sub-Tema</label>
                                                        <select name="thematic" class="form-control" v-model="cSubtopic" required>
                                                            <option value="">Seleccione un Sub Tema</option>
                                                            <option v-for="s in subthematics" :key="s.id" :value="s.id">{{ s.name }}</option>
                                                        </select>
                                                    </div>
                                                    <div class="col">
                                                        <label>Tipo de Clase</label>
                                                        <select name="course_type" class="form-control" @change="stateDropzone" v-model="type" required>
                                                            <option value="">Seleccione un Tipo de Curso</option>
                                                            <option value="1">Grabada</option>
                                                            <option value="2">Online</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row mb-4">
                                                    <div class="col">
                                                        <label>Hora de Inicio</label>
                                                        <input type="datetime-local" class="form-control" id="star" v-model="classStart" placeholder="" name="start_hour" required>
                                                    </div>
                                                    <div class="col">
                                                        <label>Hora de Fin</label>
                                                        <input type="datetime-local" class="form-control" id="end" v-model="classEnd" placeholder="" name="start_hour" required>
                                                    </div>
                                                    
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <label>Precio</label>
                                                        <input type="number" min="1" step="0.01" class="form-control" v-model="price" @keyup="calculatePromotionalPrice"  placeholder="" name="price" required>
                                                    </div>
                                                    <div class="col">
                                                        <label>Descuento</label>
                                                        <div class="input-group mb-2">
                                                            <input type="number" class="form-control" min="1" step="0.01" id="inlineFormInputGroup" @keyup="calculatePromotionalPrice" v-model="discount">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text">%</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <label>Precio Promocional</label>
                                                        <input type="number" min="1" step="0.01" class="form-control" v-model="promotionalPrice"  placeholder="" name="price" required>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <label>Inicio Promoción</label>
                                                        <input type="date" class="form-control dates" v-model="promotionStart">
                                                    </div>
                                                    <div class="col">
                                                        <label>Fin Promoción</label>
                                                        <input type="date" class="form-control dates" v-model="promotionEnd">
                                                    </div>
                                                </div>
                                                <div class="row mb-4">
                                                    <div class="col">
                                                        <label>Imagen</label>
                                                        <input type="file" class="form-control" id="file" ref="file" v-on:change="onFileChange" accept="image/*" name="image" required>
                                                    </div>
                                                </div>
                                                <div class="row mb-4">
                                                    <div class="col">
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
                                                                <div class="subtitle">Archivos Permitidos: *.mp4</div>
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
    let uuid = require("uuid");

    export default {
        name: "add-class",
        components: {VFooter, VNav, CarouselComponent, vueDropzone: vue2Dropzone, InformationComponent},
        mounted: function () {
            this.getThematic();
            this.prepare();

            document.getElementsByClassName('dates').min = moment().format('YYYY-MM-DD');
            document.getElementById('star').min = moment().format('YYYY-MM-DD') + 'T' + "00:00:00"
            document.getElementById('end').min = moment().format('YYYY-MM-DD') + 'T' + "00:00:00"
        },
        data: function () {
            return {
                thematics: [],
                dropzoneOptions: {
                    url: "/api/store/files",
                    addRemoveLinks: true,
                    maxFiles: 1,
                    thumbnailWidth: 150,
                    thumbnailHeight: 150,
                    acceptedFiles: ".mp4",
                    dictDefaultMessage: `<p class='text-default'><i class='fa fa-cloud-upload mr-2'></i> Arrastra tu video o haz clic aquí</p>
                    <p class="form-text">Archivos Permitidos: *.mp4</p>
                    `,
                    headers: {
                        "X-CSRF-TOKEN": document.head.querySelector("[name=csrf-token]").content
                    },
                    timeout: 180000000,
                },
                fileName: '',
                uidfileName:null,
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
                promotionEnd: null
            }
        },
        methods: {
            prepare: function () {
                let config = { headers: {'Authorization': "Bearer " + this.$store.state.token } };
                let id = this.$route.params.id;

                var url = '/api/prepare-class';
                axios.post(url, {id: id}, config).then(response => {
                //    console.log(response, 'ds');
                    this.className = response.data.name;
                    this.classDescription = response.data.description;
                    this.classStart = moment(response.data.hour_start).format('yyyy-MM-DDThh:mm');
                    this.classEnd = moment(response.data.hour_end).format('yyyy-MM-DDThh:mm');
                    this.fileName = null;
                    // this.type = respose.data.type_class;
                    // console.log(this.type, 'sd');
                    this.cThematic = response.data.subtopic.thematic.id;
                    this.price = response.data.price;
                    this.promotionalPrice = response.data.promotional_price;
                    this.promotionStart = moment(response.data.promotion_start).format('YYYY-MM-DD');
                    this.promotionEnd = moment(response.data.promotion_end).format('YYYY-MM-DD');
                    this.discount = response.data.discount;
                    this.getSubThemetic();
                    this.cSubtopic = response.data.subtopic_id;
                    this.type = response.data.type_class
                }).catch(error => {
                    // this.classerrors = error.response.data
                });   
            },
            stateDropzone() {
                if (this.type == '1') {
                    this.$refs.myVueDropzone.enable()
                } else if (this.type == '2') {
                    this.$refs.myVueDropzone.disable()
                } 
            },
            getThematic: function() {
                var urlThematic = '/api/get-thematics';
                axios.get(urlThematic).then(response => {
                    this.thematics = response.data
                });
            },
            getSubThemetic: function() {
                var url = '/api/get-sub-thematics?thematic=' + this.cThematic;
                axios.get(url).then(response => {
                    this.subthematics = [];
                    this.subthematics = response.data;
                });
            },
            uploadSuccess(file, response) {
                toastr.success('El video se subió correctamente', "Mensaje del sistema");
               // console.log('File Successfully Uploaded with file name: ' + response.file);
                this.fileName = response.file.preview;
                this.uidfileName = response.file.uid;

            },
            uploadError(file, message) {
               // console.log('An Error Occurred');
            },
            onFileChange(e) {
                this.filePhoto = e.target.files[0];
            },
            fileRemoved() {},
            storeClass: function() {
                if (this.className && this.classDescription && this.classStart && this.classEnd && this.type && this.cThematic && this.price && this.price >= 1) {
                    let config = { headers: { 'Content-Type': 'multipart/form-data','Authorization': "Bearer " + this.$store.state.token } }
                    let id = this.$route.params.id;

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
                    formData.append('classId', id);

                    var url = '/api/update-class';
                    axios.post(url,formData, config).then(response => {
                     //   console.log(response);
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

                        toastr.success('Se creó la clase correctamente', "Mensaje del sistema");

                        this.$router.push('/mis-clases');
                    }).catch(error => {
                        this.classerrors = error.response.data
                    });   
                }

                this.classerrors = [];

                if (!this.className) {
                    this.classerrors.push('El nombre de la clase es obligatorio.');
                }
                if (!this.filePhoto) {
                    this.classerrors.push('La foto de la clase es obligatoria.');
                }
                if (!this.classDescription) {
                    this.classerrors.push('La descripción de la clase es obligatoria.');
                }
                if (!this.classStart) {
                    this.classerrors.push('La hora de inicio es obligatoria.');
                }
                if (!this.classEnd) {
                    this.classerrors.push('La hora de fin es obligatoria.');
                }
                if (!this.type) {
                    this.classerrors.push('El tipo de clase obligatorio.');
                }
                if (!this.price) {
                    this.classerrors.push('El precio de clase obligatorio.');
                }
                if (this.price < 1) {
                    this.classerrors.push('El precio debe de ser mayor a 0.');
                }
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
        }
    }
</script>

<style scoped>
</style>