
@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content')
        <div class="card">
            <div class="card-header text-dark"><h2>Preguntas Frecuentes</h2>
                <p><button type="button" class="btn btn-secondary" id="btnAdd"><i class="fa fa-plus"></i>Registrar</button></p>
            </div>

        <div class="card-body">
            <table class="table display responsive nowrap" id="tb_data" style="width: 100%">
                <thead>
                <tr class="bg-warning text-white">
                    <th>Pregunta</th>
                    <th>Estado</th>
                    <th>Operaciones</th>
                </tr>

                </thead>
                <tbody>
                </tbody>
            </table>
        </div>

        <div class="modal" role="dialog" tabindex="-1" id="mdlQuestion">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-warning text-white">
                        <h5 class="modal-title">Registrar nueva pregunta</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" id="formQuestion" name="formQuestion">
                            <input type="hidden" id="id" name="id">
                            <div class="form-group">
                                <label for="name">Pregunta*</label>
                                <input type="text" class="form-control" id="question" name="question" placeholder="Nombre de la pregunta" required>
                            </div>
                            <div class="form-group">
                                <label for="description">Respuesta*</label>
                                <textarea type="text" class="form-control" id="response" name="response" placeholder="Respuesta" required></textarea>
                            </div>
                            <div class="form-group" hidden>
                                <label for="abbreviation">Estado</label>
                                <select class="form-control" name="state" id="state" required>
                                    <option value="1" selected>Activo</option>
                                    <option value="2">Inactivo</option>
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" id="btnSave">Grabar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')

@stop

@section('js')
    <script src="{{asset('vendor/ckeditor/ckeditor.js')}}"></script>

    <script>
        if ( CKEDITOR.env.ie && CKEDITOR.env.version < 9 )
            CKEDITOR.tools.enableHtml5Elements( document );

        CKEDITOR.replace( 'response' );
        // FIXING THE MODAL/CKEDITOR ISSUE
        $(".modal").removeAttr("tabindex");
        let bandera =0;
        let tb_data = $('#tb_data').DataTable({
            'processing': false,
            'serverSide': true,
            'responsive': true,
            'scrollX': 300,
            'scrollY': 300,
            'ajax': {
                'url': '{{route('dtQuestions')}}',
                'type' : 'get',
            },
            'language': {
                'url': '//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json'
            },
            'columns': [
                {data: 'question'},
                {data: 'state'},
                {data: null}
            ],
            'fnRowCallback': function(nRow, aData) {
                if (aData.state==0) $(nRow).find('td:eq(1)').html('<span class="badge badge-danger">Deshabilitado</span>');
                if (aData.state==1) $(nRow).find('td:eq(1)').html('<span class="badge badge-success">Activo</span>');
                let button = '';
                button += '<button type="button" class="btn btn-secondary btn-xs edit"><i class="fa fa-edit"></i></button> &nbsp; &nbsp;';
                button += '<button type="button" class="btn btn-danger btn-xs delete"><i class="fa fa-trash"></i></button>';
                //console.log(aData, 'Datos');
                $(nRow).find('td:eq(2)').html(button);
            }
        });
        $('#btnAdd').click(function() {
            $('#mdlQuestion').modal('show');
            $('#question').val('');
            CKEDITOR.instances['response'].setData(decode(""));
            //$('#response').val('');
            $('#state').val('1');
            $('#id').val('');
        });
        $('#btnSave').click(function() {
            let valName = $('#question').val();
            if(!valName){
                $("#question").removeClass("is-valid");
                $("#question").addClass("is-invalid");
                toastr.error('Lo sentimos el campo Pregunta es obligatorio', 'Faltaron completar algunos campos!');
            }else{
                let data = $('#formQuestion').serialize();
                let resp = CKEDITOR.instances['response'].getData();
                $.ajax({
                    url: '{{route('saveQuestion')}}',
                    type: 'post',
                    data: data + '&resp=' + resp + '&_token=' + '{{ csrf_token() }}',
                    'success': function(response) {
                        if(response == true) {
                            toastr.options = {
                                "positionClass": "toast-top-center"
                            };
                            toastr.success('Se grabó satisfactoramente');
                            tb_data.ajax.reload();
                            $('#question').val('');
                            $('#response').val('');
                            $('#state').val('');
                            $('#mdlQuestion').modal('hide');
                        }else{
                            toastr.options = {
                                "positionClass": "toast-top-center"
                            };
                            toastr.error('Ha ocurrido un error :(');
                            console.log(response);
                        }
                    }
                });
            }
        });
        $('body').on('click', '.edit', function() {
            let data = tb_data.row( $(this).parents('tr') ).data();
            $('#id').val(data['id']);
            $('#question').val(data['question']);
            CKEDITOR.instances['response'].setData(decode(data['response']));
            //$('#response').val(data['response']);
            $('#state').val(data['state']);
            $('#mdlQuestion').modal('show');
        });

        function decode(text) {
            let decoded = $('<textarea/>').html(text).text();
            return decoded;
        }
        $('body').on('click', '.delete', function() {
            let data = tb_data.row( $(this).parents('tr') ).data();
            //console.log (data['id'], 'IDDDD');
            $.ajax({
                url: 'deleteQuestion/' + data['id'],
                type: 'get',
                success: function(response) {
                    if(response == true) {
                        toastr.options = {
                            "positionClass": "toast-top-center"
                        };
                        toastr.error('Se ha eliminado correctamente');
                        tb_data.ajax.reload();
                        $('#mdlQuestion').modal('hide');
                    }
                }
            })
        });
    </script>
@stop
