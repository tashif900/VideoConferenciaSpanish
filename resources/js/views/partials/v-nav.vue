<template>
    <div>
        <div class="header-main">
            <div class="container-fluid">
                <div class="row">
                    <nav class="navbar navbar-expand-xl navbar-default w-100" id="header-navbar">
                        <div class="container-fluid">
                            <div class="navbar-header text-white">
                                <button class="navbar-toggler text-white collapsed" type="button" data-toggle="collapse" data-target="#navbar-brand-centered" aria-controls="navbar-brand-centered" aria-expanded="false" aria-label="Toggle navigation">
                                    <span class="navbar-toggler-icon text-white"><i class="ti-menu"></i></span>
                                </button>
                                <div class="navbar-brand navbar-brand-centered">
                                    <router-link class="navbar-brand font-weight-bold tex-center" to="/"><img src="/img/logo2b.png" alt="" width="135px"></router-link>
                                </div>
                            </div>
                            <div class="navbar navbar-expand-xl navbar-light w-100 navbar-collapse d-xl-flex justify-content-xl-between collapse" id="navbar-brand-centered">
                                <ul class="nav navbar-nav">
                                    <li class="nav-item mega-menu-item">
                                       <i class="ti-menu-alt"></i> Categorías
                                        <ul class="mega-menu-item-ul">
                                            <li><router-link :to="{ name: 'search', query: {promotion: true}}" class="text-uppercase">EN PROMOCIÓN</router-link></li>
                                            <li v-for="cat in Category" class="">
                                                <router-link :to="{ name: 'search', query: {thematic: cat.id}}" class="text-uppercase">{{cat.name}}</router-link>

                                                <ul class="mega-menu-submenu">
                                                    <li v-for="sub in cat.subtopics">
                                                        <!-- <a class="text-uppercase" href="#">{{sub.name}}</a> -->
                                                        <router-link :to="{ name: 'search', query: {subtopic: sub.id}}" class="text-uppercase">{{sub.name}}</router-link>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="nav-item pr-3 nav-search-category d-flex align-items-center">
                                        <select name="" id="" v-model="searchCategory">
                                            <option v-for="cat in Category" :value =cat.id>{{cat.name}}</option>
                                        </select>
                                    </li>
                                    <li class="nav-item nav-search-category d-flex align-items-center">
                                        <input type="text" v-model="searchInput" placeholder="Buscar...">
                                        <i class="ti-search text-white ml-2 pointer" @click="goToSearch"></i>
                                    </li>
                                    
                                    <!-- <li v-if="!islogin" class="nav-item"><a class="nav-link text-uppercase" id="show-modal-date" data-toggle="none" href="#">Entrar a la Sesión</a></li> -->
                                    <!-- <li v-if="!islogin" class="nav-item"><router-link class="nav-link text-uppercase" data-toggle="none" to="/add-date">Crear Sesión</router-link></li> -->
                                    <!-- <li class="nav-item"><a class="nav-link text-uppercase" data-toggle="none" href="#">Crear Cita</a></li>-->
                                </ul>
                                <ul class="nav navbar-nav navbar-right">
                                    <li v-if="islogin" class="nav-item">
                                        <router-link class="nav-link text-uppercase" data-toggle="none" to="/dashboard-user">Mi Cuenta</router-link>
                                    <li v-if="islogin && isInstructor"  class="nav-item dropdown">
                                        <a class="nav-link text-uppercase dropdown-toggle"
                                        href="#">Sesiones</a>
                                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                            <router-link to="/createmeeting" class="dropdown-item">Nueva Sesión Individual</router-link>
                                            <router-link to="/schedulemeeting" class="dropdown-item">Nueva Sesión Múltiple</router-link>
                                        </div>
                                    </li>
                                    <li v-if="islogin"  class="nav-item dropdown">
                                        <a class="nav-link text-uppercase dropdown-toggle"
                                        href="#">Cursos</a>
                                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                            <router-link to="/mis-cursos" class="dropdown-item">Mis Cursos</router-link>
                                            <router-link to="/add-course" v-if="isInstructor" class="dropdown-item">Agregar Curso</router-link>
                                        </div>
                                    </li>
                                    <li v-if="islogin" class="nav-item dropdown">
                                        <a class="nav-link text-uppercase dropdown-toggle"
                                        href="#">Clases</a>
                                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                            <router-link to="/mis-clases" class="dropdown-item">Mis Clases</router-link>
                                            <router-link to="/add-class" v-if="isInstructor" class="dropdown-item">Agregar Clase</router-link>
                                        </div>
                                    </li>

                                    <li v-if="islogin" class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                                        >
                                            <img id="userphoto" src="/img/default.png"
                                                width="40" height="40" class="rounded-circle"> <span v-if="getUser!=null">{{getUser.name}}</span>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                            <router-link to="/mis-anuncios" v-if="isInstructor" class="dropdown-item">Mis Anuncios</router-link>
                                            <router-link to="/dashboard-profile" class="dropdown-item">Editar Perfil</router-link>
                                            <router-link to ='/reportuser' class="dropdown-item">Reportar Usuario</router-link>
                                            <router-link to="/logout-v" class="dropdown-item">Cerrar Sesión</router-link>
                                            <!--<form action="" method="post">
                                                <input type="submit" class="dropdown-item" value="Cerrar Sesión">
                                            </form>-->
                                        </div>
                                    </li>
                                    <div class="navbar-spacer"></div>
                                    <a id="darsesiones" v-if="!islogin" class="btn btn-outline-primary navbar-button text-nowrap mb-2 mb-lg-0 mr-lg-2" href="/register-teacher" data-toggle="none">Dar Sesiones</a>
                                    <a v-if="!islogin" class="btn btn-outline-primary navbar-button text-nowrap mb-2 mb-lg-0 mr-lg-2" href="/login-v" data-toggle="none">Iniciar Sesión</a>
                                    <a v-if="!islogin" class="btn btn-outline-primary navbar-button text-nowrap" href="/register-v" data-toggle="none">Regístrate</a>
                                </ul>
                            </div>
                        </div>                       
                    </nav>
                </div>
            </div>
        </div>
        <date-component></date-component>
    </div>
</template>

<script>
    import utils from "vue";
    import DateComponent from "../../components/GoDateComponent";

    export default {
        components: {DateComponent },
        data(){
          return{
              searchCategory: 1,
              searchInput: null,
          }
        },
        mounted() {
            $('.mega-menu-item').click(function() {
                $('.mega-menu-item-ul').toggleClass('show-mega-menu');
            });
            $('.mega-menu-item-2').click(function() {
                $('.mega-menu-item-ul-2').toggleClass('show-mega-menu');
            });
            $('#show-modal-date').click(function() {
                $('#modaldate').modal('show');
            });
            $('.dropdown-toggle').click(function (e) {
                e.preventDefault();

                let drop = $(this).next();

                if (drop.hasClass('show')) {
                    drop.removeClass('show')
                } else {
                    $('.dropdown-toggle').next().removeClass('show');
                    drop.addClass('show')
                }                
            });
            // const $dropdown = $(".dropdown");
            // const $dropdownToggle = $(".dropdown-toggle");
            // const $dropdownMenu = $(".dropdown-menu");
            // const showClass = "show";
            
            // $(window).on("load resize", function() {
            // if (this.matchMedia("(min-width: 768px)").matches) {
            //     $dropdown.hover(
            //     function() {
            //         const $this = $(this);
            //         $this.addClass(showClass);
            //         $this.find($dropdownToggle).attr("aria-expanded", "true");
            //         $this.find($dropdownMenu).addClass(showClass);
            //     },
            //     function() {
            //         const $this = $(this);
            //         $this.removeClass(showClass);
            //         $this.find($dropdownToggle).attr("aria-expanded", "false");
            //         $this.find($dropdownMenu).removeClass(showClass);
            //     }
            //     );
            // } else {
            //     $dropdown.off("mouseenter mouseleave");
            // }
            // });
        },
        methods:{
            goToSearch: function() {
                if (this.searchCategory && this.searchInput) {
                    var url = '/search?thematic=' + this.searchCategory + '&query=' + this.searchInput;

                    this.$router.push(url);
                }
            }
        },
        computed: {
            islogin: function(){
                return this.$store.getters.loggedIn;
            },
            getUser: function () {
                return this.$store.state.user;
            },
            Category(){
                return this.$store.getters.getCategories;
            },
            isInstructor (){
                return this.$store.state.user.roles[0].name == "Profesor";
            },
        }
    }
</script>

<style scoped>
.navbar-brand-centered {
    height: 76px;
    line-height: 76px;
    top: 0;
    width: 230px;
    text-align: center;
}
@media screen and (min-width:768px){
    .navbar-brand-centered {
        position: absolute;
        left: 50%;
        display: block;
        width: 160px;
        top: 0;
        text-align: center;
        height: 86px;
        z-index: 999;
    }
    .navbar>.container .navbar-brand-centered, 
    .navbar>.container-fluid .navbar-brand-centered {
        margin-left: -80px;
    }
    #darsesiones{
        background: #cc2649!important;
        border: 1px solid #cc2649!important;
    }
    .pointer {
        cursor: pointer;
    }
}
/* @media screen and (max-width:1200px){
    .navbar-header {
        width: 100%;
        height: 78px;
    }
} */
</style>