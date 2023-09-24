<?php

namespace App\Exports;

use App\Models\Propiedad;
use Maatwebsite\Excel\Concerns\FromCollection;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PropiedadesMovExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Propiedad::all();
    }
    public function headings(): array
    {
        return [
            "id",
            "tipo de operacion",
            "tipo legal",
            "tipo de cambio",
            "tipo de documento"       
        ];
    }
}
