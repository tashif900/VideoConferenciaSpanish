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
                                <h3 class="title-section">Preguntas Frecuentes</h3>
                            </div>
                        </div>
                        <div class="col-12 class-carousel mt-4">
                            <div class="accordion" id="accordionExample">
                            	<div class="card" v-for="f in data" :key="f.id">
                                	<div class="card-header" :id="'headingOne' + f.id">
                                  		<h5 class="mb-0">
                                    		<button class="btn btn-link" type="button" data-toggle="collapse" :data-target="'#collapseOne' + f.id" aria-expanded="true" aria-controls="collapseOne">
                                      			{{ f.question }}
                                    		</button>
                                  		</h5>
                                	</div>

                                	<div :id="'collapseOne' + f.id" class="collapse" :aria-labelledby="'headingOne' + f.id" data-parent="#accordionExample">
                                  		<div class="card-body" v-html="f.response">
                                  		</div>
                                	</div>
                              	</div>
                        	</div>
                    	</div>
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
            this.getFaqs();
            
        },
        data: function() {
            return {
                data: [],
            };
        },
        methods: {
            getFaqs: function() {
                var url = '/api/get-faqs';
                axios.post(url).then(response => {
                    this.data = response.data
                });
            },
        },
    }
</script>

<style scoped>

</style>