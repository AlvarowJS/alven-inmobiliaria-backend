<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Publicidad;
use App\Models\Propiedad;
use App\Models\PublicidadLiga;
use Illuminate\Http\Request;

class PublicidadController extends Controller
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
        $datos = Publicidad::all();
        return response()->json($datos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $carpeta = $request->id_propiedad;
        $ruta = public_path($carpeta . '/mapa');

        if (!\File::isDirectory($ruta)) {

            $publicPath = 'storage/' . $ruta;
            \File::makeDirectory($publicPath, 0777, true, true);
        }
        $files = $request->file('mapa');

        $publicidad = new Publicidad;

        if ($request->hasFile('mapa')) {

            $nombre = uniqid() . '.' . $files->getClientOriginalName();
            $path = $carpeta . '/mapa/' . $nombre;
            \Storage::disk('public')->put($path, \File::get($files));
            $publicidad->mapa = $nombre;
        }

        $publicidad->precio_venta = $request->precio_venta;
        $publicidad->encabezado = $request->encabezado;
        $publicidad->descripcion = $request->descripcion;
        $publicidad->video_url = $request->video_url;
        $publicidad->estado = $request->estado;
        $publicidad->fecha_cierre = $request->fecha_cierre ?? null;
        $publicidad->precio_cierre = $request->precio_cierre ?? null;
        $publicidad->asesor_cierre = $request->asesor_cierre ?? null;
        $publicidad->save();

        $id = $publicidad->id;
        $id_propiedad = $request->id_propiedad;

        // Creara ligas para la publicidad
        $enlacesJson = $request->input('enlaces');
        $enlacesArray = json_decode($enlacesJson, true);
        $nuevasLigas = [];
        if (!empty($enlacesArray)) {
            foreach ($enlacesArray as $enlace) {
                $redSocial = $enlace['red_social'];
                $enlaceUrl = $enlace['enlace'];

                $ligas = new PublicidadLiga();
                $ligas->publicidad_id = $id;
                $ligas->red_social = $redSocial;
                $ligas->enlace = $enlaceUrl;
                $ligas->save();

                $nuevasLigas[] = $ligas;
            }
        }
        // Fin de la creacion

        $propiedad = Propiedad::find($id_propiedad);
        $propiedad->publicidad_id = $id;
        $propiedad->save();

        return response()->json([
            'ligas' => $nuevasLigas,
            $propiedad
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $datos = Publicidad::find($id);
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
        $datos = Publicidad::find($id);
        if (!$datos) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }
        $datos->precio_venta = $request->precio_venta;
        $datos->encabezado = $request->encabezado;
        $datos->descripcion = $request->descripcion;
        $datos->video_url = $request->video_url;
        $datos->estado = $request->estado;
        $datos->fecha_cierre = $request->fecha_cierre;
        $datos->precio_cierre = $request->precio_cierre;
        $datos->asesor_cierre = $request->asesor_cierre;
        $datos->save();
        return response()->json($datos);
    }

    public function update_fotos(Request $request)
    {
        $id = $request->id;
        $enlacesJson = $request->input('enlaces');

        // Convierte la cadena JSON en un arreglo asociativo
        // $enlacesArray = json_decode($enlacesJson, true);
        $enlacesArray = $enlacesJson;
        $enlacesActuales = PublicidadLiga::where('publicidad_id', $id)->get();
        $nuevasLigas = [];

        if (!empty($enlacesArray)) {
            foreach ($enlacesArray as $enlace) {
                $idLiga = $enlace['id'] ?? null;

                $redSocial = $enlace['red_social'];
                $enlaceUrl = $enlace['enlace'];

                if ($idLiga == null) {
                    $ligas = new PublicidadLiga();
                    $ligas->publicidad_id = $id;
                    $ligas->red_social = $redSocial;
                    $ligas->enlace = $enlaceUrl;
                    $ligas->save();
                    $nuevasLigas[] = $ligas;

                } else {
                    foreach ($enlacesActuales as $enlaceActual) {
                        if ($enlaceActual->id == $idLiga) {
                            $ligas = PublicidadLiga::find($idLiga);
                            $ligas->publicidad_id = $id;
                            $ligas->red_social = $redSocial;
                            $ligas->enlace = $enlaceUrl;
                            $ligas->save();
                            $nuevasLigas[] = $ligas;
                        } else {
                            $ligas = PublicidadLiga::find($enlaceActual->id);
                            if ($ligas) {
                                $ligas->delete();
                            }
                        }
                    }
                }

            }
        }
        $carpeta = $request->id_propiedad . '/mapa';

        $publicidad = Publicidad::find($id);

        if ($request->hasFile('mapa')) {
            $nombreArchivo = $publicidad->mapa;
            $files = $request->file('mapa');

            \Storage::disk('public')->delete($carpeta . '/' . $nombreArchivo);
            $nombreNuevo = uniqid() . '.' . $files->getClientOriginalName();
            $pathNuevo = $carpeta . '/' . $nombreNuevo;
            \Storage::disk('public')->put($pathNuevo, \File::get($files));
            $publicidad->mapa = $nombreNuevo;
        }
        $publicidad->precio_venta = $request->precio_venta;
        $publicidad->encabezado = $request->encabezado;
        $publicidad->descripcion = $request->descripcion;
        $publicidad->video_url = $request->video_url;
        $publicidad->estado = $request->estado;
        $publicidad->fecha_cierre = $request->fecha_cierre ?? null;
        $publicidad->precio_cierre = $request->precio_cierre ?? null;
        $publicidad->asesor_cierre = $request->asesor_cierre ?? null;
        $publicidad->save();
        return response()->json([
            'ligas' => $nuevasLigas,
            $publicidad
        ]);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $datos = Publicidad::find($id);
        if (!$datos) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }
        $datos->delete();
        return response()->json(['message' => 'Registro eliminado']);
    }
}
