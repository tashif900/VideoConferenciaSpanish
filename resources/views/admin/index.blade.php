@extends('adminlte::page')

@section('title', 'Sist. Video')

@section('content_header')
@stop

@section('content')
    <h2>Bienvenido</h2>
    <p>{{auth()->user()->name}}</p>
@stop

@section('css')

@stop
