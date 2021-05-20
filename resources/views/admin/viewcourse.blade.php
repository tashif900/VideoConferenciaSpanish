@extends('adminlte::page')

@section('title', 'Curso')

@section('content_header')

@stop

@section('content')

{{-- top course descriptions --}}
<div class="card">
  <div class="card-header">
    <h2>{{$course->name}}</h2>
  </div>

  <div class="card-body">
    <div class="row">
      <div class="col-9">
        <div class="row">

          <div class="col-3">
            <div class="form-group">
              <label for="">Subtema</label>
              <input type="text" class="form-control" id="" name="" placeholder="Fecha de Inicio"
                value="{{$course->subtopic->name}}" disabled>
            </div>
          </div>

          <div class="col-3">
            <div class="form-group">
              <label for="type">Tipo de curso</label>
              <input type="text" class="form-control" id="" name="" placeholder="Fecha de Fin"
                value="{{$course->type_course == 1 ? 'Grabada' : 'Online'}}" disabled>
            </div>
          </div>
          <div class="col-3">
            <div class="form-group">
              <label for="price">Precio</label>
              <input type="text" class="form-control" id="" name="" placeholder="Fecha de Fin"
                value="{{$course->price}}" disabled>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>
{{-- end top course descriptions --}}


{{-- datatable class --}}
<div id="" class="card">
  <div class="card-header text-dark">
    <h3>Lista de clases</h3>
    <p><button type="button" class="btn btn-secondary" id="btnAdd"><i class="fa fa-plus"></i> Registrar</button></p>
  </div>

  <div class="card-body">
    <table class="table display responsive nowrap" id="tb_data" style="width: 100%">
      <thead>
        <tr class="bg-warning text-white">
          <th>Nombre del curso</th>
          <th>Hora de inicio</th>
          <th>Hora de fin</th>
          <th>Course</th>
          <th>Operaciones</th>
        </tr>
      </thead>
      <tbody>

      </tbody>
    </table>
  </div>
</div>
{{-- end datatable course --}}

{{-- start model class --}}
<div class="modal" role="dialog" tabindex="-1" id="mdlClass">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-warning text-white">
        <h5 class="modal-title" id="titleClass">Nueva clase</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" id="formClass" name="formClass">
          @csrf
          <input type="hidden" id="id" name="id">
          <input type="hidden" id="course_id" name="course_id" value="{{ $course->id }}">
          <input type="hidden" id="user_id" name="user_id" value="{{ $course->user_id }}">

          <div class="row col-md-12">

            <div class="col-md-6">
              <div class="card">
                <div class="card-body">
                  <div class="form-group">
                    <label for="name">Nombre *</label>
                    <input type="text" class="form-control" id="name" name="name"
                      placeholder="Ingresar el nombre del curso">
                  </div>
                  <div class="form-group">
                    <label for="name">Descripción *</label>
                    <textarea class="form-control" id="description" name="description">
                    </textarea>
                  </div>
                  <div class="form-group">
                    <label for="start_date">Hora de inicio *</label>
                    <input type="datetime-local" class="form-control" id="hour_start" name="hour_start">
                  </div>
                  <div class="form-group">
                    <label for="start_date">Hora de fin *</label>
                    <input type="datetime-local" class="form-control" id="hour_end" name="hour_end">
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="card">
                <div class="card-body">
                  <div class="form-group">
                    <label for="photo">Foto *</label>
                    <input type="file" class="form-control-file" id="photo" name="photo" accept="image/*">
                  </div>
                  <div class="form-group">
                    <label for="url_presentation">URL presentacion *</label>
                    <input type="text" class="form-control" id="url_presentation" name="url_presentation"
                      placeholder="URL de presentacion">
                  </div>
                  <div class="form-group">
                    <label for="type">Tipo de clase *</label>
                    <select class="form-control" name="type_class" id="type_class">
                      <option value="1">Grabada</option>
                      <option value="2">Online</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="theme">Subtema *</label>
                    <select class="form-control" name="subtopic_id" id="subtopic_id">
                      @foreach ($subtopics as $s)
                      <option value="{{$s->id}}">{{$s->name}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div id="videos" class="col">
                    <label for="type">Video</label>
                    <div class="dropzone border border-warning" id="document-dropzone" style="height: 100px">
                      <div class="dz-message">
                        Haz click aqui para subir tus videos. O sueltalos aqui.
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-warning" id="btnSave">Grabar</button>
      </div>
    </div>
  </div>
</div>
{{-- end modal class --}}

@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.31/moment-timezone-with-data-1970-2030.min.js">
</script>
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
          $('#formClass').append('<input type="hidden" id="file" name="file" value="' + response + '">')
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
                  $('#formClass').find('input[name="file[]"][value="' + name + '"]').remove();
                  $('#formClass').find($('*[data-file="'+name+'"]')).remove();
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

  moment.tz.setDefault("America/Guayaquil");
  let hour = moment().format().slice(0, 16);
  document.getElementById("hour_start").min = hour;
  document.getElementById("hour_end").min = hour;

  $('#btnAdd').click(function() {
      clearinput();
      $('#titleClass').html("Nueva clase");
      $('#mdlClass').modal('show');
      $('#id').val('');
      $('#name').val('');
      $('#description').val('');
      $('#hour_start').val('');
      $('#hour_end').val('');
      $('#photo').val('');
      $('#url_presentation').val('');
      $('#type_class option')[0].selected = true;
      $('#subtopic_id option')[0].selected = true;
      $('#type_class').trigger('change');
  });

  let tb_data = $('#tb_data').DataTable({
      'processing': false,
      'serverSide': true,
      'responsive': true,
      'ajax': {
          'url': '/admin/dtcourseclass/' + "{{$course->id}}",
          'type' : 'get',
      },
      'language': {
          'url': '//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json',
      },
      'columns': [
          {data: 'name'},
          {
            data: 'hour_start', 
            render: function(data){
              return data.slice(0, 16);
            }
          },
          {
            data: 'hour_end',
            render: function(data){
              return data.slice(0, 16);
            }
          },
          {data: null, render(data, type, row){ return "{{$course->name}}"; }},
          {data: null},
      ],
      'fnRowCallback': function(nRow, aData) {
          let button = '';
          button += '<button type="button" class="btn btn-warning btn-xs edit"><i class="fa fa-edit"></i></button> &nbsp; &nbsp;';
          button += '<button type="button" class="btn btn-danger btn-xs delete"><i class="fas fa-trash"></i></button> &nbsp; &nbsp;';
          $(nRow).find('td:eq(4)').html(button);
      }
  });

  $('body').on('click', '.edit', function() {
      clearinput();
      $('#titleClass').html("Actualizar clase");
      let data = tb_data.row( $(this).parents('tr') ).data();

      // $('#titleClass').html("Actualizar clase");
      $('#mdlClass').modal('show');
      $('#id').val(           data['id']);
      $('#name').val(         data['name']);
      $('#description').val(  data['description']);
      $('#hour_start').val(   data['hour_start'].replace(' ', 'T'));
      $('#hour_end').val(     data['hour_end'].replace(' ', 'T'));
      $('#photo').val('');
      $('#url_presentation').val( data['url_presentation']);
      $('#type_class').val(   data['type_class']);
      $('#subtopic_id').val(  data['subtopic_id']);
      $('#type_class').trigger('change');
  });


  $('body').on('click', '.delete', function() {
      let data = tb_data.row( $(this).parents('tr') ).data();

      $.ajax({
              url: '/admin/deletecourseclass/' + data['id'],
              type: 'get',
              data: data,
              'success': function(response) {
                  if(response == true) {
                      toastr.warning('Se elimino satisfactoramente el registro');
                      tb_data.ajax.reload();
                  }else{
                      toastr.error('Ha ocurrido un error :(');
                  }
              }
      });
  });

  $('#btnSave').click(function() {
    let data = new FormData();
    data.append('photo', $('#photo')[0].files[0]);
    if(validate_data() == true){
        $.ajax({
            url: '{{route('savecourseclass')}}' + '?' + $('#formClass').serialize(),
            type: 'post',
            data: data,
            processData: false,
            contentType: false,
            'success': function(response) {
                if(response == true) {
                    toastr.success('Se grabósatisfactoramente');
                    tb_data.ajax.reload();
                    $('#mdlClass').modal('hide');
                }else{
                    toastr.error('Ha ocurrido un error :(');
                }
            }
        });
    }
  });

  $('#type_class').change(function(){ 
    if($('#type_class').val() == '1')
      $('#videos').show();
    else{
      $('#videos').hide();
      $('#file').remove();
    }
  });
  $('#type_class').trigger('change');

  function validate_data()
  {
      clearinput();
      if($('#name').val() == '')
      {
          $('#name').removeClass("is-valid");
          $('#name').addClass("is-invalid");
          toastr.error('Lo sentimos el campo nombre es obligatorio');
          return false;
      } 
      if($('#description').val() == '')
      {
          $('#description').removeClass("is-valid");
          $('#description').addClass("is-invalid");
          toastr.error('Lo sentimos el campo descripcion es obligatorio');
          return false;
      } 
      if($('#hour_start').val() == '')
      {
          $('#hour_start').removeClass("is-valid");
          $('#hour_start').addClass("is-invalid");
          toastr.error('Lo sentimos el campo hora de inicio es obligatorio');
          return false;
      }             
      if($('#hour_end').val() == '')
      {
          $('#hour_end').removeClass("is-valid");
          $('#hour_end').addClass("is-invalid");
          toastr.error('Lo sentimos el campo final de hora es obligatorio');
          return false;
      }              
      if($('#url_presentation').val() == '')
      {
          $('#url_presentation').removeClass("is-valid");
          $('#url_presentation').addClass("is-invalid");
          toastr.error('Lo sentimos el campo video de URL es obligatorio');
          return false;
      }
      if($('#photo').val() == '' && $('#id').val() == '')
      {
          $('#photo').removeClass("is-valid");
          $('#photo').addClass("is-invalid");
          toastr.error('Lo sentimos el campo foto es obligatorio');
          return false;
      } 
      if($('#type_class').val() == '1' && $('#file').val() != '' && $('#id').val() == ''){
          toastr.error('Cuando la clase en GRABADA se requiere que suba un video');
          return false;
      }
      return true;
  }

  function clearinput()
  {
      $('#name').removeClass("is-invalid");
    
      $('#description').removeClass("is-invalid");
  
      $('#hour_start').removeClass("is-invalid");
  
      $('#hour_end').removeClass("is-invalid");
  
      $('#url_presentation').removeClass("is-invalid");
  }

</script>
@stop