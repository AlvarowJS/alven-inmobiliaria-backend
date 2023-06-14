<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Basico;
use App\Models\Propiedad;
use Illuminate\Http\Request;

class BasicoController extends Controller
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
        $datos = Basico::all();
        return response()->json($datos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $basico = new Basico;
        $basico->superficie_terreno = $request->superficie_terreno;
        $basico->superficie_construccion = $request->superficie_construccion;
        $basico->banios = $request->banios;
        $basico->medios_banios = $request->medios_banios;
        $basico->recamaras = $request->recamaras;
        $basico->cocina = $request->cocina;
        $basico->estacionamiento = $request->estacionamiento;
        $basico->niveles_construidos = $request->niveles_construidos;
        $basico->cuota_mantenimiento = $request->cuota_mantenimiento;
        $basico->numero_casas = $request->numero_casas;
        $basico->numero_elevadores = $request->numero_elevadores;
        $basico->piso_ubicado = $request->piso_ubicado;
        $basico->save();

        $id = $basico->id;
        $id_propiedad = $request->id_propiedad;

        $propiedad = Propiedad::find($id_propiedad);
        $propiedad->basico_id = $id;
        $propiedad->save();
        return response()->json($propiedad);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $datos = Basico::find($id);
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
        $datos = Basico::find($id);
        if (!$datos) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }
        $datos->superficie_terreno = $request->superficie_terreno;
        $datos->superficie_construccion = $request->superficie_construccion;
        $datos->banios = $request->banios;
        $datos->medios_banios = $request->medios_banios;
        $datos->recamaras = $request->recamaras;
        $datos->cocina = $request->cocina;
        $datos->estacionamiento = $request->estacionamiento;
        $datos->niveles_construidos = $request->niveles_construidos;
        $datos->cuota_mantenimiento = $request->cuota_mantenimiento;
        $datos->numero_casas = $request->numero_casas;
        $datos->numero_elevadores = $request->numero_elevadores;
        $datos->piso_ubicado = $request->piso_ubicado;
        $datos->save();
        return response()->json($datos);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $datos = Basico::find($id);
        if (!$datos) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }
        $datos->delete();
        return response()->json(['message' => 'Registro eliminado']);
    }
}
