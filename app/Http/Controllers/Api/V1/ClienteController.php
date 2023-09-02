<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\Propiedad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\DB;

class ClienteController extends Controller
{
    public function registarIdCliente(Request $request, $id)
    {
        $propiedad = Propiedad::find($id);
        $propiedad->cliente_id = $id;
        if (!$propiedad) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }
        $propiedad->cliente_id = $request->cliente_id;
        $propiedad->save();
        return response()->json($propiedad);
        // $propiedad->save();
        // return response()->json($propiedad);
    }

    public function registarCliente(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'celular' => 'unique:clientes,celular',
        ]);

        if ($validator->fails()) {
            $clientesDuplicados = Cliente::with('asesor')->where('celular', $request->celular)->first();
            $asesorName = $clientesDuplicados->asesor->nombre .' '.$clientesDuplicados->asesor->apellidos;
            return response()->json([
                'error' => 'celular repetido',
                'asesor' => $asesorName
            ], 409);
        }
        $cliente = new Cliente;
        $cliente->asesor_id = $request->asesor_id;
        $cliente->nombre = $request->nombre;
        $cliente->apellido_materno = $request->apellido_materno;
        $cliente->apellido_paterno = $request->apellido_paterno;
        $cliente->cedula = $request->cedula;
        $cliente->email = $request->email;
        $cliente->celular = $request->celular;
        $cliente->medio_contacto = $request->medio_contacto;
        $cliente->save();
        return response()->json($cliente);
        // return response()->json($cliente);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $datos = Cliente::all();
        $datos = Cliente::with('asesor')->get();
        return response()->json($datos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'celular' => 'unique:clientes,celular',
        ]);

        if ($validator->fails()) {
            $clientesDuplicados = Cliente::with('asesor')->where('celular', $request->celular)->first();
            $asesorName = $clientesDuplicados->asesor->nombre .' '.$clientesDuplicados->asesor->apellidos;
            return response()->json([
                'error' => 'celular repetido',
                'asesor' => $asesorName
            ], 409);
        }
        $cliente = new Cliente;
        $cliente->asesor_id = $request->asesor_id;
        $cliente->nombre = $request->nombre;
        $cliente->apellido_materno = $request->apellido_materno;
        $cliente->apellido_paterno = $request->apellido_paterno;
        $cliente->cedula = $request->cedula;
        $cliente->email = $request->email;
        $cliente->celular = $request->celular;
        $cliente->medio_contacto = $request->medio_contacto;
        $cliente->tipo_cliente = $request->tipo_cliente;
        $cliente->save();

        $id = $cliente->id;
        $id_propiedad = $request->id_propiedad;

        $propiedad = Propiedad::find($id_propiedad);
        $propiedad->cliente_id = $id;
        $propiedad->save();
        return response()->json($propiedad);
        // return response()->json($cliente);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        $datos = Cliente::with('asesor')->find($id);
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
        $validator = Validator::make($request->all(), [
            'celular' => 'unique:clientes,celular',
        ]);

        if($validator->fails()){

            $clientesDuplicados = Cliente::with('asesor')->where('celular', $request->celular)->first();
            $asesorName = $clientesDuplicados->asesor->nombre .' '.$clientesDuplicados->asesor->apellidos;
            return response()->json([
                'error' => 'celular repetido',
                'asesor' => $asesorName
            ], 409);
        }

        $cliente = Cliente::find($id);
        if (!$cliente) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }
        $cliente->asesor_id = $request->asesor_id;
        $cliente->nombre = $request->nombre;
        $cliente->apellido_materno = $request->apellido_materno;
        $cliente->apellido_paterno = $request->apellido_paterno;
        $cliente->cedula = $request->cedula;
        $cliente->email = $request->email;
        $cliente->celular = $request->celular;
        $cliente->medio_contacto = $request->medio_contacto;
        $cliente->tipo_cliente = $request->tipo_cliente;
        $cliente->save();
        return response()->json($cliente);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // $datos = Cliente::find($id);
        // if (!$datos) {
        //     return response()->json(['message' => 'Registro no encontrado'], 404);
        // }
        // $datos->delete();
        // return response()->json(['message' => 'Registro eliminado']);
        $cliente = Cliente::findOrFail($id);

        // Iniciar una transacción de la base de datos
        DB::beginTransaction();

        try {
            // Actualizar el ID del cliente a null en los clientes relacionados
            Propiedad::where('cliente_id', $id)->update(['cliente_id' => null]);

            // Eliminar el cliente
            $cliente->delete();

            // Confirmar la transacción
            DB::commit();

            // Retornar una respuesta exitosa
            return response()->json(['message' => 'Cliente eliminado exitosamente']);
        } catch (\Exception $e) {
            // Revertir la transacción en caso de error
            DB::rollback();

            // Retornar una respuesta de error
            return response()->json(['message' => 'Error al eliminar el cliente'], 500);
        }
    }
}
