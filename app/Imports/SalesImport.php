<?php

namespace App\Imports;

use App\Models\ModelTableD;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;


class SalesImport implements ToModel, WithStartRow
{
    public function startRow(): int
    {
        return 2;
    }

    public function model(array $row)
    {
        $kode_sales = $row[0];

        // Skip if kode_sales already exists
        if (ModelTableD::where('kode_sales', $kode_sales)->exists()) {
            return null;
        }

        return new ModelTableD([
            'kode_sales' => $row[0] ?? '',
            'nama_sales' => $row[1] ?? ''
        ]);
    }
}
