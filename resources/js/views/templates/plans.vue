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
                                    <div class="col-12">
                                        <dasboard-link></dasboard-link>
                                        <div class="row mb-4 mt-4 align-items-center justify-content-center">
                                            <div class="col-12 mb-4 col-md-4 plans" v-for="plan in plans" :key="plan.id">
                                                <div class="plans-header">
                                                    <h4 class="plans-header-title">plan premium</h4>
                                                    <p class="plans-header-price">$ {{ plan.price }}</p>
                                                    <small class="plan-header-subtitle">{{ plan.name }}</small>
                                                </div>
                                                <div class="plans-body">
                                                    <ul>
                                                        <li><i class="ti-star"></i> no más comisión</li>
                                                        <li><i class="ti-star"></i> consultas gratis</li>
                                                        <li><i class="ti-star"></i> agregar hasta 50 personas</li>
                                                        <li><i class="ti-star"></i> crea más de 4 links</li>
                                                        <li><i class="ti-star"></i> recordatorios en agenda</li>
                                                    </ul>
                                                </div>
                                                <div class="plans-footer">
                                                    <button class="btn btn-custom-blue" @click="pay(plan.id)">COMPRAR</button>
                                                </div>
                                            </div>
                                            <!-- <div class="col-12 mb-4 col-md-4 plans">
                                                <div class="plans-header">
                                                    <h4 class="plans-header-title">plan premium</h4>
                                                    <p class="plans-header-price">$ 4900.00</p>
                                                    <small class="plan-header-subtitle">plan anual</small>
                                                </div>
                                                <div class="plans-body">
                                                    <ul>
                                                        <li><i class="ti-star"></i> no más comisión</li>
                                                        <li><i class="ti-star"></i> consultas gratis</li>
                                                        <li><i class="ti-star"></i> agregar hasta 50 personas</li>
                                                        <li><i class="ti-star"></i> crea más de 4 links</li>
                                                        <li><i class="ti-star"></i> recordatorios en agenda</li>
                                                    </ul>
                                                </div>
                                                <div class="plans-footer">
                                                    <button class="btn btn-custom-blue">COMPRAR</button>
                                                </div>
                                            </div> -->
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
    import CarouselComponent from "../../components/CarouselComponent";
    import InformationComponent from "../../components/InformationComponent";
    import DasboardLink from "../../components/DasboardLink";
    export default {
        components: {DasboardLink, VFooter, VNav, CarouselComponent, InformationComponent},
        name: "plans.vue",
        mounted() {
            this.getPlans();
        },
        data: function() {
            return {
                plans: []
            }
        },
        methods: {
            getPlans: function() {
                var url = '/api/get-plans';
                axios.post(url).then(response => {
                    this.plans = response.data
                });
            },
            pay(plan) {
                var url = '/paid?plan=' + plan + '&type=1';

                this.$router.push(url);
            }
        }
    }
</script>

<style scoped>

</style>