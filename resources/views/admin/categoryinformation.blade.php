
@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content')
        <div class="card">
            <div class="card-header text-dark"><h2>Categorias de información</h2>
            </div>

        <div class="card-body">
            <table class="table display responsive nowrap" id="tb_data" style="width: 100%">
                <thead>
                <tr class="bg-warning text-white">
                    <th>Nombre</th>
                    <th>Operaciones</th>
                </tr>

                </thead>
                <tbody>
                </tbody>
            </table>
        </div>

        <div class="modal" role="dialog" tabindex="-1" id="mdlCategoryInformation">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-warning text-white">
                        <h5 class="modal-title">Registrar nueva información</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" id="formCategoryInformation" name="formCategoryInformation">
                            <input type="hidden" id="id" name="id">
                            <div class="form-group">
                                <label for="name">Titulo*</label>
                                <input type="text" class="form-control" id="title" name="title" placeholder="Titulo" required>
                            </div>
                            <div class="form-group">
                                <label for="name">Cuerpo*</label>
                                <textarea name="body" id="body" class="form-control"></textarea>
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
    <!--<script src="{{ asset('js/vendors.js') }}"></script>-->
    <!--<script src="//cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>-->
    <script src="{{asset('vendor/ckeditor/ckeditor.js')}}"></script>
    <script>

        CKEDITOR.replace( 'body' );
        // FIXING THE MODAL/CKEDITOR ISSUE
        $(".modal").removeAttr("tabindex");
       /* let editor;
        ClassicEditor
        .create(document.querySelector('#body'),
            {
                language: 'es',
                toolbar: [ 'heading', '|', 'bold', 'italic', 'underline','strikethrough','subscript','superscript','|', 'link', '|','bulletedList', 'numberedList', 'blockQuote', '|', 'outdent', 'indent','|', 'alignment'],
                heading: {
                    options: [
                        { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                        { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                        { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                        { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                    ]
                }
                
            })
            .then( newEditor => {
                editor = newEditor;
            } )
            .catch( error => {
                console.error( error );
            })*/
    </script>
    <script>
        let tb_data = $('#tb_data').DataTable({
            'processing': false,
            'serverSide': true,
            'responsive': true,
            'scrollX': 300,
            'scrollY': 300,
            'ajax': {
                'url': '{{route('dtCategoryInformation')}}',
                'type' : 'get',
            },
            'language': {
                'url': '//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json'
            },
            'columns': [
                {data: 'name'},
                {data: null}
            ],
            'fnRowCallback': function(nRow, aData) {
   
                let button = '';
                button += '<button type="button" class="btn btn-warning btn-xs edit"><i class="fa fa-edit"></i></button> &nbsp; &nbsp;';
                // button += '<button type="button" class="btn btn-danger btn-xs delete"><i class="fa fa-trash"></i></button>';
                //console.log(aData, 'Datos');
                $(nRow).find('td:eq(1)').html(button);
            }
        });
        $('#btnAdd').click(function() {
            $('#mdlCategoryInformation').modal('show');
            $('#name').val('');
            $('#state').val('1');
            $('#id').val('');
        });
        $('#btnSave').click(function() {
            //let body = editor.getData();
            let body = CKEDITOR.instances['body'].getData();
            let valName = $('#title').val();
            if(!valName){
                $("#title").removeClass("is-valid");
                $("#title").addClass("is-invalid");
                toastr.error('Lo sentimos el campo Pregunta es obligatorio', 'Faltaron completar algunos campos!');
            }else{
                let data = $('#formCategoryInformation').serialize();
                $.ajax({
                    url: '{{route('saveCategoryInformation')}}',
                    type: 'post',
                    data: data + '&cuerpo=' + body  + '&_token=' + '{{ csrf_token() }}',
                    'success': function(response) {
                        if(response == true) {
                            toastr.options = {
                                "positionClass": "toast-top-center"
                            };
                            toastr.success('Se grabó satisfactoramente');
                            tb_data.ajax.reload();
                            $('#name').val('');
                            $('#state').val('');
                            $('#id').val('');
                            $('#mdlCategoryInformation').modal('hide');
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
            $('#title').val(data['name']);
            //editor.setData( decode(data['body']));
            CKEDITOR.instances['body'].setData(decode(data['body']));
            $('#mdlCategoryInformation').modal('show');
        });

        function decode(text) {
            var decoded = $('<textarea/>').html(text).text();
            return decoded;
        }

        $('body').on('click', '.delete', function() {
            let data = tb_data.row( $(this).parents('tr') ).data();
            //console.log (data['id'], 'IDDDD');
            $.ajax({
                url: 'deleteCategoryInformation/' + data['id'],
                type: 'get',
                success: function(response) {
                    if(response == true) {
                        toastr.options = {
                            "positionClass": "toast-top-center"
                        };
                        toastr.error('Se ha eliminado correctamente');
                        tb_data.ajax.reload();
                        $('#mdlCategoryInformation').modal('hide');
                    }
                }
            })
        });
    </script>
@stop
