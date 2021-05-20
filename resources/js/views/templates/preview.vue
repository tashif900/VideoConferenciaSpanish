<template>
    <div>
        <v-nav></v-nav>
        <div class="body-container">
            <div class="container">
                <div class="row mt-4">
                    <div class="row">
                        <div class="col-12">
                            <div class="card-white">
                                <div class="row">
                                    <div class="col-12 col-md-6 col-lg-5">
                                        <div class="preview-course-banner">
                                            <img src="/img/preview-bg.png" alt="">
                                            <div class="preview-course-banner-copy">
                                                <h2 class="class-viewer-banner-copy-title">{{ type }}</h2>
                                                <hr>
                                                <p class="class-viewer-banner-copy-subtitle">{{ instructor }}</p>
                                                <p>{{ description }}</p>
                                                
                                                <div v-if="islogin">
                                                    <div v-if="type == 'Clase'">
                                                        <router-link v-if="instructorId == this.$store.state.user.id" :to="{ name: 'showClass', params: {slug: this.slug}}"  class="btn btn-custom-red">Entrar</router-link>
                                                        <router-link v-else-if="has" :to="{ name: 'showClass', params: {slug: this.slug}}"  class="btn btn-custom-red">Entrar</router-link>
                                                        <a href="#" v-else @click="pay(id)" class="btn btn-custom-red">Inscribirte</a>
                                                    </div>
                                                    <div v-else>
                                                        <div v-if="classs.length > 1">
                                                            <router-link v-if="instructorId == this.$store.state.user.id" :to="{ name: 'showCourse', params: {course: id, class: classs[0].id}}"  class="btn btn-custom-red">Entrar</router-link>
                                                            <router-link v-else-if="has" :to="{ name: 'showCourse', params: {course: id, class: classs[0].id}}"  class="btn btn-custom-red">Entrar</router-link>
                                                            <a href="#" v-else @click="pay(id)" class="btn btn-custom-red">Inscribirte</a>
                                                        </div>
                                                        <div v-else>
                                                            <a href="#" v-if="instructorId != this.$store.state.user.id && has" @click="pay(id)" class="btn btn-custom-red">Inscribirte</a>
                                                            <a href="#" v-else @click="toastr.info('El curso se publicará pronto')" class="btn btn-custom-red">No Publicado</a>
                                                            <p>Faltan clases por publicarse</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div v-else>
                                                    <div v-if="type=='Curso'">
                                                        <a v-if="classs.length > 1" href="#" @click="pay(id)" class="btn btn-custom-red">Inscribirte</a>
                                                        <a href="#" v-else @click="toastr.info('El curso se publicará pronto')" class="btn btn-custom-red">No te puedes inscribir</a>
                                                    </div>
                                                    <div v-else>
                                                        <a href="#" @click="pay(id)" class="btn btn-custom-red">Inscribirte</a>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-7 preview-rightsidebar">
                                        <div class="col-12 mb-4">
                                            <div class="item border">
                                                <div class="xcard video-class-item grid">
                                                    <div class="xcard-header">
                                                        <div v-if="previewType == 1" style="background: #000;">
                                                            <div v-if="statuspreview==0" class="alert alert-primary" role="alert">
                                                                El video se está procesando, espere un momento por favor para que pueda visualizarlo.
                                                            </div>
                                                            <iframe v-if="statuspreview==1" :src="previewFile" style="border: none; position: absolute; top: 0; height: 100%; width: 100%;"
                                                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                                    allowfullscreen ="true"></iframe>
                                                        </div>
                                                        <div v-else>
                                                            <img :src="previewFile">
                                                        </div>
                                                        <div class="video-class-item-type">
                                                            <span class="icon"></span> {{ visualizationType }}
                                                        </div>
                                                    </div>
                                                    <div class="xcard-body py-3 px-3">
                                                        <div class="row cross-center">
                                                            <div class="col-12 col-lg-9 pd-0">
                                                                <div class="video-class-instructor-content d-flex mt-3">
                                                                    <div class="video-class-instructor-content-avatar" >
                                                                        <img :src="instructorPhoto">
                                                                    </div>
                                                                    <div class="video-class-instructor-content-info">
                                                                        <p>{{ name }}</p>
                                                                        <small>PROFESIONAL: {{ instructor }}</small>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-lg-3 main-end pd-0 my-4">
                                                                <p><strong>$ {{ price }}</strong></p>
                                                            </div>
                                                            <div class="col-12" style="text-align: center">
                                                                <div v-if="islogin">
                                                                    <div v-if="type == 'Clase'">
                                                                        <router-link v-if="instructorId == this.$store.state.user.id" :to="{ name: 'showClass', params: {slug: this.slug}}"  class="btn btn-custom-red">Entrar</router-link>
                                                                        <router-link v-else-if="has" :to="{ name: 'showClass', params: {slug: this.slug}}"  class="btn btn-custom-red buttonms">Entrar</router-link>
                                                                        <a href="#" v-else @click="pay(id)" class="btn btn-custom-red buttonms">Inscribirte</a>
                                                                    </div>
                                                                    <div v-else>
                                                                        <div v-if="classs.length > 1">
                                                                            <router-link v-if="instructorId == this.$store.state.user.id" :to="{ name: 'showCourse', params: {course: id, class: classs[0].id}}"  class="btn btn-custom-red buttonms">Entrar</router-link>
                                                                            <router-link v-else-if="has" :to="{ name: 'showCourse', params: {course: id, class: classs[0].id}}"  class="btn btn-custom-red buttonms">Entrar</router-link>
                                                                            <a href="#" v-else @click="pay(id)" class="btn btn-custom-red buttonms">Inscribirte</a>
                                                                        </div>
                                                                        <div v-else>
                                                                            <a href="#" v-if="instructorId != this.$store.state.user.id && has" @click="pay(id)" class="btn btn-custom-red buttonms">Inscribirte</a>
                                                                            <a href="#" v-else @click="toastr.info('El curso se publicará pronto')" class="btn btn-custom-red buttonms">No Publicado</a>
                                                                            <p>Faltan clases por publicarse</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div v-else>
                                                                    <div v-if="type=='Curso'">
                                                                        <a v-if="classs.length > 1" href="#" @click="pay(id)" class="btn btn-custom-red buttonms">Inscribirte</a>
                                                                        <a href="#" v-else @click="toastr.info('El curso se publicará pronto')" class="btn btn-custom-red buttonms">No te puedes inscribir</a>
                                                                    </div>
                                                                    <div v-else>
                                                                        <a href="#" @click="pay(id)" class="btn btn-custom-red buttonms">Inscribirte</a>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-12" >
                                            <div class="row" v-for="clase in classs" :key="clase.id">
                                                <div class="col-12 preview-course-item" style="overflow: hidden;">
                                                    <img :src="clase.photo" alt="">
                                                    <div class="preview-course-item-info">
                                                        <p><strong></strong> {{ clase.name }}</p>
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
    import VNav from "../partials/v-nav";
    import VFooter from "../partials/v-footer";
    import reportuserVue from './reportuser.vue';
    
    export default {
        name: "profile",
        components: {VFooter, VNav},
        mounted() {
            this.getInformation();
        },
        data: function() {
            return {
                type: null,
                description: null,
                name: null,
                instructor: null,
                visualizationType: null,
                price: null,
                classs: [],
                instructorPhoto: null,
                banner: null,
                id: null,
                instructorId: null,
                slug: null,
                has: false,
                previewType: null,
                previewFile: null,
                previewui:null,
                statuspreview: 1
            };
        },
        methods: {
            getVideo: function (uidvideo){
                let account = '262378b615148a97817a97541574bc04';
                //let uidvideo = 'f3c0470b63123219dd2d36f6d821dab6'
                let config = {
                    headers: {
                        'X-Auth-Email': 'pagos@zurviz.com',
                        'X-Auth-Key': '592d138b11dbe6461abc7aaae0d6c72192ff8',
                        'Content-Type': 'application/json'
                    }
                };
                let url = 'https://api.cloudflare.com/client/v4/accounts/' + account + '/stream/' + uidvideo

                axios.get(url, config).then(response =>{
               //     console.log(response.data.result, 'Respuesta');
                    let result = response.data.result;
                    if (result.status.state === 'ready'){
                        this.statuspreview = 1;
                    }else{
                        this.statuspreview = 0;
                    }
                }).catch(error =>{
                    this.statuspreview = 1;
                    //toastr.error('Ha ocurrido un error')
                    console.log(error.response);
                });
            },
            async getInformation() {
                let type = this.$route.params.type;
                let id = this.$route.params.id;

                if (type == 'class') {
                    this.type = 'Clase';
                    if (this.islogin) {
                        let config = { headers: { 'Authorization': "Bearer " + this.$store.state.token } }
                        var url = '/api/get-class-information-l';
                        await axios.post(url, {id: id}, config).then(response => {
                            this.id = response.data.clase.id;
                            this.name = response.data.clase.name;
                            this.description = response.data.clase.description;
                            this.instructor = response.data.clase.instructor.name;
                            this.instructorPhoto = response.data.clase.instructor.photo;
                            if (response.data.clase.promotion_start != null && response.data.clase.promotion_start >= moment().format('YYYY-MM-DD') && moment().format('YYYY-MM-DD') <= response.data.clase.promotion_end) {
                                this.price = response.data.clase.promotional_price;
                            } else {
                                this.price = response.data.clase.price;
                            }
                            
                            this.previewType = response.data.clase.preview_type
                            this.previewFile = response.data.clase.preview_file
                            this.previewui = response.data.clase.url_presentation
                            this.banner = response.data.clase.photo;
                            this.instructorId = response.data.clase.user_id;
                            this.slug = response.data.clase.slug;
                            this.visualizationType = response.data.clase.type_class == 1 ? 'Grabada' : 'Online';
                            this.has = response.data.has;
                        });
                    } else {
                        var url = '/api/get-class-information';
                        await axios.post(url, {id: id}).then(response => {
                            this.id = response.data.clase.id;
                            this.name = response.data.clase.name;
                            this.description = response.data.clase.description;
                            this.instructor = response.data.clase.instructor.name;
                            this.instructorPhoto = response.data.clase.instructor.photo;
                            if (response.data.clase.promotion_start != null & response.data.clase.promotion_start >= moment().format('YYYY-MM-DD') && moment().format('YYYY-MM-DD') <= response.data.clase.promotion_end) {
                                this.price = response.data.clase.promotional_price;
                            } else {
                                this.price = response.data.clase.price;
                            }
                            this.previewType = response.data.clase.preview_type
                            this.previewFile = response.data.clase.preview_file
                            this.previewui = response.data.clase.url_presentation
                            this.banner = response.data.clase.photo;
                            this.instructorId = response.data.clase.user_id;
                            this.slug = response.data.clase.slug;
                            this.visualizationType = response.data.clase.type_class == 1 ? 'Grabada' : 'Online';
                        });
                    }

                } else if (type == 'course') {
                    this.type = 'Curso';
                    if (this.islogin) {
                        let config = { headers: { 'Authorization': "Bearer " + this.$store.state.token } }
                        var url = '/api/get-course-information-l';
                        await axios.post(url, {id: id}, config).then(response => {
                            this.id = response.data.course.id;
                            this.name = response.data.course.name;
                            this.description = response.data.course.description;
                            this.instructor = response.data.course.user.name;
                            this.instructorPhoto = response.data.course.user.photo;
                            this.banner = response.data.course.photo;
                            if (response.data.course.promotion_start != null && response.data.course.promotion_start >= moment().format('YYYY-MM-DD') && moment().format('YYYY-MM-DD') < response.data.course.promotion_end) {
                                this.price = response.data.course.promotional_price;
                            } else {
                                this.price = response.data.course.price;
                            }
                             this.previewType = response.data.course.preview_type
                            this.previewFile = response.data.course.preview_file
                            this.previewui = response.data.course.url_presentation
                            this.instructorId = response.data.course.user_id;
                            this.slug = response.data.course.slug;
                            this.visualizationType = response.data.course.type_class == 1 ? 'Grabada' : 'Online';
                            this.classs = response.data.course.classes;
                           // console.log(this.classs)
                        });
                    } else {
                        var url = '/api/get-course-information';
                        await axios.post(url, {id: id}).then(response => {
                            this.id = response.data.course.id;
                            this.name = response.data.course.name;
                            this.description = response.data.course.description;
                            this.instructor = response.data.course.user.name;
                            this.instructorPhoto = response.data.course.user.photo;
                            this.banner = response.data.course.photo;
                            if (response.data.course.promotion_start != null && response.data.course.promotion_start >= moment().format('YYYY-MM-DD') && moment().format('YYYY-MM-DD') < response.data.course.promotion_end) {
                                this.price = response.data.course.promotional_price;
                            } else {
                                this.price = response.data.course.price;
                            }
                             this.previewType = response.data.course.preview_type
                            this.previewFile = response.data.course.preview_file
                            this.previewui = response.data.course.url_presentation
                            this.instructorId = response.data.course.user_id;
                            this.slug = response.data.course.slug;
                            this.visualizationType = response.data.course.type_class == 1 ? 'Grabada' : 'Online';
                            this.classs = response.data.course.classes;
                        });
                    }
                }
                if (this.previewType === '1'){
                    //console.log(this.previewui, 'PreviewUI');
                    this.getVideo(this.previewui);
                }
            },
            pay(item) {
                let type;
                if (this.$route.params.type == 'class') {
                    type = 2;
                } else if (this.$route.params.type == 'course') {
                    type = 3;
                }
                var url = '/paid?item=' + item + '&type=' + type;

                this.$router.push(url);
            }
        },
        computed: {
            islogin: function(){
                return this.$store.getters.loggedIn;
            },
            
        }
    }
</script>

<style scoped>
    .video-class-item.grid .xcard-header div img, .video-class-item.grid .xcard-header div video {
        width: 480px!important;
        height: 480px!important;
        max-height: 480px!important;
    }

    .video-class-item.grid .xcard-header {
        height: 480px!important;
        max-height: 480px!important;
    }
    a.btn-custom-red{
        width: 50%;
    }
    .buttonms{
        width: 30% !important;
    }
</style>