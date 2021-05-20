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
                                <legend>Datos Generales</legend>
                                <form action="" method="POST" enctype="multipart/form-data">
                                    <div class="row mb-4">
                                        <div class="col">
                                            <label>Nombre de la Clase</label>
                                            <input type="text" name="name" class="form-control" placeholder="Nombre del Curso" required>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col">
                                            <label>Descripción</label>
                                            <input type="text" name="description" class="form-control" placeholder="Descripción" required>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col">
                                            <label>Hora de Inicio</label>
                                            <input type="datetime-local" class="form-control" placeholder="" name="start_hour" required>
                                        </div>
                                        <div class="col">
                                            <label>Hora de Fin</label>
                                            <input type="datetime-local" class="form-control" placeholder="" name="start_hour" required>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col">
                                            <label>Imagen</label>
                                            <input type="file" class="form-control" name="image" required>
                                        </div>
                                        <div class="col">
                                            <label>URL</label>
                                            <input type="text" name="url_presentation" class="form-control" placeholder="Video de Presentación" required>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col">
                                            <div class="dropzone border border-warning" id="document-dropzone">
                                                <div class="dz-message">
                                                    Haz click aqui para subir tus videos. O sueltalos aqui.
                                                </div>
                                            </div>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
    <script>
        var uploadedDocumentMap = {};
        Dropzone.prototype.defaultOptions.dictCancelUpload = "Cancelar Subida";
        Dropzone.prototype.defaultOptions.dictRemoveFile = "Eliminar Archivo";
        Dropzone.prototype.defaultOptions.dictMaxFilesExceeded = "You can not upload any more files.";
        Dropzone.options.documentDropzone = {
            url: '/upload/vimeo/video',
            addRemoveLinks: true,
            acceptedFiles: 'video/*',
            timeout: 180000,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            success: function (file, response) {
                $('form').append('<input type="hidden" name="file" value="' + response + '">')
                uploadedDocumentMap[file.name] = response
            },
            removedfile: function (file) {
                file.previewElement.remove()
                var name = ''
                if (typeof file.file_name !== 'undefined') {
                    name = file.file_name
                } else {
                    name = uploadedDocumentMap[file.name]
                }

                $.ajax({
                    type: 'post',
                    url: '/files/video/remove',
                    data: {
                        _token: '{{ csrf_token() }}',
                        file: name,
                    },
                    success: function (response) {
                        $('form').find('input[name="file[]"][value="' + name + '"]').remove();
                        $('form').find($('*[data-file="'+name+'"]')).remove();
                    },
                    error: function(response) {
                        console.log(response);
                    }
                });
            },
            error: function() {
                toastr.error('No puede subir esta imagen');
                toastr.error('Si excede el límite permitido de imágenes, solo se cargarán la cantidad permitida segun el plan que elija.');
            },
            init: function () {

            }
        }
    </script>
@endsection
