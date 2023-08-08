<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutTransportasi extends Model
{
    use HasFactory;

    protected $primaryKey = 'transportasi_id';

    protected $fillable = [
        'laporan_id',
        'transportasi_keterangan',
        'transportasi_total',
        'transportasi_bukti',
    ];

    public function laporan()
    {
        return $this->belongsTo(Laporan::class, 'laporan_id');
    }
}
