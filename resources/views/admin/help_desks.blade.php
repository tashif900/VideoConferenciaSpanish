@extends('adminlte::page')

@section('title', 'Centro de ayuda')

@section('content_header')
@stop

@section('content')
    <div class="card">
        <div class="card-header text-dark"><h2>Centro de ayuda</h2>
            <p hidden><button type="button" class="btn btn-secondary" id="btnAdd"><i class="fa fa-plus"></i> Registrar</button></p>
        </div>

        <div class="card-body">
            <table class="table display responsive nowrap" id="tb_data" style="width: 100%">
                <thead>
                <tr class="bg-warning text-white">
                    <th>Titulo</th>
                    <th>Usuario</th>
                    <th>Estado</th>
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
                    <h5 id="modal-title" class="modal-title">Centro de ayuda</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" id="formanswer" name="formanswer">
                        @csrf
                        
                        <div class="row my-2">
                            <div class="col-3">
                                <label for="abbreviation">Título : </label>
                            </div>
                            <div class="col-9">
                                <input type="text" class="form-control" id="title" name="title" placeholder="Ingresar el titulo" required>
                            </div>
                        </div>

                        <div class="row my-2">
                            <div class="col-3">
                                <label for="abbreviation">Mensaje : </label>
                            </div>
                            <div class="col-9">
                                <textarea class="form-control" id="message" name="message">
                                </textarea>
                            </div>
                        </div>

                        <input type="text" id="parent_id" name="parent_id" hidden>

                        <div class="my-2" style="display: grid">
                            <button type="button" class="btn btn-primary ml-auto" id="btnSend" style="display: block">Responder</button>
                        </div>  

                    </form>

                    <label for="abbreviation">Hilo de respuestas</label>

                    <div class="overflow-auto" id="answers" style="height: 300px">
                        <input type="text" class="form-control m-2"  placeholder="Ingresar el titulo" disabled>
                        <textarea class="form-control m-2"  disabled></textarea>
                        <hr>
                    </div>
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
        $('#btnSend').click(function() {
            data = $('#formanswer').serialize();
            $.ajax({
                url: '/admin/savehelp_desks',
                type: 'post',
                data: data,
                dataType: 'json',
                
                success: function(response) {
                    if(response == true) {
                        toastr.success('Respuesta enviada');   

                        $('#title').val('');
                        $('#message').val('');

                        $.post('/admin/getAnswers',
                            'id=' + $('#parent_id').val() +
                            '&_token=' + '{{ csrf_token() }}', function(response) {
                                var $output = '';
                                for($i = 0; $i < response.helpdesks.length; $i++){
                                    $output += '<input type="text" class="form-control my-2" value="'+ response.helpdesks[$i]['title'] +'" placeholder="Ingresar el titulo" disabled>';
                                    $output += '<textarea class="form-control my-2"  disabled>'+ response.helpdesks[$i]['description'] +'</textarea>';
                                    $output += '<hr>';
                                }

                                $output += '<input type="text" class="form-control my-2" value="'+ response['title'] +'" placeholder="Ingresar el titulo" disabled>';
                                $output += '<textarea class="form-control my-2"  disabled>'+ response['description'] +'</textarea>';                    

                                $('#answers').html($output);
                            });


                    } else {
                        toastr.error('Error al enviar la respuesta');
                    }
                },
            });
        });
    
        let tb_data = $('#tb_data').DataTable({
            'order': [[1, 'desc']],
            'processing': false,
            'serverSide': true,
            'responsive': true,
            'ajax': {
                'url': '{{route('dthelp_desks')}}',
                'type' : 'get',
            },
            'language': {
                'url': '//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json'
            },
            'columns': [
                {data: 'title'},
                {data: 'user.name'},
                {
                    data: 'state',
                    render: function(data){
                        if(data == 1)
                            return '<span class="badge badge-success">Pendiente</span>';
                        else if(data == 2)
                            return '<span class="badge badge-success">Respondida</span>';
                        else
                            return '<span class="badge badge-danger">Cerrada</span>';
                    },
                },
                {data: null}
            ],
            'fnRowCallback': function(nRow, aData) {
                let button = '';
                button += '<button type="button" class="btn btn-secondary btn-xs edit"><i class="fa fa-eye"></i></button> &nbsp; &nbsp;';
                // button += '<button type="button" class="btn btn-danger btn-xs delete"><i class="fa fa-trash"></i></button>';
                //console.log(aData, 'Datos');
                $(nRow).find('td:eq(3)').html(button);
            }
        });

        $('body').on('click', '.edit', function() {
            clearinput();
            $('#modal-title').html('Responder consulta');
            $('#title').val('');
            $('#message').val('');
        
            let data = tb_data.row( $(this).parents('tr') ).data();
            
            $('#parent_id').val(data['id']);

            $.post('/admin/getAnswers',
                'id=' + data['id'] +
                '&_token=' + '{{ csrf_token() }}', function(response) {
                    var $output = '';
                    for($i = 0; $i < response.helpdesks.length; $i++){
                        $output += '<input type="text" class="form-control my-2" value="'+ response.helpdesks[$i]['title'] +'" placeholder="Ingresar el titulo" disabled>';
                        $output += '<textarea class="form-control my-2"  disabled>'+ response.helpdesks[$i]['description'] +'</textarea>';
                        $output += '<hr>';
                    }

                    $output += '<input type="text" class="form-control my-2" style="background-color: #8faadc" value="'+ response['title'] +'" placeholder="Ingresar el titulo" disabled>';
                    $output += '<textarea class="form-control my-2" style="background-color: #8faadc" disabled>'+ response['description'] +'</textarea>';                    

                    $('#answers').html($output);
                });

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
