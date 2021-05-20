<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compra</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700&display=swap" rel="stylesheet">
    <style>
        *{box-sizing: border-box; padding: 0;margin: 0;}
        body {font-family: 'Open Sans', sans-serif;font-size: 16px; position: relative; text-transform: uppercase;color: #33384E;}.top {width: 100%;height: 100px;background: #33384E}.top .logo {display:block;margin: auto;line-height: 100px;}
        .top .logo img {height: 70px;line-height: 100px; margin: 15px auto;display: block;}.top .logo h2 {font-weight: 600;user-select: none;margin: 0;}.main {width: 100%;padding: 25px;text-align: center;}
        .bottom {position: absolute; bottom: 0;width: 100%; height: 150px;background: #33384E; color: #fff; text-align: center; vertical-align: middle; padding: 20px; clear: both;}.footer {color: #33384E; font-size: 13px; margin-top: 1em; clear: both;} .footer p a {color: #CC2649; text-decoration: underline;}
        .information-container {background: #33384E; color: #CC2649; text-align: center; height: 60px;width: 220px; line-height: 60px; border: 1px solid #CC2649; margin: 3em auto;}
        .subbanner {background: #CC2649; color: #fff; text-align: center; width: 100%; height: 80px; line-height: 80px;}
        @media (max-width: 720px) {
            .container {
                width: 90%;
                height: auto;
            }
        }
        .container {width: 60%; display: block; margin: 2em auto; background: #fff; box-shadow: 5px 5px 5px rgba(0,0,0,.3)}
        .container .item-image,
        .container .item-info {width: 50%;display: inline-block; height: 300px; float: left;}.container .item-image img {display: block; width: 100%; height: auto;}.container .item-image {overflow: hidden;}.btn-red {background: #CC2649; color: #fff !important; text-transform: uppercase; text-decoration: none; display: block; margin: 1em auto; padding: 8px 20px; width: 200px;}.container .item-info {padding: 20px;}.container .item-info.full {width: 100%;}
        .logo {
            width: auto !important;
        }
    </style>
</head>
<body>
<div class="top">
    <div class="logo"><img src="{{ asset('img/logo2b.png') }}" alt="Zurviz" /></div>
</div>
<div class="subbanner">
    Recuperación de contraseña
</div>
<div class="main">
    <h2>Hola</h2>
    <p>
        Estas recibiendo este correo electrónico porque recibimos una solicitud de restablecimiento de contraseña para su cuenta de ZURVIZ.
    </p>

        <div class="item-info">
            {{-- Action Button --}}
            @isset($actionText)
                <?php
                switch ($level) {
                    case 'success':
                    case 'error':
                        $color = $level;
                        break;
                    default:
                        $color = 'primary';
                }
                ?>
                @component('mail::button', ['url' => $actionUrl, 'color' => $color])
                    {{ $actionText }}
                @endcomponent
            @endisset
            <p>
                Este enlace de restablecimiento de contraseña caducará en 60 minutos si no solicitó un restablecimiento de contraseña, no se requiere ninguna otra acción. saludos,
                ZURVIZ
            </p>
        </div>
</div>
<div class="bottom" style="text-align: center !important;">
    <p style="text-align: center !important;">Conviértete en Profesional</p>
    <p style="text-align: center !important;">ZURVIZ - DIRECCIÓN FISCAL C.P 03100</p>
</div>
</body>
</html>