<div class="header-main">
    <div class="container-fluid">
        <div class="row">
            <nav class="navbar navbar-expand-lg navbar-light w-100" id="header-navbar">
                <li class="nav-item mega-menu-item">
                    <i class="ti-menu-alt"></i>

                    <ul class="mega-menu-item-ul">
                        <li class=""><a class="text-uppercase" href="#">Citas</a></li>
                        <li class=""><a class="text-uppercase" href="#">Cursos</a></li>
                        <li class=""><a class="text-uppercase" href="#">Clases</a></li>
                    </ul>
                </li>
                <a class="navbar-brand font-weight-bold" href="/"><img src="/img/logo2b.png" alt="" width="200px"></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item pr-3 nav-search-category d-flex align-items-center">
                            <select name="" id="">
                                <option value="">Categoria</option>
                                <option value="">Categoria</option>
                                <option value="">Categoria</option>
                                <option value="">Categoria</option>
                            </select>
                        </li>
                        <li class="nav-item nav-search-category d-flex align-items-center">
                            <input type="text">
                            <i class="ti-search text-white ml-2"></i>
                        </li>
                        @auth
                            <li class="nav-item"><a class="nav-link text-uppercase" data-toggle="none" href="#">Mi Cuenta</a></li>
                            <li class="nav-item"><a class="nav-link text-uppercase" data-toggle="none" href="#">Citas</a></li>
                            <li class="nav-item"><a class="nav-link text-uppercase" data-toggle="none" href="#">Cursos</a></li>
                            <li class="nav-item"><a class="nav-link text-uppercase" data-toggle="none" href="#">Clases</a></li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img id="userphoto" src="{{ auth()->user()->photo == null ? asset('img/default.png') : asset(auth()->user()->photo) }}"
                                         width="40" height="40" class="rounded-circle">
                                    {{Auth::user()->name}}
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <a class="dropdown-item" href="/edit-profile">Editar Perfil</a>
                                    <form action="{{ route('logout') }}" method="post">
                                        @csrf
                                        <input type="submit" class="dropdown-item" value="Cerrar Sesión">
                                    </form>
                                </div>
                            </li>
                        @endauth
                        @guest
                            <li class="nav-item"><a class="nav-link text-uppercase" data-toggle="none" href="#">Entrar a la Cita</a></li>
                            <li class="nav-item"><router-link class="nav-link text-uppercase" data-toggle="none" to="/add-date">Crear Cita</router-link></li>
                           <!-- <li class="nav-item"><a class="nav-link text-uppercase" data-toggle="none" href="#">Crear Cita</a></li>-->
                            <li class="nav-item"><a class="nav-link text-uppercase" data-toggle="none" href="/register-profesor">Enseña</a></li>
                        @endguest
                    </ul>
                    <div class="navbar-spacer"></div>
                    @guest
                        <a class="btn btn-outline-primary navbar-button text-nowrap mr-2" href="/login" data-toggle="none">Iniciar Sesión</a>
                        <a class="btn btn-outline-primary navbar-button text-nowrap" href="/register" data-toggle="none">Regístrate</a>
                    @endguest
                </div>
            </nav>
        </div>
    </div>
</div>
