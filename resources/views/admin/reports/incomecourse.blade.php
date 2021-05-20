@extends('adminlte::page')

@section('title', 'Reporte de ingresos cursos')

@section('content_header')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css" media="screen" />
@stop

@section('content')
    <div class="card">
        <div class="card-header text-dark"><h2></h2>
            <div class="card-header"><h3>Reporte de ingresos cursos</h3>
        </div>

        <div class="card-body">
            <table class="table display responsive nowrap" id="tb_data" style="width: 100%">
                <thead>
                <tr class="bg-warning text-white">
                    <th>Nombre Curso</th>
                    <th>Periodo</th>
                    <th>Numero de estudiantes</th>
                    <th>Monto bruto</th>
                    <th>Monto plataforma</th>
                </tr>

                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('css')

@stop

@section('js')
            <script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
            <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.flash.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
            <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
            <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>
    <script>
        let tb_data = $('#tb_data').DataTable({
            'order': [1, 'desc'],
            'processing': false,
            'serverSide': true,
            'responsive': true,
            'dom': 'Bfrtip',
            'buttons': [
                'excel', 'pdf'
            ],
            'scrollX': 300,
            'ajax': {
                'url': '{{route('dtReportsIncomeCourse')}}',
                'type' : 'get',
            },
            'language': {
                'url': '//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json'
            },
            'columns': [
                {data: 'course.name'},
                {data: 'period'},
                {
                    data: 'course.participants',
                    render: function(data, type, row){
                        if(data != undefined || data != null)
                            return data.length;
                        else
                            return "0";
                    },
                },
                {
                    data: 'Monto Bruto',
                    render: function(data, type, row){
                        return Number.parseFloat(data).toFixed(2);;
                    },
                },
                {
                    data: 'Monto Plataforma',
                    render: function(data, type, row){
                        return Number.parseFloat(data).toFixed(2);;
                    }
                },
            ],
            'fnRowCallback': function(nRow, aData) {
            }
        });

    </script>
@stop
