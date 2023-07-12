<!DOCTYPE html>
<html>

<head>



    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            /* position: relative; */
        }



        .logo {
            width: 100px;
            height: 70px;
        }

        .primera-img {

            width: 300px;
            height: auto;
            position: absolute;
            top: 30%;
            right: 0;
            z-index: 9999;
        }

        .secundarias-img {
            width: 140px;
            height: 140px;

        }

        .header {
            text-align: center;
            /* margin-bottom: 20px; */
        }

        .caracteristicas {
            width: 50%;
        }

        li {
            /* margin-left: 30px */
        }

        p {
            margin-bottom: 4px;
            margin-top: 0;
        }

        .espacios {
            width: 300px;

        }
    </style>


</head>

<body>
    <div class="container">
        <h1 style="display: inline-block; margin-right: 90px">{{ $propiedades->publicidad->encabezado ?? '' }}</h1>
        <div style="text-align: center">
            <img src="{{ public_path('images/logo.png') }}" class="logo" alt="Logo" >
        </div>
        <h4 style="text-align: right">
            {{ $propiedades->direccion->calle ?? '' }} {{ $propiedades->direccion->numero ?? '' }} -
            {{ $propiedades->direccion->municipio ?? '' }} - {{ $propiedades->direccion->estado ?? '' }}
        </h4>

        <div style="overflow: auto; width: 100%;">
            <p>Precio: ${{ number_format($propiedades->publicidad->precio_venta ?? 0, 2, ',', '.') }}</p>
            <p>{!! nl2br(e($propiedades->publicidad->descripcion ?? '')) !!}</p>
            <p>Con las siguientes características</p>
            <p>Mascotas: {{ $propiedades->caracteristica->mascotas ?? '' }}</p>
        </div>
        @if (count($propiedades->foto) > 0)
            <img class="primera-img"
                src="{{ public_path('storage/' . $propiedades->id . '/' . $propiedades->foto[0]->fotos) }}"
                alt="Foto">
        @endif
        @if (!empty($propiedades->caracteristica->espacios))
            @php
                $espacios = json_decode($propiedades->caracteristica->espacios);
                if (is_array($espacios)) {
                    $totalEspacios = count($espacios);
                    $columna1Espacio = array_slice($espacios, 0, ceil($totalEspacios / 2));
                    $columna2Espacio = array_slice($espacios, ceil($totalEspacios / 2));
                } else {
                    $totalEspacios = 0;
                    $columna1Espacio = [];
                    $columna2Espacio = [];
                }
            @endphp

            <div style="width: 50%; height: auto">
                <h2>Espacios:</h2>
                <ul style="float: left; width: 50%;">
                    @foreach ($columna1Espacio as $espacio)
                        <li>{{ $espacio }}</li>
                    @endforeach
                </ul>
                <ul style="float: left; width: 50%;">
                    @foreach ($columna2Espacio as $espacio)
                        <li>{{ $espacio }}</li>
                    @endforeach
                </ul>
            </div>
        @else
            Sin Espacios
        @endif

        @if (!empty($propiedades->caracteristica->instalaciones))
            @php
                $instalaciones = json_decode($propiedades->caracteristica->instalaciones);

                // Verificar si $instalaciones es un array antes de contar los elementos
                if (is_array($instalaciones)) {
                    $totalInstalaciones = count($instalaciones);
                    $columna1Instalacion = array_slice($instalaciones, 0, ceil($totalInstalaciones / 2));
                    $columna2Instalacion = array_slice($instalaciones, ceil($totalInstalaciones / 2));
                } else {
                    $totalInstalaciones = 0;
                    $columna1Instalacion = [];
                    $columna2Instalacion = [];
                }
            @endphp

            <div style="width: 50%; height: auto; margin-top: 20px;">
                <h2>Instalaciones:</h2>
                <ul style="float: left; width: 50%;">
                    @foreach ($columna1Instalacion as $instalacion)
                        <li>{{ $instalacion }}</li>
                    @endforeach
                </ul>
                <ul style="float: left; width: 50%;">
                    @foreach ($columna2Instalacion as $instalacion)
                        <li>{{ $instalacion }}</li>
                    @endforeach
                </ul>
            </div>
        @else
            Sin Instalaciones
        @endif

        @if (!empty($propiedades->caracteristica->restricciones))
            @php
                $restricciones = json_decode($propiedades->caracteristica->restricciones);

                // Verificar si $restricciones es un array antes de contar los elementos
                if (is_array($restricciones)) {
                    $totalRestricciones = count($restricciones);
                    $columna1Restricciones = array_slice($restricciones, 0, ceil($totalRestricciones / 2));
                    $columna2Restricciones = array_slice($restricciones, ceil($totalRestricciones / 2));
                } else {
                    $totalRestricciones = 0;
                    $columna1Restricciones = [];
                    $columna2Restricciones = [];
                }
            @endphp

            <div style="overflow: auto; width: 50%">
                <h2>Restricciones:</h2>
                <ul>
                    @foreach ($columna1Restricciones as $restriccion)
                        <li>{{ $restriccion }}</li>
                    @endforeach

                    @foreach ($columna2Restricciones as $restriccion)
                        <li>{{ $restriccion }}</li>
                    @endforeach
                </ul>
            </div>
        @else
            Sin Restricciones
        @endif
        {{-- </td>
            </tr> --}}
        <div style="overflow: auto; width: 100%;">
            <h2 style="margin-bottom: 0">Básicos</h2>
            <div style="padding-left: 30px">
                <div style="width: 100%;">
                    <p>Superficie del terreno: {{ $propiedades->basico->superficie_terreno ?? '' }}</p>
                    <p>Superficie de construcción: {{ $propiedades->basico->superficie_construccion ?? '' }}</p>
                    <p>Niveles construidos: {{ $propiedades->basico->niveles_construidos ?? '' }}</p>
                    <p>Número de elevadores: {{ $propiedades->basico->numero_elevadores ?? '' }}</p>
                    {{-- </div>
                <div style="float: left; width: 30%;"> --}}
                    <p>Estacionamiento: {{ $propiedades->basico->estacionamiento ?? '' }}</p>
                    <p>Cocinas: {{ $propiedades->basico->cocinas ?? '' }}</p>
                    <p>Baños: {{ $propiedades->basico->banios ?? '' }}</p>
                    <p>Medios Baños: {{ $propiedades->basico->medios_banios ?? '' }}</p>
                    {{-- </div>
                <div style="float: left; width: 30%;"> --}}
                    <p>Número de casas: {{ $propiedades->basico->numero_casas ?? '' }}</p>
                    <p>Piso Ubicado: {{ $propiedades->basico->piso_ubicado ?? '' }}</p>
                    <p>Recamaras: {{ $propiedades->basico->recamaras ?? '' }}</p>
                </div>
            </div>
        </div>

        <h2 style="margin-bottom: 0; margin-top: 10px;">Asesor Exclusivo</h2>
        <div style="overflow: auto; ">
            <div>
                <p>Asesor: {{ $propiedades->asesor->nombre ?? '' }} {{ $propiedades->asesor->apellidos ?? '' }}</p>
                <p>Teléfono: {{ $propiedades->asesor->celular ?? '' }}</p>
            </div>
        </div>
    </div>
</body>

</html>
