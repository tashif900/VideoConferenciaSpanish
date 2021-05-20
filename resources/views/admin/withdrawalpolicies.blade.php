@extends('adminlte::page')

@section('title', 'Politicas de retiro')

@section('content_header')
@stop

@section('content')
    <div class="card">
        <div class="card-header text-dark"><h2>Politicas de retiro</h2>
            <!--<p><button type="button" class="btn btn-secondary" id="btnAdd"><i class="fa fa-plus"></i> Registrar</button></p>-->
        </div>

        <div class="card-body">
            <table class="table display responsive nowrap" id="tb_data" style="width: 100%">
                <thead>
                <tr class="bg-warning text-white">
                    <th>ID</th>
                    <th>Día Pago</th>
                    <th>Monto Máximo</th>
                    <th>Operaciones</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal" role="dialog" tabindex="-1" id="mdlwithdrawalpolicies">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header bg-warning">
                  <h5 class="modal-title">Modificar Política de Retiro</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <form method="post" id="formwithdrawalpolicies" name="formwithdrawalpolicies">
                      <input type="hidden" id="id" name="id">
                      <div class="form-group">
                          <label for="name">Día de Retiro</label>
                          <select class="form-control" id="start_day" name="start_day">
                              <option value="Lunes">Lunes</option>
                              <option value="Martes">Martes</option>
                              <option value="Miércoles">Míercoles</option>
                              <option value="Jueves">Jueves</option>
                              <option value="Viernes">Viernes</option>
                              <option value="Sábado">Sábado</option>
                              <option value="Domingo">Domingo</option>
                          </select>
                      </div>
                      <div class="form-group">
                        <label for="name">Monto Máximo Retiro</label>
                        <input type="number" class="form-control" id="amount" name="amount" required>
                      </div>
                      <div class="form-group">
                        <label for="name">Comentario</label>
                          <textarea type="text" class="form-control" id="description" name="description" placeholder="Escribe un comentario opcional"></textarea>
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
        $('#btnAdd').click(function() {
            clearinput();
            $('#modal-title').html('Nueva politica de retiro');
            $('#id').val('');
            $('#description').val('');
            $('#start_day').val('');
            $('#end_day').val('');
            $('#mdlwithdrawalpolicies').modal('show');
        });
    
        let tb_data = $('#tb_data').DataTable({
            'processing': false,
            'serverSide': true,
            'responsive': true,
            'ajax': {
                'url': '{{route('dtwithdrawalpolicies')}}',
                'type' : 'get',
            },
            'language': {
                'url': '//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json'
            },
            'columns': [
                {data: 'id'},
                {data: 'start_day'},
                {data: 'amount_max'},
                {data: null}
            ],
            'fnRowCallback': function(nRow, aData) {
                let button = '';
                button += '<button type="button" class="btn btn-secondary btn-xs edit"><i class="fa fa-edit"></i></button> &nbsp; &nbsp;';
                // button += '<button type="button" class="btn btn-danger btn-xs delete"><i class="fa fa-trash"></i></button>';
                //console.log(aData, 'Datos');
                $(nRow).find('td:eq(3)').html(button);
            }
        });

        $('#btnSave').click(function() {
            if(validate_data() == false)
                return false;
            let data = $('#formwithdrawalpolicies').serialize();
            
            $.ajax({
                url: '{{route('savewithdrawalpolicies')}}',
                type: 'post',
                data: data + '&_token=' + '{{ csrf_token() }}',
                'success': function(response) {
                    if(response == true)
                        toastr.success('Se grabó satisfactoramente');
                    else
                        toastr.error('Se ha producido un error');
                    tb_data.ajax.reload();
                    $('#mdlwithdrawalpolicies').modal('hide');
                }
            });
        });

        $('body').on('click', '.delete', function() {
            let data = tb_data.row( $(this).parents('tr') ).data();

            $.ajax({
                    url: 'deletewithdrawalpolicies/' + data['id'],
                    type: 'get',
                    'success': function(response) {
                        if(response == true)
                            toastr.success('Se elimino satisfactoramente el registro');    
                        else
                            toastr.error('Ha ocurrido un error :(');
                        tb_data.ajax.reload();
                    }
            });
        });

        $('body').on('click', '.edit', function() {
            clearinput();
            $('#modal-title').html('Editar politica de retiro');

            let data = tb_data.row( $(this).parents('tr') ).data();
            $('#id').val(data['id']);
            $('#description').val(data['description']);
            $('#start_day').val(data['start_day']);
            $('#amount').val(data['amount_max']);
            $('#mdlwithdrawalpolicies').modal('show');
        });

        function validate_data(){
            clearinput();
            /*if($('#description').val() == ''){
                $('#description').addClass("is-invalid");
                toastr.error('Falta completar el campo de descripción');
                return false;
            }*/
            if($('#start_day').val() == ''){
                $('#start_day').addClass("is-invalid");
                toastr.error('Falta completar el campo del inicio de la fecha');
                return false;
            }
            /*if($('#end_day').val() == ''){
                $('#end_day').addClass("is-invalid");
                toastr.error('Falta completar el campo de fecha final');
                return false;
            }
            if($('#start_day').val() >= $('#end_day').val()){
              toastr.error('La fecha de fin no puede ser menor que hora de inicio');
              $('#end_day').addClass("is-invalid");
              return false;
            }*/
            
            return true;
        }

        function clearinput(){
          $('#description').removeClass('is-invalid');
          $('#start_day').removeClass('is-invalid');
          $('#end_day').removeClass('is-invalid');
        }
    </script>
@stop
