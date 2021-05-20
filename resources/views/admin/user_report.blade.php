@extends('adminlte::page')

@section('title', 'Usuarios reportados')

@section('content_header')
@stop

@section('content')
    <div class="card">
        <div class="card-header text-dark"><h2>Usuarios reportados</h2>
            <p hidden><button type="button" class="btn btn-secondary" id="btnAdd"><i class="fa fa-plus"></i> Registrar</button></p>
        </div>

        <div class="card-body">
            <table class="table display responsive nowrap" id="tb_data" style="width: 100%">
                <thead>
                <tr class="bg-warning text-white">
                    <th>Fecha</th>
                    <th>Reportante</th>
                    <th>Reportado</th>
                    <th>Mensaje</th>
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
                    <h5 id="modal-title" class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" id="formcountry" name="formcountry">
                        <input type="hidden" id="id" name="id">
                        <div class="form-group">
                          <label for="name">Fecha *</label>
                          <input type="date" class="form-control" id="date" name="date" disabled>
                        </div>
                        <div class="form-group">
                          <label for="name">Reportante *</label>
                          <input type="text" class="form-control" id="reported_user" name="reported_user" disabled>
                        </div>
                        <div class="form-group">
                          <label for="name">Reportado *</label>
                          <input type="text" class="form-control" id="user_report" name="user_report" disabled>
                        </div>
                        <div class="form-group">
                          <label for="name">Comentario *</label>
                          <textarea class="form-control" name="comment" id="comment" disabled></textarea>
                        </div>
                        
                    </form>
                </div>
                <div class="modal-footer" hidden>
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
        $('#btnAdd').click(function() {
            clearinput();
            $('#modal-title').html('Nuevo pais');
            $('#id').val('');
            $('#name').val('');
            $('#state').val(1);
            $('#mdlcountry').modal('show');
        });
    
        let tb_data = $('#tb_data').DataTable({
        'order': [[0, 'desc']],
        'processing': false,
        'serverSide': true,
        'responsive': true,
        'scrollX': 300,
        'ajax': {
            'url': '{{route('dtuser_report')}}',
            'type' : 'get',
        },
        'language': {
            'url': '//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json'
        },
        'columns': [
            {
              data: 'created_at',
              render: function(data){
                if(data == null)
                  return '';
                return data.slice(0, 10);
             }
            },
            {data: 'u_reported_user.name'},
            {data: 'u_user_report.name'},
            {
                data: 'comment',
                render: function(data){
                    if(data == null)
                      return '';
                    return data.slice(0, 20);
                }
            },
            {data: null}
        ],
        'fnRowCallback': function(nRow, aData) {
            let button = '';
            button += '<button type="button" class="btn btn-secondary btn-xs edit"><i class="fa fa-eye"></i></button> &nbsp; &nbsp;';
            // button += '<button type="button" class="btn btn-danger btn-xs delete"><i class="fa fa-trash"></i></button>';
            $(nRow).find('td:eq(4)').html(button);
        }
    });

        $('#btnSave').click(function() {
            if(validate_data() == false)
                return false;
            let data = $('#formcountry').serialize();
            
            $.ajax({
                url: '{{route('savecountry')}}',
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

        $('body').on('click', '.edit', function() {
            clearinput();
            $('#modal-title').html('Detalles del reporte');

            let data = tb_data.row( $(this).parents('tr') ).data();


            if( data['created_at'] == null )
              $('#date').val('');
            else 
              $('#date').val(data['created_at'].slice(0, 10));
            $('#reported_user').val(data['u_reported_user']['name']);
            $('#user_report').val(data['u_user_report']['name']);
            $('#comment').val(data['comment']);

            $('#mdlcountry').modal('show');
        });

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
