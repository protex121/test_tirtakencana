<?php

namespace App\Imports;

use App\Models\ModelTableB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class TransactionImport implements ToModel, WithStartRow
{
    public function startRow(): int
    {
        return 2;
    }

    public function model(array $row)
    {
        return new ModelTableB([
            'kode_toko' => $row[0],
            'nominal_transaksi' => $row[1]
        ]);
    }
}
