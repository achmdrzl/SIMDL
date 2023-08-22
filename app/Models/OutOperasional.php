<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutOperasional extends Model
{
    use HasFactory;

    protected $primaryKey = 'operasional_id';

    protected $fillable = [
        'laporan_id',
        'pengeluaran_id',
        'operasional_keterangan',
        'operasional_total',
        'operasional_bukti',
        'status',
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
