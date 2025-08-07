<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelTableD extends Model
{
    protected $table = 'table_d';
    public $timestamps = false;
    protected $primaryKey = 'kode_sales';
    public $incrementing = false;
    protected $keyType = 'varchar';

    protected $fillable = [
        'kode_sales',
        'nama_sales'
    ];
}
