<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutModal extends Model
{
    use HasFactory;

    protected $primaryKey = 'modal_id';

    protected $fillable = [
        'pengeluaran_id',
        'modal_keterangan',
        'modal_total'
    ];

    public function pengeluarna()
    {
        return $this->belongsTo(Pengeluaran::class, 'pengeluaran_id');
    }
}
