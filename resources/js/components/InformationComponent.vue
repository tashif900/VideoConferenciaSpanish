<template>
    <div>
        <div class="row mb-4 mx-0" v-if="isInstructor">
            <div class="col-12 d-flex justify-content-center align-items-center px-0">
                <!--<div class="row cards-information">
                    <div class="col-12 col-md-4 card-information-item card-information-gray d-flex justify-content-center align-items-center">
                        <p>SÍGUENOS <a href="#"><i class="ti-facebook"></i></a> <a href="#"><i class="ti-twitter"></i></a> <a href="#"><i class="ti-instagram"></i></a></p>
                    </div>
                    <div class="col-12 col-md-4 card-information-item card-information-white">
                        <h5>conviertete en premium</h5>
                        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Alias adipisci omnis sit perferendis earum inventore qui autem? Laboriosam pariatur repellat possimus, ratione aspernatur commodi quae vitae, temporibus nesciunt nihil ullam.</p>
                        <router-link class="float-right" to="/plans">Ir</router-link>
                    </div>
                    <div class="col-12 col-md-4 card-information-item card-information-red">
                        <h5>lorem</h5>
                        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Alias adipisci omnis sit perferendis earum inventore qui autem? Laboriosam pariatur repellat possimus, ratione aspernatur commodi quae vitae, temporibus nesciunt nihil ullam.</p>
                    </div>
                </div>-->
                <img src="/img/imagen_premium.jpg" alt="premium" width="100%" height="auto">
            </div>
            <!--<div class="col-12 report-anunciante d-flex justify-content-center align-items-center">-->
            <div v-if="checkPlan" class="col-12 d-flex justify-content-center align-items-center pointer" style="background: #133C4E" @click="getPlans">
                <h1 style="color: white; font-size: 4em">Go Premium</h1>
                <!--<div class="row align-items-center" style="width: 100%">
                    <div class="col text-white">
                        <input type="text" class="report-anunciante mr-2" :value="this.$store.state.user.name" readonly>
                        <p class="mt-2 mb-0"><strong>ID: {{ this.$store.state.user.code }}</strong></p>
                    </div>
                    <div class="col">
                        <router-link class="btn btn-success mr-2 float-md-right" to="/reportuser">Reportar</router-link>
                        <router-link class="btn btn-custom-blue mr-2 float-md-right" to="/advertisements">Anunciante</router-link>
                    </div>
                </div>-->
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "InformatioComponent",
        computed:{
            Category(){
                return this.$store.getters.getCategories;
            },
            isInstructor (){
                return this.$store.state.user.roles[0].name == "Profesor";
            },
           /* checkPlan(){
                let url ="/api/checkPlanUser"
                axios.get(url,  {
                    headers:{Authorization: "Bearer " + this.$store.state.token}
                }).then(response =>{
                    console.log(response.data, 'CheckPlan');
                    return response.data, 'CheckPlan';
                }).catch(error => {
                    console.log(error.response);
                    return false;
                })
            }*/
        },
        mounted() {
            this.checkPlan2();
        },
        data () {
            return {
                checkPlan:true
            }
        },
        methods:{
            getPlans : function () {
                this.$router.push('plans');
            },
            checkPlan2(){
                let url ="/api/checkPlanUser"
                axios.get(url,  {
                    headers:{Authorization: "Bearer " + this.$store.state.token}
                }).then(response =>{
                   // console.log(response.data, 'Respuesta');
                    if (response.data==1){
                        this.checkPlan=false;
                    }else{
                        this.checkPlan=true;
                    }
                }).catch(error => {
                    if (error.response.status === 401) {
                        toastr.error ('Su sesión ha expirado, por favor inicie sesión nuevamente.', 'Mensaje Sistema');
                        this.logout();
                    }
                    //console.log(error.response.status);
                })
               // console.log(this.checkPlan, 'CheckPlan')
            },
            logout (){
                this.$store.dispatch("destroyToken").then(response =>{
                    this.$router.push({name: "home"})
                }).catch(error =>{
                    console.log(error.response, "Error")
                    this.$router.push({name: "home"})
                });
            }
        }
    }
</script>

<style scoped>
    .pointer {
        cursor: pointer;
    }
</style>