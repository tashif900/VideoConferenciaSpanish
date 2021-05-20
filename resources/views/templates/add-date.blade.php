@extends('layouts.web')
@section('title', 'Crear Clase')
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
                            @if (session('info'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('info') }}
                                </div>
                            @endif
                            @if (session('error'))
                                <div class="alert alert-danger" role="alert">
                                    {{ session('error') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <fieldset>
                                <legend>NUEVA CITA</legend>
                                <form action="" method="POST" enctype="multipart/form-data">
                                    <div class="row mb-4">
                                        <div class="col">
                                            <label>Nombre de la Sala</label>
                                            <input type="text" name="name" class="form-control" placeholder="Nombre de la sala" required>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col">
                                            <label>Categoría</label>
                                            <select name="" id="" class="form-control">
                                                <option value="">Seleccione una Categoría</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col">
                                            <label>Descripción Corta</label>
                                            <textarea name="" id="" class="form-control" placeholder="Descripción Corta"></textarea>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col">
                                            <label>Tipo de Cita</label>
                                            <select name="" class="form-control" id="">
                                                <option value="">Seleccione un Tipo de Cita</option>
                                            </select>
                                        </div>
                                        <div class="col">
                                            <label>N° de Participantes</label>
                                            <input type="text" class="form-control" placeholder="" name="start_hour" required>
                                        </div>
                                        <div class="col">
                                            <label>Costo</label>
                                            <input type="text" class="form-control" placeholder="" name="start_hour" required>
                                        </div>
                                    </div>
                                    <div class="row mb-4 justify-content-center">
                                        <button class="btn btn-dark" type="submit">Guardar</button>
                                    </div>
                                </form>
                            </fieldset>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
  
@endsection
