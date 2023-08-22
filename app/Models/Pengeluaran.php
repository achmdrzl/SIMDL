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
        'pengeluaran_total_modal',
        'pengeluaran_total_operasional',
        'pengeluaran_total_transportasi',
        'pengeluaran_total_gaji',
        'pengeluaran_total',
        'pengeluaran_edit_request',
        'pengeluaran_sisa_saldo',
        'user_id',
    ];

    public function modal()
    {
        return $this->hasMany(OutModal::class, 'pengeluaran_id');
    }

    public function operasional()
    {
        return $this->hasMany(OutOperasional::class, 'pengeluaran_id');
    }

    public function gaji()
    {
        return $this->hasMany(OutGaji::class, 'pengeluaran_id');
    }

    public function transportasi()
    {
        return $this->hasMany(OutTransportasi::class, 'pengeluaran_id');
    }
}
