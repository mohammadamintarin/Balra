<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use App\Notifications\CallToBuy;
use App\Notifications\CallToSendComment;
use App\Notifications\DeliveryCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Kavenegar;
use Mockery\Exception;


class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::latest()->where('payment_status', 1)->get();
        $count = count($orders);
        $title = "سفارشات موفق";
        return view('master.order.index', compact(['count', 'orders', 'title']));
    }

    public function create()
    {
        $title = "افزودن سفارش";
        $products = Product::all();
        $users = User::all();
        return view('master.order.create', compact(['title', 'products', 'users']));
    }

    public function store(Request $request)
    {
        dd($request->all());
    }

    public function show(Order $order)
    {
        $title = $order->id;
        return view('master.order.detail', compact(['order', 'title']));
    }

    public function sendCode(Request $request, Order $order)
    {
        $mobile = $order->user->mobile;
        $code = $request->code;
        $name = $order->user->name;
        $order->update([
            'code' => $code,
            'status' => "delivered",
        ]);
        $order->user->notify(new DeliveryCode($code, $mobile, $name));
        return redirect()->back()->with('success', 'پیامک با موفقیت ارسال شد!');
    }

    public function changeToRegistered(Order $order)
    {
        try {
            DB::beginTransaction();
            if ($order->status == "failed") {
                $order->update([
                    'status' => "registered",
                    'payment_status' => 1
                ]);
                $transaction = Transaction::where('order_id', $order->id);
                $transaction->update([
                    'status' => 1
                ]);
            }
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            dd($ex);
            return back()->with('error', 'وضعیت سفارش ویرایش نشد!');
        }
        return redirect()->back()->with('message', 'وضعیت سفارش ویرایش شد!');
    }

    public function changeToFail(Order $order)
    {
        try {
            DB::beginTransaction();
            if ($order->payment_status == 1) {
                $order->update([
                    'status' => "failed",
                    'payment_status' => 0
                ]);
                $transaction = Transaction::where('order_id', $order->id);
                $transaction->update([
                    'status' => 0
                ]);
            }
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            dd($ex);
            return back()->with('error', 'وضعیت سفارش ویرایش نشد!');
        }
        return back()->with('message', 'وضعیت سفارش ویرایش شد!');
    }


    public function changeStatus(Order $order)
    {
        try {
            DB::beginTransaction();
            if ($order->status == "registered") {
                $order->update([
                    'status' => "sending",
                ]);
            } elseif ($order->status == "sending") {
                $order->update([
                    'status' => "delivered",
                ]);
            }
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            dd($ex);
            return back()->with('error', 'وضعیت سفارش ویرایش نشد!');
        }
        return redirect()->back()->with('message', 'وضعیت سفارش ویرایش شد!');
    }


    public function failed()
    {
        $orders = Order::latest()->where('payment_status', 0)->get();
        $count = count($orders);
        $title = "سفارشات ناموفق";
        return view('master.order.failed', compact(['count', 'orders', 'title']));
    }

    public function callToBuy(Request $request, Order $order)
    {
        $temp = $order->orderItems()->get();
        $mobile = $order->user->mobile;
        $product = "https://www.nivor.ir/" . $temp[0]->product->category->slug . '/' . $temp[0]->product->slug;
        $name = $order->user->name;
        $order->user->notify(new CallToBuy($product, $mobile, $name));
        $order->update([
            'calltobuy' => 1,
        ]);
        return redirect()->back()->with('success', 'پیامک با موفقیت ارسال شد!');
    }

    public function callToSendComment(Request $request, Order $order)
    {
        $temp = $order->orderItems()->get();
        $mobile = $order->user->mobile;
        $product = "https://www.nivor.ir/" . $temp[0]->product->category->slug . '/' . $temp[0]->product->slug . "#comments";
        $name = $order->user->name;
        try {
            $sender = "2000400060006";
            $message = $name . " " . "جان،" . PHP_EOL . "از لباسی که خریدی راضی هستی؟ 😍" . PHP_EOL . "برامون از لینک زیر کامنت بذار و نظرت رو برای بقیه بگو:" . PHP_EOL . $product . PHP_EOL . "همچنین با ثبت کامنت از طرف فروشگاه نیور کد تخفیف هدیه بگیر 🤩";
            $receptor = $mobile;
            $result = Kavenegar::Send($sender, $receptor, $message);
            if ($result) {
                $order->update([
                    'calltosendcomment' => true,
                ]);
            }
            return redirect()->back()->with('success', 'پیامک با موفقیت ارسال شد!');
        } catch (\Kavenegar\Exceptions\ApiException $e) {
            // در صورتی که خروجی وب سرویس 200 نباشد این خطا رخ می دهد
            echo $e->errorMessage();
        } catch (\Kavenegar\Exceptions\HttpException $e) {
            // در زمانی که مشکلی در برقرای ارتباط با وب سرویس وجود داشته باشد این خطا رخ می دهد
            echo $e->errorMessage();
        } catch (\Exceptions $ex) {
            // در صورت بروز خطایی دیگر
            echo $ex->getMessage();
        }
    }

    private function cancelOrder($paymentToken)
    {
        $token = self::getSnapToken();
        if (is_null($token)) {
            return false;
        }
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.snapppay.ir/api/online/payment/v1/cancel',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode(['paymentToken' => $paymentToken]),
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer " . $token['access_token'],
                "Content-Type: application/json"
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response, true);
    }

    public function changeStatusSnapp(Order $order)
    {
        $order->update([
            'status' => "failed",
        ]);
        $cancelOrder = $this->cancelOrder($order->token);
        if (!$cancelOrder) {
            return response()->json([
                'status' => false,
                'message' => 'خطا در اتصال به پنل اسنپ '
            ], 500);
            return back()->with('error', 'خطا در اتصال به پنل اسنپ');
        }
        if ($cancelOrder['successful']) {

            DB::beginTransaction();
            try {
                $order->update([
                    'ref_id' => $cancelOrder['response']['transactionId']
                ]);
                $order->update([
                    'status' => "failed",
                    'payment_status' => 0
                ]);
                foreach ($order->orderItems as $item) {
                    $item->update(['status' => 0]);
                }
                DB::commit();
            } catch (Exception $e) {
                DB::rollBack();
                return response()->json([
                    'status' => false,
                    'message' => $e->getMessage()
                ], 500);
                // return back()->with('error', $e->getMessage());
            }

        } else {
            return response()->json([
                'status' => false,
                'message' => $cancelOrder['errorData']['message']
            ], 500);
            // return back()->with('error', $cancelOrder['errorData']['message']);
        }
//        return response()->json([
//            'status' => true,
//        ], 200);
        return back()->with('success', 'وضعیت سفارش تغییر کرد.');
    }

    public function changeItemQuantity()
    {
        if (request('quantity') <= 0) {
            return back()->with('error', 'تعداد محصول نمیتواند کمتر از 1 باشد');
        }
        $item = OrderItem::findOrFail(request('item_id'));


        $cartList = [];
        $order = $item->order;
        $transaction = $order->transaction;
        $newAmount = $transaction->amount - $item->subtotal;
        $newAmount += $item->price * request('quantity');

        DB::beginTransaction();
        try {
            $item->update([
                'quantity' => request('quantity'),
                'subtotal' => $item->price * request('quantity')
            ]);

            $transaction->update(['amount' => $newAmount]);
            $order->update([
                'paying_amount' => $newAmount]);
            $OrderItems = $order->orderItems->where('status', 1);

            foreach ($OrderItems as $orderItem) {
                $product = $orderItem->product;
                $cartList[] = [
                    'amount' => $orderItem->price * 10,
                    'category' => $product->category->name,
                    'count' => $orderItem->quantity,
                    'id' => $product->id,
                    'name' => $product->name,
                    'commissionType' => 100

                ];
            }
            $updateOrder = $this->updateOrder($newAmount, $order, $cartList, $transaction->token);
            if (!$updateOrder || !$updateOrder['successful']) {
//                return response()->json([
//                    'status' => false,
//                ], 500);
                return back()->with('error', 'خطا در اتصال به پنل اسنپ');
            }

            DB::commit();
            return response()->json([
                'status' => true,
            ], 200);
//            return back()->with('success', 'وضعیت سفارش تغییر کرد.');
        } catch (\Exception $e) {
            DB::rollBack();
//            return response()->json([
//                'status' => false,
//            ], 500);
            return back()->with('error', $e->getMessage());
        }

    }
    public function changeItemStatus($id)
    {
        $item = OrderItem::where('id' , $id)->first();
        $cartList = [];
        $order = $item->order;
        $transaction = $order->token;
        $newAmount = $item->paying_amount - $item->subtotal;
        DB::beginTransaction();
        try {

            $item->status = 0;
            $item->save();

            $order->update(['paying_amount' => $newAmount]);
            $otherOrderItems = $order->orderItems->where('status',1);

            foreach ($otherOrderItems as $orderItem){
                $product = $orderItem->product;
                $cartList[]=[
                    'amount' => $orderItem->price * 10,
                    'category' =>  $product->category->name,
                    'count' => $orderItem->quantity,
                    'id' => $product->id,
                    'name' => $product->name,
                    'commissionType' => 100

                ];
            }
            $updateOrder = $this->updateOrder($newAmount,$order,$cartList,$transaction);
            if (!$updateOrder || !$updateOrder['successful']){
                return response()->json([
                    'status' => false,
                ], 500);
//                return back()->with('error', $updateOrder['errorData']['message']);
            }
            DB::commit();
            return response()->json([
                'status' => true,
            ], 200);
//            return back()->with('success', 'وضعیت سفارش تغییر کرد.');
        }catch (\Exception $e){
            DB::rollBack();
            return response()->json([
                'status' => false,
            ], 500);
//            return back()->with('error', $e->getMessage());
        }

    }
    private function updateOrder($amount,$order,$cartList,$paymentToken)
    {
        $token = self::getSnapToken();

        if (is_null($token)){
            return false;
        }
        $payData =[
            'amount' => $amount  * 10  ,
            'cartList' => [
                [
                    'cartId' => $order->id,
                    'cartItems' => $cartList,
                    'isShipmentIncluded' => true,
                    'isTaxIncluded' => true,
                    'shippingAmount' => $order->delivery_amount * 10,
                    'taxAmount' => 0,
                    'totalAmount' => ($amount + $order->coupon_amount) * 10
                ]
            ],
            'discountAmount' => $order->coupon_amount * 10,
            'externalSourceAmount' => 0,
            'paymentMethodTypeDto' => 'INSTALLMENT',
            'paymentToken' => $paymentToken,
        ];

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.snapppay.ir/api/online/payment/v1/update',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>json_encode($payData),
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer ".$token['access_token'],
                "Content-Type: application/json"
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        return json_decode($response,true);

    }
}
