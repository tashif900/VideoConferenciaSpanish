<template>
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
                                    <select name="course" v-model="classCourse" @change="selectCourseClass($event)" id="course" class="form-control" required>
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
                                        <input type="datetime-local"  class="form-control" v-model="classStart" placeholder="" id="start_hour" name="start_hour" required>
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
                                    <input type="hidden" class="form-control" v-model="classPassword" placeholder="" required>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-12 col-md-6 mb-3">
                                    <label>Imagen de Portada</label>
                                    <input type="file" class="form-control" id="file" ref="file" v-on:change="onFileChangeClass" accept="image/*" name="image" required>
                                </div>
                                <div class="col-12 col-md-6 mb-3">
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
                                            <div class="subtitle">Archivos Permitidos: Videos</div>
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

</template>

<script>
    import vue2Dropzone from "vue2-dropzone";
    import "vue2-dropzone/dist/vue2Dropzone.min.css";
    import datetime from 'vuejs-datetimepicker';
    export default {
        name: "add-class-comp",
        components: {
            vueDropzone: vue2Dropzone, datetime
        },
        mounted() {
            document.getElementById("start_hour").min = '2020-09-25';
        },
        data: function () {
            return {
                classerrors: [],
                classCourse:null,
                courses:null,
                className:null,
                classDescription: null,
                classStart:null,
                classEnd: null,
                classPassword:null,
                filePhotoClass:null,
                dropzoneOptions: {
                    url: "/api/store/files",
                    addRemoveLinks: true,
                    maxFiles: 1,
                    maxFilesize: 2048,
                    thumbnailWidth: 150,
                    thumbnailHeight: 150,
                    acceptedFiles: ".mp4",
                    dictDefaultMessage: `<p class='text-default'><i class='fa fa-cloud-upload mr-2'></i> Arrastra tu video o haz clic aquí</p>
                    <p class="form-text">Archivos Permitidos: video/*</p>
                    `,
                    headers: {
                        "X-CSRF-TOKEN": document.head.querySelector("[name=csrf-token]").content
                    }
                },
            }
        },
        methods:{
            selectCourseClass: function (event) {
                let data = this.getDataCourse(this.classCourse);
              //  console.log(data);
                this.classType = data.type_course;
                this.classSubtopic = data.subTopic;

                if (!data.canCreateClass) {
                    $('#createClass').attr('disabled', true);
                    toastr.warning('No se pued agregar mas clases al curso seleccionado', "Mensaje del Sistema");
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
            getCourses: function () {
                var url = '/api/get-course/'+ this.$store.state.user.id;
                axios.post(url).then(response => {
                    this.courses = response.data
                });

               // console.log(this.courses);
            },
            onFileChangeClass(e) {
                this.filePhotoClass = e.target.files[0];
            },
            uploadSuccess(file, response) {
                toastr.success('El video se subió correctamente', "Mensaje del Sistema");
             //   console.log('File Successfully Uploaded with file name: ' + response.file);
                this.fileName = response.file;
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
                formData.append('file', this.filePhotoClass);
                formData.append('name', this.className);
                formData.append('description', this.classDescription);
                formData.append('hour_start', this.classStart);
                formData.append('course_id', this.classCourse);
                formData.append('hour_end', this.classEnd);
                formData.append('photo', this.classEnd);
                formData.append('url_video', this.fileName);
                formData.append('type_class', this.classType);
                formData.append('subTopic', this.classSubtopic);
                formData.append('state', 1);
                formData.append('user', this.$store.state.user.id);

                var url = '/api/store-course-class';
                axios.post(url,formData, config).then(response => {
                $('#staticBackdrop').modal('hide');
                    this.className = null,
                        this.classDescription = null,
                        this.classCourse = null,
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

                    this.getCourses();
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
               // console.log(this.classType);
                if (this.classType === 1){
                    if (this.className && this.classDescription && this.classType && this.classCourse) {
                        verifica=true;
                        //alert('Verifica true 1')
                    }
                }else if (this.classType === 2){
                    if (this.className && this.classStart && this.classDescription && this.classType && this.classEnd && this.classCourse) {
                        //alert('verifica true 2')
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
                    //alert ('Verifica es false pero no hay errores');
                }
                //console.log(verifica, ' Resultado recontra verificaaa');
                return verifica;
            },
        },
        computed:{
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