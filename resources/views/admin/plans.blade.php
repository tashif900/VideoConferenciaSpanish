@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h2>Planes del Sitio</h2>
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
                        <th>Precio</th>
                        <th>Porcentaje</th>
                        <th>Vigencia</th>
                        <th>Estado</th>
                        <th>Operaciones</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal" role="dialog" tabindex="-1" id="mdlPlan">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title">Nuevo Plan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" id="formPlan" name="formPlan">
                        <input type="hidden" id="id" name="id">
                        <input type="hidden" id="state" name="state">
                        <div class="form-group">
                            <label for="name">Nombre *</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Ingresar su Nombre" required>
                        </div>
                        <div class="form-group">
                            <label for="percentage">Precio *</label>
                            <input type="number" class="form-control" id="price" name="price" placeholder="Ingresar su Precio" required>
                        </div>
                        <div class="form-group">
                            <label for="percentage">Porcentaje *</label>
                            <input type="number" class="form-control" id="percentage" name="percentage" placeholder="Ingresar el Porcentaje del Plan" required>
                        </div>
                        <div class="form-group">
                            <label for="percentage">Descripción *</label>
                            <input type="text" class="form-control" id="description" name="description" placeholder="Ingresar su Descripcion" required>
                        </div>
                        <div class="form-group">
                            <label for="percentage">Validez *</label>
                            <input type="number" class="form-control" id="validity_day" name="validity_day" placeholder="Ingresar dias de validez" required>
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

    <div class="modal" role="dialog" tabindex="-1" id="mdlTheme">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title">Detalle del Plan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Plan *</label>
                            <input type="text" class="form-control" id="name_info" name="name_info" placeholder="Ingresar su Nombre" readonly>
                        </div>
                        <div class="form-group">
                            <label for="percentage">Descripción *</label>
                            <input type="text" class="form-control" id="description_info" name="description_info" placeholder="Ingresar su Descripcion" readonly>
                        </div>
                        <div class="form-group">
                            <label for="percentage">Porcentaje *</label>
                            <input type="number" class="form-control" id="percentage_info" name="percentage_info" placeholder="Ingresar el Porcentaje del Plan" readonly>
                        </div>
                        <div>
                            <table class="table display responsive nowrap" id="tb_theme" style="width: 100%">
                                <thead>
                                <tr class="bg-theme-info">
                                    <th>Categoría</th>
                                    <th>Porcentaje Normal</th>
                                    <th>Porcentaje Plan</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">CERRAR</button>
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
    let tb_theme = $('#tb_theme').DataTable({
            'processing': false,
            'serverSide': true,
            'info':false,
            'paging':false,
            "searching": false,
            'responsive': true,
            'scrollX': 200,
            'ajax': {
                'url': '{{route('dtThemes')}}',
                'type' : 'get',
            },
            'language': {
                'url': '//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json'
            },
            'columns': [
                {data: 'name'},
                {
                    data: 'percentage',
                    render: function(data){
                        if(data == null)
                            return '';
                        else
                            return data;
                    }
                },
                {data:null}
            ], 'fnRowCallback': function(nRow, aData) {
                    let new_percetage = aData.percentage - percentage_plan;
                    $(nRow).find('td:eq(2)').html(new_percetage.toFixed(2));
            }
        });
    let tb_data = $('#tb_data').DataTable({
        'processing': false,
        'serverSide': true,
        'responsive': true,
        'scrollX': 300,
        'scrollY': 300,
        'ajax': {
            'url': '{{route('dtPlans')}}',
            'type' : 'get',
        },
        'language': {
            'url': '//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json'
        },
        'columns': [
            {data: 'name'},
            {data: 'price'},
            {data: 'percentage'},
            {data: 'validity_day'},
            {data: 'state'},
            {data: null}
        ],
        'fnRowCallback': function(nRow, aData) {
            let button = '';
            button += '<button type="button" class="btn btn-secondary btn-xs edit"><i class="fa fa-edit"></i></button> &nbsp; &nbsp;';

            let state = aData.state;

            if (state === 1){
                $(nRow).find('td:eq(4)').html('Activo');
                $(nRow).addClass('active');
                button += '<button type="button" class="btn btn-danger btn-xs delete"><i class="fa fa-trash"></i></button> &nbsp; &nbsp;';
                button += '<button type="button" class="btn btn-success btn-xs info"><i class="fa fa-eye"></i></button>';
            }else{
                $(nRow).find('td:eq(4)').html('Eliminado');
                $(nRow).addClass('deleterow');
                button += '<button type="button" class="btn btn-info btn-xs delete"><i class="fas fa-trash-restore"></i></button>';
            }


            //console.log($(nRow).find('td:eq(4)'), 'Datos fila');
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
        $('#price').val('');
        $('#price').removeClass('is-invalid');
        $('#description').val('');
        $('#description').removeClass('is-invalid');
        $('#validity_day').val('');
        $('#validity_day').removeClass('is-invalid');
        $('#mdlPlan').modal('show');
    });

    //Mostrar

    $('body').on('click', '.info', function () {
        let data = tb_data.row( $(this).parents('tr') ).data();
        $('#name_info').val(data.name);
        $('#description_info').val(data.description);
        percentage_plan = data.percentage;
        $('#percentage_info').val(data.percentage);
        tb_theme.ajax.reload();
        $('#mdlTheme').modal('show');
    })

    //Editar
    $('body').on('click', '.edit', function() {
        let data = tb_data.row( $(this).parents('tr') ).data();

        $.get(
            '{{route('getPlans')}}',
            'id=' + data.id +'&_token=' + '{{ csrf_token() }}',
            function(response) {
                $('#id').val(data.id);
                $('#name').val(response.name);
                $('#name').removeClass('is-invalid');
                $('#price').val(response.price);
                $('#price').removeClass('is-invalid');
                $('#percentage').val(response.percentage);
                $('#percentage').removeClass('is-invalid');
                $('#description').val(response.description);
                $('#description').removeClass('is-invalid');
                $('#validity_day').val(response.validity_day);
                $('#validity_day').removeClass('is-invalid');
                $('#mdlPlan').modal('show');
            }, 'json'
        );
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

        data = $('#formPlan').serialize();
        //console.log($('#formPlan').serialize());
        $.ajax({
            url: '{{route('deletePlans')}}',
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
        if( verify_data() == false)
        {
            toastr.error('Faltan completar campos');
            return ;
        }
        let data = $('#formPlan').serialize();
        $.ajax({
            url: '{{route('savePlans')}}',
            type: 'post',
            data: data + '&_token=' + '{{ csrf_token() }}',
            'success': function(response) {
                if(response == true) {
                    toastr.options ={
                        "positionClass": "toast-top-center"
                    }
                    toastr.success('Se grabó satisfactoramente');
                    tb_data.ajax.reload();
                    $('#mdlPlan').modal('hide');
                }
                else{
                    toastr.options ={
                        "positionClass": "toast-top-center"
                    }
                    toastr.error('Ha ocurrido un error :(');
                    $('#mdlPlan').modal('hide');
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
