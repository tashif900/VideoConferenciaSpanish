<template>
    <div>
        <v-nav></v-nav>
        <div class="body-container">
            <information-component></information-component>
            <div class="container">
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card-white">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-12">
                                        <dasboard-link></dasboard-link>
                                        <div class="col-12 mt-4">
                                            <form action="">
                                                <div class="text-center">
                                                    <h4>Elige una</h4>
                                                </div>
                                                <div class="custom-form-group" style="margin-bottom: 0">
                                                    <ul class="danger-list mt-4">
                                                        <router-link to="/createmeeting">
                                                            <li>
                                                                <input type="radio" name="type" id="myCheckbox">
                                                                <label for="myCheckbox">
                                                                    <p><strong>¡Quiero mi cita ahora! </strong></p>
                                                                </label>
                                                            </li>
                                                        </router-link>

                                                        <router-link to="schedulemeeting">
                                                            <li>
                                                                <input type="radio" name="type" id="myCheckbox2">
                                                                <label for="myCheckbox2">
                                                                    <p><strong>¿Quiero programar mi cita?</strong></p>
                                                                </label>
                                                            </li>
                                                        </router-link>

                                                    </ul>
                                                </div>
                                            </form>
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
        name: "createmeeting"
    }
</script>

<style scoped>

</style>