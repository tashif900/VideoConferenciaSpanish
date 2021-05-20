@extends('layouts.web')
@section('title', 'Perfil')
@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css">
@endsection
@section('content')
    <div class="row mt-4">
        <div class="col-12">
            <div class="card-white">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <nav class="profile-tabs">
                                <div class="nav nav-tabs nav-justified" id="nav-tab" role="tablist">
                                    <a class="nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true"><img src="{{ asset('img/perfil.png') }}"> <span>Perfil</span></a>
                                    <a class="nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false"><img src="{{ asset('img/metodo-pago.png') }}"> <span>Métodos de Pago</span></a>
                                    <a class="nav-link" id="nav-help-tab" data-toggle="tab" href="#nav-help" role="tab" aria-controls="nav-help" aria-selected="false"><img src="{{ asset('img/centro-ayuda.png') }}"> <span>Centro de Ayuda</span></a>
                                    <a class="nav-link" id="nav-income-tab" data-toggle="tab" href="#nav-income" role="tab" aria-controls="nav-income" aria-selected="false"><img src="{{ asset('img/tus-ingresos.png') }}"> <span>Tus Ingresos</span></a>
                                    <a class="nav-link" id="nav-agenda-tab" data-toggle="tab" href="#nav-agenda" role="tab" aria-controls="nav-agenda" aria-selected="false"><img src="{{ asset('img/agenda.png') }}"> <span>Agenda</span></a>
                                </div>
                            </nav>
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                    <form action="">
                                        <div class="row">
                                            <div class="col-12 col-md-6 mt-4 justify-content-center">
                                                <h2 class="title-red">entrar en una reunión</h2>
                                                <div class="form-group mt-4">
                                                    <input type="text" class="form-control-custom-purple mx-auto" placeholder="id de reunión">
                                                </div>
                                                <div class="form-group text-center">
                                                    <button class="btn btn-custom-red">ENTRAR</button>
                                                </div>

                                            </div>
                                            <div class="col-12 col-md-6 mt-4 justify-content-center">
                                                <h2 class="title-red">ANFITRIÓN</h2>
                                                <div class="form-group mt-4">
                                                    <button class="btn btn-custom-purple mx-auto">CREAR UNA reunión</button>
                                                </div>
                                                <div class="form-group mt-4">
                                                    <button class="btn btn-custom-purple mx-auto">tengo agendado una cita</button>
                                                </div>
                                                <div class="form-group mt-4">
                                                    <button class="btn btn-custom-purple mx-auto">crear un curso</button>
                                                </div>
                                                <div class="form-group mt-4">
                                                    <button class="btn btn-custom-purple mx-auto">CREAR UNA clase</button>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                    <form action="">
                                        <div class="row my-4">
                                            <div class="col-12 col-md-6">
                                                <h2 class="title-blue mb-4">Tus métodos de pago</h2>
                                                <div class="card-white-item payments-user">
                                                    <div class="payments-user-img">
                                                        <img src="{{ asset('img/visa.jpg') }}" alt="">
                                                    </div>
                                                    1234**********1456
                                                </div>
                                                <div class="card-white-item payments-user">
                                                    <div class="payments-user-img">
                                                        <img src="{{ asset('img/mastercard.png') }}" alt="">
                                                    </div>
                                                    1234**********1456
                                                </div>
                                                <div class="card-white-item payments-user">
                                                    <div class="payments-user-img">
                                                        <img src="{{ asset('img/american.png') }}" alt="">
                                                    </div>
                                                    1234**********1456
                                                </div>
                                                <div class="card-white-item payments-user">
                                                    <div class="payments-user-img">
                                                        <img src="{{ asset('img/paypal.png') }}" alt="">
                                                    </div>
                                                    example@example.com
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <h2 class="title-blue mb-4">Tu cuenta para que te paguemos</h2>
                                                <div class="payment-input-cont">
                                                    <label for="bank" class="payment-input-label">Banco</label>
                                                    <input type="text" class="payment-input-control" id="bank">
                                                </div>
                                                <div class="payment-input-cont">
                                                    <label for="clabe" class="payment-input-label">Clabe</label>
                                                    <input type="text" class="payment-input-control" id="clabe">
                                                </div>
                                                <div class="payment-input-cont">
                                                    <label for="accoutn" class="payment-input-label">N° de Cuenta</label>
                                                    <input type="text" class="payment-input-control" id="account">
                                                </div>
                                                <div class="payment-input-cont">
                                                    <label for="name" class="payment-input-label">Nombre</label>
                                                    <input type="text" class="payment-input-control" id="name">
                                                </div>
                                                <div class="payment-input-cont">
                                                    <label for="lastname" class="payment-input-label">Apellido</label>
                                                    <input type="text" class="payment-input-control" id="lastname">
                                                </div>
                                                <div class="form-group text-center">
                                                    <button class="btn btn-custom-red">Guardar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="nav-help" role="tabpanel" aria-labelledby="nav-help-tab">
                                    <form action="">
                                        <div class="row mt-4">
                                            <div class="col-12">
                                                <button class="btn btn-custom-blue">Nueva Consulta</button>
                                            </div>
                                            <div class="col-12 mt-3">
                                                <textarea name="" id="" cols="30" rows="10" class="form-control" placeholder="Escribe aquí tu duda y pronto se pondrán en contacto contigo"></textarea>
                                            </div>
                                            <div class="col-12 mt-4">
                                                <button class="btn btn-custom-blue">Historial</button>
                                            </div>
                                            <div class="col-12 mt-4">
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <thead class="thead-dark">
                                                            <tr>
                                                                <th scope="col">#</th>
                                                                <th scope="col">Fecha</th>
                                                                <th scope="col">Título</th>
                                                                <th scope="col">Mensaje</th>
                                                                <th scope="col">Estado</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <th scope="row">1</th>
                                                                <td>16-09-2020</td>
                                                                <td>Otto</td>
                                                                <td>Mensaje</td>
                                                                <td>Pendiente</td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">2</th>
                                                                <td>16-09-2020</td>
                                                                <td>Otto</td>
                                                                <td>Mensaje</td>
                                                                <td>Pendiente</td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">3</th>
                                                                <td>16-09-2020</td>
                                                                <td>Otto</td>
                                                                <td>Mensaje</td>
                                                                <td>Pendiente</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="nav-income" role="tabpanel" aria-labelledby="nav-income-tab">
                                    <form action="">
                                        <div class="row mt-4">
                                            <div class="col-12 col-md-3">
                                                <div class="card card-colors">
                                                    <div class="card-header">
                                                        Periodo
                                                    </div>
                                                    <div class="card-body">
                                                        <select name="periodo" id="periodo" class="form-control">
                                                            <option value="">Agosto 2020</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="card card-colors mt-3">
                                                    <div class="card-header">
                                                        Último Retiro
                                                    </div>
                                                    <div class="card-body text-center">
                                                        <p>$ 220.00</p>
                                                        <button class="btn btn-custom-blue" type="button" data-toggle="modal" id="requestOutcome">Solicitar Retiro</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-9">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <h4>Retiros</h4>
                                                    </div>
                                                    {{-- {{ dd($petitions) }} --}}
                                                    <div class="col-12">
                                                        <div class="table-responsive">
                                                            <table class="table">
                                                                <thead class="thead-dark">
                                                                <tr>
                                                                    <th align="center">Fecha</th>
                                                                    <th align="center">Periodo</th>
                                                                    <th align="center">Monto</th>
                                                                    <th align="center">Estado</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                    
                                                                    <tr>
                                                                        <td colspan="2" align="right"><strong>Total</strong></td>
                                                                        <td align="right">$ 220.00</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-12">
                                                <h4>Actividad</h4>
                                            </div>
                                            <div class="col-12">
                                                <table class="table" id="activityTable">
                                                    <thead class="thead-dark">
                                                    <tr>
                                                        <th class="text-center">Periodo</th>
                                                        <th class="text-center">Curso</th>
                                                        <th class="text-center">Participantes</th>
                                                        <th class="text-center">Monto</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                        
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="nav-agenda" role="tabpanel" aria-labelledby="nav-agenda-tab">
                                    <div class="row my-4">
                                        <div class="col-12 my-4">
                                            <h4 class="title-red">Reportar Usuario</h4>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group row">
                                                <label for="inputPassword" class="col-sm-2 col-form-label">Encontrar</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="inputPassword" placeholder="Escribe ID / Nombre / Correo">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputPassword" class="col-sm-2 col-form-label">Nombre</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="inputPassword">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputPassword" class="col-sm-2 col-form-label">Comentarios</label>
                                                <div class="col-sm-10">
                                                    <textarea name="" class="form-control"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <button class="btn btn-custom-blue">Cancelar</button>
                                                <button class="btn btn-custom-red">Enviar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Solicitar Retiro</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="POST">
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group mx-sm-3 mb-2">
                                <label >Periodo</label>
                                <select name="period" id="period" class="form-control" style="width: 300px">
                                    <option value="">Agosto 2020</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Factura 1</label>
                                    <div class="cumtom-input-file-wrapper">
                                        <span class="label">
                                            <i class="ti-plus"></i>
                                        </span>
                                        
                                        <input type="file" name="upload" id="upload" class="cumtom-input-file-upload-box" placeholder="Upload File">
                                    </div>
                            </div>
                            <div class="form-group">
                                <label>Factura 2</label>
                                <div class="cumtom-input-file-wrapper">
                                    <span class="label">
                                        <i class="ti-plus"></i>
                                    </span>
                                    
                                    <input type="file" name="upload" id="upload" class="cumtom-input-file-upload-box" placeholder="Upload File">
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-custom-red mb-2" id="addPeriod">Agregar</button>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-rounded btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-rounded btn-yellow">Enviar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    $('#requestOutcome').click(function () {
        $("#exampleModal").modal("show");
    });
</script>
@endsection
