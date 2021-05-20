@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h2>Redes Sociales del Sitio</h2>
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
                        <th>Link</th>
                        <th>Operaciones</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal" role="dialog" tabindex="-1" id="mdlSocialNetwork">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title">Nueva Red Social</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" id="formSocialNetwork" name="formSocialNetwork">
                        <input type="hidden" id="id" name="id">
                        <div class="form-group">
                            <label for="name">Nombre *</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Ingresar su Nombre" required>
                        </div>
                        <div class="form-group">
                            <label for="name">Link *</label>
                            <input type="text" class="form-control" id="link" name="link" placeholder="Ingresar su link" required>
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
        'processing': false,
        'serverSide': true,
        'responsive': true,
        'scrollX': 300,
        'scrollY': 300,
        'ajax': {
            'url': '{{route('dtSocialNetworksMedia')}}',
            'type' : 'get',
        },
        'language': {
            'url': '//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json'
        },
        'columns': [
            {data: 'name'},
            {data: 'link'},
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
        $('#name').val('');
        $('#link').val('');
        $('#name').removeClass('is-invalid');
        $('#link').removeClass('is-invalid');
        $('#mdlSocialNetwork').modal('show');
    });

    //Editar
    $('body').on('click', '.edit', function() {
        let data = tb_data.row( $(this).parents('tr') ).data();
            $('#id').val(data['id']);
            $('#name').val(data['name']);
            $('#link').val(data['link']);
            $('#mdlSocialNetwork').modal('show');
    });

    //Eliminar
    $('body').on('click', '.delete', function() {
        let data = tb_data.row( $(this).parents('tr') ).data();

        $('#id').val(data.id);

        data = $('#formSocialNetwork').serialize();
        $.ajax({
            url: '{{route('deleteSocialNetworksMedia')}}',
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
        var link = $('#link').val();
        var name = $('#name').val();
        if( !name || name == ' ')
        {
            toastr.error('Faltan completar campos');
            $('#name').addClass('is-invalid');
            return ;
        }
        if( !link || link == ' ')
        {
            toastr.error('Faltan completar campos');
            $('#link').addClass('is-invalid');
            return ;
        }
        let data = $('#formSocialNetwork').serialize();
        $.ajax({
            url: '{{route('saveSocialNetworksMedia')}}',
            type: 'post',
            data: data + '&_token=' + '{{ csrf_token() }}',
            'success': function(response) {
                if(response == true) {
                    toastr.options ={
                        "positionClass": "toast-top-center"
                    }
                    toastr.success('Se grabó satisfactoramente');
                    tb_data.ajax.reload();
                    $('#mdlSocialNetwork').modal('hide');
                }
                else{
                    toastr.options ={
                        "positionClass": "toast-top-center"
                    }
                    toastr.error('Ha ocurrido un error :(');
                    $('#mdlSocialNetwork').modal('hide');
                }

                $('#id').val('');
                $('#name').val('');
                $('#link').val('');
            }
        });
    });

    </script>
@stop
