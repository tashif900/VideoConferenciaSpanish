<template>
    <div>
        <v-nav></v-nav>
        <div class="body-container">
            <!--            <carousel-component></carousel-component>-->
            <information-component></information-component>
            <div class="container-lg">
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card-white">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-12">
                                        <dasboard-link :schedule="true" ></dasboard-link>
                                        <div class="tab-content" id="nav-tabContent">
                                            <div class="tab-pane fade show active" id="nav-agenda" role="tabpanel" aria-labelledby="nav-agenda-tab">
                                                <div class="row my-4" v-if="isInstructor">
                                                    <div class="col-12 d-flex justify-content-center">
                                                        <router-link to="/meetingtype">
                                                            <button class="btn btn-custom-blue btn-rounded">Crear una Sesión</button>
                                                        </router-link>

                                                    </div>
                                                </div>
                                                <div class="row mt-4">
                                                    <div class="col-12 col-md-8">
                                                        <div class="row schedule-table-content">
                                                            <div class="col-12">
                                                                <h4 class="mydateTitle green"><strong>Mis Sesiones</strong> <span></span></h4>

                                                                <div class="table-responsive">
                                                                    <table class="table table-hover">
                                                                        <thead class="thead-green">
                                                                        <tr>
                                                                            <th scope="col">Cita</th>
                                                                            <th scope="col">Tipo</th>
                                                                            <th scope="col">Hora</th>
                                                                            <th scope="col">Rol</th>
                                                                            <!--<th scope="col">Estado</th>-->
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        <tr class="row-hover"  v-for="meeting in todayMeeting" @click="goToMeeting(meeting.room, meeting.type)">
                                                                            <td>{{ meeting.name }}</td>
                                                                            <td>{{meeting.type}}</td>
                                                                            <td>{{ meeting.hour }}</td>
                                                                            <td>{{ meeting.anfitrion }}</td>
                                                                        </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row schedule-table-content">
                                                            <div class="col-12">
                                                                <h4 class="mydateTitle blue"><strong>Próximas Sesiones</strong> <span></span></h4>

                                                                <div class="table-responsive">
                                                                    <table class="table table-hover">
                                                                        <thead class="thead-blue">
                                                                        <tr>
                                                                            <th scope="col">Cita</th>
                                                                            <th scope="col">Fecha</th>
                                                                            <th scope="col">Hora</th>
                                                                            <th scope="col">Rol</th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        <tr class="row-hover" v-for="meeting2 in upcomingMeeting">
                                                                            <td>{{ meeting2.name }}</td>
                                                                            <td>{{ meeting2.date }}</td>
                                                                            <td>{{ meeting2.hour }}</td>
                                                                            <td>{{ meeting2.anfitrion }}</td>
                                                                        </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row schedule-table-content">
                                                            <div class="col-12">
                                                                <h4 class="mydateTitle pink"><strong>Sesiones Pasadas</strong> <span></span></h4>

                                                                <div class="table-responsive">
                                                                    <table class="table table-hover">
                                                                        <thead class="thead-pink">
                                                                        <tr>
                                                                            <th scope="col">Cita</th>
                                                                            <th scope="col">Fecha</th>
                                                                            <th scope="col">Hora</th>
                                                                            <th scope="col">Rol</th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        <tr class="row-hover" v-for="meeting3 in pastMeeting">
                                                                            <td>{{ meeting3.name }}</td>
                                                                            <td>{{ meeting3.date }}</td>
                                                                            <td>{{ meeting3.hour }}</td>
                                                                            <td>{{ meeting3.anfitrion }}</td>
                                                                        </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-4">
                                                        <functional-calendar :marked-dates="calendarMeeting"></functional-calendar>
                                                    </div>
                                                </div>
                                            </div>
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
    import VNav from "../../partials/v-nav";
    import VFooter from "../../partials/v-footer";
    import CarouselComponent from "../../../components/CarouselComponent";
    import InformationComponent from "../../../components/InformationComponent";
    import { FunctionalCalendar } from 'vue-functional-calendar';
    import DasboardLink from "../../../components/DasboardLink";
    import Vue2 from 'vue';
    export default {
        components: {DasboardLink, VFooter, VNav, CarouselComponent, InformationComponent,FunctionalCalendar},
        name: "schedule.vue",
        mounted() {
            this.setCurrentUser();
            this.getTodaysMeeting();
            this.getUpcomingMeeting();
            this.getPastsMeeting();
            //this.calendarMeeting();
        },
        data() {
            return {
                calendarData: {},
                todayMeeting: [],
                upcomingMeeting: [],
                currentUser: null,
                pastMeeting: [],
                calendarConfigs: {
                    sundayStart: false,
                    dateFormat: 'dd-mm-yyyy',
                    isDatePicker: false,
                    isDateRange: false
                },
                meeting: [],
            }
        },
        methods: {
            setCurrentUser() {
                this.currentUser = this.$store.state.user.id;
            },
            getTodaysMeeting() {
                let url = '/api/get-todays-meeting';
                axios.post(url, {user: this.$store.state.user.id} , {
                    headers:{Authorization: "Bearer " + this.$store.state.token}
                }).then(response =>{
                    this.todayMeeting = response.data;
                    /*let todatMeetings = [];
                    for (let index = 0; index < response.data.length; index++) {
                        let date = response.data[index]['date'];
                        let fecha = date.split('-');

                        // this.markedDates.push({
                        //     date: response.data[index]['datej'],
                        //     class: 'todayMeetings',
                        // });

                        Vue2.set(this.markedDates, index, {
                            date: response.data[index]['datej'],
                            class: 'todayMeetings',
                        })
                    }*/

                }).catch(error => {
                    console.log(error);
                })
            },
            getUpcomingMeeting() {
                let url = '/api/get-upcoming-meeting';
                axios.post(url, {user: this.$store.state.user.id} , {
                    headers:{Authorization: "Bearer " + this.$store.state.token}
                }).then(response =>{
                    this.upcomingMeeting = response.data;

                    /*let upcomingMeetings = [];
                    //for (let index = 0; index < response.data.length; index++) {
                        let date = response.data[index]['date'];
                        let fecha = date.split('-');
                        this.markedDates.push({
                            date: response.data[index]['datej'],
                            class: 'upcomingMeetings',
                        });
                    }*/
                }).catch(error => {
                    console.log(error);
                })
            },
            getPastsMeeting() {
                let url = '/api/get-pasts-meeting';
                axios.post(url, {user: this.$store.state.user.id} , {
                    headers:{Authorization: "Bearer " + this.$store.state.token}
                }).then(response =>{
                    this.pastMeeting = response.data;
                    //console.log(this.pastMeeting = response.data, "Meeting Past");
                    /*let pastMeetings = [];
                    for (let index = 0; index < response.data.length; index++) {
                        let date = response.data[index]['datej'];
                        let fecha = date.split('-');
                        this.markedDates.push({
                            date: response.data[index]['date'],
                            class: 'pastMeetings',
                        });
                    }*/
                }).catch(error => {
                    console.log(error);
                })
            },
            goToMeeting(room, type) {
                let type_url = type == 'Individual' ? 1 : 2;
                window.location.href = "/meeting/" + room + "/" + type_url;
            },
        },
        computed:{
            isInstructor (){
                return this.$store.state.user.roles[0].name == "Profesor";
            },

            calendarMeeting (){
                let url = '/api/get-calendar-meeting';

                let markedDates =[];
                axios.post(url, {user: this.$store.state.user.id} , {
                    headers:{Authorization: "Bearer " + this.$store.state.token}
                }).then(response =>{
                    //console.log (response.data, 'Calendar Meeting');
                    let cal_meet = response.data;
                    cal_meet.forEach(function callback(value) {
                        for (let i = 0; i < value.length; i++){
                            let date = moment(value[i]['hour_start']).format('D/m/Y')
                            //console.log (date, 'Fechaaa 1');
                            let classtype ="";

                            if (value[i].state_type===1){
                                classtype = 'todayMeetings';
                            }else if (value[i].state_type===2){
                                classtype = 'upcomingMeetings';
                            }else{
                                classtype = 'pastMeetings';
                            }
                            markedDates.push({
                                date: date,
                                class: classtype
                            })
                        }
                    })
                }).catch(error => {
                    console.log(error);
                })
                return markedDates;
            }

        }
    }
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style>
    .vfc-today {
        background-color: #83E8CD !important;
    }

    .todayMeetings {
        background-color: #83E8CD !important;
    }

    .upcomingMeetings{
        background-color: #47B9D8 !important;
    }

    .pastMeetings {
        background-color: #F2A4C0 !important;
    }

    .row-hover {
        cursor: pointer;
    }
</style>