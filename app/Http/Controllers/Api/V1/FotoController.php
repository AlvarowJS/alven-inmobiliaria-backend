<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Foto;
use App\Models\Propiedad;
use Illuminate\Http\Request;

class FotoController extends Controller
{
    public function ordenar(Request $request)
    {
        $idPropiedad = $request->input('idPropiedad');
        $datos = $request->input('fotos');


        foreach ($datos as $dato) {
            $id = $dato['id'];
            $orden = $dato['orden'];

            $foto = Foto::find($id);
            $foto->orden = $orden;
            $foto->save();
        }
        $data = Foto::orderBy('orden')
            ->where('propiedad_id', $idPropiedad)
            ->get();
        return response()->json($data);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $datos = Foto::all();
        $datos = Foto::orderBy('orden')->get();
        return response()->json($datos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $carpeta = "fotos";
        $carpeta = $request->propiedad_id;
        $ruta = public_path($carpeta);

        // sacar un array de fotos
        $fotosRepetidas = Propiedad::find($carpeta);
        $fotosRepetidas = $fotosRepetidas->foto;
        $dataFotos = json_decode($fotosRepetidas, true);
        $fotosArray = array();
        foreach ($dataFotos as $item) {
            $fotosArray[] = $item['fotos'];
        }
        // EN fotos array se encuentra todos los nombres fotos referente al id de propiedad


        if (!\File::isDirectory($ruta)) {
            // $publicPath = 'storage/' . $carpeta;
            $publicPath = 'storage/' . $carpeta;
            \File::makeDirectory($publicPath, 0777, true, true);
        }
        $files = $request->file('fotos');
        if ($request->hasFile('fotos')) {

            foreach ($files as $file) {
                $nombre = $file->getClientOriginalName() . '.' . uniqid() . '.png';
                $path = $carpeta . '/' . $nombre;
                \Storage::disk('public')->put($path, \File::get($file));
            }
            $direcctorio = $carpeta;
            $rutaDirectorio = 'storage/' . $direcctorio;

            $arrFiles = glob($rutaDirectorio . '/*.{png,jpg,jpeg}', GLOB_BRACE);

            // $nombre = uniqid() . '.' . $files->getClientOriginalName();
            // $path = $carpeta . '/' . $nombre;
            // \Storage::disk('public')->put($path, \File::get($files));
            $respuesta = array();

            for ($i = 0; $i < count($arrFiles); $i++) {

                $nameFile = basename($arrFiles[$i]);

                if (in_array($nameFile, $fotosArray)) {
                } else {
                    $fotos = new Foto([
                        'propiedad_id' => $request->propiedad_id,
                        'fotos' => $nameFile,
                    ]);
                    $fotos->save();
                    array_push($respuesta, $fotos);
                }
            }
            return response()->json($respuesta);
            // return 'guardado';
        } else {
            return "erro";
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $datos = Propiedad::find($id);
        $fotos = $datos->foto->sortBy(function ($foto) {
            if (!empty($foto->orden)) {
                return $foto->orden;
            }

            if (preg_match('/(\d+)/', $foto->fotos, $matches)) {
                return (int) $matches[1];
            }

            // Si no hay número, poner un valor alto para que vaya al final
            return PHP_INT_MAX;
        });

        return response()->json($fotos->values());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update_fotos(Request $request)
    {
        $id = $request->id;
        $foto = Foto::find($id);
        $carpeta = $request->propiedad_id;

        $nombreArchivo = $foto->fotos;

        $files = $request->file('fotos');

        \Storage::disk('public')->delete($carpeta . '/' . $nombreArchivo);
        $nombreNuevo = $files->getClientOriginalName() . '.' . uniqid() . '.png';
        $pathNuevo = $carpeta . '/' . $nombreNuevo;
        \Storage::disk('public')->put($pathNuevo, \File::get($files));

        $foto->update([
            'propiedad_id' => $request->propiedad_id,
            'fotos' => $nombreNuevo,

        ]);

        return response()->json($foto);
        // }


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $datos = Foto::find($id);
        if (!$datos) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }

        $fotoBorrar = $datos->fotos;
        $idCarpeta = $datos->propiedad_id;
        $pathBorrar = $idCarpeta . '/' . $fotoBorrar;
        \Storage::disk('public')->delete($pathBorrar);

        $datos->delete();
        return response()->json(['message' => 'Registro eliminado']);
    }
}
