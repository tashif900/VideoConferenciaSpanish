<template>
    <div>
        <v-nav></v-nav>
        <div class="body-container">
            <div class="container">
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="title-section-cont">
                            <h3 class="title-section">{{ this.name }}</h3>
                        </div>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-12 col-md-7">
                        <div id="video"></div>
                    </div>
                    <div class="col-12 col-md-5">
                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-4 col-form-label">Sala</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" :value="name" id="staticEmail" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-4 col-form-label">Profesional</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="staticEmail" :value="instructor" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-4 col-form-label">Hora de inicio</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="staticEmail" v-model="date" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-4 col-form-label">Código de la Sala</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="staticEmail" :value="code" readonly>
                            </div>
                        </div>
                        <div class="row" v-if="checkinstructor">
                            <div class="col-12">
                                <button class="btn btn-custom-red" type="button"  @click="finishSession">Finalizar Sesión</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="description-tab" data-toggle="tab" href="#description" role="tab" aria-controls="description" aria-selected="true">Descripción</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="comments-tab" data-toggle="tab" href="#comments" role="tab" aria-controls="comments" aria-selected="false">Comentarios</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="resources-tab" data-toggle="tab" href="#resources" role="tab" aria-controls="resources" aria-selected="false">Recursos</a>
                        </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
                                <div class="row mt-4">
                                    <div class="col">
                                        <label><strong>Descripción</strong></label>
                                        <p>{{ this.description }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="comments" role="tabpanel" aria-labelledby="comments-tab">
                                 <div class="row mt-4">
                                    <div class="col">
                                        <label><strong>Comentarios</strong></label>

                                        <textarea v-model="comment" class="form-control" placeholder="Escribe tu Comentario"></textarea>
                                        <button class="btn btn-custom-blue btn-rounded float-right mt-2 mb-4" @click="storeComment()">Enviar</button>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <ul class="list-unstyled">
                                            <li class="media border-bottom p-3" v-for="comment in comments" :key="comment.id" v-bind:class="comment.user_id == instructorId ? 'comment-active' : ''">
                                                <img :src="comment.photo" class="mr-3" width="64px" height="64px">
                                                <div class="media-body">
                                                    <h5 class="mt-0 mb-1">{{ comment.user }} <small class="text-muted">{{ comment.created }}</small></h5>
                                                    {{ comment.comment }}                                    
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="resources" role="tabpanel" aria-labelledby="resources-tab">
                                <div class="row mt-4" v-if="isInstructor">
                                    <div class="col-12 mb-4">
                                        <label>Nombre del Recurso</label>
                                        <input type="text" class="form-control" v-model="resourceName">
                                    </div>
                                    <div class="col-12 mb-4">
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
                                                <h3 class="dropzone-custom-title">Arrastra los nuevos recursos</h3>
                                            </div>
                                        </vue-dropzone>
                                    </div>
                                    <div class="col-12 mb-4">
                                        <button class="btn btn-custom-red btn-rounded" @click="storeResource">Agregar</button>
                                    </div>
                                </div>
                                <div class="row my-4">
                                    <div class="col-12">
                                        <h4>Recursos de la Clase</h4>
                                    </div>
                                    <div class="col-12">
                                        <div class="list-group">
                                            <a :href="resource.file" class="list-group-item list-group-item-action" v-for="resource in resources" :key="resource.file">{{ resource.name }}</a>
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
    import VFooter from "../partials/v-footer";
    import VNav from "../partials/v-nav";
    import terminosVue from './terminos.vue';
    import StarRating from 'vue-star-rating';

    import vue2Dropzone from "vue2-dropzone";
    import "vue2-dropzone/dist/vue2Dropzone.min.css";
    import sha256 from 'crypto-js/sha256';
    import "../../jitsi-meet";

    export default {
        components: {VNav, VFooter, StarRating, vueDropzone: vue2Dropzone,},
        mounted() {
            this.checkSubscribeSession();
            this.getClassInformation();
            jitsiConferenceFrame0.$('.invite-more-content').style.display = 'none!important';
            // this.getComments();


        },
        data: function() {
            return {
                id: null,
                name: null,
                description: null,
                video: null,
                type: null,
                instructor: null,
                participants: null,
                comments: [],
                comment: null,
                rating: null,
                instructorId: null,
                code: null,
                date: null,
                dropzoneOptions: {
                    url: "/api/store/files",
                    addRemoveLinks: true,
                    maxFiles: 1,
                    thumbnailWidth: 150,
                    thumbnailHeight: 150,
                    dictDefaultMessage: `<p class='text-default'><i class='fa fa-cloud-upload mr-2'></i> Arrastra los nuevos recursos</p>
                    `,
                    headers: {
                        "X-CSRF-TOKEN": document.head.querySelector("[name=csrf-token]").content
                    },
                    timeout: 180000000,
                },
                resourceName: null,
                resources: [],
                fileName: null,
                checkinstructor: false,
                server_jitsi: "https://meet.jit.si",
                room_id: "",
            };
        },
        methods: {
            async checkSubscribeSession() {
                //alert('hola');
              const that = this;
                let config = { headers: { 'Authorization': "Bearer " + this.$store.state.token } }
                await axios.post('/api/checkSubscribeSession', {
                  uuid: that.$route.params.uuid
                }, config).then(response => {
                   console.log(response, 'Respuesta Checksuscripcion');
                  if (response.data.check == 0) {
                      //alert('Hola')
                    let url = '/paid?item=' + response.data.meetingid + '&type=4';
                    this.$router.push(url);
                  }
                });
            },
            async getClassInformation () {
                let slug = this.$route.params.uuid;
                let type = this.$route.params.type;

                let config = { headers: { 'Authorization': "Bearer " + this.$store.state.token } }
                let url = '/api/get-meeting-single';
                let data = {
                    uuid:slug,
                    type:type
                }
                await axios.post(url,data, config).then(response => {
                    if (response.data.item == null) {
                        toastr.warning('La sesión ha finalizado.', 'Mensaje del sistema');
                        //this.$router.push('/dashboard-schedule')
                    }
                    console.log(response.data, 'Respuesta Meeting');
                    this.checkinstructor = response.data.checkinstructor;
                    let meeting;
                    if (!(response.data.item.meeting === undefined)){
                        meeting = response.data.item.meeting;
                        this.name = meeting.name + ' - ' + response.data.item.name;
                        this.type = 2;
                    }else{
                        meeting = response.data.item;
                        this.name = meeting.name;
                        this.type=1;
                    }

                    this.code = meeting.code;
                    //this.date = moment(response.data.item.hour_start).format('DD-MM-YYYY HH:mm');
                    this.date = moment(meeting.hour_start).format('DD-MM-YYYY HH:mm');
                    this.id = response.data.item.id;
                    this.description = meeting.description;
                    this.instructor = meeting.user.name;
                    this.instructorId = meeting.user_id;
                    if(typeof meeting.participantes !== "undefined") {
                      this.participants = meeting.participantes.length;
                    }
                    this.getComments(response.data.item.id);
                    this.getResources(response.data.item.id);
                    this.server_jitsi = response.data.server_jitsi;
                    this.room_id = response.data.item.room_id;
                   // alert(this.room_id);
                }).catch(error => {

                });

                this.loadJitsi();
            },

            setRating: function(rating){
                this.rating= rating;
                let config = { headers: { 'Authorization': "Bearer " + this.$store.state.token } };

                var url = '/api/store-rating';

                axios.post(url,{rating: this.rating, meeting: this.id, user: this.instructorId}, config).then(response => {
                    
                }).catch(error => {
    
                });  
            },
            getComments(id) {
                let config = { headers: { 'Authorization': "Bearer " + this.$store.state.token } }
                var url = '/api/get-comments';
                axios.post(url,{meeting: id}, config).then(response => {
                    this.comments = response.data;
                }).catch(error => {
                    // this.classerrors = error.response.data
                });   
            },
            getResources(id) {
                let config = { headers: { 'Authorization': "Bearer " + this.$store.state.token } }
                var url = '/api/get-resources';
                axios.post(url,{meeting: id}, config).then(response => {
                    this.resources = response.data;
                }).catch(error => {
                    // this.classerrors = error.response.data
                });   
            },
            storeComment() {
                let config = { headers: { 'Authorization': "Bearer " + this.$store.state.token } };

                var url = '/api/store-comments';

                axios.post(url,{comment: this.comment, meeting: this.id}, config).then(response => {
                    if (response.data == -9) {
                        toastr.warning('Ya hizo un comentario para esta clase', 'Mensaje del sistema');
                    } else {
                        toastr.success('Se agregó correctamente su comentario.', 'Mensaje del sistema');
                        this.getComments(this.id);
                        this.comment = '';
                    }
                }).catch(error => {
                    // this.classerrors = error.response.data
                });  
            },
            uploadSuccess(file, response) {
                toastr.success('El archivo se subió correctamente', 'Mensaje del sistema');
                this.fileName = response.file;
            },
            uploadError(file, message) {
                console.log('An Error Occurred');
            },
            storeResource() {
                let config = { headers: { 'Authorization': "Bearer " + this.$store.state.token } };

                var url = '/api/store-resources';
                let data = {
                    file: this.fileName,
                    meeting: this.id,
                    name: this.resourceName,
                }

                axios.post(url,data, config).then(response => {
                    
                        toastr.success('Se agregó correctamente el recurso.', 'Mensaje del sistema');
                        this.getResources(this.id);
                        this.resourceName = '';
                        this.fileName = '';
                        this.$refs.myVueDropzone.removeAllFiles()
                }).catch(error => {
                    // this.classerrors = error.response.data
                });  
            },
            fileRemoved() {},
            loadJitsi() {
                const headers = {
                                    "kid": "jitsi/custom_key_name",
                                    "typ": "JWT",
                                    "alg": "RS256"
                                };
                const payload = {
                                    "context": {
                                        "user": {
                                            "avatar": this.$store.state.user.photo,
                                            "name": this.$store.state.user.name,
                                            "email": this.$store.state.user.email,
                                            "id": this.$store.state.user.id,
                                        },
                                        "group": "",
                                    },
                                    "aud": "jitsi",
                                    "iss": "",
                                    "sub": "meet.jit.si",
                                    "room": "*",
                                    "exp": 1500006923,
                                    "moderator": true,
                                }

                const base64UrlHeader = window.btoa(unescape(encodeURIComponent( headers )));
                const base64UrlPayload = window.btoa(unescape(encodeURIComponent( payload )));

                const secret = "";

                var CryptoJS = require("crypto-js");

                const signature = CryptoJS.HmacSHA256(base64UrlHeader + "." + base64UrlPayload, secret);

                const base64UrlSignature = window.btoa(unescape(encodeURIComponent( signature )));

                const jwt = base64UrlHeader + "." + base64UrlPayload + "." + base64UrlSignature;

                var teacher = false;
                var toolBar = [
                        'microphone', 'camera', 'closedcaptions', 'desktop', 'fullscreen',
                        'fodeviceselection', 'hangup', 'profile', 'chat', 'etherpad', 'settings', 'raisehand',
                        'videoquality', 'filmstrip', 'shortcuts',
                        'tileview', 'videobackgroundblur', 'download'];
                if (this.isInstructor) {
                    teacher = true;
                    toolBar = [
                                'microphone', 'camera', 'closedcaptions', 'desktop', 'fullscreen',
                                'fodeviceselection', 'hangup', 'profile', 'info', 'chat', 'recording', 'etherpad', 'settings', 'raisehand',
                                'videoquality', 'filmstrip', 'invite', 'feedback', 'stats', 'shortcuts',
                                'tileview', 'videobackgroundblur', 'download', 'help', 'mute-everyone'];
                }

                var meet = new JitsiMeet('https://meet.jit.si');
                let self = this;
                meet.on('ready', function() {
                    var interfaceConfig = {
                        // TOOLBAR_BUTTONS: toolBar,
                        SETTINGS_SECTIONS: ['language', 'devices'],
                        DEFAULT_REMOTE_DISPLAY_NAME: 'Yo',
                        SHOW_CHROME_EXTENSION_BANNER: false
                    };
                    let option = {
                        configOverwrite: {
                            channelLastN: -1,
                            startWithAudioMuted: true,
                            startWithVideoMuted: true,
                            //disableDeepLinking : true
                        },
                        roomName: this.name,
                        jwt: jwt,
                        parentNode: document.querySelector('#video'),
                        interfaceConfigOverwrite: {
                            TOOLBAR_BUTTONS: toolBar,
                            SHOW_JITSI_WATERMARK: false
                        },
                        width: '100%',
                        height: 550,
                    }
                    
                    option.interfaceConfig = interfaceConfig;

                    var conference = meet.join(self.room_id, '#video', option);
                    conference.on('joined', function() {
                        //console.log('We are in!');
                    });
                });
            },
            finishSession() {
                let config = { headers: { 'Authorization': "Bearer " + this.$store.state.token } };
                let url = '/api/finish-session';
                let data = {
                    meeting: this.id,
                    type : this.type
                }

                axios.post(url,data, config).then(response => {
                    toastr.success('Se finalizó la sesión.', 'Mensaje del sistema');
                    this.$router.push('/dashboard-schedule')
                }).catch(error => {
                    // this.classerrors = error.response.data
                });  
            },
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
    .comment-active {
        background: rgba(241, 196, 15, .15);
    }
    #video {
        height: 600px;
    }
    .form-control{
        user-select: auto !important;
    }


</style>