<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InHandling extends Model
{
    use HasFactory;

    protected $primaryKey = 'handling_id';

    protected $fillable = [
        'laporan_id',
        'handling_kota',
        'handling_tarif',
        'handling_berat',
        'handling_total',
    ];

    public function laporan()
    {
        return $this->belongsTo(Laporan::class, 'laporan_id');
    }
}
