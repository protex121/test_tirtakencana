<?php

namespace App\Imports;

use App\Models\ModelTableA;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class TokoImport implements ToModel, WithStartRow
{
    public function startRow(): int
    {
        return 2;
    }
    /**
     *
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new ModelTableA([
            'kode_toko_baru' => $row[0] ?? null,
            'kode_toko_lama' => $row[1] ?? null,
            'nama_toko' => $row[2] ?? null
        ]);
    }
}
