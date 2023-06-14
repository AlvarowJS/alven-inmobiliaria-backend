<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Direccion;
use App\Models\Propiedad;
use Illuminate\Http\Request;

class DireccionController extends Controller
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
        $datos = Direccion::all();
        return response()->json($datos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $direccion = new Direccion;
        $direccion->pais = $request->pais;
        $direccion->codigo_postal = $request->codigo_postal;
        $direccion->estado = $request->estado;
        $direccion->municipio = $request->municipio;
        $direccion->colonia = $request->colonia;
        $direccion->colonia = $request->colonia;
        $direccion->calle = $request->calle;
        $direccion->numero = $request->numero;
        $direccion->LAT = $request->LAT;
        $direccion->LON = $request->LON;
        $direccion->ZOOM = $request->ZOOM;
        $direccion->save();

        $id = $direccion->id;
        $id_propiedad = $request->id_propiedad;

        $propiedad = Propiedad::find($id_propiedad);
        $propiedad->direccion_id = $id;
        $propiedad->save();
        return response()->json($propiedad);
        // return response()->json($direccion);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $datos = Direccion::find($id);
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
        $direccion = Direccion::find($id);
        if (!$direccion) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }
        $direccion->pais = $request->pais;
        $direccion->codigo_postal = $request->codigo_postal;
        $direccion->estado = $request->estado;
        $direccion->municipio = $request->municipio;
        $direccion->colonia = $request->colonia;
        $direccion->colonia = $request->colonia;
        $direccion->calle = $request->calle;
        $direccion->numero = $request->numero;
        $direccion->LAT = $request->LAT;
        $direccion->LON = $request->LON;
        $direccion->ZOOM = $request->ZOOM;
        $direccion->save();
        return response()->json($direccion);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $datos = Direccion::find($id);
        if (!$datos) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }
        $datos->delete();
        return response()->json(['message' => 'Registro eliminado']);
    }
}
