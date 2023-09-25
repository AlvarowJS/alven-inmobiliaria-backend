<?php

namespace App\Exports;

use App\Models\Propiedad;
use App\Models\Publicidad;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Facades\DB;

class PropiedadesMovExport implements FromCollection, WithHeadings
{
    use Exportable;

    // private $ids;
    private $status;
    private $asesorEx;
    private $fechaAlta;

    public function __construct($status, $asesorEx)
    {
        $this->status = $status;
        $this->asesorEx = urldecode($asesorEx);
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $data = Propiedad::select(
            'generals.numero_ofna',
            DB::raw("CONCAT( COALESCE(direccions.calle, ''), ', ', COALESCE(direccions.numero, ''), ', ', COALESCE(direccions.colonia, ''), ', ', COALESCE(direccions.municipio, ''), ', ', COALESCE(direccions.estado, ''), ', ', COALESCE(direccions.pais, '')) AS direccion_completa"),
            'generals.tipo_operacion',
            'generals.asesor_exclusivo',
            'publicidads.asesor_cierre',
            'publicidads.precio_venta',
            'publicidads.precio_cierre',
            'generals.fecha_alta',
        )
            // ->whereIn('publicidads.estado', [$this->status])
            ->when($this->status !== 'todos', function ($query) {
                return $query->whereIn('publicidads.estado', [$this->status]);
            })
            // ->where('generals.asesor_exclusivo', [$this->asesorEx])
            ->when($this->asesorEx !== 'todos', function ($query) {
                return $query->where('generals.asesor_exclusivo', $this->asesorEx);
            })
            ->join('publicidads', 'publicidads.id', '=', 'propiedads.publicidad_id')
            ->join('generals', 'generals.id', '=', 'propiedads.general_id')
            ->join('direccions', 'direccions.id', '=', 'propiedads.direccion_id')
            ->get();
        $collection = new Collection();

        $data->map(function ($item) use ($collection) {
            $collection->push([
                'numero_ofna' => $item->numero_ofna,
                'direccion_completa' => $item->direccion_completa,
                'tipo_operacion' => $item->tipo_operacion,
                'asesor_exclusivo' => $item->asesor_exclusivo,
                'asesor_cierre' => $item->asesor_cierre,
                'precio_venta' => $item->precio_venta,
                'precio_cierre' => $item->precio_cierre,
            ]);
        });
        return $collection;
    }
    public function startRow(): int
    {
        return 6;
    }

    public function headings(): array
    {

        $fechaAltaHead = Propiedad::select(
            'generals.fecha_alta',
        )
            ->when($this->status !== 'todos', function ($query) {
                return $query->whereIn('publicidads.estado', [$this->status]);
            })
            ->when($this->asesorEx !== 'todos', function ($query) {
                return $query->where('generals.asesor_exclusivo', $this->asesorEx);
            })
            ->join('publicidads', 'publicidads.id', '=', 'propiedads.publicidad_id')
            ->join('generals', 'generals.id', '=', 'propiedads.general_id')
            ->min('generals.fecha_alta');

        $fechaAltaHeadFin = Propiedad::select(
            'generals.fecha_alta',
        )
            ->when($this->status !== 'todos', function ($query) {
                return $query->whereIn('publicidads.estado', [$this->status]);
            })
            ->when($this->asesorEx !== 'todos', function ($query) {
                return $query->where('generals.asesor_exclusivo', $this->asesorEx);
            })
            ->join('publicidads', 'publicidads.id', '=', 'propiedads.publicidad_id')
            ->join('generals', 'generals.id', '=', 'propiedads.general_id')
            ->max('generals.fecha_alta');

        $header = [
            ["Reporte de Movimientos de Propiedades"],
            [""],
            ["Status", $this->status],
            ["", "Inicio", "Fin"],
            ["Periodo", $fechaAltaHead, $fechaAltaHeadFin],
            ["Asesor Exclusivo", $this->asesorEx],
            ["Asesor Cierre"],
            [""],
            [""],
            [""],
            [""],
            ["REPORTE DE MOVIMIENTOS DE PROPIEDADES A " . $this->status . ""],
            ["CORRESPONDIENTES AL PERIODO AL .$fechaAltaHead. AL. $fechaAltaHeadFin "],
            [
                "ID",
                "Dirección",
                "Tipo de Operación",
                "Asesor Exclusiva",
                "Asesor Cierre",
                "Precio Promoción",
                "Precio Cierre"
            ]
        ];


        return $header;
    }
}
