<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Publicidad;
use Illuminate\Http\Request;

class PublicidadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }
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
        $publicidad = new Publicidad;
        $publicidad->precio_venta = $request->precio_venta;
        $publicidad->encabezado = $request->encabezado;
        $publicidad->descripcion = $request->descripcion;
        $publicidad->video_url = $request->video_url;
        $publicidad->save();
        return response()->json($publicidad);
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
        $datos->precio_venta = $request->input('precio_venta');
        $datos->encabezado = $request->input('encabezado');
        $datos->descripcion = $request->input('descripcion');
        $datos->video_url = $request->input('video_url');
        $datos->save();
        return response()->json($datos);
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
