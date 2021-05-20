@extends('adminlte::page')

@section('title', 'Tipos de documento')

@section('content_header')
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h2>Tipos de documento</h2>
            <p>
                <button type="button" class="btn btn-secondary" id="btnAdd">
                    <i class="fa fa-plus"></i>Registrar
                </button>
            </p>
        </div>
        <div class="card-body">
            <table class="table display responsive nowrap" id="tb_data" style="width: 100%">
                <thead>
                    <tr class="bg-warning">
                        <th>Nombre</th>
                        <th>Estado</th>
                        <th>Operaciones</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal" role="dialog" tabindex="-1" id="mdlDocument">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title">Nuevo Documento</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" id="formDocument" name="formDocument">
                        <input type="hidden" id="id" name="id">
                        <div class="form-group">
                            <label for="name">Nombre *</label>
                            <input type="text" class="form-control" id="description" name="description" placeholder="Ingresar su Nombre" required>
                        </div>
                        <div class="form-group">
                            <label for="abbreviation">Estado</label>
                            <select class="form-control" name="state" id="state" required>
                                <option value="1" selected>Activo</option>
                                <option value="0">Inactivo</option>
                            </select>
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
    <script>
    let tb_data = $('#tb_data').DataTable({
        'order': [[1, 'desc']],
        'processing': false,
        'serverSide': true,
        'responsive': true,
        'scrollX': 300,
        'ajax': {
            'url': '{{route('dtDocuments')}}',
            'type' : 'get',
        },
        'language': {
            'url': '//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json'
        },
        'columns': [
            {data: 'description'},
            {
                data: 'state',
                render: function(data){
                    if(data == 0)
                        return '<span class="badge badge-danger">Deshabilitado</span>';
                    else
                        return '<span class="badge badge-success">Activo</span>';
                }    
            },
            {data: null}
        ],
        'fnRowCallback': function(nRow, aData) {
            let button = '';
            button += '<button type="button" class="btn btn-secondary btn-xs edit"><i class="fa fa-edit"></i></button> &nbsp; &nbsp;';
            button += '<button type="button" class="btn btn-danger btn-xs delete"><i class="fa fa-trash"></i></button>';
            $(nRow).find('td:eq(2)').html(button);
        }
    });
    </script>
    <script type="text/javascript">
    //Mostrar Registro
    $('#btnAdd').click(function() {
        $('#id').val('');
        $('#description').val('');
        $('#state').val(1);
        $('#description').removeClass('is-invalid');
        $('#mdlDocument').modal('show');
    });

    //Editar
    $('body').on('click', '.edit', function() {
        let data = tb_data.row( $(this).parents('tr') ).data();

        $.get(
            '{{route('getDocuments')}}',
            'id=' + data.id +'&_token=' + '{{ csrf_token() }}',
            function(response) {
                $('#id').val(data.id);
                $('#description').val(response.description);
                $('#state').val(response.state);
                $('#description').removeClass('is-invalid');
                $('#mdlDocument').modal('show');
            }, 'json'
        );
    });

    //Eliminar
    $('body').on('click', '.delete', function() {
        let data = tb_data.row( $(this).parents('tr') ).data();

        $('#id').val(data.id);

        data = $('#formDocument').serialize();
        $.ajax({
            url: '{{route('deleteDocuments')}}',
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
        var name = $('#description').val();
        if( !name || name == ' ')
        {
            toastr.error('Faltan completar campos');
            $('#description').addClass('is-invalid');
            return ;
        }
        let data = $('#formDocument').serialize();
        $.ajax({
            url: '{{route('saveDocuments')}}',
            type: 'post',
            data: data + '&_token=' + '{{ csrf_token() }}',
            'success': function(response) {
                if(response == true) {
                    toastr.options ={
                        "positionClass": "toast-top-center"
                    }
                    toastr.success('Se grabó satisfactoramente');
                    tb_data.ajax.reload();
                    $('#mdlDocument').modal('hide');
                }
                else{
                    toastr.options ={
                        "positionClass": "toast-top-center"
                    }
                    toastr.error('Ha ocurrido un error :(');
                    $('#mdlDocument').modal('hide');
                }

                $('#id').val('');
                $('#description').val('');
            }
        });
    });

    </script>
@stop
