@extends('adminlte::page')

@section('title', 'Usuarios')

@section('content_header')
@stop

@section('content')
    <div class="card">
        <div class="card-header text-dark"><h2>Notificaciones</h2></div>

        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <ul class="list-group list-group-flush" id="notifications-list-page">
                        @foreach ($notifications as $notification)
                            <li class="list-group-item">
                                {{ $notification->message }}
                                <span class="float-right text-muted text-sm">{{ \Date::createFromTimeStamp(strtotime($notification->created_at))->diffForHumans() }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    

@stop

@section('css')

@stop

@section('js')
    
@stop
