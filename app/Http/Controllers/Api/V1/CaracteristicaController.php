<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Caracteristica;
use App\Models\Propiedad;
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
        // $caracteristica = new Caracteristica;
        // $caracteristica->mascotas = $request->mascotas;
        // $caracteristica->espacios = $request->espacios;
        // $caracteristica->instalaciones = $request->instalaciones;
        // $caracteristica->restricciones = $request->restricciones;
        // $caracteristica->extras = $request->extras;
        // $caracteristica->youtube = $request->youtube;
        // $caracteristica->save();

        // $id = $caracteristica->id;
        // $id_propiedad = $request->id_propiedad;

        // $propiedad = Propiedad::find($id_propiedad);
        // $propiedad->caracteristica_id = $id;
        // $propiedad->save();
        $data = $request->all();

        $mascotas = $data['mascotas'];
        $espacios = json_encode($data['espacios']);
        $instalaciones = json_encode($data['instalaciones']);
        $restricciones = json_encode($data['restricciones']);
        $extras = json_encode($data['extras']);

        $youtube = $data['youtube'];

        // Guardar los datos en la base de datos
        $caracteristica = Caracteristica::create([
            'mascotas' => $mascotas,
            'espacios' => $espacios,
            'instalaciones' => $instalaciones,
            'restricciones' => $restricciones,
            'extras' => $extras,
            'youtube' => $youtube,
        ]);

        $id = $caracteristica->id;
        $id_propiedad = $request->id_propiedad;

        $propiedad = Propiedad::find($id_propiedad);
        $propiedad->caracteristica_id = $id;
        $propiedad->save();
        // return response()->json($caracteristica);
        return response()->json($propiedad);
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
        $data = $request->all();

        $caracteristica = Caracteristica::find($id);
        if (!$caracteristica) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }

        // $caracteristica->mascotas = $request->mascotas;
        // $caracteristica->espacios = $request->espacios;
        // $caracteristica->instalaciones = $request->instalaciones;
        // $caracteristica->resctricciones = $request->resctricciones;
        // $caracteristica->extras = $request->extras;
        // $caracteristica->youtube = $request->youtube;

        $caracteristica->mascotas = $data['mascotas'];
        $caracteristica->espacios = json_encode($data['espacios']);
        $caracteristica->instalaciones = json_encode($data['instalaciones']);
        $caracteristica->restricciones = json_encode($data['restricciones']);
        $caracteristica->extras = json_encode($data['extras']);
        $caracteristica->youtube = $data['youtube'];

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
