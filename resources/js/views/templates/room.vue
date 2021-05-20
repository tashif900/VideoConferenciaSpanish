<template>
    <div>
        <v-nav></v-nav>
        <div class="row mt-4">
            <div class="col-12">
                <div class="card-white">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <h4 class="title-blue">Nombre de la Sala</h4>
                            </div>
                            <div class="col-12 col-md-7"></div>
                            <div class="col-12 col-md-5">
                                <div class="form-group row">
                                    <label for="staticEmail" class="col-sm-4 col-form-label">Sala</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="staticEmail">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="staticEmail" class="col-sm-4 col-form-label">Instructor</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="staticEmail">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="staticEmail" class="col-sm-4 col-form-label">Hora de inicio</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="staticEmail">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="staticEmail" class="col-sm-4 col-form-label">Código de la Sala</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="staticEmail">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="staticEmail" class="col-sm-4 col-form-label">Descripción</label>
                                    <div class="col-sm-8">
                                        <textarea class="form-control"></textarea>
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
    export default {
        name: "room",
        components: {VFooter, VNav}
    }
</script>

<style scoped>

</style>