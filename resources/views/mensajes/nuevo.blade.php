<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bienvenido a Vitrina Laboral</title>
</head>
<body>
    Hola {{ $usuario->nombre }}, gracias por unirtenos.<br><br>
    Tu usuario corresponde a <b>{{ $usuario->email }}</b>, mientras que tu clave es <b>123456789<b/>
    <br><br>

    Atte. Equipo de <a href="https://www.vitrinalaboral.cl">Vitrina Laboral</a>

</body>
</html>
