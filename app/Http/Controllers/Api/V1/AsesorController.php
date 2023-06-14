<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Asesor;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class AsesorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datos = Asesor::all();
        return response()->json($datos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $asesor = new Asesor;
        $asesor->nombre = $request->nombre;
        $asesor->apellidos = $request->apellidos;
        $asesor->cedula = $request->cedula;
        $asesor->email = $request->email;
        $asesor->celular = $request->celular;
        $asesor->save();
        return response()->json($asesor);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $datos = Asesor::find($id);
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
        $asesor = Asesor::find($id);
        if (!$asesor) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }
        $asesor->nombre = $request->nombre;
        $asesor->apellidos = $request->apellidos;
        $asesor->cedula = $request->cedula;
        $asesor->email = $request->email;
        $asesor->celular = $request->celular;
        $asesor->save();
        return response()->json($asesor);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // $datos = Asesor::find($id);
        // if (!$datos) {
        //     return response()->json(['message' => 'Registro no encontrado'], 404);
        // }
        // $datos->delete();
        // return response()->json(['message' => 'Registro eliminado']);
// Buscar el asesor por su ID
        $asesor = Asesor::findOrFail($id);

        // Iniciar una transacción de la base de datos
        DB::beginTransaction();

        try {
            // Actualizar el ID del asesor a null en los clientes relacionados
            Cliente::where('asesor_id', $id)->update(['asesor_id' => null]);

            // Eliminar el asesor
            $asesor->delete();

            // Confirmar la transacción
            DB::commit();

            // Retornar una respuesta exitosa
            return response()->json(['message' => 'Asesor eliminado exitosamente']);
        } catch (\Exception $e) {
            // Revertir la transacción en caso de error
            DB::rollback();

            // Retornar una respuesta de error
            return response()->json(['message' => 'Error al eliminar el asesor'], 500);
        }

    }
}
