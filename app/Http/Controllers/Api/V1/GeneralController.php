<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\General;
use App\Models\Propiedad;
use Illuminate\Http\Request;

class GeneralController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datos = General::all();
        return response()->json($datos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $general = new General;
        $general->numero_ofna = $request->numero_ofna;
        $general->fecha_alta = $request->fecha_alta;
        $general->tipo_operacion = $request->tipo_operacion;
        $general->tipo_propiedad = $request->tipo_propiedad;
        $general->tipo_contrato = $request->tipo_contrato;
        $general->asesor_exclusivo = $request->asesor_exclusivo;
        $general->porcentaje = $request->porcentaje;
        $general->aceptar_creditos = $request->aceptar_creditos;
        $general->fecha_credito = $request->fecha_credito;
        $general->fecha_inicio = $request->fecha_inicio;
        $general->duracion_dias = $request->duracion_dias;
        $general->requisito_arrendamiento = $request->requisito_arrendamiento;
        $general->save();

        $id = $general->id;
        $id_propiedad = $request->id_propiedad;

        $propiedad = Propiedad::find($id_propiedad);
        $propiedad->general_id = $id;
        $propiedad->save();
        return response()->json($propiedad);
        // return response()->json($general);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $datos = General::find($id);
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
        $general = General::find($id);
        if (!$general) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }
        $general->numero_ofna = $request->numero_ofna;
        $general->fecha_alta = $request->fecha_alta;
        $general->tipo_operacion = $request->tipo_operacion;
        $general->tipo_propiedad = $request->tipo_propiedad;
        $general->tipo_contrato = $request->tipo_contrato;
        $general->asesor_exclusivo = $request->asesor_exclusivo;
        $general->porcentaje = $request->porcentaje;
        $general->aceptar_creditos = $request->aceptar_creditos;
        $general->fecha_credito = $request->fecha_credito;
        $general->fecha_inicio = $request->fecha_inicio;
        $general->duracion_dias = $request->duracion_dias;
        $general->requisito_arrendamiento = $request->requisito_arrendamiento;
        $general->save();
        return response()->json($general);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $datos = General::find($id);
        if (!$datos) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }
        $datos->delete();
        return response()->json(['message' => 'Registro eliminado']);
    }
}
