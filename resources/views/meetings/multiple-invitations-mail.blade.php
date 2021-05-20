<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recordatorio</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700&display=swap" rel="stylesheet">
    <style>
        body {font-family: 'Open Sans', sans-serif;font-size: 16px; position: relative; text-transform: uppercase;color: #33384E; overflow: hidden;}.top {width: 100%;height: 100px;background: #33384E}.top .logo {display:block;margin: auto;line-height: 100px;}
        .top .logo img {height: 70px;line-height: 100px; margin: 15px auto;display: block;}.top .logo h2 {font-weight: 600;user-select: none;margin: 0;}.main {width: 100%;padding: 25px;text-align: center;}
        .bottom {bottom: 0;width: 100%; height: 150px;background: #33384E; color: #fff; text-align: center; vertical-align: middle; padding: 20px;}.footer {color: #33384E; font-size: 13px} .footer p a {color: #CC2649; text-decoration: underline;}
        .information-container {background: #33384E; color: #CC2649; text-align: center; height: 60px;width: 220px; line-height: 60px; border: 1px solid #CC2649; margin: 3em auto;}
        table {margin: 0 auto; border-spacing: 0;} table tr td {padding: 5px 8px;}
    </style>
</head>
<body>
    <div class="top">
        <div class="logo"><img src="{{ asset('img/logo2b.png') }}" alt="Zurviz"></div>
    </div>
    <div class="main">
        <h2>Hola, {{ $name }}</h2>
        <p>Te estan invitando a participar a una reunion. para ingresar ingresa al siguiente enlace.</p>

        <a href="{{ $link_invitacion }}" class="btn" target="_blank">Unirme a la reunión</a>
        <!--
        <table border="1">
            <thead>
                <tr>
                    <th>Session</th>
                    <th>Enlace</th>
                </tr>
            </thead>
            <tbody>
                @for ($i = 0; $i < count($link); $i++)
                    <tr>
                        <td>{{ $link[$i]['name'] }}</td>
                        <td>{{ $link[$i]['room'] }}</td>
                    </tr>
                @endfor
            </tbody>
        </table>-->
        <div class="item-info">
            <p><strong>Código de Sesión: </strong>{{ $code }}</p>
        </div>
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