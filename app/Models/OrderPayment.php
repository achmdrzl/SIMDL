<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderPayment extends Model
{
    use HasFactory;

    protected $primaryKey = 'payment_id';

    protected $fillable = [
        'order_id',
        'payment_keterangan',
        'payment_status',
        'payment_tanggal',
        'payment_method',
        'payment_bukti',
        'user_id',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function userAcc()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
