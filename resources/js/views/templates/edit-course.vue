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
                                        <div class="alert alert-danger" v-if="errors != ''">
                                            <ul>
                                                <li v-for="error in errors" :key="error">{{ error }}</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <fieldset>
                                            <legend>Editar Curso</legend>
                                            <form action="" method="POST" enctype="multipart/form-data">
                                                <div class="row mb-4">
                                                    <div class="col">
                                                        <label>Nombre del Curso</label>
                                                        <input type="text" name="name" class="form-control" v-model="name" placeholder="Nombre del Curso" required>
                                                    </div>
                                                </div>
                                                <div class="row mb-4">
                                                    <div class="col">
                                                        <label>Descripción</label>
                                                        <input type="text" name="description" class="form-control" v-model="description" placeholder="Descripción" required>
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
                                                        <label>Tipo de  Curso</label>
                                                        <select name="course_type" class="form-control" v-model="type" required>
                                                            <option value="">Seleccione un Tipo de Curso</option>
                                                            <option value="1">Grabada</option>
                                                            <option value="2">Online</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row mb-4">
                                                    <div class="col">
                                                        <label># de Clases</label>
                                                        <input type="text" name="number_class" class="form-control" placeholder="" v-model="numberClass" required>
                                                    </div>
                                                    <div class="col">
                                                        <label>Precio Original</label>
                                                        <input type="number" step="0.01" min="1" class="form-control" placeholder="Precio"  @keyup="calculatePromotionalPrice" v-model="price" name="price" required>
                                                    </div>
                                                    <div class="col">
                                                        <label>Descuento</label>
                                                        <div class="input-group mb-2">
                                                            <input type="number" min="1" step="0.01" class="form-control" id="inlineFormInputGroup" @keyup="calculatePromotionalPrice" v-model="discount">
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
                                                        <input type="date" class="form-control dates" id="pstar" v-model="promotionStart">
                                                    </div>
                                                    <div class="col">
                                                        <label>Fin Promoción</label>
                                                        <input type="date" class="form-control dates" id="pend" v-model="promotionEnd">
                                                    </div>
                                                </div>
                                                <div class="row mb-4">
                                                    <div class="col">
                                                        <label>Fecha de Inicio</label>
                                                        <input type="date" class="form-control" placeholder="" v-model="start_hour" name="start_hour" id="courseStart" required>
                                                    </div>
                                                    <div class="col">
                                                        <label>Imagen de Portada</label>
                                                        <input type="file" class="form-control" id="file" ref="file" v-on:change="onFileChange" accept="image/*" name="image" required>
                                                    </div>
                                                </div>
                                              <div class="row mb-4">
                                                <div class="col-12">
                                                  <label>Previsualización del Curso</label>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                  <!--<div class="mb-3">-->
                                                  <label><input type="radio" @click="stateDropzone(true)"  v-model="previewType" value="2" name="previewType"> Imagen (<small>La Imagen debe de tener 1901 x 500 pixeles de tamaño</small>)</label>
                                                  <input type="file" class="form-control" id="preview" v-on:change="onFilePreview" accept="image/*" name="preview" required>
                                                  <!--</div>-->
                                                  <!--<label><input type="radio" v-model="previewType" value="1" name="previewType"> Video (<small>(Tamaño máximo de archivo de video 500 MB. Tiempo máximo 30 segundos. )</small> )</label>-->
                                                </div>
                                                <div class="col-12 col-md-6">
                                                  <label><input @click="stateDropzone(false)" type="radio" v-model="previewType" value="1" name="previewType"> Video <small>(Tamaño máximo de archivo de video 500 MB. Tiempo máximo 30 segundos. )</small> </label>
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
                                                <div class="row mb-4 justify-content-center">
                                                    <button class="btn btn-dark" @click="store" type="button">Guardar</button>
                                                </div>
                                            </form>
                                        </fieldset>
                                        <fieldset>
                                            <legend>Clases del Curso</legend>
                                            <button class="btn btn-custom-blue"  data-toggle="modal" @click="addClass">Agregar Clase</button>
                                            <div class="table-responsive mt-4">
                                                <table class="table">
                                                    <thead class="thead-dark">
                                                    <tr>
                                                        <!-- <th scope="col">Fecha</th> -->
                                                        <th scope="col">Nombre de la Clase</th>
                                                        <th scope="col">Modo</th>
                                                        <!-- <th scope="col"># de Participantes</th> -->
                                                        <th scope="col">Opciones</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="course in classes" :key="course.id">
                                                            <!-- <td>{{ course.s }}</td> -->
                                                            <td>{{ course.name }}</td>
                                                            <td>{{ course.type_class == 1? 'Grabada' : 'Online' }}</td>
                                                            <!-- <td>{{ course.participants }}</td> -->
                                                            <td><button class="btn btn-warning btn-sm" @click="edit(course)">Editar</button></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">Agregar Clase</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="" enctype="multipart/form-data" method="POST">
                                <div class="modal-body">
                                    <fieldset>
                                        <legend>Datos Generales</legend>
                                        <div class="row mb-4">
                                            <div class="col-12">
                                                <div class="alert alert-danger" v-if="classerrors != ''">
                                                    <ul>
                                                        <li v-for="error in classerrors" :key="error">{{ error }}</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col">
                                                <label>Curso</label>
                                                <select name="course" v-model="classCourse" @change="selectCourseClass($event)" id="course" class="form-control" disabled required>
                                                    <option value="">Seleccione un Curso</option>
                                                    <option v-for="course in courses" :key="course.id" :value="course.id"
                                                            :data-date="course.start_date"
                                                            :data-clase="course.number_class"
                                                            :data-type="course.type_course" :data-can="course.canCreateClass">{{ course.name }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col">
                                                <label>Nombre</label>
                                                <input type="text" class="form-control" v-model="className" name="name" placeholder="Nombre de la Clase" required>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col">
                                                <label>Descripción</label>
                                                <input type="text" class="form-control" v-model="classDescription" name="description" placeholder="Descripción" required>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col">
                                                <label>Hora de Inicio</label>
                                                <div v-if="verificaBrowser==='Firefox' || verificaBrowser==='Safari'">
                                                    <datetime format="YYYY-MM-DD H:i:s" class="form-control2"  v-model="classStart" id="start_hour" name="start_hour"></datetime>
                                                </div>
                                                <div v-else>
                                                    <input type="datetime-local" class="form-control" v-model="classStart" placeholder="" id="start_hour" name="start_hour" required>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <label>Hora de Fin</label>
                                                <div v-if="verificaBrowser==='Firefox' || verificaBrowser==='Safari'">
                                                    <datetime format="YYYY-MM-DD H:i:s" class="form-control2"  v-model="classEnd" id="end_hour" name="start_hour"></datetime>
                                                </div>
                                                <div v-else>
                                                    <input type="datetime-local" class="form-control" v-model="classEnd" placeholder="" id="end_hour" name="end_hour" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-4" style="display: none">
                                            <div class="col">
                                                <label>Contraseña de la Sala</label>
                                                <input type="text" class="form-control" v-model="classPassword" placeholder="" required>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col">
                                                <label>Imagen</label>
                                                <input type="file" class="form-control" id="file" ref="file" v-on:change="onFileChangeClass" accept="image/*" name="image" required>
                                            </div>
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
                                                        <div class="subtitle">Archivos Permitidos: videos</div>
                                                    </div>
                                                </vue-dropzone>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn" data-dismiss="modal">Cerrar</button>
                                    <button type="button" class="btn btn-dark" id="createClass" @click="storeClass">Guardar</button>
                                </div>
                            </form>
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
    import moment from 'moment';
    import datetime from 'vuejs-datetimepicker';

    export default {
        name: "add-course",
        components: {VFooter, VNav, CarouselComponent, vueDropzone: vue2Dropzone,InformationComponent, datetime},
        mounted: function () {
            this.getThematic();
            this.getCourses();
            this.prepare();

            document.getElementById("start_hour").min = '2020-09-25';
            document.getElementById("courseStart").min = moment().format('YYYY-MM-DD');
            document.getElementById("pstar").min = moment().format('YYYY-MM-DD');
            document.getElementById("pend").min = moment().format('YYYY-MM-DD');
        },
        data: function () {
            return {
                name: null,
                description: null,
                cThematic: null,
                type: null,
                numberClass: null,
                start_hour: null,
                price: null,
                discount: 0,
                url: null,
                errors: [],
                thematics: [],
                subthematics: [],
                courses: [],
                cSubtopic: null,
                classCourse: null,
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
                    timeout: 180000000
                },
                fileName: '',
                uifileName: null,
                filePreview: '',
                uiPreview: null,
                classId: null,
                className: null,
                classDescription: null,
                classStart: null,
                classEnd: null,
                classPassword: null,
                classUrl: null,
                classType: null,
                classerrors: [],
                classSubtopic: null,
                filePhoto: null,
                filePhotoClass: null,
                promotionalPrice: null,
                promotionStart: null,
                promotionEnd: null,
                classes: [],
                previewType: 2,
            }
        },
        methods: {
            addClass (){
                //Validacion Clases Máximas Course
                let data = this.getDataCourse(this.classCourse);
                this.classType = data.type_course;
                this.classSubtopic = data.subTopic;

                if (this.classType == '1') {
                    this.$refs.myVueDropzone.enable()
                    $('#start_hour').attr('disabled', true);
                    $('#end_hour').attr('disabled', true);
                } else if (this.classType == '2') {
                    this.$refs.myVueDropzone.disable()
                    $('#start_hour').attr('disabled', false);
                    $('#end_hour').attr('disabled', false);
                }
              //  console.log(data, 'Data addclasss');

                if (!data.canCreateClass) {
                    $('#createClass').attr('disabled', true);
                    toastr.warning('No se puede agregar mas clases al curso seleccionado', "Mensaje del sistema");
                } else {
                    this.classId=null;
                    $('#createClass').attr('disabled', false);
                    $('#staticBackdrop').modal('show');
                }
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
          },
            stateDropzone (validate){
              if (validate){
                this.$refs.myVueDropzone2.disable();
                $('#preview').attr('disabled', false);
              }else{
                this.$refs.myVueDropzone2.enable();
                $('#preview').attr('disabled', true);
              }
            },
            prepare: function() {
                let config = { headers: {'Authorization': "Bearer " + this.$store.state.token } };
                let id = this.$route.params.id;

                let url = '/api/prepare-course';
                axios.post(url, {id: id}, config).then(response => {
                    this.name = response.data.name;
                    this.description = response.data.description;
                    this.cThematic = response.data.subtopic.thematic.id;
                    this.type = response.data.type_course;
                    this.numberClass = response.data.number_class;
                    this.start_hour = response.data.date_start;
                    this.price = response.data.price;
                    this.discount = response.data.discount;
                    this.promotionStart = response.data.promotion_start;
                    this.promotionEnd = response.data.promotion_end;
                    this.promotionalPrice = response.data.promotional_price;
                    this.url = '';
                    this.getSubThemetic();
                    this.cSubtopic = response.data.subtopic_id;
                    this.classes = response.data.classes;
                    this.classCourse = response.data.id;
                    this.previewType = response.data.preview_type;
                    //console.log(response.data, 'Courseee');

                }).catch(error => {
                    // this.classerrors = error.response.data
                });   
            },
            getThematic: function() {
                var urlThematic = '/api/get-thematics';
                axios.get(urlThematic).then(response => {
                    // console.log(response.data);
                    this.thematics = response.data
                });
            },
            getSubThemetic: function() {
                var url = '/api/get-sub-thematics?thematic=' + this.cThematic;
                axios.get(url).then(response => {
                   // console.log(response.data);
                    this.subthematics = response.data
                });
            },
            getCourses: function () {
                var url = '/api/get-course/'+ this.$store.state.user.id;
                axios.post(url).then(response => {
                    this.courses = response.data
                });

               // console.log(this.courses);
            },
            selectCourseClass: function (event) {
                let data = this.getDataCourse(this.classCourse);
                //console.log(data);
                this.classType = data.type_course;
                this.classSubtopic = data.subTopic;

                if (!data.canCreateClass) {
                    $('#createClass').attr('disabled', true);
                    toastr.warning('No se puede agregar mas clases al curso seleccionado', "Mensaje del sistema");
                } else {
                    $('#createClass').attr('disabled', false);
                }

                document.getElementById("start_hour").min = data.start_date + 'T00:00:00';
                document.getElementById("end_hour").min = data.start_date + 'T00:00:00';

                if (this.classType == '1') {
                    this.$refs.myVueDropzone.enable()
                    $('#start_hour').attr('disabled', true);
                    $('#end_hour').attr('disabled', true);
                } else if (this.classType == '2') {
                    this.$refs.myVueDropzone.disable()
                    $('#start_hour').attr('disabled', false);
                    $('#end_hour').attr('disabled', false);
                }
            },
            getDataCourse: function (id) {
                return this.courses.find(course => course.id === id); 
            },
            onFileChange(e) {
                this.filePhoto = e.target.files[0];
            },
            onFileChangeClass(e) {
                this.filePhotoClass = e.target.files[0];
            },
            store: function () {
                this.errors = [];
                if (this.name && this.cSubtopic && this.description && this.type && this.numberClass && this.start_hour && this.price) {
                    let config = { headers: { 'Content-Type': 'multipart/form-data','Authorization': "Bearer " + this.$store.state.token } }
                    let id = this.$route.params.id;

                    let formData = new FormData();
                    formData.append('file', this.filePhoto);
                    formData.append('name', this.name);
                    formData.append('description', this.description);
                    formData.append('thematic', this.cSubtopic);
                    formData.append('type_course', this.type);
                    formData.append('date_start', this.start_hour);
                    formData.append('price', this.price);
                    formData.append('discount', this.discount);
                    formData.append('url', this.url);
                    formData.append('user', this.$store.state.user.id);
                    formData.append('number_class', this.numberClass);
                    formData.append('promotional_price', this.promotionalPrice);
                    formData.append('start_promotion', this.promotionStart);
                    formData.append('end_promotion', this.promotionEnd);
                    formData.append('courseId', id);

                    formData.append('url_presentation', this.uiPreview);
                    formData.append('previewType', this.previewType);
                    formData.append('filePreview', this.filePreview);

                    var url = '/api/update-course';
                    axios.post(url,formData, config).then(response => {
                        this.errors = [],

                        this.prepare();
                        toastr.success('Se grabó el curso correctamente', "Mensaje del sistema");
                    }).catch(error => {
                        this.errors = error.response.data
                    });
                }


                this.errors = [];

                if (!this.name) {
                    this.errors.push('El nombre del curso es obligatorio.');
                }
                if (!this.cThematic) {
                    this.errors.push('El tema del curso es obligatorio.');
                }
                if (!this.description) {
                    this.errors.push('La descripción es obligatoria.');
                }
                if (!this.type) {
                    this.errors.push('El tipo de curso obligatorio.');
                }
                if (!this.numberClass) {
                    this.errors.push('El número de clases es obligatorio.');
                }
                if (!this.start_hour) {
                    this.errors.push('La fecha de inicio es obligatoria.');
                }
                if (!this.price) {
                    this.errors.push('El precio obligatorio.');
                }
                if (!this.filePhoto) {
                    this.errors.push('La foto de la clase es obligatoria.');
                }
            },
            uploadSuccess(file, response) {
                toastr.success('El video se subió correctamente', "Mensaje del sistema");
              //  console.log('File Successfully Uploaded with file name: ' + response.file);
                this.fileName = response.file.preview;
                this.uifileName = response.file.uid;
            },
            uploadSuccessPreview(file, response){
              toastr.success('El video preview se subió correctamente', "Mensaje del Sistema");
              //  console.log('Video preview cargado correctamente: ' + response.file);
              this.filePreview = response.file.preview;
              this.uiPreview = response.file.uid;
            },
            uploadError(file, message) {
                console.log('An Error Occurred');
            },
            fileRemoved() {},
            storeClass: function() {
                if (this.verificaClass()){
                    this.saveClass();
                }else{
                    toastr.warning('Ha ocurrido un error', 'Mensaje del Sistema');
                }
            },
            saveClass(){
                let config = { headers: { 'Content-Type': 'multipart/form-data','Authorization': "Bearer " + this.$store.state.token } }

                let formData = new FormData();
                formData.append('class_id', this.classId);
                formData.append('file', this.filePhotoClass);
                formData.append('name', this.className);
                formData.append('description', this.classDescription);
                formData.append('hour_start', this.classStart);
                formData.append('course_id', this.classCourse);
                formData.append('hour_end', this.classEnd);
                formData.append('photo', this.classEnd);
                formData.append('url_video', this.fileName);
                formData.append('url_room', this.uifileName);
                formData.append('type_class', this.classType);
                formData.append('subTopic', this.classSubtopic);
                formData.append('state', 1);
                formData.append('user', this.$store.state.user.id);

                let url = '/api/store-course-class';
                axios.post(url,formData, config).then(response => {
                    $('#staticBackdrop').modal('hide');
                    this.className = null,
                        this.classDescription = null,
                        //this.classCourse = null,
                        this.classStart = null,
                        this.classEnd = null,
                        this.fileName = null,
                        this.classType = null,
                        this.classerrors = [],
                        this.classSubtopic = null,
                        this.classUrl = null,
                        this.classPassword = null,

                        this.name = '';
                    this.description = '';
                    this.cThematic = '';
                    this.type = '';
                    this.numberClass = '';
                    this.start_hour = '';
                    this.price = '';
                    this.url = '';
                    this.cSubtopic = '';
                    this.errors = [],

                    //this.getCourses();
                    this.prepare();
                    toastr.success('Se creó la clase correctamente', "Mensaje del Sistema");
                    this.$refs.myVueDropzone.removeAllFiles()

                    // this.$router.push('/mis-cursos');
                }).catch(error => {
                    this.classerrors = error.response.data
                });
            },
            verificaClass (){
                this.classerrors = [];
                //alert (' ingresando verifica')
                let verifica =false;
              //  console.log(this.classType);
                if (this.classType === 1){
                    if (this.className && this.classDescription && this.classType && this.classCourse) {
                        verifica=true;
                        //alert('Verifica true 1')
                    }
                }else if (this.classType === 2){
                    if (this.className && this.classStart && this.classDescription && this.classType && this.classEnd && this.classCourse) {
                       // alert('verifica true 2')
                        verifica=true;
                    }
                }

                if (verifica == false){
                    if (!this.classCourse) {
                        this.classerrors.push('Debe de seleccionar un curso.');
                    }
                    if (!this.className) {
                        this.classerrors.push('El nombre de la clase es obligatorio.');
                    }
                    if (!this.classEnd) {
                        this.classerrors.push('La fecha de fin es obligatoria.');
                    }
                    if (!this.classDescription) {
                        this.classerrors.push('La descripción es obligatoria.');
                    }
                    if (!this.classType) {
                        this.classerrors.push('El tipo de clase obligatorio.');
                    }
                    if (!this.classStart) {
                        this.classerrors.push('La fecha de inicio es obligatoria.');
                    }
                   // alert ('Verifica es false pero no hay errores');
                }
                console.log(verifica, ' Resultado recontra verificaaa');
                return verifica;
            },

            calculatePromotionalPrice() {
                let price = parseFloat(this.price);
                let discount = parseFloat(this.discount) / 100;

                this.promotionalPrice = (price - (price * discount)).toFixed(2);
            },
            edit(clase) {


                //console.log(clase, 'Classeeee')
                this.classId = clase.id;
                this.className = clase.name;
                this.classDescription = clase.description;
                this.classCourse = clase.course_id;
                this.classStart = moment(clase.hour_start).format('yyyy-MM-DDThh:mm');
                this.classEnd =  moment(clase.hour_end).format('yyyy-MM-DDThh:mm');
                this.fileName = null;
                this.uifileName = null;
                this.classType = clase.type_class;
                this.classerrors = [];
                this.classSubtopic = clase.subtopic.id;
                this.classUrl = null;
                this.classPassword = clase.room_password;

                //alert ('Hola  editar clase' + this.classId);

                if (this.classType == '1') {
                    this.$refs.myVueDropzone.enable()
                    $('#start_hour').attr('disabled', true);
                    $('#end_hour').attr('disabled', true);
                } else if (this.classType == '2') {
                    this.$refs.myVueDropzone.disable()
                    $('#start_hour').attr('disabled', false);
                    $('#end_hour').attr('disabled', false);
                }

                $('#staticBackdrop').modal('show');
            },
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