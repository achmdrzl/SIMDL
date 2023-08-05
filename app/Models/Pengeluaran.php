<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    use HasFactory;

    protected $primaryKey = 'pengeluaran_id';
    
    protected $fillable = [
        'pengeluaran_tanggal',
        'pengeluaran_total',
        'pengeluaran_jenis',
        'pengeluaran_keterangan',
    ];
}
