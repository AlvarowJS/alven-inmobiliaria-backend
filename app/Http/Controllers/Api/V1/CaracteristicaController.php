<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Caracteristica;
use Illuminate\Http\Request;

class CaracteristicaController extends Controller
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
        $datos = Caracteristica::all();
        return response()->json($datos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $caracteristica = new Caracteristica;
        $caracteristica->mascotas = $request->mascotas;
        $caracteristica->espacios = $request->espacios;
        $caracteristica->instalaciones = $request->instalaciones;
        $caracteristica->basicos = $request->basicos;
        $caracteristica->save();
        return response()->json($caracteristica);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $datos = Caracteristica::find($id);
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
        $caracteristica = Caracteristica::find($id);
        if (!$caracteristica) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }

        $caracteristica->mascotas = $request->mascotas;
        $caracteristica->espacios = $request->espacios;
        $caracteristica->instalaciones = $request->instalaciones;
        $caracteristica->basicos = $request->basicos;

        $caracteristica->save();
        return response()->json($caracteristica);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $datos = Caracteristica::find($id);
        if (!$datos) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }
        $datos->delete();
        return response()->json(['message' => 'Registro eliminado']);
    }
}
