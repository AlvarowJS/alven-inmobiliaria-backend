<!DOCTYPE html>
<html>
<head>



    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            position: relative;
        }

        .container {
            margin: 0 auto;
            /* max-width: 800px; */
            /* padding: 20px; */
        }

        .logo {
            width: 100px;
            height: 70px;
        }
        .primera-img{
            width: 300px;
            height: auto;
            position: absolute;
            top: 180px;
            right: 0;
            z-index: 9999;
            /* margin-top: 50px; */
        }

        .secundarias-img{
            width: 140px;
            height: 140px;

        }
        .header {
            text-align: center;
            /* margin-bottom: 20px; */
        }

        /* .galeria {
            margin-top: 20px;
            text-align: center;
            margin-bottom: 40px;
        } */

        /* .galeria img {
            width: 50%;
            height: auto;
            margin: 10px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 1);
        } */
        .caracteristicas{
            width: 50%;
        }
        li{
            margin-left: 30px
        }
        p{
            margin-bottom: 4px;
            margin-top: 0;
        }
        .espacios{
            width: 300px;

        }


    </style>


</head>
<body>
    <div class="container">
        <div class="header">
            <div class="header">
                <h1 style="display: inline-block; margin-right: 90px">{{ $propiedades->publicidad->encabezado ?? '' }}</h1>
                <img src="{{ public_path('images/logo.png') }}" class="logo" alt="Logo" style="display: inline-block;">
            </div>
        </div>
        <div style="text-align: right; margin-bottom: 0;">
        {{ $propiedades->direccion->calle ?? '' }}  {{ $propiedades->direccion->numero ?? ''}} - {{ $propiedades->direccion->municipio ?? ''}} - {{ $propiedades->direccion->estado ?? ''}}
        </div>
        <table class="datos-propiedad">
            <tr class="basicos">
                <td class="caracteristicas">
                    Precio: {{ $propiedades->publicidad->precio_venta ?? ''}}
                    <p>{{ $propiedades->publicidad->descripcion ?? '' }}</p>
                    <p>Con las siguientes caracteristicas</p>
                    <p>Mascotas: {{ $propiedades->caracteristica->mascotas ?? ''}}</p>
                    <h2>Espacios:</h2>
                    @if (!empty($propiedades->caracteristica->espacios))
                        @php
                            $espacios = json_decode($propiedades->caracteristica->espacios);
                            $totalEspacios = count($espacios);
                            $columna1Espacio = array_slice($espacios, 0, ceil($totalEspacios / 2));
                            $columna2Espacio = array_slice($espacios, ceil($totalEspacios / 2));
                        @endphp
                        <div style="overflow: auto;">
                                <div style="float: left; width: 50%;">
                                    @foreach ($columna1Espacio as $espacio)
                                        <li>{{ $espacio }}</li>
                                    @endforeach
                                </div>
                                <div style="float: left; width: 50%;">
                                    @foreach ($columna2Espacio as $espacio)
                                        <li>{{ $espacio }}</li>
                                    @endforeach
                                </div>
                            </div>
                    @else
                            Sin Espacios
                    @endif
                    <h2>Instalaciones:</h2>
                    @if (!empty($propiedades->caracteristica->instalaciones))
                    @php
                    $instalaciones = json_decode($propiedades->caracteristica->instalaciones);
                    $totalInstalaciones = count($instalaciones);
                    $columna1Instalacion = array_slice($instalaciones, 0, ceil($totalInstalaciones / 2));
                    $columna2Instalacion = array_slice($instalaciones, ceil($totalInstalaciones / 2));
                    @endphp

                    <div style="overflow: auto;">
                        <div style="float: left; width: 50%;">
                            @foreach ($columna1Instalacion as $instalacion)
                                <li>{{ $instalacion }}</li>
                            @endforeach
                        </div>
                        <div style="float: left; width: 50%;">
                            @foreach ($columna2Instalacion as $instalacion)
                                <li>{{ $instalacion }}</li>
                            @endforeach
                        </div>
                    </div>
                    @else
                        Sin Instalaciones
                    @endif
                    <h2>Restricciones:</h2>
                    @if (!empty($propiedades->caracteristica->restricciones))
                    @php
                    $restricciones = json_decode($propiedades->caracteristica->restricciones);
                    $totalRestricciones = count($restricciones);
                    $columna1Restricciones = array_slice($restricciones, 0, ceil($totalRestricciones / 2));
                    $columna2Restricciones = array_slice($restricciones, ceil($totalRestricciones / 2));
                    @endphp

                    <div style="overflow: auto;">
                        <div style="float: left; width: 50%;">
                            @foreach ($columna1Restricciones as $restriccion)
                                <li>{{ $restriccion }}</li>
                            @endforeach
                        </div>
                        <div style="float: left; width: 50%;">
                            @foreach ($columna2Restricciones as $restriccion)
                                <li>{{ $restriccion }}</li>
                            @endforeach
                        </div>
                    </div>
                    @else
                        Sin Restricciones
                    @endif
                </td>
                {{-- <td> --}}

                    {{-- <div class="galeria-fotos">
                        @foreach ($propiedades->foto as $foto)
                            <img class="secundarias-img" src="{{ public_path('storage/'.$propiedades->id.'/'.$foto->fotos) }}" alt="Foto">
                        @endforeach
                    </div> --}}
                {{-- </td> --}}
            </tr>
        </table>
        @if(count($propiedades->foto) > 0)
            <img class="primera-img" src="{{ public_path('storage/'.$propiedades->id.'/'.$propiedades->foto[0]->fotos) }}" alt="Foto" >
        @endif

        <h2 style="margin-top: 80px; margin-bottom: 0">Básicos</h2>
        <div style="overflow: auto; ">
            <div style="float: left; width: 40%;">
                <p>Superficie del terreno: {{ $propiedades->basico->superficie_terreno ?? '' }}</p>
                <p>Superficie de construcción: {{ $propiedades->basico->superficie_construccion ?? '' }}</p>
                <p>Niveles construidos: {{ $propiedades->basico->niveles_construidos ?? '' }}</p>
                <p>Número de elevadores: {{ $propiedades->basico->numero_elevadores ?? '' }}</p>
            </div>
            <div style="float: left; width: 30%;">
                <p>Estacionamiento: {{ $propiedades->basico->estacionamiento ?? '' }}</p>
                <p>Cocinas: {{ $propiedades->basico->cocinas ?? '' }}</p>
                <p>Baños: {{ $propiedades->basico->banios ?? '' }}</p>
                <p>Medios Baños: {{ $propiedades->basico->medios_banios ?? ''}}</p>
            </div>
            <div style="float: left; width: 30%;">
                <p>Número de casas: {{ $propiedades->basico->numero_casas ?? ''}}</p>
                <p>Piso Ubicado: {{ $propiedades->basico->piso_ubicado ?? ''}}</p>
                <p>Recamaras: {{ $propiedades->basico->recamaras ?? '' }}</p>

            </div>

        </div>
    </div>
</body>
</html>
