<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Order extends Model
{
    use HasFactory , Notifiable;

    protected $guarded = [];

    public function scopeGetData($query, $month, $status)
    {
        $v = verta()->startMonth()->subMonth($month - 1);
        $date = verta()->formatGregorian($v->year, $v->month, $v->day);
        return $query->where('created_at', '>', Carbon::create($date[0], $date[1], $date[2], 0, 0, 0))
            ->where('payment_status', $status)
            ->get();
    }

    public function scopeGetGatewayData($query, $month , $status , $gateway)
    {
        $v = verta()->startMonth()->subMonth($month - 1);
        $date = verta()->formatGregorian($v->year, $v->month, $v->day);
        return $query->where('created_at', '>', Carbon::create($date[0], $date[1], $date[2], 0, 0, 0))
            ->where('payment_status', $status)
            ->where('payment' , $gateway)
            ->get();
    }
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function address()
    {
        return $this->belongsTo(UserAddress::class);
    }
    public function province()
    {
        return $this->belongsTo(Province::class);
    }
    public function city()
    {
        return $this->belongsTo(City::class);
    }
    public function transaction()
    {
        return $this->hasOne(Transaction::class,'order_id');
    }




}
