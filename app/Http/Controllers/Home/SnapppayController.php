<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductVariation;
use App\Models\Transaction;
use App\Notifications\PaymentReceipt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class SnapppayController extends Controller
{
    public $accessToken;
    public $paymentToken;
    public $transactionId;

    public function Payment()
    {
        $addressId = session('addressId');
        $amounts = session('amounts');
        $date = session('date');
        $jwtToken = self::getSnapToken();
        if (isset($jwtToken['access_token'])) {
            DB::beginTransaction();
            try {

                $this->accessToken = $jwtToken['access_token'];
                //session()->put('access_token',$jwtToken['access_token']);
                // Cache::put('access_token',$jwtToken['access_token']);
                $cartList = [];
                $order = Order::create([
                    'user_id' => auth()->id(),
                    'address_id' => $addressId,
                    'coupon_id' => session()->has('coupon') ? session()->get('coupon.id') : null,
                    'total_amount' => $amounts['total_amount'],
                    'delivery_amount' => $amounts['delivery_amount'],
                    'coupon_amount' => $amounts['coupon_amount'],
                    'paying_amount' => $amounts['paying_amount'],
                    'payment' => 'snapppay',
                    'date' => $date
                ]);

                foreach (\Cart::getContent() as $item) {

                    $cartItem = [
                        'order_id' => $order->id,
                        'product_id' => $item->associatedModel->id,
                        'product_variation_id' => $item->attributes->id,
                        'price' => $item->price,
                        'quantity' => $item->quantity,
                        'subtotal' => ($item->quantity * $item->price),
                    ];
                    OrderItem::create($cartItem);

                    //Add To CartList For SnapPay
                    $cartList[] = [
                        'amount' => $item->price * 10,
                        'category' => $item->associatedModel->category->name,
                        'count' => $item->quantity,
                        'id' => $item->associatedModel->category->id,
                        'name' => $item->associatedModel->name,
                        'commissionType' => 100
                    ];
                }


                $paymentToken = $this->getPaymentToken($amounts['paying_amount'], $order, $cartList, auth()->user()->mobile);
                if ($paymentToken['successful']) {
                    $response = $paymentToken['response'];
                    $this->paymentToken = $response['paymentToken'];
                    //session()->put('paymentToken',$response['paymentToken']);
                    // Cache::put('paymentToken',$response['paymentToken']);

                    $eligible = $this->eligiblePayment($amounts['paying_amount'] * 10);
                    if ($eligible['successful']) {
                        $order->update([
                            'description' => $eligible['response']['title_message'] . '(' . $eligible['response']['description'] . ')',
                            'token' => $this->paymentToken,
                            'ref_id' => $this->transactionId,
                            'access_token' => $this->accessToken,
                        ]);
                        $payAddress = $response['paymentPageUrl'];
//                        Transaction::create([
//                            'user_id' => auth()->id(),
//                            'order_id' => $order->id,
//                            'amount' => $amounts['paying_amount'],
//                            'token' => $this->paymentToken,
//                            'ref_id' => $this->transactionId,
//                            'gateway_name' => 'pay',
//                            'access_token' => $this->accessToken
//                        ]);
                        \Cart::clear();
                        DB::commit();

                        return redirect()->to($payAddress);
                    } else {
                        DB::commit();
                        return redirect()->back()->with('error', 'امکان پرداخت اقساطی فعال نیست');
                        // return ['error' => 'امکان پرداخت اقساطی فعال نیست'];
                    }

                } else {
                    DB::commit();
                    return redirect()->back()->with('error', $paymentToken['errorData']['message']);
                    // return ['error' => 'خطا در اتصال به درگاه'];
                }
            } catch (\Exception $ex) {
                DB::rollBack();
                return redirect()->back()->with('error', 'internal error :' . $ex->getMessage());

            }

        } else {
            return redirect()->back();
        }
    }

    private function getPaymentToken($amount, $order, $cartList, $mobile)
    {
        $realAmount = $amount;
        if (session()->has('coupon')) {
            $realAmount += session()->get('coupon.amount');
        }

        $curl = curl_init();

        $payData = [
            'amount' => $amount * 10,
            'cartList' => [
                [
                    'cartId' => $order->id,
                    'cartItems' => $cartList,
                    'isShipmentIncluded' => true,
                    'isTaxIncluded' => true,
                    'shippingAmount' => $order->delivery_amount * 10,
                    'taxAmount' => 0,
                    'totalAmount' => $realAmount * 10
                ]
            ],

            'discountAmount' => $order->coupon_amount * 10,
            'externalSourceAmount' => 0,
            'mobile' => preg_replace('/^0?/', '+' . +98, $mobile),
            'paymentMethodTypeDto' => 'INSTALLMENT',
            'returnURL' => route('home.payment.snap-pay.callback'),
            'transactionId' => $this->createTransactionId()
        ];
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.snapppay.ir/api/online/payment/v1/token',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($payData),
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer " . $this->accessToken,
                'Content-Type: application/json',
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return json_decode($response, true);

    }

    public function callBackSnapPayment()
    {
        if (request('state') == 'OK') {
            $order = Order::where('ref_id', request('transactionId'))->first();
            $this->accessToken = $order->access_token;
            $this->paymentToken = $order->token;
            $this->transactionId = $order->ref_id;

            $verify = $this->verifyPayment();
            if ($verify['successful']) {
                $settle = $this->settlePayment();
                $this->updateOrder($settle['response']['transactionId']);
                return redirect()->route('profile.order');
            }
            return redirect()->route('profile.order')->with('error', $verify['errorData']['message']);
        } elseif (request('state') == 'FAILED') {
            $this->revertPayment();
            return redirect()->route('home.index');
        }

    }

    private function verifyPayment()
    {

        try {

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.snapppay.ir/api/online/payment/v1/verify',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode(['paymentToken' => $this->paymentToken]),
                CURLOPT_HTTPHEADER => array(
                    "Authorization: Bearer " . $this->accessToken,
                    "Content-Type: application/json"
                ),
            ));


            $response = curl_exec($curl);
            curl_close($curl);

            return json_decode($response, true);
        } catch (Exception $e) {
            dd('ex : ' . $e->getMessage());
            sleep(30);
            $paymentStatus = $this->getPaymentStatus();
            if ($paymentStatus['successful']) {
                if ($paymentStatus['response']['status'] == 'OK') {
                    $settle = $this->settlePayment();
                    $this->updateOrder($settle['response']['transactionId']);

                    return redirect()->route('profile.order');
                } elseif ($paymentStatus['response']['status'] == 'FAILED') {
                    return ['error' => 'error in second verify :' . $e->getMessage()];
                }
            } else {
                return ['error' => 'error in verify :' . $e->getMessage()];
            }
        }
    }

    private function revertPayment()
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.snapppay.ir/api/online/payment/v1/revert',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode(['paymentToken' => $this->paymentToken]),
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer " . $this->accessToken,
                "Content-Type: application/x-www-form-urlencoded"
            ),
        ));


        $response = curl_exec($curl);
        curl_close($curl);

        return json_decode($response, true);

    }

    private function settlePayment()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.snapppay.ir/api/online/payment/v1/settle',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode(['paymentToken' => $this->paymentToken]),
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer " . $this->accessToken,
                "Content-Type: application/json"
            ),
        ));


        $response = curl_exec($curl);
        curl_close($curl);

        return json_decode($response, true);
    }

    public function eligiblePayment($amount)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.snapppay.ir/api/online/offer/v1/eligible?amount=' . $amount,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $this->accessToken,
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        return json_decode($response, true);

    }

    private function updateOrder($transactionId)
    {
        DB::beginTransaction();
        try {

            $order = Order::where('ref_id', $this->transactionId)->first();
            $order->update([
                'payment_status' => 1,
                'ref_id' => $transactionId,
                'status' => 'registered',

            ]);
//            $order = Order::find($transaction->order_id);
//            $order->update([
//                'payment_status' => 1,
//            ]);
            foreach ($order->orderItems as $item) {
                $variation = ProductVariation::find($item->product_variation_id);
                $quantity = ($variation->quantity - $item->quantity) >= 0 ? $variation->quantity - $item->quantity : 0;
                $variation->update([
                    'quantity' => $quantity
                ]);
            }
            foreach ($order->orderItems as $item) {
                $botToken = '6501058184:AAHvm7VMsM3w4oCZQBLIaxRxxgnczami5m4';
                $id = $order->id;
                $address = $order->address->province->name . " " . $order->address->city->name . " " . $order->address->address;
                $mobile = $order->user->mobile;
                $fullName = $order->user->name . " " . $order->user->family;
                $variation = \App\Models\ProductVariation::find($item->product_variation_id)->value;
                $time = verta($order->created_at)->format('Y.m.d');
                $image = url("/images/product") . '/' . $item->product->image;
                $quantity = $item->quantity;
                $note = $order->note;
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
            \Cart::clear();
            DB::commit();
            $order->user->notify(new PaymentReceipt($order->user->name, $order->id));
            return redirect()->route('profile.order');
        } catch (\Exception $ex) {
            DB::rollBack();
            dd('error in update : ' . $ex->getMessage());
            return redirect()->back()->with('error', 'error in update : ' . $ex->getMessage());
            // return ['error' => 'error in update : '.$ex->getMessage()];
        }
    }

    private function createTransactionId()
    {
        $token = rand(10000, 99999);
        $order = Order::where('ref_id', $token)->first();
        if (!is_null($order)) {
            $this->createTransactionId();
        }
        // Cache::put('refId',$token);
        session()->put('refId', $token);
        $this->transactionId = $token;
        return $token;
    }

    public function getPaymentStatus()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.snapppay.ir/api/online/payment/v1/status?paymentToken=' . $this->paymentToken,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $this->accessToken,
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        return json_decode($response, true);
    }
}
