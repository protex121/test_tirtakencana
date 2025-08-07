<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelTableC extends Model
{
    protected $table = 'table_c';
    public $timestamps = false;

    protected $primaryKey = 'kode_toko';
    public $incrementing = false;
    protected $keyType = 'int';

    protected $fillable = [
        'kode_toko',
        'area_sales'
    ];

    public function table_a(){
        return $this->belongsTo(ModelTableA::class, 'kode_toko', 'kode_toko_baru');
    }
}
