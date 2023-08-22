<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;

    protected $primaryKey = 'laporan_id';

    protected $fillable = [
        'laporan_tanggal',
        'laporan_tanggal_awal',
        'laporan_tanggal_akhir',
        'laporan_total_omset',
        'laporan_total_handling',
        'laporan_total_operasional',
        'laporan_total_transportasi',
        'laporan_total_gaji',
        'laporan_total_pengeluaran_mks',
        'laporan_total',
        'laporan_edit_request',
        'user_id',
    ];

    public function handling()
    {
        return $this->hasMany(InHandling::class, 'laporan_id');
    }

    public function operasional()
    {
        return $this->hasMany(OutOperasional::class, 'laporan_id');
    }

    public function gaji()
    {
        return $this->hasMany(OutGaji::class, 'laporan_id');
    }

    public function transportasi()
    {
        return $this->hasMany(OutTransportasi::class, 'laporan_id');
    }
}
