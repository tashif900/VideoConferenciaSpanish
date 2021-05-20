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
                                        <dasboard-link :message="true" ></dasboard-link>
                                        <div class="tab-content" id="nav-tabContent">
                                            <div class="tab-pane fade show active" id="nav-message" role="tabpanel" aria-labelledby="nav-message-tab">
                                                <div class="content-wrapper chat-container-gen">
                                                    <div class="row gutters">
                                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                            <div class="card m-0">
                                                                <div class="row no-gutters">
                                                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-3 col-3">
                                                                        <div class="users-container">
<!--                                                                          <span v-if="chats.length === 0">No tienes ningún conversación</span>-->
                                                                            <ul class="users" v-if="chats.length === 0">
                                                                              <li class="person">
                                                                                <div class="user">

                                                                                </div>
                                                                                <p class="name-time">
                                                                                  <span class="name">Chats (0)</span>
                                                                                  <span class="time"></span>
                                                                                </p>
                                                                              </li>
                                                                            </ul>
                                                                            <ul class="users" v-if="typeChat == 1">
                                                                                <li class="person lchat" data-chat="person1" @click="listMessage(chat.id, chat.user1.name)" v-for="chat in chats" :key="chat.id">
                                                                                    <div class="user">
                                                                                        <img :src="chat.user1.photo" :alt="chat.user1.name">
                                                                                    </div>
                                                                                    <p class="name-time">
                                                                                        <span class="name">{{ chat.user1.name }}</span>
                                                                                        <span class="time">{{ formatDate(chat.updated_at) }}</span>
                                                                                    </p>
                                                                                </li>
                                                                            </ul>
                                                                            <ul class="users" v-else>
                                                                                <li class="person lchat" data-chat="person1" @click="listMessage(chat.id, chat.user2.name)" v-for="chat in chats" :key="chat.id">
                                                                                    <div class="user">
                                                                                        <img :src="chat.user2.photo" :alt="chat.user2.name">
                                                                                    </div>
                                                                                    <p class="name-time">
                                                                                        <span class="name">{{ chat.user2.name }}</span>
                                                                                        <span class="time">{{ formatDate(chat.updated_at) }}</span>
                                                                                    </p>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xl-8 col-lg-8 col-md-8 col-sm-9 col-9" v-if="chatMessages.length > 0">
                                                                        <div class="selected-user">
                                                                            <span>Chat con: <span class="name">{{ chatName }}</span></span>
                                                                        </div>
                                                                        <div class="chat-container">
                                                                            <ul class="chat-box chatContainerScroll">
                                                                                <div v-for="msg in chatMessages" :key="msg.id">
                                                                                    <li class="chat-left" v-if="currentUser != msg.user">
                                                                                        <div class="chat-avatar">
                                                                                            <img :src="msg.photo" alt="Retail Admin">
                                                                                            <div class="chat-name">{{ chatName }}</div>
                                                                                        </div>
                                                                                        <div class="chat-text">{{ msg.message }} </div>
                                                                                        <div class="chat-hour">{{ msg.hour }} <span class="fa fa-check-circle"></span></div>
                                                                                    </li>
                                                                                    <li class="chat-right" v-else>
                                                                                        <div class="chat-hour">{{ msg.hour }} <span class="fa fa-check-circle"></span></div>
                                                                                        <div class="chat-text">{{ msg.message }} </div>
                                                                                        <div class="chat-avatar">
                                                                                            <img :src="thisUserPhoto" alt="Retail Admin">
                                                                                            <div class="chat-name">Tú</div>
                                                                                        </div>
                                                                                    </li>
                                                                                </div>
                                                                            </ul>
                                                                            <div class="form-group mt-3 mb-4">
                                                                                <textarea class="form-control" rows="3" v-model="message" placeholder="Escribe tu mensaje aquí..."></textarea>
                                                                                <button class="btn btn-custom-blue float-right" type="button" @click="sendMessage23">Enviar</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xl-8 col-lg-8 col-md-8 col-sm-9 col-9" v-if="chats.length === 0">
                                                                      <div class="users-container">
                                                                        <p class="name-time">
                                                                          <span class="name">Mensajes (0)</span>
                                                                          <span class="time"></span>
                                                                        </p>
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
    import DasboardLink from "../../../components/DasboardLink";
    export default {
        components: {DasboardLink, VFooter, VNav, CarouselComponent, InformationComponent},
        name: "schedule.vue",
        mounted() {
            this.getChats();
        },
        data() {
            return {
                chats: [],
                chatName: null,
                typeChat: null,
                thisUserPhoto: this.$store.state.user.photo,
                chatMessages: [],
                message: null,
                currentUser: this.$store.state.user.id,
                chatId: null,
            }
        },
        methods: {
            async getChats() {
                let config = { headers: {'Authorization': "Bearer " + this.$store.state.token } };
                let url = '/api/message/list-chat';
                await axios.post(url,{}, config).then(response => {
                    this.chats = response.data.chat;
                    this.typeChat = response.data.type
                }).catch(error => {
                    console.log(error);
                });

                if (this.chats.length > 0) {
                    $(".users-container .users .person.lchat").eq(0).click();
                    $(".users-container .users .person.lchat").eq(0).click();
                //    console.log($(".users-container .users .person.lchat").eq(0).click(), 'element')
                }

            },
            async listMessage(chat, name = null) {
                this.chatName = name;
                let config = { headers: {'Authorization': "Bearer " + this.$store.state.token } };
                let url = '/api/message/list-chat-message';
                this.chatId = chat;
                await axios.post(url,{chat: chat}, config).then(response => {
                    this.chatMessages = response.data;
                }).catch(error => {
                    console.log(error);
                });
                $("body .chatContainerScroll").animate({ 
                    scrollTop: $( 
                      'body .chatContainerScroll').get(0).scrollHeight 
                }, 100); 
            },
            sendMessage23() {
                if (this.message != null) {
                    let config = { headers: {'Authorization': "Bearer " + this.$store.state.token } };
                    let url = '/api/message/new-message';
                    axios.post(url,{chat: this.chatId, message: this.message}, config).then(response => {
                        if (response.data) {
                            this.message = null;
                            this.listMessage(this.chatId)
                            $(".chatContainerScroll").animate({ 
                                scrollTop: $( 
                                '.chatContainerScroll').get(0).scrollHeight 
                            }, 100); 
                            this.getChats();
                        }
                    }).catch(error => {
                        console.log(error);
                    });   
                } else {
                    toastr.warning('Dede de escribir un mensaje.', 'Mensaje del sistema');
                }
            },
            formatDate(date) {
                return moment(date).format('DD-MM-YYYY');
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