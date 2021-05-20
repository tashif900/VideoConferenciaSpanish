@extends('adminlte::page')

@section('title', 'Precios de los anuncios')

@section('content_header')
@stop

@section('content')
    <div class="card">
        <div class="card-header text-dark"><h2>Precios de los anuncios</h2>
            <p><button type="button" class="btn btn-secondary" id="btnAdd"><i class="fa fa-plus"></i> Registrar</button></p>
        </div>

        <div class="card-body">
            <table class="table display responsive nowrap" id="tb_data" style="width: 100%">
                <thead>
                <tr class="bg-warning text-white">
                    <th>Descripcion</th>
                    <th>Tiempo</th>
                    <th>Monto</th>
                    <th>Operaciones</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

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
                            <label for="name">Descripcion *</label>
                            <input type="text" class="form-control" id="description" name="description" placeholder="Ingresar una descripcion">
                        </div>
                        <div class="form-group">
                          <label for="name">Tiempo *</label>
                          <input type="number" class="form-control" id="time" name="time" placeholder="Ingresar el tiempo">
                        </div>
                        <div class="form-group">
                          <label for="name">Monto *</label>
                          <input type="number" class="form-control" id="mount" name="mount" placeholder="Ingresar el monto">
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
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
@stop

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script> console.log('Hi!'); </script>
    <script>
        // Mostrar Formulario pais
        // PricesAdvertisements pricesadvertisements

        $('#btnAdd').click(function() {
            clearinput();
            $('#modal-title').html('Nuevo precio de anuncio');
            $('#id').val('');
            $('#description').val('');
            $('#time').val('');
            $('#mount').val('');
            $('#mdlcountry').modal('show');
        });
    
        let tb_data = $('#tb_data').DataTable({
            'processing': false,
            'serverSide': true,
            'responsive': true,
            'ajax': {
                'url': '{{route('dtpricesadvertisements')}}',
                'type' : 'get',
            },
            'language': {
                'url': '//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json'
            },
            'columns': [
                {data: 'description'},
                {data: 'time'},
                {data: 'mount'},
                {data: null}
            ],
            'fnRowCallback': function(nRow, aData) {
                let button = '';
                button += '<button type="button" class="btn btn-secondary btn-xs edit"><i class="fa fa-edit"></i></button> &nbsp; &nbsp;';
                button += '<button type="button" class="btn btn-danger btn-xs delete"><i class="fa fa-trash"></i></button>';
                //console.log(aData, 'Datos');
                $(nRow).find('td:eq(3)').html(button);
            }
        });

        $('#btnSave').click(function() {
            if(validate_data() == false)
                return false;
            let data = $('#formcountry').serialize();
            
            $.ajax({
                url: '{{route('savepricesadvertisements')}}',
                type: 'post',
                data: data + '&_token=' + '{{ csrf_token() }}',
                'success': function(response) {
                    if(response == true)
                        toastr.success('Se grabó satisfactoramente');
                    else
                        toastr.error('Se ha producido un error');
                    tb_data.ajax.reload();
                    $('#mdlcountry').modal('hide');
                }
            });
        });

        $('body').on('click', '.delete', function() {
            let data = tb_data.row( $(this).parents('tr') ).data();

            $.ajax({
                    url: 'deletepricesadvertisements/' + data['id'],
                    type: 'get',
                    'success': function(response) {
                        if(response == true)
                            toastr.error('Se elimino satisfactoramente el registro');    
                        else
                            toastr.error('Ha ocurrido un error :(');
                        tb_data.ajax.reload();
                    }
            });
        });

        $('body').on('click', '.edit', function() {
            clearinput();
            $('#modal-title').html('Editar precio de los anuncios');

            let data = tb_data.row( $(this).parents('tr') ).data();
            $('#id').val(data['id']);
            $('#description').val(data['description']);
            $('#time').val(data['time']);
            $('#mount').val(data['mount']);

            $('#mdlcountry').modal('show');
        });

        function validate_data(){
            clearinput();
            if($('#description').val() == ''){
                $('#description').addClass("is-invalid");
                return false;
            }
            if($('#time').val() == ''){
                $('#time').addClass("is-invalid");
                return false;
            }
            if($('#mount').val() == ''){
                $('#mount').addClass("is-invalid");
                return false;
            }
            return true;
        }

        function clearinput(){
            $('#description').removeClass('is-invalid');
            $('#time').removeClass('is-invalid');
            $('#mount').removeClass('is-invalid');
        }
    </script>
@stop
