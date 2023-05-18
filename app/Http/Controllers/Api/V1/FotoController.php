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
        $carpeta = "fotos";
        $ruta = public_path($carpeta);


        if (!\File::isDirectory($ruta)) {
            // $publicPath = 'storage/' . $carpeta;
            $publicPath = 'storage/' . $carpeta;
            \File::makeDirectory($publicPath, 0777, true, true);
        }
        $files = $request->file('fotos');
        if ($request->hasFile('fotos')) {

            $nombre = uniqid() . '.' . $files->getClientOriginalName();
            $path = $carpeta . '/' . $nombre;
            \Storage::disk('public')->put($path, \File::get($files));

            $noticia = new Foto([
                'propiedad_id' => $request->propiedad_id,
                'fotos' => $nombre,

            ]);
            $noticia->save();
            return "archivo guardado";

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
        $carpeta = "fotos";
        $nombreArchivo = $foto->fotos;
        // $tituloNuevo = $request->input('fotos');
        $files = $request->file('fotos');


        // if (\Storage::disk('public')->exists($carpeta . '/' . $nombreArchivo)) {

        \Storage::disk('public')->move($carpeta . '/' . $nombreArchivo, $carpeta . '/' . $files);

        $nombre = uniqid() . '.' . $files->getClientOriginalName();

        $foto->update([
            'propiedad_id' => $request->propiedad_id,
            'fotos' => $nombre,

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
        $datos->delete();
        return response()->json(['message' => 'Registro eliminado']);
    }
}
