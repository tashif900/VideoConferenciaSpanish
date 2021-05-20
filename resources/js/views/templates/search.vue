<template>
    <div>
        <v-nav></v-nav>
        <div class="body-container">
            <!-- <carousel-component></carousel-component> -->
            <div class="container">
                <div class="container">
                    <div class="row">
                        <div class="col-12 mb-4">
                            <div class="title-section-cont">
                                <h3 class="title-section">Resultados de busqueda</h3>
                            </div>
                        </div>
                        <div class="col-12 class-carousel mt-4">
                            <div class="row" v-if="items">
                                <div class="col-12 col-md-6 col-lg-4 mb-3" v-for="dat in items" :key="dat.name">
                                    <div class="item border">
                                        <div class="card-carousel">
                                            <div class="card-carousel-img d-flex justify-content-center align-items-center">
                                                <img :src="dat.photo" alt="">
                                            </div>
                                            <div class="card-carousel-body px-2 pb-2">
                                                <h5 v-if="dat.type2 == 'course'">Curso: {{ dat.name }}</h5>
                                                <h5 v-else-if="dat.type2 == 'class'">Clase: {{ dat.name }}</h5>
                                                <h5 v-else>{{ dat.name }}</h5>
                                                <p v-if="dat.type == 'item'"><strong>Instructor</strong> {{ dat.user }}</p>
                                                <span v-if="dat.type == 'teachers'" class="card-carousel-body-teacher-status">Activo</span>
                                                <!-- <p style="font-size: 14px">Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatum facilis magni facilis magni  Voluptatum facilis magni facilis magni magni facilis magni!</p> -->
                                                <p v-if="dat.type != 'teachers' && dat.promotion == null"><strong>$ {{ dat.price }}</strong></p>
                                                <p v-else-if="dat.type != 'teachers' && dat.promotion != null"><strong>$ {{ dat.promotion }}</strong> <span><small><del>$ {{ dat.price }}</del></small></span></p>
                                                <button v-if="dat.type == 'teachers'" class="btn btn-custom-blue btn-rounded" @click="goToProfile(dat)">Ver Perfil</button>
                                                <button v-else class="btn btn-custom-blue btn-rounded" @click="goToPreview(dat)">Ver</button>
                                                <span v-if="dat.promotion != null" class="badge badge-light float-right" style="font-size: 16px">{{ dat.promotion }} %</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" v-else>
                                <div class="col-12 text-center">
                                    <h3>No se encontraron resultados.</h3>
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

    export default {
        components: {VNav, VFooter, carousel, CarouselComponent },
        mounted() {
            this.getSearchData();
        },
        created() {
        },
        data(){
          return{
              data: [],
              items: [],
          }
        },
        methods: {
            getSearchData: function() {
                var url = '/api/search';

                let data;

                if (this.$route.query.query == undefined && this.$route.query.subtopic == undefined && this.$route.query.promotion == undefined) {
                    data = {
                        thematic: this.$route.query.thematic
                    };
                } else if(this.$route.query.query == undefined && this.$route.query.thematic == undefined && this.$route.query.promotion == undefined) {
                    data = {
                        subtopic: this.$route.query.subtopic
                    };
                } else if(this.$route.query.promotion) {
                    data = {
                        promotion: this.$route.query.promotion
                    }
                } else {
                    data = {
                        query: this.$route.query.query,
                        thematic: this.$route.query.thematic
                    }
                }

                axios.post(url,data).then(response => {
                    this.data = response.data;
                    console.log(this.data, 'Searchs');
                    this.items = this.data.items
                });
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
            }
        },
        computed:{
            Category(){
                return this.$store.getters.getCategories;
            }
        }

    }
</script>

<style scoped>

</style>