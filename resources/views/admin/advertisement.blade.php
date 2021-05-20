@extends('adminlte::page')

@section('title', 'Anuncios')

@section('content_header')
@stop

@section('content')
    <div class="card">
        <div class="card-header text-dark">
          <h2>Anuncios</h2>
            <p><button type="button" class="btn btn-secondary" id="btnAdd"><i class="fa fa-plus"></i> Registrar</button></p>
        </div>

        <div class="card-body">
            <table class="table display responsive nowrap" id="tb_data" style="width: 100%">
                <thead>
                <tr class="bg-warning text-white">
                    <th>Titulo</th>
                    <th>Tipo</th>
                    <th>Desde</th>
                    <th>Hasta</th>
                    <th>Estado</th>
                    <th>Operaciones</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

{{--
    <div class="modal" role="dialog" tabindex="-1" id="mdlcountry">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning text-white">
                    <h5 id="modal-title" class="modal-title">Nuevo Pais</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" id="formcountry" name="formcountry">
                        <input type="hidden" id="id" name="id">
                        <div class="form-group">
                            <label for="name">Nombre *</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Ingresar su nombre del pais">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">CERRAR</button>
                    <button type="button" class="btn btn-primary" id="btnSave">GRABAR</button>
                </div>
            </div>
        </div>
    </div>
--}}

{{-- modal course --}}
<div class="modal" role="dialog" tabindex="-1" id="mdladvertisement">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-warning text-white">
        <h5 id="titleCourse" class="modal-title">Anuncio</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <form method="post" id="formadvertisement" name="formadvertisement" enctype="multipart/form-data">
          @csrf
          <input id="id" name="id" hidden>
          <div class="row col-md-12">
            <div class="col-md-6">
              <div class="card">
                <div class="card-body">
                  <div class="form-group">
                    <label for="number_class">Titulo *</label>
                    <input type="text" class="form-control" id="title" name="title"
                      placeholder="" >
                  </div>
                  <div class="form-group">
                    <label for="name">Ruta *</label>
                    <select class="form-control" id="path" name="path">
                        @foreach($paths as $path)
                            <option value="{{$path->id}}">{{$path->description}}</option>
                        @endforeach
                    </select>
                    <!--<input type="text" class="form-control" id="vigency" name="vigency"
                      placeholder="" readonly>-->
                  </div>
                    <div class="form-group">
                        <label for="name">Inicio *</label>
                        <input type="date" class="form-control" id="from" name="from"
                               placeholder="" >
                    </div>
                    <div class="form-group">
                        <label for="type">Final *</label>
                        <input type="date" class="form-control" id="to" name="to"
                               placeholder="">
                    </div>

                  <div class="row">
                    <div class="col-6">
                      <div class="form-group">
                        <label for="abbreviation">Estado *</label>
                        <select class="form-control" name="status" id="status" required>
                            <option value="0" selected>Pendiente</option>
                            <option value="1">Publicado</option>
                            <option value="2">Concluido</option>
                            <option value="3">Cancelado</option>
                            <option value="4">Impago</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="form-group">
                        <label for="start_date">Tipo *</label>
                          <select class="form-control" id="type" name="type" disabled>
                              <option value="1">Perfil</option>
                              <option value="2">Curso</option>
                              <option value="3">Clase</option>
                              <option value="4">Reunión</option>
                              <option value="5">Aplicación</option>
                          </select>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="">Usuario *</label>
                    <select class="form-control" name="user_id" id="user_id" disabled>
                      @foreach ($users as $user)
                        <option value="{{$user->id}}">{{$user->name}}</option>                      
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
                      <img src="" alt="ERR" id="img" style="height: 105px; display: block; object-fit: contain" class="m-auto w-100">
                      <label for="name">Imagen web *</label>
                      <input type="file" id="image" name="image" accept="image/*" class="form-control">
                  </div>

                    <div class="form-group">
                        <img src="" alt="ERR" id="img_movil" style="height: 105px; display: block; object-fit: contain" class="m-auto w-100">
                        <label for="name">Imagen movil *</label>
                        <input type="file" id="image_movil" name="image_movil" accept="image/*" class="form-control">
                    </div>

                  <div class="form-group">
                    <label for="name">Descripción *</label>
                    <textarea class="form-control" id="description" name="description" rows="3" required>
                    </textarea>
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
@stop

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script> console.log('Hi!'); </script>
    <script>

        let tb_data = $('#tb_data').DataTable({
            'processing': false,
            'serverSide': true,
            'responsive': true,
            'ajax': {
                'url': '{{route('dtadvertisement')}}',
                'type' : 'get',
            },
            'language': {
                'url': '//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json'
            },
            'columns': [
                {data: 'title'},
                {data: 'type'},
                {data: 'from'},
                {data: 'to'},
                {data: null},
                {data: null}
            ],
            'fnRowCallback': function(nRow, aData) {
                let button = '';
                button += '<button type="button" class="btn btn-secondary btn-xs edit"><i class="fa fa-eye"></i></button> &nbsp; &nbsp;';
                console.log(aData, 'Datos');
                let status ="";
                if (aData.status == 0) status = "Pendiente";
                if (aData.status == 1) status = "Publicado";
                if (aData.status == 2) status = "Concluido";
                if (aData.status == 3) status = "Desestimado";
                if (aData.status == 4) status = "Impago";

                let type ="";
                if (aData.type == 1) type = "Perfil";
                if (aData.type == 2) type = "Curso";
                if (aData.type == 3) type = "Clase";
                if (aData.type == 4) type = "Reunión";
                if (aData.type == 5) type = "Aplicación";

                $(nRow).find('td:eq(1)').html(type);
                $(nRow).find('td:eq(4)').html(status);
                $(nRow).find('td:eq(5)').html(button);
            }
        });

        $('#btnSave').click(function() {
            if(validate_data() == false)
                return false;
            //let data = $('#formadvertisement').serialize();

            let formData = new FormData()
            let image = $('#image')[0].files[0];

            //if (typeof image === 'undefined') image = null;

            formData.append('id', $('#id').val());
            formData.append('image', $('#image')[0].files[0]);
            formData.append('image_movil', $('#image_movil')[0].files[0]);
            formData.append('from', $('#from').val());
            formData.append('to', $('#to').val());
            formData.append('description', $('#description').val());
            formData.append('type', $('#type').val());
            formData.append('path', $('#path').val());
            formData.append('title', $('#title').val());
            formData.append('status', $('#status').val());
            let token = '{{ csrf_token() }}';
            $.ajax({
                url: '{{route('saveadvertisement')}}',
                type: 'post',
                headers: {'X-CSRF-TOKEN' : token},
                contentType: false,
                processData: false,
                data: formData,
                'success': function(response) {
                    if(response == true)
                        toastr.success('Se grabó satisfactoramente');
                    else
                        toastr.error('Se ha producido un error');
                    tb_data.ajax.reload();
                    $('#mdladvertisement').modal('hide');
                }
            });
        });


        $('body').on('click', '.edit', function() {
            clearinput();
            $('#modal-title').html('Editar pais');

            let data = tb_data.row( $(this).parents('tr') ).data();
            $('#id').val(data['id']);
            $('#vigency').val(data['vigency']);
            $('#from').val(data['from']);
            $('#to').val(data['to']);
            $('#title').val(data['title']);
            $('#description').val(data['description']);
            $('#type').val(data['type']);
            $('#status').val(data['status']);
            $('#user_id').val(data['user_id']);

            $('#img').attr("src", data['image']);
            $('#img_movil').attr("src", data['image_movil']);

            $('#path').val(data.path['id']);
            console.log(data, 'Datos');

            if ($('#status').val() == 4){

                $('#status').attr('disabled', true)
                toastr.info('El usuario aun no ha realizado el pago');
            }else{

                $('#status').attr('disabled', false);
            }

            if ($('#type').val() == 5){
                HabDes(false);
            }else{
                HabDes(true);
            }

            $('#mdladvertisement').modal('show');
        });

        $('#btnAdd').on('click', function () {
            clearinput();
            $('#title').val('');
            $('#description').val('');
            $('#vigency').val('');

            $('#to').val('');
            $('#type').val(5);
            $('#status').val(0);
            let fecha = moment().format('YYYY-MM-DD');
            $('#from').val(fecha);
            $('#img').attr("src", "/img/banner-prueba.jpg");
            $('#img_movil').attr("src", "/img/banner-prueba.jpg");
            HabDes(false);
            $('#mdladvertisement').modal('show');
        });

        function HabDes(val){
            $('#from').attr('disabled', val);
            $('#title').attr('disabled', val);
            $('#description').attr('disabled', val);
            $('#path').attr('disabled', val);
        }


        function validate_data(){
            clearinput();
            if($('#name').val() == ''){
                $('#name').addClass("is-invalid");
                return false;
            }
            return true;
        }

        function clearinput(){
            $('#name').removeClass('is-invalid');
        }
    </script>
@stop
