@extends('layouts.web')
@section('title', 'Perfil')
@section('content')
    <div class="row mt-4">
        <div class="col-12">
            <div class="card-white">
                <div class="container-fluid">
                    <div class="row public-profile">
                        <div class="col-12 col-md-3">
                            <div class="profile-image">
                                <img src="{{ asset('img/banner.jpg') }}" alt="">
                                <p>Carlos Perez <span>Instructor</span></p>
                            </div>
                            <div class="status-icon"><span></span> Disponible</div> 
                        </div>
                        <div class="col-12 col-md-9">
                            <div class="row">
                                <div class="col-12">
                                    <h5 class="subtitle-underline">INFORMACIÓN</h5>
                                    <p><strong>PROFESIÓN</strong> Lorem ipsum dolor sit amet</p> 
                                    <p><strong>CENTRO DE ESTUDIOS</strong> Lorem ipsum dolor sit amet</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <h5 class="subtitle-underline">CONTACTO</h5>
                                </div>
                                <div class="col-12 col-md-6">
                                    <p><strong>FACEBOOK</strong> Lorem ipsum dolor sit amet</p> 
                                    <p><strong>WHATSAPP</strong> Lorem ipsum dolor sit amet</p> 
                                </div>
                                <div class="col-12 col-md-6">
                                    <p><strong>INSTAGRAM</strong> Lorem ipsum dolor sit amet</p> 
                                    <p><strong>TWITTER</strong> Lorem ipsum dolor sit amet</p> 
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 text-center">
                                    <strong>Horario Disponibilidad</strong> 08:00 - 11:00
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <label><strong>Descripción</strong></label>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Autem dolorum et consectetur sint, quibusdam dolore beatae quae laborum at dolorem earum vitae iusto quisquam a illo voluptatem consequuntur animi. Corrupti? Lorem ipsum dolor sit amet consectetur adipisicing elit. Molestias repellendus accusantium earum nulla molestiae officia consectetur aliquid vel nihil, eos inventore iure animi et porro perferendis, voluptatibus quibusdam alias debitis.</p>
                        </div>
                        <div class="col-12">
                            <label><strong>Intereses</strong></label>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Autem dolorum et consectetur sint, quibusdam dolore beatae quae laborum at dolorem earum vitae iusto quisquam a illo voluptatem consequuntur animi. Corrupti? Lorem ipsum dolor sit amet consectetur adipisicing elit. Molestias repellendus accusantium earum nulla molestiae officia consectetur aliquid vel nihil, eos inventore iure animi et porro perferendis, voluptatibus quibusdam alias debitis.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

@endsection
