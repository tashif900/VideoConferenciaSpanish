<template>
    <div>
        <v-nav></v-nav>
        <div class="body-container">
            <carousel-component></carousel-component>
            <div class="container">
                <!-- <div class="row mb-4" v-for="dat in data" style="height: 480px">
                    <div class="col-12">
                        <div class="title-section-cont">
                            <h3 class="title-section">{{dat.theme}}</h3>
                        </div>
                    </div>
                    <div class="col-12 class-carousel mt-4">
                        <carousel :autoplay="false" :nav="false" :margin="10" :touchDrag="true" :dots="false" :responsive="{0:{items:1},600:{items:2},1000:{items:4}}">
                            <template slot="prev"><span class="owl-prev-custom"><img src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/PjwhRE9DVFlQRSBzdmcgIFBVQkxJQyAnLS8vVzNDLy9EVEQgU1ZHIDEuMS8vRU4nICAnaHR0cDovL3d3dy53My5vcmcvR3JhcGhpY3MvU1ZHLzEuMS9EVEQvc3ZnMTEuZHRkJz48c3ZnIGVuYWJsZS1iYWNrZ3JvdW5kPSJuZXcgMCAwIDMyIDMyIiBoZWlnaHQ9IjMycHgiIGlkPSJMYXllcl8xIiB2ZXJzaW9uPSIxLjEiIHZpZXdCb3g9IjAgMCAzMiAzMiIgd2lkdGg9IjMycHgiIHhtbDpzcGFjZT0icHJlc2VydmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiPjxwYXRoIGQ9Ik03LjcwMSwxNC4yNzZsOS41ODYtOS41ODVjMC44NzktMC44NzgsMi4zMTctMC44NzgsMy4xOTUsMGwwLjgwMSwwLjhjMC44NzgsMC44NzcsMC44NzgsMi4zMTYsMCwzLjE5NCAgTDEzLjk2OCwxNmw3LjMxNSw3LjMxNWMwLjg3OCwwLjg3OCwwLjg3OCwyLjMxNywwLDMuMTk0bC0wLjgwMSwwLjhjLTAuODc4LDAuODc5LTIuMzE2LDAuODc5LTMuMTk1LDBsLTkuNTg2LTkuNTg3ICBDNy4yMjksMTcuMjUyLDcuMDIsMTYuNjIsNy4wNTQsMTZDNy4wMiwxNS4zOCw3LjIyOSwxNC43NDgsNy43MDEsMTQuMjc2eiIgZmlsbD0iIzUxNTE1MSIvPjwvc3ZnPg==" alt=""></span></template>
                            <div class="item border" v-for="dat in dat.items">
                                <div class="card-carousel">
                                    <div class="card-carousel-img d-flex justify-content-center align-items-center pointer" @click="gotoSelect(dat)">
                                        <img :src="dat.photo" alt="">
                                    </div>
                                    <div class="card-carousel-body  px-2 pb-2">
                                        <div>
                                            <h5 v-if="dat.type2 == 'course'">Curso: {{ dat.name }}</h5>
                                            <h5 v-else>{{ dat.name }}</h5>
                                        </div>
                                        <div>
                                            <star-rating :rating="dat.rating" :show-rating="false" :read-only="true" :star-size="16"></star-rating>
                                        </div>
                                        <p v-if="dat.type == 'item'" class="m-0"><strong>Profesional</strong> {{ dat.user }}</p>
                                        <span v-if="dat.type == 'teachers'" class="card-carousel-body-teacher-status">Activo</span>
                                        <p v-if="dat.type != 'teachers' && dat.promotion == null"><strong>$ {{ dat.price }}</strong></p>
                                        <p v-else-if="dat.type != 'teachers' && dat.promotion != null"><strong>$ {{ dat.promotion }}</strong> <span><small><del>$ {{ dat.price }}</del></small></span></p>
                                        <button v-if="dat.type == 'teachers'" class="btn btn-custom-blue btn-rounded carousel-btn" @click="goToProfile(dat)">Ver Perfil</button>
                                        <button v-else class="btn btn-custom-blue btn-rounded carousel-btn" @click="goToPreview(dat)">Ver</button>
                                    </div>
                                </div>
                            </div>
                            <template  slot="next"><span class="owl-next-custom"><img src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/PjwhRE9DVFlQRSBzdmcgIFBVQkxJQyAnLS8vVzNDLy9EVEQgU1ZHIDEuMS8vRU4nICAnaHR0cDovL3d3dy53My5vcmcvR3JhcGhpY3MvU1ZHLzEuMS9EVEQvc3ZnMTEuZHRkJz48c3ZnIGVuYWJsZS1iYWNrZ3JvdW5kPSJuZXcgMCAwIDMyIDMyIiBoZWlnaHQ9IjMycHgiIGlkPSJMYXllcl8xIiB2ZXJzaW9uPSIxLjEiIHZpZXdCb3g9IjAgMCAzMiAzMiIgd2lkdGg9IjMycHgiIHhtbDpzcGFjZT0icHJlc2VydmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiPjxwYXRoIGQ9Ik0yNC4yOTEsMTQuMjc2TDE0LjcwNSw0LjY5Yy0wLjg3OC0wLjg3OC0yLjMxNy0wLjg3OC0zLjE5NSwwbC0wLjgsMC44Yy0wLjg3OCwwLjg3Ny0wLjg3OCwyLjMxNiwwLDMuMTk0ICBMMTguMDI0LDE2bC03LjMxNSw3LjMxNWMtMC44NzgsMC44NzgtMC44NzgsMi4zMTcsMCwzLjE5NGwwLjgsMC44YzAuODc4LDAuODc5LDIuMzE3LDAuODc5LDMuMTk1LDBsOS41ODYtOS41ODcgIGMwLjQ3Mi0wLjQ3MSwwLjY4Mi0xLjEwMywwLjY0Ny0xLjcyM0MyNC45NzMsMTUuMzgsMjQuNzYzLDE0Ljc0OCwyNC4yOTEsMTQuMjc2eiIgZmlsbD0iIzUxNTE1MSIvPjwvc3ZnPg==" alt=""></span></template>
                        </carousel>
                    </div>
                </div> -->
                <div class="row d-flex">
                    <div class="col-md-6 my-5">
                        <div class="col-md-12 text-center">
                            <h2>Professionales</h2>
                            <label>Registrate gratis para llegar a mas personas</label>
                        </div>
                        <div class="row">
                            <div class="col-md-4 class-carousel" v-for="professional,index in professionals" v-bind:key=index>
                                <div class="card-carousel">
                                    <div class="card-carousel-img d-flex justify-content-center align-items-end pointer">
                                        <img :src="professional.user_photo" alt="">
                                        <!-- <img v-else src="img/002.jpg" alt=""> -->
                                    </div>
                                    <div class="card-carousel-body px-2 pb-2 border">
                                        <div>
                                            <p class="small">{{professional.user_name}}</p>
                                        </div>
                                        <div>
                                            <star-rating :rating="3" :show-rating="false" :read-only="true" :star-size="16"></star-rating>
                                        </div>
                                        <span class="card-carousel-body-teacher-status">Activo</span>
                                        <button class="btn btn-custom-blue btn-rounded carousel-btn">Ver Perfil</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 my-5">
                        <div class="col-12 text-center">
                            <h2>Cursos y Clases</h2>
                            <label><span class="text-danger">Grabadas</span> y En vivo</label>
                        </div>
                        <div class="row">
                            <div class="col-4 class-carousel">
                                <div class="card-carousel">
                                    <div class="card-carousel-img d-flex justify-content-center align-items-end pointer">
                                        <img src="files/1621447603MjwJ3.jpeg" alt="">
                                    </div>
                                    <div class="card-carousel-body px-2 pb-2 border">
                                        <div>
                                            <h5>Curso: Curso</h5>
                                        </div>
                                        <div>
                                            <star-rating :rating="3" :show-rating="false" :read-only="true" :star-size="16"></star-rating>
                                        </div>
                                        <p class="m-0"><strong>Profesional</strong>User</p>
                                        <p><strong>Price</strong></p>
                                        <p><strong>Promotion</strong> <span><small><del>Price</del></small></span></p>
                                        <button class="btn btn-custom-blue btn-rounded carousel-btn">Ver</button>
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
    import carousel from 'vue-owl-carousel'
    import VFooter from "../partials/v-footer";
    import VNav from "../partials/v-nav";
    import CarouselComponent from "../../components/CarouselComponent";
    import DateComponent from "../../components/GoDateComponent";
    import StarRating from 'vue-star-rating';

    export default {
        components: {VNav, VFooter, carousel, CarouselComponent, DateComponent,StarRating },
        created() {
            //console.log('ms s');
        },
        mounted() {
            this.getWelcomeData();
            this.getProfessionals();
            $('.owl-prev').text('d');
            $('#show-modal-date').click(function() {
                $('#modaldate3').modal('show');
            })
        },
        data: function() {
            return {
                data: [],
                professionals:[],
            };
        },
        methods: {
            getProfessionals(){
                axios.get('api/get-user-data').then((response)=>{
                    this.professionals = response.data.data;
                });
            },
            getWelcomeData: function() {
                let url = '/api/welcome';
                axios.post(url).then(response => {
                    console.log(response.data, 'DataThematic');
                    let thematics = response.data;
                    thematics.forEach(item => {
                        if (item.items.length >0){
                            this.data.push(item);
                        }
                    });
                    //this.data = response.data
                }).catch(error => {
                    //alert('Que paso aquí :(')
                  console.log(error.response);
                });
            },
            gotoSelect (item){
                if(item.type == 'teachers'){
                    this.goToProfile(item);
                }else{
                    this.goToPreview(item);
                }
              //console.log(item, 'Veamos');
            },
            goToProfile(item) {
                this.$router.push('/perfil-publico/'+ item.id)
            },
            goToPreview(item) {
                let url;

                if (item.type2 == 'class') {
                    url = '/preview/class/' + item.id;
                } 

                if (item.type2 == 'course') {
                    url = '/preview/course/' + item.id;    
                }
                this.$router.push(url);
            },
        },
        computed:{
            Category(){
                return this.$store.getters.getCategories;
            }
        }

    }
</script>

<style scoped>
    .pointer {
        cursor: pointer;
    }

    .card-carousel{
        height: 350px !important;
    }
</style>