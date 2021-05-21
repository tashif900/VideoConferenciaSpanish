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
            </div>
            <div class="row d-flex px-2">

                <div class="col-md-12 text-center mt-4 mb-2" style="color:#133C4E;">
                    <h2>Encuentra a un professional o un servicio</h2>
                </div>
                <div class="col-md-12 d-flex justify-content-center mb-4">
                    <div class="col-6 py-3 d-flex align-items-center justify-content-center text-white" style="background:#133C4E;">
                        <div class="row align-items-center justify-content-center">
                            <ul class="nav navbar-nav d-contents">
                                <li class="nav-item mega-menu-item-2 h-0 d-flex align-items-center">
                                    <i class="ti-menu-alt mr-2"></i> Categorías
                                    <ul class="mega-menu-item-ul-2 categorymenu">
                                        <li>
                                            <!-- <router-link :to="{ name: 'search', query: {promotion: true}}" class="text-uppercase">EN PROMOCIÓN</router-link> -->
                                            <a href="javascript:void(0)" class="text-uppercase">EN PROMOCIÓN</a>
                                        </li>
                                        <li v-for="cat,index in Category" v-bind:key="index" class="" @click="searchByCategory(cat.id)">
                                            <a href="javascript:void(0)" class="text-uppercase">{{cat.name}}</a>
                                            <!-- <router-link :to="{ name: 'search', query: {thematic: cat.id}}" class="text-uppercase">{{cat.name}}</router-link> -->

                                            <ul class="mega-menu-submenu">
                                                <li v-for="sub,index in cat.subtopics" v-bind:key="index" @click="searchBySubtopic(sub.id)">
                                                    <a class="text-uppercase" href="javascript:void(0)">{{sub.name}}</a>
                                                    <!-- <router-link :to="{ name: 'search', query: {subtopic: sub.id}}" class="text-uppercase">{{sub.name}}</router-link> -->
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nav-item mr-3 p-2 d-flex align-items-center category-dropdown">
                                    <select class="category-dropdown-menu" name="" id="" v-model="searchCategory">
                                        <option class="text-dark" v-for="cat in Category" :value =cat.id>{{cat.name}}</option>
                                    </select>
                                </li>
                                <li class="nav-item nav-search-category d-flex align-items-center">
                                    <input type="text" v-model="searchInput" placeholder="Buscar..." @keyup="filterResult()">
                                    <i class="ti-search text-white ml-2 pointer"></i>
                                </li>
                                
                                <!-- <li v-if="!islogin" class="nav-item"><a class="nav-link text-uppercase" id="show-modal-date" data-toggle="none" href="#">Entrar a la Sesión</a></li> -->
                                <!-- <li v-if="!islogin" class="nav-item"><router-link class="nav-link text-uppercase" data-toggle="none" to="/add-date">Crear Sesión</router-link></li> -->
                                <!-- <li class="nav-item"><a class="nav-link text-uppercase" data-toggle="none" href="#">Crear Cita</a></li>-->
                            </ul>
                        </div>
                        <!-- <div class="col-md-4 ml-3">
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle small" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Finanzas y contabilidad
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="#">Action</a>
                                    <a class="dropdown-item" href="#">Another action</a>
                                    <a class="dropdown-item" href="#">Something else here</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 ml-5">
                            <li class="nav-item nav-search-category d-flex align-items-center">
                                <input type="text" placeholder="Buscar...">
                                <i class="ti-search text-white ml-2 pointer"></i>
                            </li>
                        </div> -->
                    </div>
                </div>

                <div class="col-md-6 mb-5">
                    <div class="col-md-12 text-center">
                        <h4>Professionales</h4>
                        <label>Registrate gratis para llegar a mas personas</label>
                    </div>
                    <div class="row">
                        <div class="col-md-4 class-carousel" v-for="professional,index in professionals" v-bind:key=index>
                            <div class="card-carousel">
                                <div class="card-carousel-img d-flex justify-content-center align-items-end pointer">
                                    <img :src="professional.photo" alt="">
                                    <!-- <img v-else src="img/002.jpg" alt=""> -->
                                </div>
                                <div class="card-carousel-body px-2 pb-2 border">
                                    <div style="margin-bottom: -19px">
                                        <p class="small"><strong>{{professional.name}}</strong></p>
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
                <div class="col-6 mb-5">
                    <div class="col-12 text-center">
                        <h4>Cursos y Clases</h4>
                        <label><span class="text-danger">Grabadas</span> y En vivo</label>
                    </div>
                    <div class="row">
                        <div class="col-4 class-carousel" v-for="course,index in courses" v-bind:key=index>
                            <div class="card-carousel">
                                <div class="card-carousel-img d-flex justify-content-center align-items-end pointer">
                                    <img :src="course.photo" alt="">
                                </div>
                                <div class="card-carousel-body px-2 pb-2 border">
                                    <div style="margin-bottom: -19px">
                                        <p class="small"><strong>Curso: {{course.name}}</strong></p>
                                    </div>
                                    <div>
                                        <star-rating :rating="course.averageRating" :show-rating="false" :read-only="true" :star-size="16"></star-rating>
                                    </div>
                                    <p class="small"><strong>Profesional </strong>{{course.user.name}}</p>
                                    <p class="small"><strong>Price </strong>{{course.price}}</p>
                                    <p class="small"><strong>Promotion </strong> <span><small><del>{{course.price}}</del></small></span>{{course.promotional_price}}</p>
                                    <button class="btn btn-custom-blue btn-rounded carousel-btn">Ver</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center mt-5">
                        <button class="col-md-4 btn text-white" style="background: var(--blue);">Ver mas Cursos</button>
                        <div class="col-md-10 text-center">
                            <h3>Sube<span class="text-danger">gratis</span>tus cursos y <span class="text-danger">clases</span></h3>
                            <h3>Solo da <span class="text-danger">click</span> aqui</h3>
                        </div>
                        <button class="col-md-3 btn text-white" style="background: var(--blue);">Registrate</button>
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
            this.getCourses();
            $('.owl-prev').text('d');
            $('#show-modal-date').click(function() {
                $('#modaldate3').modal('show');
            })
        },
        data: function() {
            return {
                data: [],
                professionals:[],
                courses:[],
                searchCategory: 1,
                searchInput: "",
            };
        },
        methods: {
            filterResult(){
                if(this.searchInput.length > 0 ){
                    var searchlength = this.searchInput.length%3;
                    if(searchlength == 0){
                        this.professionals = [];
                        console.log('njasn');
                        axios.get('api/filter-by-search?cat_id='+this.searchCategory+'&search='+this.searchInput).then((response)=>{
                            this.courses = response.data;
                            for(var i=0; i<response.data.length; i++){
                                console.log(response.data[i].user);
                                this.professionals.push(response.data[i].user);
                            }
                        });
                    }

                }
            },
            searchByCategory(cat_id){
                this.professionals = [];
                this.courses = [];
                axios.get('api/filter-by-category?cat_id='+cat_id).then((response)=>{
                    this.courses = response.data;
                    for(var i=0; i<response.data.length; i++){
                        console.log(response.data[i].user);
                        this.professionals.push(response.data[i].user);
                    }
                });
            },
            searchBySubtopic(sub_id){
                this.professionals = [];
                this.courses = [];
                axios.get('api/filter-by-subtopic?sub_id='+sub_id).then((response)=>{
                    this.courses = response.data;
                    for(var i=0; i<response.data.length; i++){
                        console.log(response.data[i].user);
                        this.professionals.push(response.data[i].user);
                    }
                });
            },
            getProfessionals(){
                axios.get('api/get-user-data').then((response)=>{
                    this.professionals = response.data.data;
                }).catch(error => {
                  console.log(error.response);
                });
            },
            getCourses(){
                axios.get('api/get-courses-data').then((response)=>{
                    this.courses = response.data.data;
                }).catch(error => {
                  console.log(error.response);
                });
            },
            getWelcomeData: function() {
                let url = '/api/welcome';
                axios.post(url).then(response => {
                    // console.log(response.data, 'DataThematic');
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

    .d-contents{
        display: contents !important;
    }
    .h-0{
        height: 0px;
    }
    .category-dropdown{
        border: 3px solid steelblue;
        border-radius: 12px;
        height: 36px;
    }
    .category-dropdown-menu{
        background: transparent;
        color: white;
        outline: none;
        border: none;
    }
    .categorymenu{
        top: 0%;
        margin-top: 45%;
    }
</style>