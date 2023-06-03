<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Foto;
use App\Models\Propiedad;
use Illuminate\Http\Request;

class FotoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datos = Foto::all();
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


        if (!\File::isDirectory($ruta)) {
            // $publicPath = 'storage/' . $carpeta;
            $publicPath = 'storage/' . $carpeta;
            \File::makeDirectory($publicPath, 0777, true, true);
        }
        $files = $request->file('fotos');
        if ($request->hasFile('fotos')) {

            foreach ($files as $file) {
                $nombre = uniqid() . '.' . $file->getClientOriginalName();
                $path = $carpeta . '/' . $nombre;
                \Storage::disk('public')->put($path, \File::get($file));
            }
            $direcctorio = $carpeta;
            $rutaDirectorio = 'storage/' . $direcctorio;

            $arrFiles = glob($rutaDirectorio . '/*.{png, jpg, jpeg}', GLOB_BRACE);

            // $nombre = uniqid() . '.' . $files->getClientOriginalName();
            // $path = $carpeta . '/' . $nombre;
            // \Storage::disk('public')->put($path, \File::get($files));
            $respuesta = array();
            for ($i = 0; $i < count($arrFiles); $i++) {
                try {
                    $nameFile = basename($arrFiles[$i]);
                    $fotos = new Foto([
                        'propiedad_id' => $request->propiedad_id,
                        'fotos' => $nameFile,
                    ]);
                    $fotos->save();
                    array_push($respuesta, $fotos);
                } catch (\Throwable $th) {

                }
            }
            return response()->json($respuesta);
        } else {
            return "erro";
        }


    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $datos = Foto::find($id);
        if (!$datos) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }
        return response()->json($datos);
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
        $nombreNuevo = uniqid() . '.' . $files->getClientOriginalName();
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
        $pathBorrar = $idCarpeta.'/'.$fotoBorrar;
        \Storage::disk('public')->delete($pathBorrar);

        $datos->delete();
        return response()->json(['message' => 'Registro eliminado']);
    }
}
