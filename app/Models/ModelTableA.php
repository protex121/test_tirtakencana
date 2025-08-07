<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelTableA extends Model
{
    protected $table = 'table_a';
    public $timestamps = false;

    protected $primaryKey = 'kode_toko_baru';
    public $incrementing = false;
    protected $keyType = 'int';

    protected $fillable = [
        'kode_toko_baru',
        'kode_toko_lama',
        'nama_toko'
    ];
}
