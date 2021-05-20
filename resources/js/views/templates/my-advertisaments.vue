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
                                <div class="row">
                                    <div class="col-12 mb-4 mt-4">
                                        <form action="">
                                            <fieldset>
                                                <legend class="title-red">Mis Anuncios</legend>
                                                <div class="mt-2" style="text-align: center">
                                                    <router-link to="/advertisements" class="btn btn-custom-red">Crear Anuncio</router-link>
                                                </div>
                                                <div class="row mt-4" v-if="data.length >0">
                                                    <div class="col-12 col-md-6" v-for="d in data" :key="d.id">
                                                        <div class="row border mb-4">
                                                            <div class="col-12 col-md-5  px-0">
                                                                <img :src="d.img" alt="" class="adver-image">
                                                            </div>
                                                            <div class="col-12 col-md-7  py-3">
                                                                <h6>{{ d.title }}</h6>
                                                                <p>{{ d.description.substring(0,31) }}</p>

                                                                <div class="row mb-2">
                                                                    <div class="col-12 col-lg-6"><strong>Fecha de Inicio</strong><br> {{ d.from }}</div>
                                                                    <div class="col-12 col-lg-6"><strong>Fecha de Fin</strong><br> {{ d.to }}</div>
                                                                </div>
                                                                <div class="row mb-2">
                                                                    <div class="col-12 col-md-6">
                                                                        <label><strong>Estado</strong></label>
                                                                        <span class="badge badge-secondary" v-if="d.status == 0">Anuncio Pendiente</span>
                                                                        <span class="badge badge-success" v-else-if="d.status == 1">Anuncio Publicado</span>
                                                                        <span class="badge badge-warning" v-else-if="d.status == 2">Anuncio Concluido</span>
                                                                        <span class="badge badge-danger" v-else-if="d.status == 3">Desestimado</span>
                                                                        <span class="badge badge-danger" v-else-if="d.status == 4">Pendiente Pago</span>
                                                                    </div>
                                                                    <div v-if="d.status ==3" class="col-12 col-md-6">
                                                                        <router-link class="btn btn-custom-blue btn-rounded mt-3"
                                                                                     :to="{path: '/advertisements/' + d.id}">Editar</router-link>

                                                                    </div>
                                                                    <div v-if="d.status ==4" class="col-12 col-md-6">
                                                                        <a href="#" @click="paidAd(d)" class="btn btn-custom-blue btn-rounded mt-3">Pagar</a>
                                                                        <!--<router-link :to="{path: '/paid?item=' + d.vigency + '&type=5'}"
                                                                                     class="btn btn-custom-blue btn-rounded mt-3">Pagar</router-link>-->
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row" v-else>
                                                    <div class="col-12">Aún no tiene Anuncios creados</div>
                                                </div>
                                            </fieldset>
                                        </form>
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
    import DasboardUser from "../../components/DasboardUser";
    export default {
        components: {DasboardUser, VFooter, VNav, CarouselComponent, InformationComponent},
        name: "myads",
        data: function() {
            return {
                data: [],
            };
        },
        mounted: function() {
            this.getData();
        },
        methods: {
            async paidAd(d){
                let id = d.id;
                let days =d.vigency;
                let url = '/api/updateDate-avertisement';
                let config = { headers: { 'Authorization': "Bearer " + this.$store.state.token } }
                let startdate = moment(moment().add('days', 1).format('DD-MM-YYYY'), 'DD-MM-YYYY').format('DD-MM-YYYY');
                let enddate = moment(startdate,'DD-MM-YYYY').add('days', days).format('DD-MM-YYYY');
                let data = {
                    id: id,
                    from: startdate,
                    to: enddate
                }
                await axios.post(url,data, config).then(response => {
                    this.data = response.data
                    this.$router('/paid?item=' + d.vigency + '&type=5');
                    //console.log(this.data, 'Datta');
                });

                //console.log(d, 'Data');
            },
            getData: function () {
                let url = '/api/get-my-ads';
                let config = { headers: { 'Authorization': "Bearer " + this.$store.state.token } }

                axios.post(url,{}, config).then(response => {
                    this.data = response.data;
                    //console.log(this.data, 'Datta');
                });
            },
        }
    }
</script>

<style scoped>

</style>