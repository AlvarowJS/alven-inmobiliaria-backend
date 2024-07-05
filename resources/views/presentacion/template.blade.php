<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carta Presentación</title>
    <style>
        .container {
            position: relative;
            width: 1050px;
            height: 700px;
            overflow: hidden; /* Asegúrate de que el contenido adicional se recorte */
        }

        .background-img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
        }

        .diagonal-left,
        .diagonal-right {
            position: absolute;
            top: 0;
            width: 100%;
            height: 100%;
            z-index: 2;
        }

        .diagonal-left {
            left: 0;
            background-color: rgba(0, 0, 0, 0.5); /* Fondo semitransparente */
            transform: skewY(-45deg);
            transform-origin: top left;
        }

        .diagonal-right {
            right: 0;
            background-color: white; /* Fondo blanco */
            transform: skewY(45deg);
            transform-origin: top right;
        }

        .logo-container {
            position: absolute;
            top: 20px;
            left: 20px;
            width: 160px;
            height: 140px;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 3;
        }

        .logo {
            width: 100%;
            height: 100%;
        }

        .top-right-text {
            position: absolute;
            top: 0;
            right: 0;
            color: white;
            font-size: 44px;
            font-weight: bold;
            text-shadow: 2px 2px 4px #000;
            margin-top:200px;
            margin-right: 600px;
            margin-left: 20px;
            word-break: break-word;
            line-height: 1.2;
            padding: 4px;
            border-radius: 4px;
            background-color: rgba(255, 0, 0, 0.5);
            padding-left: 10px;
            z-index: 3;
            border-radius: 0 0 10% 0;
        }

        .bottom-right-text {
            position: absolute;
            bottom: 0;
            left: 0;
            color: white;
            font-size: 44px;
            font-weight: bold;
            text-shadow: 2px 2px 4px #000;
            /* margin-bottom: 20px; */
            margin-right: 20px;
            margin-left: 20px;
            background-color: rgba(255, 0, 0, 0.5);
            padding-left: 10px;
            padding-right: 10px;
            z-index: 3;
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="{{ public_path('storage/fotoPresentacion/'.$imagenFondo) }}" alt="Imagen" class="background-img">
        <div class="diagonal-left"></div>
        <div class="diagonal-right"></div>
        <div class="logo-container">
            <img src="{{ public_path('images/logo2.png') }}" alt="Logo" class="logo">
        </div>
        <div class="top-right-text">
            <span>{{ $frase }}</span>
        </div>
        <div class="bottom-right-text">
            <span>{{ $nombre }}</span><br>
            Tel: {{ $telefono }}
        </div>
    </div>
</body>
</html>
