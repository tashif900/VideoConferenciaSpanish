<template>
    <div>
        <v-nav></v-nav>
        <div class="body-container">
            <!-- <carousel-component></carousel-component> -->
            <div class="container">
                <div class="container">
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="title-section-cont">
                                <h3 class="title-section">Política de Privacidad</h3>
                            </div>
                        </div>
                        <div class="col-12 class-carousel mt-4" v-html="info"></div>
                    </div>

                </div>
            </div>
        </div>
        <date-component></date-component>
        <v-footer></v-footer>
    </div>
</template>

<script>
    import carousel from 'vue-owl-carousel'
    import VFooter from "../partials/v-footer";
    import VNav from "../partials/v-nav";
    import CarouselComponent from "../../components/CarouselComponent";
    import DateComponent from "../../components/GoDateComponent";

    export default {
        components: {VNav, VFooter, carousel, CarouselComponent, DateComponent },
        created() {
            //console.log('ms s');
        },
        mounted() {
            this.getWelcomeData();
            this.getInfoPage();
            $('#show-modal-date').click(function() {
                $('#modaldate').modal('show');
            })
        },
        data: function() {
            return {
                data: [],
                info: null,
            };
        },
        methods: {
            getWelcomeData: function() {
                var url = '/api/get-page/politicas';
                axios.post(url).then(response => {
                  //  console.log(response.data);
                    this.info = response.data.body
                });
            },
            getInfoPage: function () {
                 var url = '/api/welhome';
                axios.post(url).then(response => {
                   // console.log(response.data);
                    this.data = response.data
                });
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

</style>