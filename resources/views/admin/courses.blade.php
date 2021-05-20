@extends('adminlte::page')

@section('title', 'Cursos')

@section('content_header')

@stop

@section('content')
{{-- datatable course --}}
<div id="datatableCourse" class="card">
  <div class="card-header text-dark">
    <h2>Cursos</h2>
    <p><button type="button" class="btn btn-secondary" id="btnAdd" hidden><i class="fa fa-plus"></i> Registrar</button></p>
  </div>

  <div class="card-body">
    <table class="table display responsive nowrap" id="tb_data" style="width: 100%">
      <thead>
        <tr class="bg-warning text-white">
          <th>Nombre</th>
          <th>Instructor</th>
          <th>Subtema</th>
          <th>Tipo</th>
          <th>Precio</th>
          <th>Hora de inicio</th>
          <th>Estado</th>
          <th>Operaciones</th>
        </tr>

      </thead>
      <tbody>
      </tbody>
    </table>
  </div>
</div>

{{-- end datatable course --}}

{{-- modal course --}}
<div class="modal" role="dialog" tabindex="-1" id="mdlCourses">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-warning text-white">
        <h5 id="titleCourse" class="modal-title">Nuevo Curso</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <form method="post" id="formCourse" name="formCourse">
          @csrf
          <input id="id" name="id" hidden>
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
                    <label for="type">Tipo de clase *</label>
                    <select class="form-control" name="type_course" id="type_course">
                      <option value="1">Grabada</option>
                      <option value="2">Online</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="number_class">Numero de clases *</label>
                    <input type="number" class="form-control" id="number_class" name="number_class"
                      placeholder="Ingrese el numero de clases">
                  </div>
                  <div class="form-group">
                    <label for="user_id">Ponente *</label>
                    <select class="form-control" name="user_id" id="user_id">
                      @foreach($teachers as $t)
                      <option value="{{$t->id}}">{{$t->name}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card">
                <div class="card-body">
                  <div class="form-group">
                    <label for="price">Precio</label>
                    <input type="number" class="form-control" id="price" name="price" placeholder="Precio">
                  </div>
                  <div class="form-group">
                    <label for="start_date">Dia de inicio *</label>
                    <input type="date" class="form-control" id="date_start" name="date_start">
                  </div>
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
                    <label for="theme">Subtema *</label>
                    <select class="form-control" name="subtopic_id" id="subtopic_id">
                      @foreach ($subtopics as $s)
                        <option value="{{$s->id}}">{{$s->name}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="abbreviation">Estado</label>
                    <select class="form-control" name="state" id="state" required>
                        <option value="0">Inactivo</option>
                        <option value="1" selected>Activo</option>
                        <option value="2">Concluido</option>
                    </select>
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
{{-- final del modal --}}

@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.31/moment-timezone-with-data-1970-2030.min.js">
</script>
<script>
  moment.tz.setDefault("America/Guayaquil");
  let hour = moment().format().slice(0, 10);
  document.getElementById("date_start").min = hour;

  $('#btnAdd').click(function() {
    clearinput();
    $('#titleCourse').html("Nuevo curso");
    $('#mdlCourses').modal('show');
    $('#id').val('');
    $('#name').val('');
    $('#description').val('');
    $('#type_course option')[0].selected = true;
    $('#number_class').val('');
    $('#price').val('');
    $('#date_start').val('');
    $('#photo').val('');
    $('#url_presentation').val('');
    $('#user_id option')[0].selected = true;
    $('#subtopic_id option')[0].selected = true;
    $('#state').val(1);

    // $('#type_course').prop('disabled', false);
    // $('#type_course').trigger('change');
  });

  let tb_data = $('#tb_data').DataTable({
    'order': [[6, 'desc']],
    'processing': false,
    'serverSide': true,
    'responsive': true,
    'ajax': {
        'url': '{{route('dtcourses')}}',
        'type' : 'get',
    },
    'language': {
        'url': '//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json'
    },
    'columns': [
        {data: 'name'},
        {data: 'user.name'},
        {data: 'subtopic.name'},
        {
            data: 'type_course',
                render: function(data, type, row){
                    return data == 1 ? 'Grabada' : 'Online';
                }
        },
        {data: 'price'},
        {data: 'date_start'},
        {
          data: 'state',
                render: function(data){
                  if(data == 0)
                        return '<span class="badge badge-danger">Deshabilitado</span>';
                    else if(data == 1)
                        return '<span class="badge badge-success">Activo</span>';
                    else
                        return '<span class="badge badge-primary">Concluido</span>';
                }          
        },
        {data: null},
    ],
    'fnRowCallback': function(nRow, aData) {
        let button = '';
        button += '<button type="button" class="btn btn-info btn-xs view"><i class="fas fa-eye"></i></button> &nbsp; &nbsp;';
        button += '<button type="button" class="btn btn-warning btn-xs edit"><i class="fa fa-edit"></i></button> &nbsp; &nbsp;';
        button += '<button type="button" class="btn btn-danger btn-xs delete"><i class="fas fa-trash"></i></button> &nbsp; &nbsp;';
        $(nRow).find('td:eq(7)').html(button);
    }
  });

  $('body').on('click', '.view', function () {
    let data = tb_data.row($(this).parents('tr')).data();
    window.location.href = 'viewcourse/'+ data['id'] ;
  });       


  $('body').on('click', '.edit', function() {
    clearinput();
    $('#titleCourse').html("Actualizar curso");

    let data = tb_data.row( $(this).parents('tr') ).data();
    $('#mdlCourses').modal('show');
    $('#id').val(               data['id']);
    $('#name').val(             data['name']);
    $('#subtopic_id').val(      data['subtopic_id']);
    $('#number_class').val(   data['number_class']);
    $('#type').val(             data['type']);
    $('#description').val(      data['description']);
    $('#url_presentation').val( data['url_presentation']);
    $('#price').val(            data['price']);
    $('#date_start').val(       data['date_start'].replace(' ', 'T'));
    $('#user_id').val(          data['user_id']);
    $('#photo').val('');
    $('#type').trigger('change');
    $('#state').val(data['state']);
  });

  $('body').on('click', '.delete', function() {
    let data = tb_data.row( $(this).parents('tr') ).data();

    if(data['state'] == 0 || data['state'] == 2)
    {
      toastr.error('No puede deshabilitar ese elemento');
      return;
    }

    $.ajax({
      url: 'deletecourse/' + data['id'],
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
      $('#type').prop('disabled', false);
      $.ajax({
        url: '{{route('savecourse')}}' + '?' +$('#formCourse').serialize(),
        type: 'post',
        data: data,
        processData: false,
        contentType: false,
        'success': function(response) {
          if(response == true) {
              toastr.success('Se grabó satisfactoramente');
              tb_data.ajax.reload();
              $('#mdlCourses').modal('hide');
          }else{
              toastr.error('Ha ocurrido un error :(');
          }
        }
      });
    }
  });
  
  function validate_data()
  {
    clearinput();
    if($('#name').val() == '')
    {
        $("#name").removeClass("is-valid");
        $("#name").addClass("is-invalid");
        toastr.error('Lo sentimos el campo nombre es obligatorio');
        return false;
    } 
    if($('#subtopic_id').val() == '')
    {
        $("#subtopic_id").removeClass("is-valid");
        $("#subtopic_id").addClass("is-invalid");
        toastr.error('Lo sentimos el campo tema es obligatorio');
        return false;
    } 
    if($('#number_class').val() == '')
    {
        $("#number_class").removeClass("is-valid");
        $("#number_class").addClass("is-invalid");
        toastr.error('Lo sentimos el campo numero de clases es obligatorio');
        return false;
    }             
    if($('#type').val() == '')
    {
        $("#type").removeClass("is-valid");
        $("#type").addClass("is-invalid");
        toastr.error('Lo sentimos el campo tipo es obligatorio');
        return false;
    }              
    if($('#description').val() == '')
    {
        $("#description").removeClass("is-valid");
        $("#description").addClass("is-invalid");
        toastr.error('Lo sentimos el campo descripción es obligatorio');
        return false;
    }            
    if($('#photo').val() == '' && $('#id').val() == '')
    {
        $("#photo").removeClass("is-valid");
        $("#photo").addClass("is-invalid");
        toastr.error('Lo sentimos el campo foto es obligatorio');
        return false;
    }            
    if($('#url_presentation').val() == '')
    {
        $("#url_presentation").removeClass("is-valid");
        $("#url_presentation").addClass("is-invalid");
        toastr.error('Lo sentimos el campo url presentacion es obligatorio');
        return false;
    } 
    if($('#price').val() == '')
    {
        $("#price").removeClass("is-valid");
        $("#price").addClass("is-invalid");
        toastr.error('Lo sentimos el campo precio obligatorio');
        return false;
    } 

    if($('#price').val() < 0)
    {
        $("#price").removeClass("is-valid");
        $("#price").addClass("is-invalid");
        toastr.error('El precio tiene que ser mayor a 0');
        return false;
    } 
    if($('#number_class').val() < 0)
    {
        $("#number_class").removeClass("is-valid");
        $("#number_class").addClass("is-invalid");
        toastr.error('El numero de clases tiene que ser mayor a 0');
        return false;
    } 
    if($('#date_start').val() == '')
    {
        $("#date_start").removeClass("is-valid");
        $("#date_start").addClass("is-invalid");
        toastr.error('La fecha de inicio es obligatorio en las clases online');
        return false;
    }
    return true;
  }

  function clearinput()
  {
      $("#name").removeClass("is-invalid");

      $("#subtopic_id").removeClass("is-invalid");
      
      $("#number_class").removeClass("is-invalid");
      
      $("#type").removeClass("is-invalid");
      
      $("#description").removeClass("is-invalid");
  
      $("#photo").removeClass("is-invalid");
  
      $("#url_presentation").removeClass("is-invalid");
      $("#price").removeClass("is-invalid");
      $("#date_start").removeClass("is-invalid");
  }
</script>
@stop