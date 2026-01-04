<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['order_id', 'user_id', 'cafe_id', 'total_amount', 'delivery_method', 'payment_method'];

    public function cafe() {
        return $this->belongsTo(Cafe::class);
    }
}
