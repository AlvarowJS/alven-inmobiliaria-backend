<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Asesor;
use App\Models\Cliente;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AsesorController extends Controller
{
    public function indexPublic()
    {
        $datos = Asesor::where('publico', true)->get();
        return response()->json($datos);
    }
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

        // Registrar en usuarios
        $user = User::create([
            'name' => $request->nombre . " " . $request->apellidos,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id
        ]);

        $idUser = $user->id;

        //Registrar asesor
        $carpeta = "asesor";
        $ruta = public_path($carpeta);
        if (!\File::isDirectory($ruta)) {
            // $publicPath = 'storage/' . $carpeta;
            $publicPath = 'storage/' . $carpeta;
            \File::makeDirectory($publicPath, 0777, true, true);
        }
        $files = $request->file('foto');

        $asesor = new Asesor;

        if ($request->hasFile('foto')) {

            $nombre = uniqid() . '.' . $files->getClientOriginalName();
            $path = $carpeta . '/' . $nombre;
            \Storage::disk('public')->put($path, \File::get($files));
            $asesor->foto = $nombre;
        }

        $asesor->nombre = $request->nombre;
        $asesor->apellidos = $request->apellidos;
        $asesor->rfc = $request->rfc;
        $asesor->direccion = $request->direccion;
        $asesor->email = $request->email;
        $asesor->celular = $request->celular;
        $asesor->contacto_emergencia = $request->contacto_emergencia;
        $asesor->status = $request->status;
        $asesor->publico = $request->publico;
        $asesor->user_id = $idUser;
        $asesor->save();




        return response()->json([
            'message' => 'Usuario creado exitosamente.',
            'asesor' => $asesor,
            'usuario' => $user
        ], 201);



    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $datos = Asesor::with('user')->find($id);
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
        $asesor->status = $request->status;
        $asesor->publico = $request->publico;
        $asesor->save();
        return response()->json($asesor);
    }

    public function update_fotos(Request $request)
    {


        $carpeta = "asesor";
        $id = $request->id;
        $asesor = Asesor::find($id);
        $asesorUser = User::where('id', $asesor->user_id)->first();

        // actualizar usuario
        if (!$asesorUser) {
            return response()->json([
                'message' => 'Usuario no encontrado.',
            ], 404);
        }
        if ($request->has('password') && !empty($request->password)) {
            $asesorUser->password = Hash::make($request->password);
        }

        if ($request->has('email')) {
            $asesorUser->email = $request->email;
        }
        if ($request->has('role_id')) {
            $asesorUser->role_id = $request->role_id;
        }
        $asesorUser->save();

        // Actualizar asesor
        if (!$asesor) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }

        if ($request->hasFile('foto')) {
            $nombreArchivo = $asesor->foto;
            $files = $request->file('foto');

            \Storage::disk('public')->delete($carpeta . '/' . $nombreArchivo);
            $nombreNuevo = uniqid() . '.' . $files->getClientOriginalName();
            $pathNuevo = $carpeta . '/' . $nombreNuevo;
            \Storage::disk('public')->put($pathNuevo, \File::get($files));
            $asesor->foto = $nombreNuevo;

        }

        $asesor->nombre = $request->nombre;
        $asesor->apellidos = $request->apellidos;
        $asesor->rfc = $request->rfc;
        $asesor->direccion = $request->direccion;
        $asesor->email = $request->email;
        $asesor->celular = $request->celular;
        $asesor->contacto_emergencia = $request->contacto_emergencia;
        $asesor->status = $request->status;
        $asesor->publico = $request->publico;
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
