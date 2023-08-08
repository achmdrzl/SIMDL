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
        'gaji_keterangan',
        'gaji_total',
        'gaji_bukti',
    ];

    public function laporan()
    {
        return $this->belongsTo(Laporan::class, 'laporan_id');
    }

}
