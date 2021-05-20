@extends('layouts.web')
@section('title', 'Crear Clase')
@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css">
@endsection
@section('content')
    <div class="row mt-4">
        <div class="col-12">
            <div class="card-white">
                <div class="row">
                    <div class="col-12">
                        <h4><strong>Adquiriendo:</strong> Reunión privada sobre la Geología</h4>
                    </div>
                    {{-- <div class="col-12">
                        <div class="alert" id="response-panel">
                            <div class="alert-heading">Response</div>
                            <div class="alert-body" id="response"></div>
                        </div>
                        @if (session('status'))
                            <div class="alert alert-danger">
                                {{ session('status') }}
                            </div>
                        @endif
                    </div> --}}
                    <div class="col-12">
                        <p><strong>Descripción:</strong></p>
                        <p>Reunión sobre la educación.</p>
                        <p><strong>Detalle de la Compra</strong></p>
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">UND</th>
                                        <th scope="col">Descripción</th>
                                        <th scope="col">Monto</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">01</th>
                                        <td id="description">Reunión privada sobre la Geología</td>
                                        <td align="right">$ 20.00</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td align="right"><strong>TOTAL</strong></td>
                                        <td align="right"><strong>$ 20.00</strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <p><strong>Forma de Pago</strong></p>
                        <p>Elije un forma de pago</p>
                        <form id="payment-form">
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="customRadioInline1" name="customRadioInline1" class="custom-control-input payment-type" data-type="1" required>
                                <label class="custom-control-label" for="customRadioInline1"><img src="{{ asset('img/paypal-logo.png') }}" width="120px"></label>                                
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="customRadioInline2" name="customRadioInline1" class="custom-control-input payment-type" data-type="2" required>
                                <label class="custom-control-label" for="customRadioInline2"><img src="{{ asset('img/cards.png') }}" width="300px"></label>
                            </div>
                            <div class="custom-control custom-checkbox mt-4">
                                <input type="checkbox" class="custom-control-input" id="customCheck1" required>
                                <label class="custom-control-label" for="customCheck1">Acepto <a href="#"> Términos y Condiciones</a> de la Transacción</label>
                            </div>
                            <div class="form-group text-center mt-4">
                                <button class="btn btn-dark" id="pay">Pagar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
  
@endsection
