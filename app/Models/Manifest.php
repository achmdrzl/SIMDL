<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manifest extends Model
{
    use HasFactory;

    protected $primaryKey = 'manifest_id';
    
    protected $fillable   = [
        'manifest_no',
        'manifest_tanggal',
        'manifest_tanggal_awal',
        'manifest_tanggal_akhir',
        'manifest_plat_mobil',
        'manifest_total_koli',
        'manifest_total_berat',
        'manifest_total_harga',
        'manifest_status',
    ];

    public function detailmanifest()
    {
        return $this->hasMany(ManifestDetail::class, 'manifest_id');
    }
}
