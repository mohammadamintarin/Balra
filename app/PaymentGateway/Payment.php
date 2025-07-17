<?php

namespace App\PaymentGateway;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;
use App\Models\ProductVariation;
use App\Models\User;
use App\Notifications\PaymentReceipt;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use App\Notifications\Telegram;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

class Payment
{
    use Notifiable;

    public function createOrder($addressId, $amounts, $token, $gateway_name, $note, $date)
    {

        $cashbackAmount = auth()->user()->cashback;
        try {
            DB::beginTransaction();
            $gateway = $gateway_name == 'zarinpal' ? 'online' : 'snapppay';
            $order = Order::create([
                'user_id' => auth()->id(),
                'address_id' => $addressId,
                'coupon_id' => session()->has('coupon') ? session()->get('coupon.id') : null,
                'total_amount' => $amounts['total_amount'],
                'delivery_amount' => $amounts['delivery_amount'],
                'coupon_amount' => $amounts['coupon_amount'],
                'paying_amount' => $amounts['paying_amount'],
                'note' => $note,
                'token' => $token,
                'payment' => $gateway,
                'date' => $date
            ]);


            foreach (\Cart::getContent() as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->associatedModel->id,
                    'product_variation_id' => $item->attributes->id,
                    'price' => $item->price,
                    'quantity' => $item->quantity,
                    'subtotal' => ($item->quantity * $item->price),
                ]);
            }

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            return ['error' => $ex->getMessage()];
        }

        return ['success' => 'success!'];
    }

    public function updateOrder($token, $refId)
    {

        try {
            DB::beginTransaction();

            $order = Order::where('token', $token)->firstOrFail();
            $order->update([
                'payment_status' => 1,
                'status' => 'registered',
                'ref_id' => $refId,
                'cashback' => true
            ]);



            foreach (\Cart::getContent() as $item) {
                $variation = ProductVariation::find($item->attributes->id);
                $variation->update([
                    'quantity' => $variation->quantity - $item->quantity
                ]);
            }
            $order = Order::where('token', $token)->get();

            $cashback = (int)round(substr($order[0]->paying_amount, 0, -1) * 5 / 100);
            $user = User::find($order[0]->user_id);
            $user->update([
                'cashback' => $cashback
            ]);


            foreach ($order[0]->orderItems as $item) {
                $botToken = '6501058184:AAHvm7VMsM3w4oCZQBLIaxRxxgnczami5m4';
                $id = $order[0]->id;
                $address = $order[0]->address->province->name . " " . $order[0]->address->city->name . " " . $order[0]->address->address;
                $mobile = $order[0]->user->mobile;
                $fullName = $order[0]->user->name . " " . $order[0]->user->family;
                $variation = \App\Models\ProductVariation::find($item->product_variation_id)->value;
                $time = verta($order[0]->created_at)->format('Y.m.d');
                $image = url("/images/product") . '/' . $item->product->image;
                $quantity = $item->quantity;
                $note = $order[0]->note;
                $caption = "#️⃣" . "سفارش:" . "$id" . " " . "\n" .
                    "🕰" . "زمان:" . " " . "$time" . "\n" .
                    "⚖️" . " " . "مقدار:" . " " . "$variation" . "\n" .
                    "🥡" . " " . "تعداد:" . " " . "$quantity" . "\n" .
                    "🗿" . " " . "نام و نام خانوادگی:" . " " . "$fullName" . " " . "" . "\n" .
                    "☎️" . " " . "تلفن همراه:" . " " . "$mobile" . "\n" .
                    "🏠" . " " . "آدرس:" . "  " . "$address" . "\n" .
                    "📝" . " " . "یادداشت:" . " " . "";
                $response = Http::attach('photo', $image)->post('https://api.telegram.org/bot' . $botToken . '/' . 'sendPhoto',
                    [
                        'chat_id' => '-1001591483339',
                        'text' => "famessage",
                        'parse_mode' => 'HTML',
                        'caption' => $caption
                    ]);
            }
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            dd($ex);
            return ['error' => $ex->getMessage()];
        }
        auth()->user()->notify(new PaymentReceipt($order[0]->user->name, $order[0]->id));
        return ['success' => 'success!'];
    }
}
