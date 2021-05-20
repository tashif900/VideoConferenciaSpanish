<template>
    <nav class="profile-tabs">
        <div class="nav nav-tabs nav-justified" id="nav-tab" role="tablist">
            <router-link class="nav-link" v-bind:class="{ active: ishome }" id="nav-home-tab" data-toggle="tab" to="/dashboard-user" role="tab" aria-controls="nav-home" aria-selected="true"><img src="/img/home.png"> <span>Home</span></router-link>
            <router-link class="nav-link" v-bind:class="{ active: isprofile }" id="nav-profile-tab" data-toggle="tab" to="/dashboard-profile" role="tab" aria-controls="nav-profile" aria-selected="false"><img src="/img/perfil.png"> <span>Perfil</span></router-link>
            <router-link class="nav-link" v-bind:class="{ active: ispayment }" id="nav-payment-tab" data-toggle="tab" to="/dashboard-payment" role="tab" aria-controls="nav-payment" aria-selected="false"><img src="/img/metodo-pago.png"> <span>Métodos de Pago</span></router-link>
            <router-link class="nav-link" v-bind:class="{ active: ishelp_desk }"  id="nav-help-tab" data-toggle="tab" to="/dashboard-help" role="tab" aria-controls="nav-help" aria-selected="false"><img src="/img/centro-ayuda.png"> <span>Centro de Ayuda</span></router-link>
            <router-link class="nav-link" v-bind:class="{ active: isincome }" v-if="isInstructor"  id="nav-income-tab" data-toggle="tab" to="/dashboard-income" role="tab" aria-controls="nav-income" aria-selected="false"><img src="/img/tus-ingresos.png"> <span>Tus Ingresos</span></router-link>
            <router-link class="nav-link"  v-bind:class="{ active: isschedule }" id="nav-agenda-tab" data-toggle="tab" to="/dashboard-schedule" role="tab" aria-controls="nav-agenda" aria-selected="false"><img src="/img/agenda.png"> <span>Agenda</span></router-link>
            <router-link class="nav-link"  v-bind:class="{ active: ismessage }" id="nav-message-tab" data-toggle="tab" to="/dashboard-messages" role="tab" aria-controls="nav-message" aria-selected="false"><img src="/img/messages.png"> <span>Mensajes</span></router-link>
        </div>
    </nav>
</template>

<script>
    export default {
        name: "DasboardLink",

        props:[
            //Carga propiedades externas
            'home', 'profile', 'payment', 'help_desk', 'income', 'schedule'
        ],
        mounted() {
            this.checkPlan2();
        },

        methods:{
            checkPlan2(){
                let url ="/api/checkPlanUser"
                axios.get(url,  {
                    headers:{Authorization: "Bearer " + this.$store.state.token}
                }).then(response =>{
                 //   console.log(response.data, 'Respuesta');
                    if (response.data==1){
                        this.checkPlan_d=true;
                    }else{
                        this.checkPlan_d=false;
                    }
                }).catch(error => {
                    console.log(error.response);
                })
               // console.log(this.checkPlan, 'CheckPlan')
            },

        },

        data(){
            return{
                ishome : this.home,
                isprofile : this.profile,
                ispayment : this.payment,
                ishelp_desk: this.help_desk,
                isincome: this.income,
                isschedule: this.schedule,
                ismessage: this.message,
                checkPlan_d: false
            }
        },
        computed:{
            isInstructor (){
                return this.$store.state.user.roles[0].name == "Profesor";
            },
        }
    }
</script>

<style scoped>

</style>