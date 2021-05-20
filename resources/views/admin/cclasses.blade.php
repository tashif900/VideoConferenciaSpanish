@extends('adminlte::page')

@section('title', 'Clases')

@section('content_header')
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h2>Clases</h2>
            <p>
                <button type="button" class="btn btn-secondary" id="btnAdd" hidden>
                    <i class="fa fa-plus"></i>Registrar
                </button>
            </p>
        </div>
        <div class="card-body">
            <table class="table display responsive nowrap" id="tb_data" style="width: 100%">
                <thead>
                    <tr class="bg-warning">
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th>Tipo de Clase</th>
                        <th>Estado</th>
                        <th>Operaciones</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal" role="dialog" tabindex="-1" id="mdlClasses">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title">Nueva Clase</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" id="formClasses" name="formClasses">

                        <div class="row">
                            <div class="col-6">
                                <div class="card">
                                    <div class="card-body">
                                        <input type="hidden" id="id" name="id">
                                        <div class="form-group">
                                            <label for="name">Nombre *</label>
                                            <input type="text" class="form-control" id="name" name="name" placeholder="Ingresar su Nombre" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="description">Descripción *</label>
                                            <input type="text" class="form-control" id="description" name="description" placeholder="Ingresar su Porcentaje" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="description">Precio *</label>
                                            <input type="number" class="form-control" id="price" name="price" placeholder="Ingresar su Porcentaje" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="description">Hora de Inicio *</label>
                                            <input type="datetime-local" class="form-control" id="hour_start" name="hour_start" placeholder="Ingresar su Porcentaje" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="card">
                                   <div class="card-body">
                                        <div class="form-group">
                                            <label for="description">Hora de Fin *</label>
                                            <input type="datetime-local" class="form-control" id="hour_end" name="hour_end" placeholder="Ingresar su Porcentaje" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="description">Tipo de Clase *</label>
                                            <select class="form-control" id="type_class" name="type_class">
                                                <option value="1">Grabado</option>
                                                <option value="2">Online</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="description">Sub Tema *</label>
                                            <select class="form-control" id="subtopic_id" name="subtopic_id">
                                                @foreach ($subtopics as $key => $subtopic)
                                                    <option value="{{ $subtopic->id }}">{{ $subtopic->name }}</option>
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
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">CERRAR</button>
                    <button type="button" class="btn btn-primary" id="btnSave">GRABAR</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
@stop

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.31/moment-timezone-with-data-1970-2030.min.js"></script>
    <script>
    moment.tz.setDefault("America/Guayaquil");

    let hora_inicio = moment().format().slice(0, 16);
    let hora_fin = moment().add('minutes',20).format().slice(0, 16);

    console.log(hora_inicio);
    console.log(hora_fin);

    document.getElementById("hour_start").min = hora_inicio;
    document.getElementById("hour_end").min= hora_fin;

    let tb_data = $('#tb_data').DataTable({
        'order': [[4, 'desc']],
        'processing': false,
        'serverSide': true,
        'responsive': true,
        'scrollX': 300,
        'ajax': {
            'url': '{{route('dtCclasses')}}',
            'type' : 'get',
        },
        'language': {
            'url': '//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json'
        },
        'columns': [
            {data: 'name'},
            {data: 'description'},
            {data: 'price'},
            {data: 'type_class'},
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
            {data: null}
        ],
        'fnRowCallback': function(nRow, aData) {
            let button = '';
            button += '<button type="button" class="btn btn-secondary btn-xs edit"><i class="fa fa-edit"></i></button> &nbsp; &nbsp;';
            button += '<button type="button" class="btn btn-danger btn-xs delete"><i class="fa fa-trash"></i></button>';
            $(nRow).find('td:eq(5)').html(button);
        }
    });
    </script>
    <script type="text/javascript">
    //Mostrar Registro
    $('#btnAdd').click(function() {
        $('#id').val('');
        $('#name').val('');
        $('#name').removeClass('is-invalid');
        $('#description').val('');
        $('#description').removeClass('is-invalid');
        $('#price').val('');
        $('#price').removeClass('is-invalid');
        $('#hour_start').val('');
        $('#hour_start').removeClass('is-invalid');
        $('#hour_end').val('');
        $('#state').val(1);
        $('#hour_end').removeClass('is-invalid');
        $('#subtopic_id').prop('selectedIndex',0);
        $('#type_class').prop('selectedIndex',0);
        $('#mdlClasses').modal('show');
    });

    //Editar
    $('body').on('click', '.edit', function() {
        let data = tb_data.row( $(this).parents('tr') ).data();

        $.get(
            '{{route('getCclasses')}}',
            'id=' + data.id +'&_token=' + '{{ csrf_token() }}',
            function(response) {
                $('#id').val(data.id);
                $('#name').val(response.name);
                $('#name').removeClass('is-invalid');
                $('#description').val(response.description);
                $('#description').removeClass('is-invalid');
                $('#price').val(response.price);
                $('#price').removeClass('is-invalid');
                $('#hour_start').val(moment(response.hour_start).format().slice(0, 16));
                $('#hour_start').removeClass('is-invalid');
                $('#hour_end').val(moment(response.hour_end).format().slice(0, 16));
                $('#hour_end').removeClass('is-invalid');
                $('#subtopic_id').val(response.subtopic_id);
                $('#type_class').prop(response.type_class);
                $('#state').val(response.state);
                $('#mdlClasses').modal('show');
            }, 'json'
        );
    });

    //Eliminar
    $('body').on('click', '.delete', function() {
        let data = tb_data.row( $(this).parents('tr') ).data();

        if(data['state'] == 0 || data['state'] == 2)
        {
            toastr.error('No puede deshabilitar ese elemento');
            return;
        }

        $('#id').val(data.id);

        data = $('#formClasses').serialize();
        $.ajax({
            url: '{{route('deleteCclasses')}}',
            type: 'post',
            data: data + '&_token=' + '{{ csrf_token() }}',
            'success': function(response) {
                if(response == true) {
                    toastr.options ={
                        "positionClass": "toast-top-center"
                    }
                    toastr.success('Se elimino satisfactoramente');
                    tb_data.ajax.reload();
                }else{
                    toastr.options ={
                        "positionClass": "toast-top-center"
                    }
                    toastr.error('Ha ocurrido un error :(');
                }
                $('#id').val('');
            }
        });
    });

    //Grabar
    $('#btnSave').click(function() {
        let data = $('#formClasses').serialize();
        $.ajax({
            url: '{{route('saveCclasses')}}',
            type: 'post',
            data: data + '&_token=' + '{{ csrf_token() }}',
            'success': function(response) {
                if(response == true) {
                    toastr.options ={
                        "positionClass": "toast-top-center"
                    }
                    toastr.success('Se grabó satisfactoramente');
                    tb_data.ajax.reload();
                    $('#mdlClasses').modal('hide');
                }
                else{
                    toastr.options ={
                        "positionClass": "toast-top-center"
                    }
                    toastr.error('Ha ocurrido un error :(');
                    $('#mdlClasses').modal('hide');
                }

                $('#id').val('');
                $('#name').val('');
            }
        });
    });

    function verify_data(){
        let name = $('#name').val();
        let description = $('#description').val();
        let price = $('#price').val();
        let validity_day = $('#validity_day').val();
        let bool = true;

        if (bool === true) {
            if(name == ' ' || !name){
                $('#name').addClass('is-invalid');
                bool = false;
            }
            if (description == ' ' || !description) {
                $('#description').addClass('is-invalid');
                bool = false;
            }
            if (price == ' ' || !price || price < 0) {
                $('#price').addClass('is-invalid');
                bool = false;
            }
            if (validity_day == ' ' || !validity_day || validity_day < 0) {
                $('#validity_day').addClass('is-invalid');
                bool = false;
            }
        }
        return bool;
    }
    </script>
@stop
