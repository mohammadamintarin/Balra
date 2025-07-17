<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class OrderItem extends Model
{
    use HasFactory, Notifiable;
    protected $table = "order_items";
    protected $guarded = [];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class,'order_id');
    }
}
