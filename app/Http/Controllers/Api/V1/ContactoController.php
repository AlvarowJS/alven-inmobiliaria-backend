<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Contacto;
use Illuminate\Http\Request;

class ContactoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datos = Contacto::all();
        return response()->json($datos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $contacto = new Contacto;
        $contacto->direccion_inmueble = $request->direccion_inmueble;
        $contacto->nombre = $request->nombre;
        $contacto->apellido = $request->apellido;
        $contacto->email = $request->email;
        $contacto->telefono = $request->telefono;
        $contacto->save();
        return response()->json($contacto);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $datos = Contacto::find($id);
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
        $contacto = Contacto::find($id);
        if (!$contacto) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }
        $contacto->direccion_inmueble = $request->direccion_inmueble;
        $contacto->nombre = $request->nombre;
        $contacto->apellido = $request->apellido;
        $contacto->email = $request->email;
        $contacto->telefono = $request->telefono;
        $contacto->save();
        return response()->json($contacto);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $datos = Contacto::find($id);
        if (!$datos) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }
        $datos->delete();
        return response()->json(['message' => 'Registro eliminado']);
    }
}
