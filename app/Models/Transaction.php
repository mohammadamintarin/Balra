<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Transaction extends Model
{
    use HasFactory , Notifiable;
    protected $table = "transactions";
    protected $guarded = [];


    public function scopeGetData($query, $month, $status)
    {
        $v = verta()->startMonth()->subMonth($month - 1);
        $date = verta()->formatGregorian($v->year, $v->month, $v->day);
        return $query->where('created_at', '>', Carbon::create($date[0], $date[1], $date[2], 0, 0, 0))
            ->where('status', $status)
            ->get();
    }

    public function scopeGetGatewayData($query, $month , $status , $gateway)
    {
        $v = verta()->startMonth()->subMonth($month - 1);
        $date = verta()->formatGregorian($v->year, $v->month, $v->day);
        return $query->where('created_at', '>', Carbon::create($date[0], $date[1], $date[2], 0, 0, 0))
            ->where('status', $status)
            ->where('gateway' , $gateway)
            ->get();
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
