<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManifestDetail extends Model
{
    use HasFactory;

    protected $primaryKey = 'detail_manifest_id';

    protected $fillable   = [
        'manifest_id',
        'order_id'
    ];

    public function manifest()
    {
        return $this->hasOne(Manifest::class, 'manifest_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
