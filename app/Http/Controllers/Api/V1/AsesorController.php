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

        $carpeta = "asesor";
        $ruta = public_path($carpeta);
        if (!\File::isDirectory($ruta)) {
            // $publicPath = 'storage/' . $carpeta;
            $publicPath = 'storage/' . $carpeta;
            \File::makeDirectory($publicPath, 0777, true, true);
        }
        $files = $request->file('foto');

        if ($request->hasFile('foto')) {

            $nombre = uniqid() . '.' . $files->getClientOriginalName();
            $path = $carpeta . '/' . $nombre;
            \Storage::disk('public')->put($path, \File::get($files));

            $asesor = new Asesor;
            $asesor->nombre = $request->nombre;
            $asesor->apellidos = $request->apellidos;
            $asesor->rfc = $request->rfc;
            $asesor->direccion = $request->direccion;
            $asesor->email = $request->email;
            $asesor->celular = $request->celular;
            $asesor->foto = $nombre;
            $asesor->contacto_emergencia = $request->contacto_emergencia;
            $asesor->save();

            return response()->json($asesor);

        } else {
            return "error";
        }


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
        $asesor->rfc = $request->rfc;
        $asesor->direccion = $request->direccion;
        $asesor->email = $request->email;
        $asesor->celular = $request->celular;
        $asesor->contacto_emergencia = $request->contacto_emergencia;
        $asesor->save();
        return response()->json($asesor);
    }

    public function update_fotos(Request $request)
    {
        $carpeta = "asesor";
        $id = $request->id;
        $asesor = Asesor::find($id);
        if (!$asesor) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }

        $nombreArchivo = $asesor->foto;
        $files = $request->file('foto');

        \Storage::disk('public')->delete($carpeta . '/' . $nombreArchivo);
        $nombreNuevo = uniqid() . '.' . $files->getClientOriginalName();
        $pathNuevo = $carpeta . '/' . $nombreNuevo;
        \Storage::disk('public')->put($pathNuevo, \File::get($files));

        $asesor->nombre = $request->nombre;
        $asesor->apellidos = $request->apellidos;
        $asesor->rfc = $request->rfc;
        $asesor->direccion = $request->direccion;
        $asesor->email = $request->email;
        $asesor->celular = $request->celular;
        $asesor->foto = $nombreNuevo;
        $asesor->contacto_emergencia = $request->contacto_emergencia;
        $asesor->save();
        return response()->json($asesor);
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy($id)
    {

        $asesor = Asesor::findOrFail($id);

        if (!$asesor) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }

        $fotoBorrar = $asesor->foto;
        $carpeta = 'asesor';
        $pathBorrar = $carpeta . '/' . $fotoBorrar;
        \Storage::disk('public')->delete($pathBorrar);

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
