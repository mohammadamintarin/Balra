<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id' , auth()->user()->id)->where('payment_status' , 1)->latest()->get();
        $title = "سفارش‌های من";
        $description =  "لیست سفارش‌های من";
        return view('home.profile.order' , compact('orders' , 'title' , 'description'));
    }
}
