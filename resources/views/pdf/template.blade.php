<!DOCTYPE html>
<html>

<head>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #333333;
            /* position: relative; */
        }

        .encabezado {
            text-align: center;
        }

        .encabezado-foto {
            display: inline-block;
            vertical-align: middle;
            color: #ee8178;
        }

        .nombre-asesor {
            display: inline-block;
            text-align: left;
        }

        .foto-asesor {
            display: inline-block;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            border: 3px solid #ee8178;

        }

        .encabezado-logo {
            display: inline-block;
            vertical-align: middle;
            margin: 0 20px
        }

        .logo-img {
            width: 100px;
            height: 100px;
        }

        .encabezado-datos {
            display: inline-block;
            text-align: right;

        }

        .encabezado-datos p {
            margin-bottom: 0px;
            margin-top: 0px;

        }

        .portada {
            text-align: center;
            background-color: #E6E7E8;
        }

        .portada-img {
            width: '100%';
            height: 300px;

        }

        .titulo {
            color: black;
        }

        .titulo-color {
            color: #ee8178
        }

        .tipo-propiedad {
            display: inline-block;
            margin-right: 60px
        }

        .tipo-operacion {
            display: inline-block;

        }

        .basicos {
            padding-left: 30px;
        }

        .basicos p {
            margin-bottom: 0px;
            margin-top: 0px;
        }

        .descripcion {
            padding-left: 40px;
        }

        .direccion {
            padding-left: 40px;
            margin-bottom: 20px;

        }

        .direccion-mapa {
            text-align: center;
            background-color: #E6E7E8;

        }

        .direccion-img {
            width: 600px;
            height: 300px;
            object-fit: cover;
        }

        .galeria {
            /* display: inline; */
            /* page-break-inside: avoid; */
            /* padding-top: 30px; */
            /* float: bottom; */

        }

        .galeria-container {
            text-align: center;
            /* display: inline-block; */
        }

        .galeria b {
            margin-left: 40px;
            margin-bottom: 30px;
        }

        .galeria-img {
            /* display: inline-block; */
            width: 300px;
            height: 200px;
            margin-top: 10px;
            margin-right: 20px;
            margin-bottom: 20px;

        }

        .pie {
            text-align: center;
        }

        .pie p {
            margin-bottom: 0px;
            margin-top: 0px;
            font-size: 12px
        }

        .pie b {

            font-size: 12px
        }

        hr {
            color: #E6E7E8;
        }

        /* dividir */
        .column {
            float: left;
            width: 25%;
            /* Ancho de cada columna (25% para 4 columnas) */
            box-sizing: border-box;
            padding: 5px;
        }

        .clear {
            clear: both;
        }
    </style>


</head>

<body>
    <div class="encabezado">
        @if ($estado == 'true')
            <div class="encabezado-foto">
                @if (isset($propiedades->asesor->foto))
                    <img class="foto-asesor" src="{{ public_path('storage/asesor/' . $propiedades->asesor->foto) }}">
                @endif

                <div class="nombre-asesor">
                    {{ $propiedades->asesor->nombre ?? '' }} <br>
                    {{ $propiedades->asesor->apellidos ?? '' }}
                </div>
            </div>
        @endif
        <div class="encabezado-logo">
            <img src="{{ public_path('images/logo2.png') }}" class="logo-img" alt="Logo">
        </div>

        <div class="encabezado-datos">
            <p>ID: {{ $propiedades->general->numero_ofna ?? '' }}</p>
            @if ($estado == 'true')
                <p>{{ $propiedades->asesor->email ?? '' }}</p>
                <p>{{ $propiedades->asesor->celular ?? '' }}</p>
            @endif
        </div>
    </div>
    <div class="portada">
        @if (count($propiedades->foto) > 0)
            <img class="portada-img"
                src="{{ public_path('storage/' . $propiedades->id . '/' . $propiedades->foto[0]->fotos) }}"
                alt="Foto">
        @endif
    </div>

    <div class="titulo">
        <p class="titulo-color">{{ $propiedades->publicidad->encabezado ?? '' }}</p>
        <p>{{ $propiedades->direccion->calle ?? '' }} {{ $propiedades->direccion->numero ?? '' }} ,
            {{ $propiedades->direccion->municipio ?? '' }} , {{ $propiedades->direccion->estado ?? '' }}</p>
    </div>

    <hr>

    <div>
        <p><b>Precio: ${{ number_format($propiedades->publicidad->precio_venta ?? 0, 2, ',', ',') }}</b></p>
    </div>

    <hr>

    <div class="tipo">
        <div class="tipo-propiedad">
            <p><b>Tipo de propiedad: {{ $propiedades->general->tipo_propiedad ?? '' }}</b></p>
        </div>
        <div class="tipo-operacion">
            <p><b>Tipo de operación: </b>{{ $propiedades->general->tipo_operacion ?? '' }}</p>
        </div>
    </div>

    <hr>

    <div class="basicos">
        @if ($propiedades->basico->superficie_terreno)
            <p><b>• Superficie del terreno:</b> {{ $propiedades->basico->superficie_terreno }}</p>
        @endif
        @if ($propiedades->basico->superficie_construccion)
            <p><b>• Superficie de construcción:</b> {{ $propiedades->basico->superficie_construccion }}</p>
        @endif
        @if ($propiedades->basico->niveles_construidos)
            <p><b>• Niveles construidos:</b> {{ $propiedades->basico->niveles_construidos }}</p>
        @endif
        @if ($propiedades->basico->numero_elevadores)
            <p><b>• Número de elevadores:</b> {{ $propiedades->basico->numero_elevadores }}</p>
        @endif
        @if ($propiedades->basico->estacionamiento)
            <p><b>• Estacionamiento:</b> {{ $propiedades->basico->estacionamiento }}</p>
        @endif
        @if ($propiedades->basico->cocinas)
            <p><b>• Cocinas:</b> {{ $propiedades->basico->cocinas }}</p>
        @endif
        @if ($propiedades->basico->banios)
            <p><b>• Baños:</b> {{ $propiedades->basico->banios }}</p>
        @endif
        @if ($propiedades->basico->medios_banios)
            <p><b>• Medios Baños:</b> {{ $propiedades->basico->medios_banios }}</p>
        @endif
        @if ($propiedades->basico->numero_casas)
            <p><b>• Número de casas:</b> {{ $propiedades->basico->numero_casas }}</p>
        @endif
        @if ($propiedades->basico->piso_ubicado)
            <p><b>• Piso Ubicado:</b> {{ $propiedades->basico->piso_ubicado }}</p>
        @endif
        @if ($propiedades->basico->recamaras)
            <p><b>• Recamaras:</b> {{ $propiedades->basico->recamaras }}</p>
        @endif
        @if ($propiedades->basico->edad)
            <p><b>• Edad del inmueble:</b> {{ $propiedades->basico->edad }}</p>
        @endif

        {{-- <p><b>• Superficie del terreno:</b> {{ $propiedades->basico->superficie_terreno ?? '' }}</p>
        <p><b>• Superficie de construcción:</b> {{ $propiedades->basico->superficie_construccion ?? '' }}</p>
        <p><b>• Niveles construidos:</b> {{ $propiedades->basico->niveles_construidos ?? '' }}</p>
        <p><b>• Número de elevadores:</b> {{ $propiedades->basico->numero_elevadores ?? '' }}</p>
        <p><b>• Estacionamiento:</b> {{ $propiedades->basico->estacionamiento ?? '' }}</p>
        <p><b>• Cocinas:</b> {{ $propiedades->basico->cocinas ?? '' }}</p>
        <p><b>• Baños:</b> {{ $propiedades->basico->banios ?? '' }}</p>
        <p><b>• Medios Baños:</b> {{ $propiedades->basico->medios_banios ?? '' }}</p>
        <p><b>• Número de casas:</b> {{ $propiedades->basico->numero_casas ?? '' }}</p>
        <p><b>• Piso Ubicado:</b> {{ $propiedades->basico->piso_ubicado ?? '' }}</p>
        <p><b>• Recamaras:</b> {{ $propiedades->basico->recamaras ?? '' }}</p>
        <p><b>• Edad del inmueble:</b> {{ $propiedades->basico->edad ?? '' }}</p> --}}
    </div>

    <hr>
    @php
        $espaciosArray = json_decode($propiedades->caracteristica->espacios, true);
        // $totalEspacios = count($espaciosArray);
        if (is_array($espaciosArray)) {
            $totalEspacios = count($espaciosArray);
        } else {
            $totalEspacios = 0;
        }
    @endphp

    @for ($i = 0; $i < $totalEspacios; $i += 4)
        <div class="column">
            <ul>
                @for ($j = $i; $j < min($i + 4, $totalEspacios); $j++)
                    <li>{{ $espaciosArray[$j] }}</li>
                @endfor
            </ul>
        </div>
    @endfor

    <div class="clear"></div>

    <hr>

    <div class="descripcion">
        <b>Descripción</b>
        <p>{!! nl2br(e($propiedades->publicidad->descripcion ?? '')) !!}</p>
    </div>

    <hr>

    <div class="direccion">
        <b>Ubicación</b>
        <p>{{ $propiedades->direccion->calle ?? '' }} {{ $propiedades->direccion->numero ?? '' }} ,
            {{ $propiedades->direccion->municipio ?? '' }} , {{ $propiedades->direccion->estado ?? '' }}</p>

        <b>Referencias</b> <br>
        <div class="direccion-mapa">
            @if (isset($propiedades->publicidad->mapa))
                <img class="direccion-img"
                    src="{{ public_path('storage/' . $propiedades->id . '/mapa/' . $propiedades->publicidad->mapa) }}"
                    alt="Foto">
            @endif
        </div>
    </div>

    <hr>


    <div class="galeria">
        <b style="margin-left: 40px">Catálogo de fotos</b>
        <br>

        <table style="width:100%">
            @foreach ($propiedades->foto as $index => $foto)
                @if ($index % 2 === 0)
                    <tr>
                @endif
                <td>
                    <img class="galeria-img"
                        src="{{ public_path('storage/' . $propiedades->id . '/' . $foto->fotos) }}" alt="Foto">
                </td>
                @if ($index % 2 !== 0 || $loop->last)
                    </tr>
                @endif
            @endforeach
        </table>
        <div class="galeria-container">

        </div>


    </div>

    <div class="pie">
        <b>Dirección: C. J. Enrique Pestalozzi 583 - CDMX, México</b> <br>
        <b>Teléfono: +52 55 11 07 87 17 | www.alven-inmobiliaria.com.mx </b>
        <div style="margin-top: 20px; ">
            <p>Propiedad sujeta a disponibilidad.</p>
            <p>Precio sujeto a cambios sin previo aviso.</p>
            <p>El envío de esta ficha no compromete a las partes a la suscripción de ningún documento legal. La
                información y medidas </p>
            <p>son aproximadas y deberán ratificarse con la documentación pertinente.</p>
        </div>
    </div>

</body>

</html>
