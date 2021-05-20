@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
@stop

@section('content')
    <div class="card">
        <div class="card-header text-dark">
            <h2>Lista de Retiros</h2>
        </div>

        <div class="card-body">
            <table class="table display responsive nowrap" id="tb_data" style="width: 100%">
                <thead>
                <tr class="bg-warning">
                    <th>Fecha</th>
                    <th>Instructor</th>
                    <th>Mes</th>
                    <th>Monto</th>
                    <th>Estado</th>
                    <th>Operaciones</th>
                </tr>

                </thead>
                <tbody>
                </tbody>
            </table>
        </div>

        <div class="modal" role="dialog" tabindex="-1" id="mdlRequest">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <form method="post" id="formRequest" name="formRequest">
                        <div class="modal-body">
                            @csrf
                            <input type="hidden" id="request_id" name="request_id">
                            <input type="hidden" id="user_id" name="user_id">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="name">Fecha *</label>
                                                        <input type="text" class="form-control" id="date" name="date" disabled>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="description">Instructor *</label>
                                                        <input type="text" class="form-control" id="instructor" name="instructor" disabled>
                                                    </div>
                                                </div>

                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="description">Banco *</label>
                                                        <input type="text" class="form-control" id="bank" name="bank" disabled>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="description">N° Cuenta *</label>
                                                        <input type="text" class="form-control" id="account_number" name="account_number" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <h3 class="title">Periodos Solicitados</h3>
                                </div>
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table" style="width: 100%;" id="tb_movements">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Periodo</th>
                                                <th>Monto</th>
                                            </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="description">Total *</label>
                                        <input type="text" class="form-control" id="total" name="total" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Estado *</label>
                                        <select name="state" id="state" class="form-control" required>
                                            <option value="1">Pendiente</option>
                                            <option value="2">Pagado</option>
                                            <option value="3">Declinado</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="description">Fecha Pago *</label>
                                        <input type="date" class="form-control" id="payment_date" name="payment_date" >
                                    </div>
                                    <div class="form-group">
                                        <label for="description">N° Operación *</label>
                                        <input type="text" class="form-control" id="operation_number" name="operation_number" placeholder="Número de Operación">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="description">Comentario *</label>
                                        <textarea type="text" class="form-control" id="observation" name="observation" placeholder="Comentario" required></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary" id="btnSave">Grabar</button>
                        </div>
                    </form>
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
            'scrollX': 300,
            'scrollY': 300,
            'ajax': {
                'url': '{{route('dtWithdrawalRequests')}}',
                'type' : 'get',
            },
            'language': {
                'url': '//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json'
            },
            'columns': [
                {data: 'request_date'},
                {data: 'user.name'},
                {data: 'id'},
                {data: 'amount'},
                {data: 'state'},
                {data: 'id'}
            ],
            'fnRowCallback': function(nRow, aData) {
                let state;

                if (aData['state'] == 1) {
                    state = 'Pendiente';
                } else if (aData['state'] == 2) {
                    state = 'Pagado';
                } else {
                    state = 'Declinado';
                }
                moment.locale('es');
                let date = moment(aData['request_date']).format('MMMM - YYYY');
                //console.log(date, 'Fecha');
                $(nRow).find('td:eq(2)').html(date[0].toUpperCase() + date.slice(1));
                $(nRow).find('td:eq(4)').text(state);
                $(nRow).find('td:eq(5)').html('<button type="button" class="btn btn-warning btn-xs edit"><i class="fa fa-edit"></i></button>');
            }
        });

        $('body').on('click', '.edit', function() {
            let data = tb_data.row( $(this).parents('tr') ).data();

            $.get(
                '{{route('getWithdrawalRequests')}}',
                'id=' + data.id +'&_token=' + '{{ csrf_token() }}',
                function(response) {
                    console.log(response);
                    let movements = '';
                    for(let x = 0; x < response.output.length; x++) {
                        movements += '<tr>';
                            movements += '<td>' + response.output[x].id +'</td>';
                            movements += '<td>' + response.output[x].period +'</td>';
                            movements += '<td>' + response.output[x].amount +'</td>';
                        movements += '</tr>';
                    }
                    $('#request_id').val(response.id);
                    $('#user_id').val(response.user_id);
                    $('#date').val(response.request_date);
                    for (var i = 0; i < response.user.payment_method_users.length; i++) {
                        if(response.user.payment_method_users[i].state === '2'){
                            $('#bank').val(response.user.payment_method_users[i].name);
                            $('#account_number').val(response.user.payment_method_users[i].value);
                        }
                    }
                    $('#instructor').val(response.user.name);
                    $('#total').val(response.amount);
                    $('#payment_date').val(response.payment_date);
                    $('#state').val(response.state);
                    $('#operation_number').val(response.operation_number);
                    $('#observation').val(response.comment);

                    $('#tb_movements tbody').append(movements);
                    $('#mdlRequest').modal('show');
                }, 'json'
            );
        });
/*
        $('body').on('click', '.edit', function () {
            cleanForm();
            let data = tb_data.row( $(this).parents('tr') ).data();
            console.log(data);
            let movements = '';
            for(let x = 0; x < data['output'].length; x++) {
                movements += '<tr>';
                    movements += '<td>' + data['output'][x]['id'] +'</td>';
                    movements += '<td>' + data['output'][x]['period'] +'</td>';
                    movements += '<td>' + data['output'][x]['amount'] +'</td>';
                movements += '</tr>';
            }
            $('#request_id').val(data['id']);
            $('#user_id').val(data['user_id']);
            $('#date').val(data['request_date']);
            $('#bank').val(data['instructor']['account']['bank_name']);
            $('#account_number').val(data['instructor']['account']['account_number']);
            $('#instructor').val(data['instructor']['name']);
            $('#total').val(data['amount']);
            $('#payment_date').val(data['payment_date']);
            $('#state').val(data['state']);
            $('#operation_number').val(data['operation_number']);
            $('#observation').val(data['comment']);

            $('#tb_movements tbody').append(movements);
            $('#mdlRequest').modal('show');
        });
*/
        $('#formRequest').submit(function(e) {
            e.preventDefault();

            let data = $(this).serialize();

            $.ajax({
                url: '{{route('saveWithdrawalRequests')}}',
                type: 'post',
                data: data + '&_token=' + '{{ csrf_token() }}',
                'success': function(response) {
                    if(response == true) {
                        toastr.options = {
                            "positionClass": "toast-top-center"
                        };
                        toastr.success('Se grabó satisfactoramente');
                        tb_data.ajax.reload();

                        $('#mdlRequest').modal('hide');
                    }else{
                        toastr.options = {
                            "positionClass": "toast-top-center"
                        };
                        toastr.error('Ha ocurrido un error :(');
                        console.log(response);
                    }
                }
            });
        })

        function cleanForm() {
            $('#date').val('');
            $('#bank').val('');
            $('#bank_name').val('');
            $('#instructor').val(1);
            $('#account_number').val('');
            $('#total').val('');
            $('#payment_date').val('');
            $('#state').val('');
            $('#operation_number').val('');
            $('#observation').val('');
            $('#tb_movements tbody').html('');
        }
    </script>
@stop
