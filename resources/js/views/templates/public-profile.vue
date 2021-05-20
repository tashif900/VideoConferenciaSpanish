<template>
    <div>
        <v-nav></v-nav>
        <div class="body-container">
            <div class="container">
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card-white">
                            <div class="row public-profile">
                                <div class="col-12 col-md-9">
                                    <p class="text-muted text-uppercase mb-0">PROFESIONALES</p>
                                    <h2>{{ name }}</h2>
                                    <p><strong>{{ deal }} {{ profession }}</strong></p>

                                    <div class="row">
                                        <div class="col-12 col-md-3">
                                            <p class="my-0">Total de Estudiantes</p>
                                            <p style="font-size: 22px"><strong>{{ participants }}</strong></p>
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <p class="my-0">Valoraciones Clases</p>
                                            <star-rating v-model="rating" :read-only="true" :star-size="25"></star-rating>
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <p class="my-0">Valoraciones Cursos</p>
                                            <star-rating v-model="rating" :read-only="true" :star-size="25"></star-rating>
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <p class="my-0">Valoraciones Sesiones</p>
                                            <star-rating v-model="rating" :read-only="true" :star-size="25"></star-rating>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <h5>Sobre mí</h5>
                                            <p>{{ description }}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 mb-4">
                                            <h5>Mis Cursos ({{ totalCourse }})</h5>
                                        </div>
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-12 col-md-6 col-lg-4 mb-3" v-for="dat in courses" :key="dat.name">
                                                    <div class="item border">
                                                        <div class="card-carousel">
                                                            <div class="card-carousel-img d-flex justify-content-center align-items-center">
                                                                <img :src="dat.photo" alt="">
                                                            </div>
                                                            <div class="card-carousel-body px-2 pb-2">
                                                                <h5>{{ dat.name }}</h5>
                                                                <star-rating :rating="dat.rating" :read-only="true" :star-size="18"></star-rating>
                                                                <p><strong>Instructor</strong> {{ dat.user.name }}</p>
                                                                <p><strong>$ {{ dat.price }}</strong></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <nav>
                                                <ul class="pagination">
                                                    <li class="page-item" v-if="pagination.current_page > 1">
                                                        <a class="page-link" href="#"  @click.prevent="changePage(pagination.current_page - 1)"><span>Atras</span></a>
                                                    </li>
                                                    <li class="page-item" v-for="page in pagesNumber" :key="page" v-bind:class="[ page == isActived ? 'active' : ''] ">
                                                        <a class="page-link" href="#" @click.prevent="changePage(page)">{{ page }}</a>
                                                    </li>
                                                    <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                                        <a class="page-link" href="#" @click.prevent="changePage(pagination.current_page + 1)"><span>Siguiente</span></a>
                                                    </li>
                                                </ul>
                                            </nav>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-3">
                                    <div class="profile-image">
                                        <img :src="photo" alt="">
                                    </div>
                                    <div class="status-icon"><span></span> Disponible</div> 
                                    <div class="row">
                                        <div class="col-12">
                                            <button class="btn btn-block btn-custom-blue" @click="checkLogin()">Contactar</button>
                                            <a class="btn btn-block btn-custom-red-outline" target="_blank" :href="fb"><i class="ti-facebook"></i> Facebook</a>
                                            <a class="btn btn-block btn-custom-red-outline" target="_blank" :href="twitter"><i class="ti-twitter-alt"></i> Twitter</a>
                                            <a class="btn btn-block btn-custom-red-outline" target="_blank" :href="linkedin"><i class="ti-linkedin"></i> Linkedin</a>
                                            <a class="btn btn-block btn-custom-red-outline" target="_blank" :href="instragram"><i class="ti-instagram"></i> Instagram</a>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="row mb-4">
                                <div class="col-12">
                                    <label><strong>Comentarios</strong></label>
                                    <ul class="list-unstyled">
                                        <li class="media border-bottom p-3" v-for="comment in comments" :key="comment.id">
                                            <img :src="comment.photo" class="mr-3" width="64px" height="64px">
                                            <div class="media-body">
                                                <h5 class="mt-0 mb-1">{{ comment.user }} <small class="text-muted">{{ comment.created }} - en {{ comment.where }}</small></h5>
                                                {{ comment.comment }}                                    
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="contact" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Contactar con el Instructor</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Escribe tu mensaje</label>
                        <textarea class="form-control" v-model="message"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-custom-red" @click="sendMessage">Enviar</button>
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
    import StarRating from 'vue-star-rating';

    import vue2Dropzone from "vue2-dropzone";
    import "vue2-dropzone/dist/vue2Dropzone.min.css";
    let uuid = require("uuid");

    export default {
        name: "add-class",
        components: {VFooter, VNav, InformationComponent, StarRating},
        mounted: function () {
            this.getUserInformation();
        },
        data: function () {
            return {
                id: null,
                name: null,
                photo: null,
                profession: null,
                studies: null,
                fb: null,
                linkedin: null,
                twitter: null,
                instragram: null,
                description: null,
                interests: null,
                disponibility: null,
                rating: null,
                deal: null,
                courses: [],
                totalCourse: 0,
                pagination: {
                    total: 0,
                    current_page: 0,
                    per_page: 0,
                    last_page: 0,
                    from: 0,
                    to: 0
                },
                offset: 3,
                participants: 0,
                comments: [],
                message: null,
            }
        },
        methods: {
          checkLogin() {
            if (!this.islogin) {
              this.$router.push('/login-v');
            } else {
              $('#contact').modal('show');
            }
          },
            sendMessage() {
                if (this.message != null) {
                    let config = { headers: {'Authorization': "Bearer " + this.$store.state.token } };
                    let url = '/api/message/start-conversation';
                    axios.post(url,{instructor: this.id, message: this.message}, config).then(response => {
                        if (response.data) {
                            toastr.success('Se envió tu mensaje.', "Mensaje del sistema");
                            $('#contact').modal('hide');

                            this.$router.push('/dashboard-messages');
                        }
                    }).catch(error => {
                        console.log(error);
                    });   
                } else {
                    toastr.warning('Debe escribir un mensaje.', "Mensaje del sistema");
                }
            },
            getUserInformation: function() {
                let id = this.$route.params.id;
                var url = '/api/get-user-information';
                axios.post(url, {id: id}).then(response => {
                    this.id = response.data.user.id;
                    this.name = response.data.user.name;
                    this.studies = response.data.user.people.name_institution;
                    this.profession = response.data.user.people.profession;
                    this.photo = response.data.user.photo;
                    this.rating = response.data.user.averageRating;
                    this.deal = response.data.user.people.deal.deal;
                    this.description = response.data.user.people.description;
                    this.twitter = response.data.user.people.tw_link;
                    this.linkedin = response.data.user.people.ln_link;
                    this.fb = response.data.user.people.fb_link;
                    this.instragram = response.data.user.people.ig_link;
                    this.participants = response.data.totalStudents;
                    this.getUserCourseInformation();
                    this.getUserComments();
                });
            },
            getUserCourseInformation: function(page) {
                let id = this.$route.params.id;
                var url = '/api/get-user-course-information?page=' + page;
                axios.post(url, {id: id}).then(response => {
                    this.courses = response.data.courses.data,
                    this.pagination = response.data.pagination;
                    this.totalCourse = response.data.courses.total;
                });
            },
            getUserComments: function() {
                let id = this.$route.params.id;
                var url = '/api/get-user-comments';
                axios.post(url, {id: id}).then(response => {
                    this.comments = response.data;
                });
            },
            changePage: function (page) {
                this.pagination.current_page = page;
                this.getUserCourseInformation(page);
            }
        },
        computed:{
            Category(){
                return this.$store.getters.getCategories;
            },
            isActived: function () {
                return this.pagination.current_page;
            },
            pagesNumber: function () {
                if (!this.pagination.to) {
                    return [];
                }

                var from = this.pagination.current_page - this.offset;
                if (from < 1) {
                    from = 1;
                }

                var to = from + (this.offset * 2);
                if (to >= this.pagination.last_page) {
                    to = this.pagination.last_page;
                }

                var pageArray = [];
                while (from <= to) {
                    pageArray.push(from);
                    from++;
                }
                return pageArray;
            },
            islogin: function(){
                return this.$store.getters.loggedIn;
            },
        }
    }
</script>

<style scoped>
</style>