<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Presentacion;
use Illuminate\Http\Request;

class PresentacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datos = Presentacion::all();
        return $datos;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $carpeta = 'fotoPresentacion';
        $ruta = public_path($carpeta);
        if (!\File::isDirectory($ruta)) {
            $publicpath = 'storage/' . $carpeta;
            \FIle::makeDirectory($publicpath, 0777, true, true);
        }

        $presentacion = new Presentacion;
        $presentacion->nombre = $request->nombre;

        $imagen = $request->file('foto');

        if ($request->hasFile('foto')) {
            $nombre = uniqid() . '.' . $imagen->getClientOriginalName();
            $path = $carpeta . '/' . $nombre;
            \Storage::disk('public')->put($path, \File::get($imagen));
            $presentacion->foto = $nombre;
        }
        $presentacion->save();

        return response()->json(['mensaje' => 'Presentacion creada exitosamente', 'data' => $presentacion], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $datos = Presentacion::find($id);
        if (!$datos) {
            return response()->json(['message' => 'Registro no encontrado'], 201);
        }
        return response()->json($datos);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Presentacion $presentacion)
    {
        //
    }
    public function updateFoto(Request $request)
    {
        $id = $request->id;
        $presentacion = Presentacion::find($id);

        if (!$presentacion) {
            return response()->json(['error' => 'Portada no encontrada'], 404);
        }

        $presentacion->nombre = $request->nombre;

        if ($request->hasFile('foto')) {
            // Elimina la imagen antigua si existe
            if ($presentacion->foto) {
                \Storage::disk('public')->delete('fotoPresentacion/' . $presentacion->foto);
            }

            // Sube la nueva imagen
            $imagen = $request->file('foto');
            $nombre = uniqid() . '.' . $imagen->getClientOriginalName();
            $path = 'fotoPresentacion/' . $nombre;
            \Storage::disk('public')->put($path, \File::get($imagen));
            $presentacion->foto = $nombre;
        }        
        $presentacion->save();

        return response()->json(['mensaje' => 'Presentación actualizada exitosamente', 'data' => $presentacion], 200);

    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $presentacion = Presentacion::find($id);

        if (!$presentacion) {
            return response()->json(['error' => 'Portada no encontrada'], 404);
        }

        // Elimina la imagen asociada si existe
        if ($presentacion->foto) {
            \Storage::disk('public')->delete('fotoPresentacion/' . $presentacion->foto);
        }

        $presentacion->delete();

        return response()->json(['mensaje' => 'Presentacion eliminada exitosamente'], 200);
    }
}
