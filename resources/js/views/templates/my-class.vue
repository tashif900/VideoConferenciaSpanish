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
                                        <h3>Mis Clases</h3>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-md-4 col-lg-3 mb-2" v-for="clase in classes" :key="clase.id">
                                        <div class="my-class-item border">
                                            <div class="my-class-item-img pointer" @click="goToClass(clase.slug)" >
                                                <img :src="clase.photo" alt="">
                                            </div>
                                            <div class="my-class-item-body py-3 px-2">
                                                <p>{{ clase.name }}</p>
                                                <p class="instructor m-0"><strong>Instructor</strong> {{ clase.instructor.name }}</p>
                                                <p class="instructor m-0 online-class-info-price"><strong>Precio</strong>  $ {{ clase.price }}</p>
                                                <p class="instructor m-0"><strong>Dificultad</strong></p>
                                                <div class="progress">
                                                    <span class="progress-bar bg-danger" v-bind:style="{width: clase.difficulty*20 + '%'}"></span>
                                                </div>
                                                                                                
                                                <button @click="goToClass(clase.slug)" class="btn btn-custom-red btn-rounded mt-3">Entrar</button>
                                                <router-link v-if="isInstructor" :to="{ name: 'editclass', params: {id: clase.id}}" class="btn btn-custom-blue btn-rounded mt-3">Editar</router-link>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-4" v-if="!classes.length">
                                    <div class="col text-center">
                                        <h4 class="text-red">Aún no tienes clases asociadas a tu cuenta.</h4>
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
            this.getMyClasses();
        },
        data: function () {
            return {
                classes: []
            }
        },
        methods: {
            getMyClasses: function () {
                let config = { headers: {'Authorization': "Bearer " + this.$store.state.token } }

                var url = '/api/get-my-classes';
                axios.post(url,{},config).then(response => {
                    this.classes = response.data;
                });
                
            },
            goToClass(slug) {
                this.$router.push('/class/' + slug);
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