<template>
    <div class="col-12 mt-4">
        <button class="btn btn-custom-blue">Respuestas</button>
        <div v-if="HelpDesk.length>0" >
            <div v-for="item in HelpDesk">
                <div class="col-12 mt-3">
                    <input v-model="item.title" class="form-control" readonly>
                </div>
                <div class="col-12 mt-3">
                    <textarea v-model="item.description" name="" id="" cols="30" rows="10" class="form-control" readonly></textarea>
                </div>
            </div>
        </div>
        <div v-else>
            <span>Sin respuestas</span>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ResponseHelpDesk",
        data(){
          return{
              HelpDesk: []
          }
        },
        mounted() {
          this.HelpDesk = this.HelpDeskR;
        },
        props:[
            'HelpDeskR'
        ],
        computed:{
            isHelpDesk(){

            }
        }
    }
</script>

<style scoped>

</style>