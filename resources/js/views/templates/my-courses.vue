<template>
    <div>
        <v-nav></v-nav>
        <div class="body-container">
            <!-- <carousel-component></carousel-component> -->
            <information-component></information-component>
            <div class="container">
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card-white">
                            <div class="container-fluid">
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <h3>Mis Cursos</h3>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-md-4 col-lg-3 mb-2" v-for="course in courses" :key="course.id">
                                        <div class="my-class-item border">
                                            <div class="my-class-item-img pointer" @click="goToCourse(course)">
                                                <img :src="course.photo" alt="">
                                            </div>
                                            <div class="my-class-item-body py-3 px-2">
                                                <p>{{ course.name.substring(0,32) }}</p>
                                                <p class="instructor m-0"><strong>Profesional</strong> {{ course.instructor }}</p>
                                                <p class="instructor m-0 online-class-info-price"><strong>Precio</strong>  $ {{ course.price }}</p>
                                                <p class="instructor m-0"><strong>Dificultad</strong></p>
                                                <div class="progress">
                                                    <span class="progress-bar bg-danger" style="width: 20%"></span>
                                                </div>
                                                                                                
                                                <button @click="goToCourse(course)" class="btn btn-custom-red btn-rounded mt-3">Entrar</button>
                                                <router-link v-if="isInstructor" :to="{ name: 'editcourse', params: {id: course.id}}" class="btn btn-custom-blue btn-rounded mt-3">Editar</router-link>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-4" v-if="!courses.length">
                                    <div class="col text-center">
                                        <h4 class="text-red">Aún no tienes cursos asociadas a tu cuenta.</h4>
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

    export default {
        name: "my-class",
        components: {VFooter, VNav, CarouselComponent, InformationComponent},
        mounted: function () {
            this.getMyCourses();
        },
        data: function () {
            return {
                courses: []
            }
        },
        methods: {
            getMyCourses: function () {
                let config = { headers: {'Authorization': "Bearer " + this.$store.state.token } }

                var url = '/api/get-my-courses';
                axios.post(url,{},config).then(response => {
                    this.courses = response.data;
                   // console.log(this.courses);
                });
            },
            goToCourse(course) {
               // console.log(course)
               // console.log(course.classes.length)
                if (course.classes.length===0){
                    toastr.info('Aun no ha agregado ninguna clase a su curso', "Mensaje del Sistema");
                }else{
                    this.$router.push('/curso/' + course.id + '/' + course.classes[0].id);
                }
                //course.id, course.classes[0].id
                //this.$router.push('/curso/' + course + '/' + classes);
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
    .pointer {
        cursor: pointer;
    }
</style>