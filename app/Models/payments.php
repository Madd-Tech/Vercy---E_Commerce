<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class payments extends Model
{
    protected $fillable = [
        'order_id','method','amount','status'
    ];

    public function order()
    {
        return $this->belongsTo(order::class);
    }
}
