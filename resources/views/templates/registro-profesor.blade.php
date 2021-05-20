@extends('layouts.auth')
@section('title', 'Registro de Profesores')
@section('content')
    <div class="row hvh-100">
        <div class="col-12 col-lg-6 hvh-100 login-left-sidebar">
            <div class="row justify-content-center hvh-100 align-items-center">
                <div class="col-12 col-md-9 text-center">
                    <div class="mb-4">
                        <img src="/img/logo2b.png" alt="" width="200px">
                    </div>
                    <h2 class="text-white text-center mb-4">Registro</h2>
                    <form action="">
                        <div class="form-group">
                            <input type="text" placeholder="Nombres" class="form-control">
                        </div>
                        <div class="form-group">
                            <input type="email" placeholder="Correo" class="form-control">
                        </div>
                        <div class="form-group">
                            <input type="text" placeholder="Contraseña" class="form-control">
                        </div>
                        <div class="form-group">
                            <input type="text" placeholder="Profesión" class="form-control">
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" placeholder="Intereses"></textarea>
                        </div>
                        <div class="form-group text-center mt-4">
                            <button class="btn btn-rounded btn-custom-blue">Registrarme</button>
                        </div>

                        <hr class="login-divider">

                        <div class="form-row">
                            <div class="col">
                                <button class="btn btn-custom-social facebook"><img src="/img/facebook-icon.png"> Registrarme con Facebook</button>
                            </div>
                            <div class="col text-right">
                                <button class="btn btn-custom-social google"><img src="/img/google-icon.png"> Registrarme con Google</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6 login-right-sidebar"></div>
    </div>
@endsection