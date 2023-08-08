<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $primaryKey = 'order_id';

    protected $fillable   = [
        'order_noresi',
        'order_tanggal',
        'order_pengirim',
        'order_penerima',
        'order_alamat_penerima',
        'order_nohp_penerima',
        'order_koli',
        'order_kemasan',
        'order_rincian',
        'order_berat',
        'order_volume',
        'order_isi',
        'order_tarif',
        'order_total',
        'order_lampiran',
        'order_keterangan',
        'order_status',
        'order_created',
        'order_received_validation',
        'order_received',
        'order_edit_request',
    ];

    public function payment()
    {
        return $this->hasOne(OrderPayment::class, 'order_id');
    }

    public function userCreate()
    {
        return $this->belongsTo(User::class, 'order_created');
    }

    public function userReceive()
    {
        return $this->belongsTo(User::class, 'order_received_validation');
    }

    public function manifestdetail()
    {
        return $this->hasOne(ManifestDetail::class, 'order_id');
    }
}
