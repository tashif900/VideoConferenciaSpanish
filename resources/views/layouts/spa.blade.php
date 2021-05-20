<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="apple-touch-icon" sizes="57x57" href="{{asset('favicon_zurviz/apple-icon-57x57.png')}}">
    <link rel="apple-touch-icon" sizes="60x60" href="/favicon_zurviz/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/favicon_zurviz/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/favicon_zurviz/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/favicon_zurviz/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/favicon_zurviz/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/favicon_zurviz/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/favicon_zurviz/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/favicon_zurviz/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="/favicon_zurviz/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon_zurviz/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/favicon_zurviz/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon_zurviz/favicon-16x16.png">
    <link rel="manifest" href="/favicon_zurviz/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <link rel="stylesheet" href="{{asset('css/app.css')}}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}" type="text/css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;1,100&display=swap" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/owl.theme.default.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/themify-icons.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" type="text/css">
    @yield('styles')
    <link rel="stylesheet" href="{{ asset('css/waitMe.min.css') }}" type="text/css">
    <title>ZURVIZ</title>
</head>
<body>
<script type="text/javascript" src="https://cdn.conekta.io/js/latest/conekta.js"></script>
<div id="app">
   <app></app>
</div>

<script src="https://apis.google.com/js/platform.js" async defer></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="{{asset('js/app.js?v=1.3')}}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/owl.carousel.min.js') }}"></script>
{{-- <script src="{{asset('https://meet.jit.si/external_api.js')}}"></script> --}}
<script src="https://meet.jit.si/external_api.js"></script>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js"></script>

<script>
    // $('.class-carousel').owlCarousel({
    //     loop:true,
    //     margin:10,
    //     responsiveClass:true,
    //     dots: false,
    //     responsive:{
    //         0:{
    //             items:1,
    //             nav:true
    //         },
    //         600:{
    //             items:2,
    //             nav:false
    //         },
    //         1000:{
    //             items:4,
    //             nav:true,
    //             loop:false
    //         }
    //     }
    // });

</script>
<script src="{{ asset('js/waitMe.min.js') }}"></script>
@yield('scripts')
</body>
</html>