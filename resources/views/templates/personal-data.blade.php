@extends('layouts.web')
@section('title', 'Datos Personales')
@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css">
@endsection
@section('content')
    <div class="row mt-4">
        <div class="col-12">
            <div class="card-white">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <a class="nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Datos Personales</a>
                                    <a class="nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Instructor</a>
                                </div>
                            </nav>
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                    <form action="">
                                        <div class="row my-4">
                                            <div class="col-12 col-md-3 text-center">
                                                <img src="/img/banner.jpg" width="150px" height="150px" class="rounded-circle" alt="">
                                                <button type="button" class="btn btn-block btn-dark mt-3">Subir Foto</button>
                                            </div>
                                            <div class="col-12 col-md-9">
                                                <div class="row">
                                                    <div class="col-12 col-md-8">
                                                        <div class="form-group row mt-3">
                                                            <label for="staticEmail" class="col-sm-4 col-form-label">Nombres</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control" id="staticEmail">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-4">
                                                        <div class="form-group row mt-3">
                                                            <label for="staticEmail" class="col-sm-4 col-form-label">Edad</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control" id="staticEmail">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <div class="form-group row mt-3">
                                                            <label for="staticEmail" class="col-sm-4 col-form-label">Nacionalidad</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control" id="staticEmail">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <div class="form-group row mt-3">
                                                            <label for="staticEmail" class="col-sm-4 col-form-label">Profesión</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control" id="staticEmail">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <div class="form-group row mt-3">
                                                            <label for="staticEmail" class="col-sm-4 col-form-label">Teléfono</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control" id="staticEmail">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <div class="form-group row mt-3">
                                                            <label for="staticEmail" class="col-sm-4 col-form-label">Grado</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control" id="staticEmail">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <div class="form-group">
                                                    <label for="">Intereses</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="form-group">
                                                    <label for="">Descripción</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-12">
                                                <h5>Datos de la Cuenta</h5>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="form-group">
                                                    <label for="">Correo Electrónico</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="form-group">
                                                    <label for="">Contraseña</label>
                                                    <input type="password" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row my-4">
                                            <div class="col-12">
                                                <button class="btn btn-rounded btn-custom-red">Guardar</button>
                                                <button class="btn btn-rounded btn-custom-blue">Cancelar</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                    <form action="">
                                        <div class="row my-4">
                                            <div class="col-12">
                                                <h4>Datos Generales</h4>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="form-group row mt-3">
                                                    <label for="staticEmail" class="col-sm-4 col-form-label">Cédula</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="staticEmail">
                                                    </div>
                                                </div>
                                                <div class="form-group row mt-3">
                                                    <label for="staticEmail" class="col-sm-4 col-form-label">Pasaporte</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="staticEmail">
                                                    </div>
                                                </div>
                                                <div class="form-group row mt-3">
                                                    <label for="staticEmail" class="col-sm-4 col-form-label">Otro</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="staticEmail">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="form-group row mt-3">
                                                    <label for="staticEmail" class="col-sm-4 col-form-label">Grados de Instrucción</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="staticEmail">
                                                    </div>
                                                </div>
                                                <div class="form-group row mt-3">
                                                    <label for="staticEmail" class="col-sm-4 col-form-label">Tipo de Institución</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="staticEmail">
                                                    </div>
                                                </div>
                                                <div class="form-group row mt-3">
                                                    <label for="staticEmail" class="col-sm-4 col-form-label">Nombre de Institución</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="staticEmail">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <h4>Formas de Pago</h4>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="form-group row mt-3">
                                                    <label for="staticEmail" class="col-sm-4 col-form-label">Paypal</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="staticEmail">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="form-group row mt-3">
                                                    <label for="staticEmail" class="col-sm-4 col-form-label">Clave <small>Únicamente para México</small></label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="staticEmail">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection
