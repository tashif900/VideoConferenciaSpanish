@extends('adminlte::page')

@section('title', 'Usuarios')

@section('content_header')
@stop

@section('content')
    <div class="card">
        <div class="card-header text-dark"><h2>Usuarios</h2>
            <p><button type="button" class="btn btn-secondary" id="btnAdd"><i class="fa fa-plus"></i> Registrar</button></p>
        </div>

        <div class="card-body">
            <table class="table display responsive nowrap" id="tb_data" style="width: 100%">
                <thead>
                <tr class="bg-warning text-white">
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Operaciones</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal" role="dialog" tabindex="-1" id="mdlUser">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning text-white">
                    <h5 id="modal-title" class="modal-title">Nuevo Usuario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" id="formUser" name="formUser">
                        <input type="hidden" id="id" name="id">
                        
                        <div class="form-group">
                            <label for="name">Nombre *</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Ingresar su nombre">
                        </div>
                        <div class="form-group">
                            <label for="name">Email *</label>
                            <input type="text" class="form-control" id="email" name="email" placeholder="Ingresar su correo">
                        </div>
                        <div class="form-group">
                            <label for="name">Contraseña *</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña">
                        </div>
                        <div class="form-group">
                            <label for="name">Rol *</label>
                            <select class="form-control" name="role" id="role">
                                @foreach($role as $r)
                                    <option value="{{$r->id}}">{{$r->name}}</option>
                                @endforeach
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

    <div class="modal" role="dialog" tabindex="-1" id="mdlviewuser">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title">Detalles del usuario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row col-md-12">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="name">Nombre</label>
                                        <input type="text" class="form-control" id="vname" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="country">Email</label>
                                        <input type="text" class="form-control" id="vemail" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="telephone">Red Social</label>
                                        <input type="text" class="form-control" id="vsocialnetwork" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="security">Pregunta de seguridad</label>
                                        <input type="text" class="form-control" id="vsecurityquestion" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="career_id">Respuesta de seguridad</label>
                                        <input type="text" class="form-control" id="vsecurityanswer" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">

                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="email">Fecha de nacimiento</label>
                                        <input type="text" class="form-control" id="vbirthdate" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Telefono</label>
                                        <input type="text" class="form-control" id="vphone" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="question1">Profesion</label>
                                        <input type="text" class="form-control" id="vprofession" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="response1">Descripción</label>
                                        <input type="text" class="form-control" id="vdescription" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="question2">País</label>
                                        <input type="text" class="form-control" id="vcountry" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
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
        // Mostrar Formulario Usuarios
        $('#btnAdd').click(function() {
            clearinput();
            $('#modal-title').html('Nuevo usuario');
            $('#id').val('');
            $('#name').val('');
            $('#email').val('');
            $('#password').val('');
            $('#role').val('1');
            $('#mdlUser').modal('show');
            $('#role').prop('disabled', false);
        });
    
        let tb_data = $('#tb_data').DataTable({
            'processing': false,
            'serverSide': true,
            'responsive': true,
            'ajax': {
                'url': '{{route('dtusers')}}',
                'type' : 'get',
            },
            'language': {
                'url': '//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json'
            },
            'columns': [
                {data: 'name'},
                {data: 'email'},
                {data: 'roles[0].name'},
                {data: null}
            ],
            'fnRowCallback': function(nRow, aData) {
  
                let button = '';
                button += '<button type="button" class="btn btn-secondary btn-xs edit"><i class="fa fa-edit"></i></button> &nbsp; &nbsp;';
                button += '<button type="button" class="btn btn-info btn-xs view"><i class="fa fa-eye"></i></button> &nbsp; &nbsp;';
                button += '<button type="button" class="btn btn-danger btn-xs delete"><i class="fa fa-trash"></i></button>';
                //console.log(aData, 'Datos');
                $(nRow).find('td:eq(3)').html(button);
                
            }
        });

        $('#btnSave').click(function() {
            if(validate_data() == false)
                return false;
            $('#role').prop('disabled', false);
            let data = $('#formUser').serialize();
            
            $.ajax({
                url: '{{route('saveuser')}}',
                type: 'post',
                data: data + '&_token=' + '{{ csrf_token() }}',
                'success': function(response) {
                    if(response == true)
                        toastr.success('Se grabó satisfactoramente');
                    else
                        toastr.error('Se ha producido un error');
                    tb_data.ajax.reload();
                    $('#mdlUser').modal('hide');
                },
                'error': function(){
                    toastr.error('El email ya esta en uso');
                }
            });
        });

        $('body').on('click', '.delete', function() {
            let data = tb_data.row( $(this).parents('tr') ).data();

            $.ajax({
                    url: 'deleteuser/' + data['id'],
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
            $('#modal-title').html('Editar usuario');

            let data = tb_data.row( $(this).parents('tr') ).data();
            $('#id').val(data['id']);
            $('#name').val(data['name']);
            $('#email').val(data['email']);
            $('#role').val(data['roles'][0].id);
            $('#mdlUser').modal('show');
            $('#role').prop('disabled', true);
        });

        $('body').on('click', '.view', function() {
            let data = tb_data.row( $(this).parents('tr') ).data();

            console.log(data);
            $('#vname').val(                data['name']);
            $('#vemail').val(               data['email']);
            $('#vsocialnetwork').val(       data['social_network']);
            $('#vsecurityquestion').val(    data['security_question']);
            $('#vsecurityanswer').val(      data['security_answer']);
            
            $('#vbirthdate').val(           data['people']['birth_date']);
            $('#vphone').val(               data['people']['phone']);
            $('#vprofession').val(          data['people']['profession']);
            $('#vdescription').val(         data['people']['description']);
            if(data['people']['country'] != null)
                $('#vcountry').val(             data['people']['country'].name);
            else
                $('#vcountry').val('');

            $('#mdlviewuser').modal('show');
        });

        function validate_data(){
            clearinput();

            if($('#name').val() == ''){
                $('#name').addClass("is-invalid");
                return false;
            }
            if($('#email').val() == ''){
                $('#email').addClass("is-invalid");
                return false;
            }
            if($('#id').val() == ''){
                if($('#password').val() == ''){
                    $('#password').addClass("is-invalid");
                    return false;
                }
            }
            return true;
        }

        function clearinput(){
            $('#name').removeClass('is-invalid');
            $('#email').removeClass('is-invalid');
            $('#password').removeClass('is-invalid');
        }
    </script>
@stop
