<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Te escribieron un mensaje</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700&display=swap" rel="stylesheet">
    <style>
        body {font-family: 'Open Sans', sans-serif;font-size: 16px; position: relative; text-transform: uppercase;color: #33384E; overflow: hidden;}.top {width: 100%;height: 100px;background: #33384E}.top .logo {display:block;margin: auto;line-height: 100px;}
        .top .logo img {height: 70px;line-height: 100px; margin: 15px auto;display: block;}.top .logo h2 {font-weight: 600;user-select: none;margin: 0;}.main {width: 100%;padding: 25px;text-align: center;}
        .bottom {position: absolute; bottom: 0;width: 100%; height: 150px;background: #33384E; color: #fff; text-align: center; vertical-align: middle; padding: 20px;}.footer {color: #33384E; font-size: 13px} .footer p a {color: #CC2649; text-decoration: underline;}
        .information-container {background: #33384E; color: #CC2649; text-align: center; height: 60px;width: 220px; line-height: 60px; border: 1px solid #CC2649; margin: 3em auto;}

        .btn-custom-blue {
            background: #33384E;
            color: #fff!important;
            display: inline-block;
            font-weight: 400;
            text-align: center;
            vertical-align: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            border: 1px solid transparent;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            line-height: 1.5;
            border-radius: 0.25rem;
            transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }
        a:link, a:visited, a:active {
            text-decoration:none;
            color: white;
        }
        .message{
            font-size: 1.15rem;
            font-weight: 400;
            line-height: 1.5;
            color: #212529;
            text-align: center;
            background-color: #fff;
        }
    </style>
</head>
<body>
<div class="top">
    <div class="logo"><img src="{{ asset('img/logo2b.png') }}" alt="Zurviz"></div>
</div>
<div class="main">
    <h2>Hola, {{$name_send}} </h2>
    <p> <strong> {{$name}} </strong> ha dejado un nuevo mensaje:</p>
    <p class="message">"{{$message_n}}"</p>
    <p>Para contestarle inicia sesión</p>
    <a href="{{ env('APP_URL') }}/dashboard-messages" class="btn-custom-blue" target="_blank">Únete</a>
    <!--<a href="" class="btn" target="_blank">Unirme a la reunión</a>
    <div class="item-info">
        <p><strong>Código de Sesión: </strong></p>
    </div>-->

    <div class="footer">
        <P>¿Quieres enterarte cuando esté en oferta los cursos y clases?</P>
        <p>SUSCRÍBETE <a href="{{ env('APP_URL') }}" target="_blank">Haciendo clic Aquí</a></p>
    </div>
</div>
<div class="bottom">
    <p>Conviértete en Profesional</p>
    <p>ZURVIZ - DIRECCIÓN FISCAL C.P 03100</p>
</div>
</body>
</html>