<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Propiedad;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Cliente;
use App\Models\Asesor;
use App\Models\User;

class PropiedadController extends Controller
{
    public function filtrarStatus(Request $request)
    {
        $estadoActual = $request->estado;
        $datos = Propiedad::with('publicidad', 'caracteristica', 'general', 'direccion', 'cliente.asesor', 'foto', 'basico')
            ->whereHas('publicidad', function ($query) use ($estadoActual) {
                $query->where('estado', $estadoActual);
            })
            ->orderBy('updated_at', 'desc')
            ->get();
        return response()->json($datos);
    }
    public function indexTrue()
    {
        $datos = Propiedad::with('publicidad', 'caracteristica', 'general', 'direccion', 'cliente.asesor', 'foto', 'basico')
            ->whereHas('publicidad', function ($query) {
                $query->where('estado', 'En Promocion');
            })
            ->orderBy('updated_at', 'desc')
            ->get();
        return response()->json($datos);

    }
    public function exportarPdf($id, $id_user)
    {
        $verificarRol = User::find($id_user);
        $rol = $verificarRol->role_id;

        $propiedades = Propiedad::with('publicidad', 'caracteristica', 'general', 'direccion', 'cliente', 'foto', 'basico')->find($id);
        $asesorActual = Asesor::where('user_id', $id_user)->first();
        $propiedades->asesor = $asesorActual;

        $pdf = Pdf::loadView('pdf.template', compact('propiedades'))
            ->setPaper('a4', 'portrait');


        return $pdf->download('documento.pdf');
        // if($rol == 2){
        //     $propiedades = Propiedad::with('publicidad', 'caracteristica', 'general', 'direccion', 'cliente', 'foto', 'basico')->find($id);
        //     $asesorActual = Asesor::where('user_id',$id_user)->first();
        //     $propiedades->asesor = $asesorActual;

        //     $pdf = Pdf::loadView('pdf.template', compact('propiedades'))
        //         ->setPaper('a4', 'portrait');


        //     return $pdf->download('documento.pdf');
        // }else{
        //     $propiedades = Propiedad::with('publicidad', 'caracteristica', 'general', 'direccion', 'cliente', 'foto', 'basico')->find($id);
        //     $idAsesor = $propiedades->cliente->asesor_id;
        //     $asesorActual = Asesor::find($idAsesor);
        //     $propiedades->asesor = $asesorActual;

        //     $pdf = Pdf::loadView('pdf.template', compact('propiedades'))
        //         ->setPaper('a4', 'portrait');


        //     return $pdf->download('documento.pdf');
        // }

    }
    public function cambiarEstado(Request $request, $id)
    {
        $propiedad = Propiedad::find($id);
        if (!$propiedad) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }
        $propiedad->estado = $request->estado;
        $propiedad->save();
        return response()->json($propiedad);
    }
    public function actualizarEstado($id)
    {
        $propiedad = Propiedad::find($id);
        if (!$propiedad) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }
        $propiedad->estado = true;
        $propiedad->save();
        return response()->json($propiedad);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datos = Propiedad::with('publicidad', 'caracteristica', 'general', 'direccion', 'cliente.asesor', 'foto', 'basico')
            ->orderBy('updated_at', 'desc')
            ->get();


        return response()->json($datos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $propiedad = new Propiedad;
        $propiedad->general_id = $request->general_id;
        $propiedad->direccion_id = $request->direccion_id;
        $propiedad->caracteristica_id = $request->caracteristica_id;
        $propiedad->publicidad_id = $request->publicidad_id;
        $propiedad->cliente_id = $request->cliente_id;
        $propiedad->save();
        return response()->json($propiedad);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $datos = Propiedad::with('publicidad', 'caracteristica', 'general', 'direccion', 'cliente.asesor', 'foto', 'basico')->find($id);
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
        $propiedad = Propiedad::find($id);
        if (!$propiedad) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }
        $propiedad->general_id = $request->general_id;
        $propiedad->direccion_id = $request->direccion_id;
        $propiedad->caracteristica_id = $request->caracteristica_id;
        $propiedad->publicidad_id = $request->publicidad_id;
        $propiedad->cliente_id = $request->cliente_id;
        $propiedad->estado = $request->estado;
        $propiedad->save();
        return response()->json($propiedad);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $datos = Propiedad::find($id);
        if (!$datos) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }
        $datos->delete();
        return response()->json(['message' => 'Registro eliminado']);
    }
}
