@extends('adminlte::page')

@section('title', 'Reuniones')

@section('content_header')

@stop

@section('content')
{{-- datatable course --}}
<div id="datatableCourse" class="card">
  <div class="card-header text-dark">
    <h2>Reuniones</h2>
    <p><button type="button" class="btn btn-secondary" id="btnAdd" hidden><i class="fa fa-plus"></i> Registrar</button></p>
  </div>

  <div class="card-body">
    <table class="table display responsive nowrap" id="tb_data" style="width: 100%">
      <thead>
        <tr class="bg-warning text-white">
          <th>Nombre</th>
          <th>Precio</th>
          <th>Hora de inicio</th>
          <th>Tema</th>
          <th>Ponente</th>
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
                    <label for="type">Tipo reunión *</label>
                    <select class="form-control" name="type_meeting" id="type_meeting">
                      <option value="1">Uno a uno</option>
                      <option value="2">Uno a varios</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="number_class">Numero de Participantes *</label>
                    <input type="number" class="form-control" id="number_participant" name="number_participant"
                      placeholder="Ingrese el numero de clases">
                  </div>
                  <div class="form-group">
                    <label for="price">Precio *</label>
                    <input type="number" class="form-control" id="price" name="price" placeholder="Precio">
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card">
                <div class="card-body">
                 
                  <div class="form-group">
                    <label for="start_date">Hora de inicio *</label>
                    <input type="datetime-local" class="form-control" id="hour_start" name="hour_start">
                  </div>
                  <div class="form-group">
                    <label for="start_date">Hora de fin *</label>
                    <input type="datetime-local" class="form-control" id="hour_end" name="hour_end">
                  </div>
                  <div class="form-group">
                    <label for="theme">Temas *</label>
                    <select class="form-control" name="thematic_id" id="thematic_id">
                      @foreach ($thematics as $s)
                        <option value="{{$s->id}}">{{$s->name}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="user_id">Ponente *</label>
                    <select class="form-control" name="user_id" id="user_id">
                      @foreach($teachers as $t)
                      <option value="{{$t->id}}">{{$t->name}}</option>
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
  document.getElementById("hour_start").min = hour;

  $('#btnAdd').click(function() {
    clearinput();
    $('#titleCourse').html("Nuevo reunión");
    $('#mdlCourses').modal('show');
    $('#id').val('');
    $('#name').val('');
    $('#description').val('');
    $('#type_meeting option')[0].selected = true;
    $('#number_participant').val('');
    $('#price').val('');
    $('#hour_start').val('');
    $('#hour_end').val('');
    $('#user_id option')[0].selected = true;
    $('#thematic_id option')[0].selected = true;

    // $('#type_course').prop('disabled', false);
    // $('#type_course').trigger('change');
  });

  let tb_data = $('#tb_data').DataTable({
    'order': [[5, 'desc']],
    'processing': false,
    'serverSide': true,
    'responsive': true,
    'ajax': {
        'url': '{{route('dtmeetings')}}',
        'type' : 'get',
    },
    'language': {
        'url': '//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json'
    },
    'columns': [
        {data: 'name'},
        /*{
          data: 'type_meeting',
          render: function(data){
            return (data == 1)? 'Uno a uno' : 'Uno a varios';
          },
        },*/
        {data: 'price'},
        {data: 'hour_start'},
        {data: 'thematic.name'},
        {data: 'user.name'},
        {
          data: 'state',
          render: function(data){
            if(data == 0)
                return '<span class="badge badge-danger">Deshabilitado</span>';
            else if(data == 1)
                return '<span class="badge badge-success">Activo</span>';
            else
                return '<span class="badge badge-primary">Concluido</span>';
          },
        },
        {data: null},
    ],
    'fnRowCallback': function(nRow, aData) {
        let button = '';
        button += '<button type="button" class="btn btn-warning btn-xs edit"><i class="fa fa-edit"></i></button> &nbsp; &nbsp;';
        button += '<button type="button" class="btn btn-danger btn-xs delete"><i class="fas fa-trash"></i></button> &nbsp; &nbsp;';
        $(nRow).find('td:eq(6)').html(button);
    }
  });

  $('body').on('click', '.edit', function() {
    clearinput();
    $('#titleCourse').html("Actualizar reunión");

    let data = tb_data.row( $(this).parents('tr') ).data();
    $('#mdlCourses').modal('show');
    $('#id').val(               data['id']);
    $('#name').val(             data['name']);
    $('#description').val(      data['description']);
    $('#type_meeting').val(     data['type_meeting']);
    $('#number_participant').val(data['number_participant']);
    $('#description').val(      data['description']);
    $('#price').val(            data['price']);
    $('#hour_start').val(       data['hour_start'].replace(' ', 'T'));
    $('#hour_end').val(         data['hour_end'].replace(' ', 'T'));
    $('#user_id').val(          data['user_id']);
    $('#thematic_id').val(      data['thematic_id']);
    $('#state').val(            data['state']);

    if($('#state').val() == 2)
      $('#state').prop('disabled', true);
    else
      $('#state').prop('disabled', false);

  });

  $('body').on('click', '.delete', function() {
    let data = tb_data.row( $(this).parents('tr') ).data();

    if(data['state'] == 0 || data['state'] == 2)
    {
      toastr.error('No puede deshabilitar ese elemento');
      return;
    }
    

    $.ajax({
      url: 'deletemeeting/' + data['id'],
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
    if(validate_data() == true){
      $.ajax({
        url: '{{route('savemeeting')}}',
        type: 'post',
        data: $('#formCourse').serialize(),
        'success': function(response) {
          if(response == true) {
              toastr.success('Se grabósatisfactoramente');
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
    if($('#description').val() == '')
    {
        $("#description").removeClass("is-valid");
        $("#description").addClass("is-invalid");
        toastr.error('Lo sentimos el campo descripción es obligatorio');
        return false;
    } 
    if($('#type_meeting').val() == '')
    {
        $("#type_meeting").removeClass("is-valid");
        $("#type_meeting").addClass("is-invalid");
        toastr.error('Lo sentimos el campo typo de reuniones es obligatorio');
        return false;
    }             
    if($('#number_participant').val() == '')
    {
        $("#number_participant").removeClass("is-valid");
        $("#number_participant").addClass("is-invalid");
        toastr.error('Lo sentimos el campo numero de participantes es obligatorio');
        return false;
    }              
    if($('#price').val() == '')
    {
        $("#price").removeClass("is-valid");
        $("#price").addClass("is-invalid");
        toastr.error('Lo sentimos el campo precio es obligatorio');
        return false;
    }            
        
    if($('#hour_start').val() == '')
    {
        $("#hour_start").removeClass("is-valid");
        $("#hour_start").addClass("is-invalid");
        toastr.error('Lo sentimos el campo hora de inicio es obligatorio');
        return false;
    } 
    if($('#hour_end').val() == '')
    {
        $("#hour_end").removeClass("is-valid");
        $("#hour_end").addClass("is-invalid");
        toastr.error('Lo sentimos el campo hora de fin obligatorio');
        return false;
    } 

    if($('#price').val() < 0)
    {
        $("#price").removeClass("is-valid");
        $("#price").addClass("is-invalid");
        toastr.error('El precio tiene que ser mayor a 0');
        return false;
    } 
    if($('#number_participant').val() < 0)
    {
        $("#number_participant").removeClass("is-valid");
        $("#number_participant").addClass("is-invalid");
        toastr.error('El numero de participantes tiene que ser mayor a 0');
        return false;
    } 
    if($('#user_id').val() == '')
    {
        $("#user_id").removeClass("is-valid");
        $("#user_id").addClass("is-invalid");
        toastr.error('Lo sentimos el campo de user es obligatorio');
        return false;
    }
    if($('#thematic_id').val() == '')
    {
        $("#thematic_id").removeClass("is-valid");
        $("#thematic_id").addClass("is-invalid");
        toastr.error('Lo sentimos el campo de temas es obligatorio');
        return false;
    }
    return true;
  }

  function clearinput()
  {
      $("#name").removeClass("is-invalid");

      $("#description").removeClass("is-invalid");
      
      $("#type_meeting").removeClass("is-invalid");
      
      $("#number_participant").removeClass("is-invalid");
      
      $("#price").removeClass("is-invalid");
  
      $("#hour_start").removeClass("is-invalid");
  
      $("#hour_end").removeClass("is-invalid");
     
  }
</script>
@stop