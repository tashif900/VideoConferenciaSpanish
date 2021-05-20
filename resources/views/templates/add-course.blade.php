@extends('layouts.web')
@section('title', 'Crear Cursos')
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
                    <div class="row cards-information">
                        <div class="col-12 col-md-4 card-information-item card-information-gray d-flex justify-content-center align-items-center">
                            <p>SÍGUENOS <a href="#"><i class="ti-facebook"></i></a> <a href="#"><i class="ti-twitter"></i></a> <a href="#"><i class="ti-instagram"></i></a></p>
                        </div>
                        <div class="col-12 col-md-4 card-information-item card-information-white">
                            <h5>conviertete en premium</h5>
                            <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Alias adipisci omnis sit perferendis earum inventore qui autem? Laboriosam pariatur repellat possimus, ratione aspernatur commodi quae vitae, temporibus nesciunt nihil ullam.</p>
                            <a href="#" class="float-right"><i class="ti-arrow-right"></i></a>
                        </div>
                        <div class="col-12 col-md-4 card-information-item card-information-red">
                            <h5>lorem</h5>
                            <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Alias adipisci omnis sit perferendis earum inventore qui autem? Laboriosam pariatur repellat possimus, ratione aspernatur commodi quae vitae, temporibus nesciunt nihil ullam.</p>
                            <a href="#" class="float-right"><i class="ti-arrow-right"></i></a>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-12 report-anunciante d-flex justify-content-center align-items-center">
                            <input type="text" class="report-anunciante mr-2" placeholder="Hola...">
                            <button class="btn btn-success mr-2">Reportar</button>
                            <button class="btn btn-custom-blue">Anunciante</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <fieldset>
                                <legend>Datos Generales</legend>
                                <form action="" method="POST" enctype="multipart/form-data">
                                    <div class="row mb-4">
                                        <div class="col">
                                            <label>Nombre del Curso</label>
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
                                            <label>Temática</label>
                                            <select name="thematic" class="form-control"  required>
                                                <option value="">Seleccione una Temática</option>
                                            </select>
                                        </div>
                                        <div class="col">
                                            <label>Tipo de  Curso</label>
                                            <select name="course_type" class="form-control"  required>
                                                <option value="">Seleccione un Tipo de Curso</option>
                                                <option value="1">Grabada</option>
                                                <option value="2">Online</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col">
                                            <label># de Clases</label>
                                            <input type="text" name="number_class" class="form-control" placeholder="" required>
                                        </div>
                                        <div class="col">
                                            <label>Precio Original</label>
                                            <input type="text" class="form-control" placeholder="Precio" name="price" required>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col">
                                            <label>Hora de Inicio</label>
                                            <input type="datetime-local" class="form-control" placeholder="" name="start_hour" required>
                                        </div>
                                        <div class="col">
                                            <label>Imagen</label>
                                            <input type="file" class="form-control" name="image" required>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col">
                                            <label>URL</label>
                                            <input type="text" name="url_presentation" class="form-control" placeholder="Video de Presentación" required>
                                        </div>
                                    </div>
                                    <div class="row mb-4 justify-content-center">
                                        <button class="btn btn-dark" type="submit">Guardar</button>
                                    </div>
                                </form>
                            </fieldset>
                            <fieldset>
                                <legend>Mis Curso</legend>
                                <button class="btn btn-custom-blue"  data-toggle="modal" data-target="#staticBackdrop">Agregar Clase</button>
                                <div class="table-responsive mt-4">
                                    <table class="table">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th scope="col">Fecha</th>
                                                <th scope="col">Nombre de la Clase</th>
                                                <th scope="col">Modo</th>
                                                <th scope="col"># de Participantes</th>
                                                <th scope="col">Opciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Agregar Clase</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" enctype="multipart/form-data" method="POST">
                <div class="modal-body">
                    <fieldset>
                        <legend>Datos Generales</legend>
                            <div class="row mb-4">
                                <div class="col">
                                    <label>Curso</label>
                                    <select name="course" id="course" class="form-control" required>
                                        <option value="">Seleccione un Curso</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col">
                                    <label>Nombre</label>
                                    <input type="text" class="form-control" name="name" placeholder="Nombre de la Clase" required>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col">
                                    <label>Descripción</label>
                                    <input type="text" class="form-control" name="description" placeholder="Descripción" required>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col">
                                    <label>Hora de Inicio</label>
                                    <input type="datetime-local" class="form-control" placeholder="" id="start_hour" name="start_hour" required>
                                </div>
                                <div class="col">
                                    <label>Hora de Fin</label>
                                    <input type="datetime-local" class="form-control" placeholder="" id="end_hour" name="end_hour" required>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col">
                                    <label>URL</label>
                                    <input type="text" id="url_presentation" name="url_presentation" class="form-control" placeholder="Video de Presentación" required>
                                </div>
                                {{-- <div class="col">
                                    <label>Contraseña de la Sala</label>
                                    <input type="text" class="form-control" placeholder="" required>
                                </div> --}}
                            </div>
                            <div class="row mb-4">
                                {{-- <div class="col">
                                    <label>Imagen</label>
                                    <input type="file" name="file" class="form-control">
                                </div> --}}
                                <div class="col">
                                    <div class="dropzone border border-warning" id="document-dropzone">
                                        <div class="dz-message">
                                            Haz click aqui para subir tus videos. O sueltalos aqui.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-dark">Guardar</button>
                    </div>
                </form>
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
