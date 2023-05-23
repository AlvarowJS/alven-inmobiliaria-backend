<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Propiedad;
use Illuminate\Http\Request;

class PropiedadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datos = Propiedad::with('publicidad', 'caracteristica', 'general', 'direccion', 'cliente.asesor','foto','basico')->get();
        return response()->json($datos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $propiedad = new Propiedad;
        $propiedad->general_id = $request->general_id;
        $propiedad->direccion_id = $request->direccion_id;
        $propiedad->caracteristica_id = $request->caracteristica_id;
        $propiedad->publicidad_id = $request->publicidad_id;
        $propiedad->cliente_id = $request->cliente_id;
        $propiedad->save();
        return response()->json($propiedad);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $datos = Propiedad::with('publicidad', 'caracteristica', 'general', 'direccion', 'cliente', 'foto')->find($id);
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
        $propiedad = Propiedad::find($id);
        if (!$propiedad) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }
        $propiedad->general_id = $request->general_id;
        $propiedad->direccion_id = $request->direccion_id;
        $propiedad->caracteristica_id = $request->caracteristica_id;
        $propiedad->publicidad_id = $request->publicidad_id;
        $propiedad->cliente_id = $request->cliente_id;
        $propiedad->save();
        return response()->json($propiedad);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $datos = Propiedad::find($id);
        if (!$datos) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }
        $datos->delete();
        return response()->json(['message' => 'Registro eliminado']);
    }
}
