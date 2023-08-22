<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutGaji extends Model
{
    use HasFactory;

    protected $primaryKey = 'gaji_id';
    
    protected $fillable = [
        'laporan_id',
        'pengeluaran_id',
        'gaji_keterangan',
        'gaji_total',
        'gaji_bukti',
        'status'
    ];

    public function laporan()
    {
        return $this->belongsTo(Laporan::class, 'laporan_id');
    }

    public function pengeluaran()
    {
        return $this->belongsTo(Pengeluaran::class, 'pengeluaran_id');
    }

}
