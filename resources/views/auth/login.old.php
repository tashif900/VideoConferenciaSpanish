@extends('layouts.auth')
@section('title', 'Acceder')
@section('content')
    <div class="row hvh-100">
        <div class="col-12 col-lg-6 hvh-100 login-left-sidebar">
            <div class="row justify-content-center hvh-100 align-items-center">
                <div class="col-12 col-md-9 text-center">
                    <div class="mb-4">
                        <img src="/img/logo2b.png" alt="" width="200px">
                    </div>
                    <h2 class="text-white text-center">Acceder</h2>
                    <form action="{{route('login')}}" method="POST">
                        @csrf
                        @if (session('info'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('info') }}
                            </div>
                        @endif
                        <div class="form-group">
                            <input type="email" name="email" placeholder="Email" class="form-control @error('email') is-invalid @enderror" required autocomplete="email">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                   <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" placeholder="Contraseña" class="form-control @error('password') is-invalid @enderror" required>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                     <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <label class="text-white"><input type="checkbox"> Mantenerme Conectado</label>
                            </div>
                            <div class="col text-right">
                                <a href="#" class="text-white">¿Olvidaste tu Contraseña?</a>
                            </div>
                        </div>
                        <div class="form-group text-center mt-4">
                            <button type="submit" class="btn btn-rounded btn-custom-blue">INGRESAR</button>
                        </div>

                        <hr class="login-divider">

                        <div class="form-row">
                            <div class="col">
                                <a class="btn btn-custom-social facebook"><img src="{{ asset('img/facebook-icon.png') }}"> Ingresar con Facebook</a>
                            </div>
                            <div class="col text-right">
                                <a class="btn btn-custom-social google"><img src="{{ asset('img/google-icon.png') }}"> Ingresar con Google</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6 login-right-sidebar"></div>
    </div>
@endsection
