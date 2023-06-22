<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Medio;
use Illuminate\Http\Request;

class MedioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datos = Medio::all();
        return response()->json($datos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $medio = new Medio;
        $medio->medio_contacto = $request->medio_contacto;
        $medio->save();
        return response()->json($medio);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $datos = Medio::find($id);
        if (!$datos) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }
        return response()->json($datos);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $medio = Medio::find($id);
        if (!$medio) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }
        $medio->medio_contacto= $request -> medio_contacto;
        $medio->save();
        return response()->json($medio);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $medio = Medio::find($id);
        if(!$medio){
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }
        $medio->delete();
        return response()->json(['message' => 'Registro eliminado']);
    }
}
