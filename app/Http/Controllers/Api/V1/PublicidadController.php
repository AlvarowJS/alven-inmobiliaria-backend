<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Publicidad;
use App\Models\Propiedad;
use Illuminate\Http\Request;

class PublicidadController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth:sanctum');
    // }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datos = Publicidad::all();
        return response()->json($datos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $carpeta = $request->id_propiedad;
        $ruta = public_path($carpeta.'/mapa');

        if (!\File::isDirectory($ruta)) {

            $publicPath = 'storage/' . $ruta;
            \File::makeDirectory($publicPath, 0777, true, true);
        }
        $files = $request->file('mapa');

        $publicidad = new Publicidad;

        if ($request->hasFile('mapa')) {

            $nombre = uniqid() . '.' . $files->getClientOriginalName();
            $path = $carpeta . '/mapa/' . $nombre;
            \Storage::disk('public')->put($path, \File::get($files));
            $publicidad->mapa = $nombre;
        }

        $publicidad->precio_venta = $request->precio_venta;
        $publicidad->encabezado = $request->encabezado;
        $publicidad->descripcion = $request->descripcion;
        $publicidad->video_url = $request->video_url;
        $publicidad->estado = $request->estado;
        $publicidad->save();

        $id = $publicidad->id;
        $id_propiedad = $request->id_propiedad;

        $propiedad = Propiedad::find($id_propiedad);
        $propiedad->publicidad_id = $id;
        $propiedad->save();
        return response()->json($propiedad);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $datos = Publicidad::find($id);
        if (!$datos) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }
        return response()->json($datos);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $datos = Publicidad::find($id);
        if (!$datos) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }
        $datos->precio_venta = $request->precio_venta;
        $datos->encabezado = $request->encabezado;
        $datos->descripcion = $request->descripcion;
        $datos->video_url = $request->video_url;
        $datos->estado = $request->estado;
        $datos->save();
        return response()->json($datos);
    }

    public function update_fotos(Request $request)
    {
        $carpeta = $request->id_propiedad.'/mapa';
        $id = $request->id;
        $publicidad = Publicidad::find($id);

        if ($request->hasFile('mapa')) {
            $nombreArchivo = $publicidad->mapa;
            $files = $request->file('mapa');

            \Storage::disk('public')->delete($carpeta . '/' . $nombreArchivo);
            $nombreNuevo = uniqid() . '.' . $files->getClientOriginalName();
            $pathNuevo = $carpeta . '/' . $nombreNuevo;
            \Storage::disk('public')->put($pathNuevo, \File::get($files));
            $publicidad->mapa = $nombreNuevo;
        }
        $publicidad->precio_venta = $request->precio_venta;
        $publicidad->encabezado = $request->encabezado;
        $publicidad->descripcion = $request->descripcion;
        $publicidad->video_url = $request->video_url;
        $publicidad->estado = $request->estado;
        $publicidad->save();
        return response()->json($publicidad);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $datos = Publicidad::find($id);
        if (!$datos) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }
        $datos->delete();
        return response()->json(['message' => 'Registro eliminado']);
    }
}
