@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h2>Rutas de la Aplicación</h2>
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
                    <th>Descripción</th>
                    <th>Ruta</th>
                    <th>Estado</th>
                    <th>Operaciones</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal" role="dialog" tabindex="-1" id="mdlPaths">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title">Rutas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" id="formPaths" name="formPaths">
                        <input type="hidden" id="id" name="id">
                        <div class="form-group">
                            <label for="name">Descripción *</label>
                            <input type="text" class="form-control" id="description" name="description" placeholder="Ingresar la descripción" required>
                        </div>
                        <div class="form-group">
                            <label for="percentage">Ruta *</label>
                            <input type="text" class="form-control" id="path" name="path" placeholder="Ingresar su Ruta" required>
                        </div>
                        <div class="form-group">
                            <label for="percentage">Estado *</label>
                            <input type="text" class="form-control" id="state" name="state" readonly>
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
    <style>
        .active{
            background: white;
        }

        .deleterow{
            background: rgb(249,130,127);
        }
        .bg-theme-info{
            background: #33384e;
            color: white;
        }
    </style>
@stop

@section('js')
    <script>
        let percentage_plan =0;
        let tb_data = $('#tb_data').DataTable({
            'processing': false,
            'serverSide': true,
            'responsive': true,
            'scrollX': 300,
            'scrollY': 300,
            'ajax': {
                'url': '{{route('dtpaths')}}',
                'type' : 'get',
            },
            'language': {
                'url': '//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json'
            },
            'columns': [
                {data: 'description'},
                {data: 'name'},
                {data: 'state'},
                {data: null}
            ],
            'fnRowCallback': function(nRow, aData) {
                let button = '';
                button += '<button type="button" class="btn btn-secondary btn-xs edit"><i class="fa fa-edit"></i></button> &nbsp; &nbsp;';

                let state = aData.state;

                if (state === 1){
                    $(nRow).find('td:eq(2)').html('Activo');
                    $(nRow).addClass('active');
                    button += '<button type="button" class="btn btn-danger btn-xs delete"><i class="fa fa-trash"></i></button> &nbsp; &nbsp;';
                }else{
                    $(nRow).find('td:eq(2)').html('Eliminado');
                    $(nRow).addClass('deleterow');
                    button += '<button type="button" class="btn btn-info btn-xs delete"><i class="fas fa-trash-restore"></i></button>';
                }


                //console.log($(nRow).find('td:eq(4)'), 'Datos fila');
                $(nRow).find('td:eq(3)').html(button);
            }
        });
    </script>

    <script type="text/javascript">
        //Mostrar Registro
        $('#btnAdd').click(function() {
            $('#id').val('');
            $('#description').val('');
            $('#description').removeClass('is-invalid');

            $('#path').val('');
            $('#path').removeClass('is-invalid');

            $('#state').val('Activo');
            $('#state').removeClass('is-invalid');
            /*
            $('#name').val('');
            $('#name').removeClass('is-invalid');
            $('#price').val('');
            $('#price').removeClass('is-invalid');
            $('#description').val('');
            $('#description').removeClass('is-invalid');
            $('#validity_day').val('');
            $('#validity_day').removeClass('is-invalid');*/
            $('#mdlPaths').modal('show');
        });

        //Editar
        $('body').on('click', '.edit', function() {
            let data = tb_data.row( $(this).parents('tr') ).data();
            //console.log(data, 'Datos');
            $('#id').val(data.id);
            $('#description').val(data.description);
            $('#path').val(data.name);
            data.state == 1 ?  $('#state').val('Activo') : $('#state').val('Eliminado');
            $('#mdlPaths').modal('show');
        });

        //Eliminar
        $('body').on('click', '.delete', function() {
            let data = tb_data.row( $(this).parents('tr') ).data();
            let state = data.state;
            $('#id').val(data.id);

            if (state===0)
                $('#state').val(1);
            else
                $('#state').val(0);

            data = $('#formPaths').serialize();
            //console.log($('#formPlan').serialize());
            $.ajax({
                url: '{{route('deletepaths')}}',
                type: 'post',
                data: data + '&_token=' + '{{ csrf_token() }}',
                'success': function(response) {
                    if(response == true) {
                        toastr.options ={
                            "positionClass": "toast-top-center"
                        }
                        if (state ===1)
                            toastr.success('Se elimino el plan satisfactoramente');
                        else
                            toastr.info('Se restauró el plan satisfactoramente');

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
            /*if( verify_data() == false)
            {
                toastr.error('Faltan completar campos');
                return ;
            }*/
            let data = $('#formPaths').serialize();
            $.ajax({
                url: '{{route('savepaths')}}',
                type: 'post',
                data: data + '&_token=' + '{{ csrf_token() }}',
                'success': function(response) {
                    if(response == true) {
                        toastr.options ={
                            "positionClass": "toast-top-center"
                        }
                        toastr.success('Se grabó satisfactoramente');
                        tb_data.ajax.reload();
                        $('#mdlPaths').modal('hide');
                    }
                    else{
                        toastr.options ={
                            "positionClass": "toast-top-center"
                        }
                        toastr.error('Ha ocurrido un error :(');
                        $('#mdlPaths').modal('hide');
                    }
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
