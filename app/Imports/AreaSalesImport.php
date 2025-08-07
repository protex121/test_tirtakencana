<?php

namespace App\Imports;

use App\Models\ModelTableC;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;


class AreaSalesImport implements ToModel, WithStartRow
{
    public function startRow(): int
    {
        return 2;
    }

    public function model(array $row)
    {

        return new ModelTableC([
            'kode_toko' => $row[0] ?? '',
            'area_sales' => $row[1] ?? ''
        ]);
    }
}
