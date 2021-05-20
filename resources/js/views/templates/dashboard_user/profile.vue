<template>
    <div>
        <v-nav></v-nav>
        <div class="body-container">
            <!--            <carousel-component></carousel-component>-->
            <information-component></information-component>
            <div class="container-lg">
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card-white">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-12" id="cabecera_hiden">
                                        <dasboard-link :profile="true"></dasboard-link>
                                        <div class="tab-content" id="nav-tabContent">
                                            <div class="tab-pane fade show active" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                                <div class="row mt-4">
                                                    <div class="col-12">
                                                        <nav>
                                                            <div class="nav nav-tabs" id="nav-tab2" role="tablist">
                                                                <a class="nav-link active" id="nav-home-tab2" data-toggle="tab" href="#nav-home2" role="tab" aria-controls="nav-home2" aria-selected="true">Datos Personales</a>
                                                                <a v-if="isInstructor" class="nav-link" id="nav-profile-tab2" data-toggle="tab" href="#nav-profile2" role="tab" aria-controls="nav-profile2" aria-selected="false">Datos Profesionales</a>
                                                            </div>
                                                        </nav>
                                                        <div class="tab-content" id="nav-tabContent2">
                                                            <div class="tab-pane fade show active" id="nav-home2" role="tabpanel" aria-labelledby="nav-home2-tab">
                                                                <div class="row my-4" v-if="isInstructor && (User.photo == '/img/default.jpg' || User.thematic_id==null)">
                                                                    <div class="col-12">
                                                                        <div class="alert alert-warning" role="alert">
                                                                            Tu perfil no se mostrará en nuestro directorio hasta que llenes los datos con * que son obligatorios de Datos personales y de Datos profesionales así como subir tu foto.                                                                      </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row my-4">
                                                                    <div class="col-12 col-md-3 text-center">
                                                                        <img :src="User.photo" width="150px" height="150px" class="rounded-circle" alt="">
                                                                        <div class="input-group">
                                                                            <div class="custom-file">
                                                                                <input type="file" name="filename" class="custom-file-input" id="inputFileUpload"
                                                                                       v-on:change="onFileChange">
                                                                                <label class="custom-file-label" id="elegir" for="inputFileUpload">Elegir Archivo</label>
                                                                            </div>
                                                                        </div>
                                                                        <button type="button" class="btn btn-block btn-dark mt-3" @click="submitForm">Subir Foto</button>
                                                                    </div>
                                                                    <div class="col-12 col-md-9">
                                                                        <div class="row">
                                                                            <div class="col-12 col-md-6">
                                                                                <div class="form-group row mt-3">
                                                                                    <label for="staticEmail" class="col-sm-4 col-form-label">Trato (*)</label>
                                                                                    <div class="col-sm-8">
                                                                                        <select v-model="User.people.deal_id" class="form-control">
                                                                                            <option v-for="(deal, index) in deals" :key="index" :selected="deal.id == 1" :value="deal.id">{{deal.deal}}</option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-12 col-md-6">
                                                                                <div class="form-group row mt-3">
                                                                                    <label for="staticEmail" class="col-sm-4 col-form-label">Nombres (*)</label>
                                                                                    <div class="col-sm-8">
                                                                                        <input v-model="User.name" type="text" class="form-control">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-12 col-md-6">
                                                                                <div class="form-group row mt-3">
                                                                                    <label for="staticEmail" class="col-sm-4 col-form-label">Fecha Nac.</label>
                                                                                    <div class="col-sm-8">
                                                                                        <div v-if="verificaBrowser==='Safari'">
                                                                                            <datetime format="YYYY-MM-DD" class="form-control2"  v-model="User.people.birth_date"></datetime>
                                                                                        </div>
                                                                                        <div v-else>
                                                                                            <input v-model="User.people.birth_date" type="date" class="form-control">
                                                                                        </div>

                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-12 col-md-6">
                                                                                <div class="form-group row mt-3">
                                                                                    <label for="staticEmail" class="col-sm-4 col-form-label">Nacionalidad</label>
                                                                                    <div class="col-sm-8">
                                                                                        <select v-model="User.people.country_id" class="form-control">
                                                                                            <option value="0">Ninguna</option>
                                                                                            <option v-for="c in Country" :value="c.id">{{c.name}}</option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-12 col-md-6">
                                                                                <div class="form-group row mt-3">
                                                                                    <label for="staticEmail" class="col-sm-4 col-form-label">Profesión (*)</label>
                                                                                    <div class="col-sm-8">
                                                                                        <input v-model="User.people.profession" type="text" class="form-control">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-12 col-md-6">
                                                                                <div class="form-group row mt-3">
                                                                                    <label for="staticEmail" class="col-sm-4 col-form-label">Teléfono</label>
                                                                                    <div class="col-sm-8">
                                                                                        <input v-model="User.people.phone" type="text" class="form-control">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-12 col-md-6">
                                                                                <div class="form-group row mt-3">
                                                                                    <label for="staticEmail" class="col-sm-4 col-form-label">Grado</label>
                                                                                    <div class="col-sm-8">
                                                                                        <input v-model="User.people.grade" type="text" class="form-control">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-12 col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="">Intereses</label>
                                                                            <multiselect v-model="interests" @change="addTag" @remove="removeTag" :options="interesetsOptions" :multiple="true" :taggable="true" label="name" track-by="id" @select="addTag" placeholder="Seleccione sus intereses"></multiselect>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12 col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="">Descripción (*)</label>
                                                                            <textarea v-model="User.people.description" type="text" class="form-control"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row mt-4">
                                                                    <div class="col-12">
                                                                        <h5>Datos de la Cuenta</h5>
                                                                    </div>
                                                                    <div class="col-12 col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="">Correo Electrónico</label>
                                                                            <input v-model="User.email" type="text" class="form-control" readonly>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-12 col-md-6" v-if="User.social_network != 1">
                                                                        <div class="form-group">
                                                                            <label for="">Contraseña Actual</label>
                                                                            <input v-model="User.password" type="password" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12">
                                                                            <div class="alert alert-danger" v-if="classerrors != ''">
                                                                                <ul>
                                                                                    <li v-for="error in classerrors" :key="error">{{ error }}</li>
                                                                                </ul>
                                                                            </div>
                                                                    </div>
                                                                    <div class="col-12 col-md-6" v-if="User.social_network != 1">
                                                                        <div class="form-group">
                                                                            <label for="">Nueva  Contraseña</label>
                                                                            <input v-model="User.newpassword" type="password" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12 col-md-6" v-if="User.social_network != 1">
                                                                        <div class="form-group">
                                                                            <label for="">Repetir nueva contraseña</label>
                                                                            <input v-model="User.newpassword2" type="password" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row my-4">
                                                                    <div class="col-12">
                                                                        <button class="btn btn-rounded btn-custom-red"  @click="savePersonData">Guardar</button>
                                                                        <button class="btn btn-rounded btn-custom-blue">Cancelar</button>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <div v-if="isInstructor" class="tab-pane fade" id="nav-profile2" role="tabpanel" aria-labelledby="nav-profile2-tab">
                                                                <div class="row my-4">
                                                                    <div class="col-12">
                                                                        <h4>Datos de la cuenta</h4>
                                                                    </div>
                                                                    <div class="col-12 col-md-6">
                                                                        <div class="form-group row mt-3">
                                                                            <label for="staticEmail" class="col-sm-4 col-form-label">Categoría (*)</label>
                                                                            <div class="col-sm-8">
                                                                                <select v-model="User.thematic_id" class="form-control">
                                                                                    <option v-for="item in Category" :value="item.id">
                                                                                        {{item.name}}
                                                                                    </option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12 col-md-6">
                                                                        <div class="form-group row mt-3">
                                                                            <label for="staticEmail" class="col-sm-4 col-form-label">Última Conexión</label>
                                                                            <div class="col-sm-8">
                                                                                <input v-model="User.last_session" type="text" class="form-control" readonly>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-4">
                                                                    <div class="col-12">
                                                                        <h4>Datos Generales</h4>
                                                                    </div>
                                                                    <div class="col-12 col-md-6">
                                                                        <div class="form-group row mt-3">
                                                                            <label for="staticEmail" class="col-sm-4 col-form-label">Tipo Documento</label>
                                                                            <div class="col-sm-8">
                                                                                <select v-model="User.people.document_type_id" class="form-control">
                                                                                    <option value="0">Ninguna</option>
                                                                                    <option v-for="c in TypeDocuments" :value="c.id">{{c.description}}</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row mt-3">
                                                                            <label for="staticEmail" class="col-sm-4 col-form-label">Nro. Documento</label>
                                                                            <div class="col-sm-8">
                                                                                <input v-model="User.people.document_number" type="text" class="form-control" id="staticEmail">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12 col-md-6">
                                                                        <div class="form-group row mt-3">
                                                                            <label for="staticEmail" class="col-sm-4 col-form-label">Grado de Instrucción</label>
                                                                            <div class="col-sm-8">
                                                                                <input v-model="User.people.grade_instruction" type="text" class="form-control" id="staticGrade">
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row mt-3">
                                                                            <label for="staticEmail" class="col-sm-4 col-form-label">Tipo de Institución</label>
                                                                            <div class="col-sm-8">
                                                                                <select v-model="User.people.institution_type_id" class="form-control">
                                                                                    <option value="0">Ninguna</option>
                                                                                    <option v-for="c in InstitutionTypes" :value="c.id">{{c.description}}</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row mt-3">
                                                                            <label for="staticEmail" class="col-sm-4 col-form-label">Nombre de Institución</label>
                                                                            <div class="col-sm-8">
                                                                                <input v-model="User.people.name_institution" type="text" class="form-control" id="staticNameInstitution">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-4">
                                                                    <div class="col-12">
                                                                        <h4>Redes Sociales</h4>
                                                                    </div>
                                                                    <div class="col-12 col-md-6">
                                                                        <div class="form-group row mt-3">
                                                                            <label for="staticEmail" class="col-sm-4 col-form-label">Facebook</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="text" class="form-control" id="staticEmail" v-model="User.people.fb_link">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12 col-md-6">
                                                                        <div class="form-group row mt-3">
                                                                            <label for="staticEmail" class="col-sm-4 col-form-label">Twitter</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="text" class="form-control" id="staticEmail" v-model="User.people.tw_link">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12 col-md-6">
                                                                        <div class="form-group row mt-3">
                                                                            <label for="staticEmail" class="col-sm-4 col-form-label">Linkedin</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="text" class="form-control" id="staticEmail" v-model="User.people.ln_link">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12 col-md-6">
                                                                        <div class="form-group row mt-3">
                                                                            <label for="staticEmail" class="col-sm-4 col-form-label">Instagram</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="text" class="form-control" id="staticInstragram" v-model="User.people.ig_link">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row mt-4">
                                                                    <div class="col-12 mb-4">
                                                                        <h4>Sube tus documentos</h4>
                                                                    </div>
                                                                    <div class="col-12 col-md-6" v-for="docus in typeUserDocuments" :key="docus.id">
                                                                        <div class="form-group row mt-3">
                                                                            <label for="staticEmail" class="col-sm-4 col-form-label">{{ docus.name }}</label>
                                                                            <div v-if="userDocuments.length > 0">
                                                                                <div class="col-md-8" v-for="ud in userDocuments" :key="ud.id">
                                                                                    <div v-if="docus.id != ud.document_account_id">
                                                                                        <div class="cumtom-input-file-wrapper" style="width='100%'; hegiht: 100px;">
                                                                                            <span class="label">
                                                                                                <i class="ti-plus"></i>
                                                                                            </span>
                                                                                            
                                                                                            <input type="file" name="upload" id="doc" class="cumtom-input-file-upload-box" @change="uploadDoc($event, docus.id)" placeholder="Upload File">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div v-else>
                                                                                        <a :href="'/files/' + ud.url_document" target="_blank" class="btn btn-custom-blue">Ver</a>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div v-else>
                                                                                <div class="col-md-8">
                                                                                    <div class="cumtom-input-file-wrapper" style="width='100%'; hegiht: 100px;">
                                                                                        <span class="label">
                                                                                            <i class="ti-plus"></i>
                                                                                        </span>
                                                                                        
                                                                                        <input type="file" name="upload" id="doc" class="cumtom-input-file-upload-box" @change="uploadDoc($event, docus.id)" placeholder="Upload File">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row my-4">
                                                                    <div class="col-12">
                                                                        <button class="btn btn-rounded btn-custom-red" @click="saveInstructor">Guardar</button>
                                                                        <button class="btn btn-rounded btn-custom-blue">Cancelar</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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
    </div>
</template>

<script>
    import VNav from "../../partials/v-nav";
    import VFooter from "../../partials/v-footer";
    import CarouselComponent from "../../../components/CarouselComponent";
    import InformationComponent from "../../../components/InformationComponent";
    import DasboardLink from "../../../components/DasboardLink";
    import Multiselect from 'vue-multiselect'
    import datetime from 'vuejs-datetimepicker';
    export default {
        components: {DasboardLink, VFooter, VNav, CarouselComponent, InformationComponent, 'multiselect': Multiselect, datetime},
        name: "profile.vue",
        data (){
            return{
                User: {
                    people:{
                        paypal:"",
                        clabe:"",
                        deal_id:"",
                        birth_date:"",
                        country_id: "",
                        profession: "",
                        phone: "",
                        grade:"",
                        description: "",
                    },
                    social_network:0,
                    roles:[],
                    payment_method_users:[],
                    payment_account: [],
                    interest_users:[],
                    newpassword:'',
                    newpassword2:''
                },
                Country:[],
                interesetsOptions: [],
                interests: [],
                TypeDocuments:[],
                InstitutionTypes: [],
                documentTypes: [],
                userInterestSelected: [],
                deals: [],
                typeUserDocuments: [],
                userDocuments: [],
                classerrors: [],
                password_length:0
            }
        },
        mounted(){
            this.get_avatar();
            this.getUser();
            this.getCountry ();
            this.getDeals();
            this.getInterests();
            this.getTypeDocuments();
            this.getInstitutionTypes();
            this.getUserInterests();
            this.getDocumentTypes();
            this.getTypeUserDocuments();
            this.getUserDocuments();
            this.avatar = this.$store.state.user.photo;
            $("html, body").animate({ scrollTop: $("#cabecera_hiden").offset().top }, 1000);
        },
        methods:{
            get_avatar() {
                return this.User.photo
            },
            getUserInterests() {
                let url ="/api/get-user-interest";
             //   console.log(this.$store.state.token);
                axios.post(url, this.User , {
                    headers:{Authorization: "Bearer " + this.$store.state.token}
                }).then(response =>{
                    this.interests = response.data
                }).catch(error => {
                    
                })
            },
            getDeals() {
                let url ="/api/get-deals"
                axios.get(url).then(response =>{
                    this.deals = response.data;
                }).catch(error => {
                    console.log(error);
                })
            },
            onFileChange(e) {
                this.filename = "Archivo Seleccionado: " + e.target.files[0].name;
                this.file = e.target.files[0];
            },
            submitForm(e) {
                e.preventDefault();
                let formData = new FormData();
                formData.append('file', this.file);

                let currentObj = this;

                axios.post('/api/upload-avatar', formData, {
                    headers:{Authorization: "Bearer " + this.$store.state.token}
                })
                    .then(function (response) {
                        if (response.data.response == true) {
                            currentObj.User.photo = response.data.path;
                            localStorage.setItem('user_login',JSON.stringify(currentObj.User))
                            currentObj.$store.commit('getUser', currentObj.User)
                            currentObj.get_avatar();
                            toastr.success('Se actualizó correctamente tu foto de perfil', 'Mensaje del sistema');
                        } else {
                            toastr.error('Ha ocurrido un error inesperado', 'Mensaje del sistema');
                        }
                    })
                    .catch(function (error) {
                        console.log(error, "Error subir foto");
                        toastr.error('Ha ocurrido un error inesperado', 'Mensaje del sistema');
                    });
            },
            getCountry (){
                let url ="/api/getCountries"
                axios.get(url).then(response =>{
                    this.Country = response.data;
                }).catch(error => {
                    console.log(error);
                })
            },
            getInterests: function() {
                let url ="/api/get-interests"
                axios.get(url).then(response =>{
                    this.interesetsOptions = response.data;
                    //console.log(this.interesetsOptions, "Intereses");
                }).catch(error => {
                    console.log(error);
                })
            },
            addTag(newTag) {
                this.userInterestSelected.push(newTag.id);             
            },
            removeTag(tag) {
                const index = this.userInterestSelected.indexOf(tag.id);

                if (index > -1) {
                    this.userInterestSelected.splice(index, 1);
                }
            },
            savePersonData (){
                let url ="/api/updatePersonalData"

                let newpassword = this.User.newpassword;
                let newpassword2 = this.User.newpassword2;
                this.User.interest_users = this.interest_users;

                if (this.User.password != null && this.User.password != ""){
                    if (!this.validaPassword(newpassword, newpassword2)){
                        this.classerrors =[];
                        toastr.warning('La nueva contraseña no coincide', 'Mensaje del sistema');
                        return;
                    }
                    if (!this.checkPassword()){
                        toastr.warning('Revise los errores', 'Mensaje del sistema');
                        return;
                    }
                }
                    //console.log(this.User);
                    axios.post(url, this.User , {
                        headers:{Authorization: "Bearer " + this.$store.state.token}
                    }).then(response =>{
                       // console.log(response.data, 'Respuesta');
                        let user = response.data;
                        localStorage.setItem('user_login',JSON.stringify(user))
                        this.$store.commit('getUser', user)
                        toastr.success('Se ha grabado correctamente', 'Mensaje del sistema');
                        this.classerrors =[];
                    }).catch(error => {
                        if (error.response){
                            let error_response = error.response.data[0];
                            //console.log(error_response, 'Error response');
                            if (error_response.error==='20'){
                                toastr.error(error_response.mensaje, 'Mensaje del sistema');
                            }else{
                                toastr.error("Ha ocurrido un error, reinténtelo nuevamente", 'Mensaje del sistema');
                                setInterval (this.refreshPage(), 4000);
                            }
                        }else{
                            toastr.error('Ha ocurrido un error, inesperado', 'Mensaje del sistema');
                        }
                    })
            },

            checkPassword() {
                this.password_length = this.User.newpassword.length;
                const format = /[ !@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/;
                let test = false;
                this.classerrors =[];

                if (!(this.password_length >= 8)) {
                    this.classerrors.push('La contraseña debe contener mas de 8 caracteres');
                }

                if (!(/\d/.test(this.User.newpassword))){
                    this.classerrors.push('La contraseña debe contener un número');
                }

                if (!(/[A-Z]/.test(this.User.newpassword))){
                    this.classerrors.push('La contraseña debe contener una letra mayúscula');
                }

                if (!(/[a-z]/.test(this.User.newpassword))){
                    this.classerrors.push('La contraseña debe contener una letra minúscula');
                }

                if (!(format.test(this.User.newpassword))){
                    this.classerrors.push('La contraseña debe contener un caracter especial');
                }

                if (this.classerrors.length === 0){
                    test = true;
                }
                return test;
            },

            refreshPage(){
                location.reload();
            },

            validaPassword (password1, password2){
                let res = false;
                if (password1!= null && password1!="" && password2 !=null && password2!=""){
                    if (password1 === password2){
                        res =true;
                    }
                }
                return res;
            },
            getUser(){
                this.User = this.$store.state.user;
                this.User.people.country_id == null ? this.User.people.country_id=0 : "";
                this.User.people.deal_id == null ? this.User.people.deal_id == 1 : this.User.people.deal_id = this.User.people.deal_id;
                this.User.people.document_type_id == null ? this.User.people.document_type_id=0 : "";
                this.User.people.institution_type_id == null ? this.User.people.institution_type_id=0 : "";
                this.Payment_account = this.User.payment_account;
                this.getMethodUser();
                //console.log(this.User, 'Usuario logueado');
            },
            getMethodUser (){
                let paypal = "";
                let clabe ="";
                this.User.payment_method_users.forEach(function (method) {
                    if (method.payment_method_id ==1){
                        paypal = method.value;
                    }else if (method.payment_method_id ==2){
                        clabe = method.value;
                    }
                });
                this.User.people.paypal =paypal;
                this.User.people.clabe =clabe;
            },
            getTypeDocuments(){
                let url ="/api/getTypeDocuments"
                axios.get(url).then(response =>{
                    this.TypeDocuments = response.data;
                }).catch(error => {
                    console.log(error);
                })
            },
            getInstitutionTypes(){
                let url ="/api/getInstitutionTypes"
                axios.get(url).then(response =>{
                    this.InstitutionTypes = response.data;
                }).catch(error => {
                    console.log(error);
                })
            },
            getDocumentTypes() {
                let url ="/api/get-documents-types"
                axios.get(url).then(response =>{
                    this.documentTypes = response.data;
                }).catch(error => {
                    console.log(error);
                })
            },
            getTypeUserDocuments() {
                let url ="/api/get-type-user-documents"
                axios.get(url).then(response =>{
                    this.typeUserDocuments = response.data;
                }).catch(error => {
                    console.log(error);
                });
            },
            getUserDocuments() {
                let url ="/api/get-user-documents";
                axios.post(url, this.User , {
                    headers:{Authorization: "Bearer " + this.$store.state.token}
                }).then(response =>{
                    this.userDocuments = response.data;
                }).catch(error => {
                    toastr.error('Ha ocurrido un error inesperado', 'Mensaje del sistema');
                    console.log(error);
                })
            },
            saveInstructor(){
                // this.setMethodUser();
                let url ="/api/updateInstructor";
                axios.post(url, this.User , {
                    headers:{Authorization: "Bearer " + this.$store.state.token}
                }).then(response =>{
                    //console.log(response.data, 'Respuesta');
                    let user = response.data;
                    localStorage.setItem('user_login',JSON.stringify(user))
                    this.$store.commit('getUser', user)
                    toastr.success('Se ha grabado correctamente', 'Mensaje del sistema');
                }).catch(error => {
                    toastr.error('Ha ocurrido un error inesperado', 'Mensaje del sistema');
                    console.log(error);
                })
            },
            uploadDoc(e, doc) {
                this.submitDoc(e, doc);
            },
            submitDoc(e, doc) {
                e.preventDefault();
                let currentObj = this;
   
                const config = {
                    headers: { 'content-type': 'multipart/form-data','Authorization': "Bearer " + this.$store.state.token },
                }
    
                let formData = new FormData();
                formData.append('file', e.target.files[0]);
                formData.append('type', doc);
   
                axios.post('/api/upload-doc-user-instructor', formData, config)
                .then(function (response) {
                    if (response.data.success == true) {
                        toastr.success('Se subió el documento correctamente', 'Mensaje del sistema');
                        this.getTypeUserDocuments();
                        this.getUserDocuments();
                    } else {
                        toastr.error('Ooops. Hubo un error', 'Mensaje del sistema');
                    }
                })
                .catch(function (error) {
                    currentObj.output = error;
                });
            }
        },
        computed:{
            isInstructor (){
                return this.$store.state.user.roles[0].name == "Profesor";
            },
            Category(){
                return this.$store.getters.getCategories;
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
    .nav-link {
        color: #33384E;
    }
    .nav-link.active {
        background: #CC2649;
        color: #fff;
    }
    #elegir{
        font-size: 90%;
    }
</style>