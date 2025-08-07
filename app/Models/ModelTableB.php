<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelTableB extends Model
{
    protected $table = 'table_b';
    public $timestamps = false;
    protected $primaryKey = 'kode_toko';
    public $incrementing = false;
    protected $keyType = 'int';

    protected $fillable = [
        'kode_toko',
        'nominal_transaksi'
    ];

    public function table_a() {
        return $this->belongsTo(ModelTableA::class, 'kode_toko', 'kode_toko_baru');
    }
}
