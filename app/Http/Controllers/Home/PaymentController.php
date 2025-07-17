<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\ProductVariation;
use App\PaymentGateway\Zarinpal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    public function payment(Request $request)
    {
        if (auth())
        {
            $validator = Validator::make($request->all(), [
                'address_id' => 'required',
                'payment_method' => 'required',
                'date' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with('error', 'انتخاب آدرس تحویل سفارش الزامی می باشد!');
            }

            $checkCart = $this->checkCart();
            if (array_key_exists('error', $checkCart)) {
                return redirect()->route('home.index')->with('error', 'سبد خرید خالی است!');
            }
            $addressId = $request->address_id;
            $date = $request->date;
            $amounts = $this->getAmounts();
            if (array_key_exists('error', $amounts)) {
                return redirect()->route('home.index')->with('error', 'قیمت تغییر کرده است!');
                return redirect()->route('home.index');
            }
            if ($request->payment_method == 'zarinpal') {
                $amounts['paying_amount'] = (substr($amounts['paying_amount'] - $amounts['paying_amount'] * 5 / 100,0, -1) - auth()->user()->cashback) ;
                $zarinpalGateway = new Zarinpal();
                $zarinpalGatewayResult = $zarinpalGateway->send($amounts, 'zarinpal', $request->address_id , $request->note , $request->user_id, $date);
                if (array_key_exists('error', $zarinpalGatewayResult)) {
                    dd($zarinpalGatewayResult);
                return redirect()->back()->with('error', 'فرآیند خرید با  مشکل روبرو شد، دوباره اقدام بفرمایید!');
                } else {
                    return redirect()->to($zarinpalGatewayResult['success']);
                }
            }elseif ($request->payment_method == 'snap_pay'){
                $amounts = $this->getAmountsForSnapp();
            

                return to_route('home.payment.snap-pay.payment')->with(['addressId'=>$addressId,'amounts'=>$amounts,'date' => $date]);

            }
            return redirect()->back()->with('error', 'در انتخاب درگاه پرداخت  دقت نمایید!');
        }
        return view('auth.login');
    }

    public function paymentVerify(Request $request, $gatewayName)
    {
        $authority = $request->Authority;
        $status = $request->Status;
        if ($gatewayName == 'zarinpal') {
            $amounts = $this->getAmounts();
            $paying_amount = (int)round(substr($amounts['paying_amount'] - $amounts['paying_amount'] * 5 / 100,0, -1) - auth()->user()->cashback ) . '0';
            if (array_key_exists('error', $amounts)) {
                return redirect()->route('home.index');
            }
            $zarinpalGateway = new Zarinpal();
            $zarinpalGatewayResult = $zarinpalGateway->verify($authority, $paying_amount);
            session()->forget('coupon');
            return redirect()->route('profile.order');
        }
        return redirect()->route('home.index');
    }

    public function checkCart()
    {
        if (\Cart::isEmpty()) {
            return ['error' => 'سبد خرید شما خالی می باشد'];
        }

        foreach (\Cart::getContent() as $item) {
            $variation = ProductVariation::find($item->attributes->id);

            $price = $variation->is_sale ? $variation->sale_price : $variation->price;

            if ($item->price != $price) {
                \Cart::clear();
                return ['error' => 'قیمت محصول تغییر پیدا کرد'];
            }

            if ($item->quantity > $variation->quantity) {
                \Cart::clear();
                return ['error' => 'تعداد محصول تغییر پیدا کرد'];
            }

            return ['success' => 'success!'];
        }
    }

    public function getAmounts()
    {
        if (session()->has('coupon')) {
            $checkCoupon = checkCoupon(session()->get('coupon.code'));
            if (array_key_exists('error', $checkCoupon)) {
                return $checkCoupon;
            }
        }

        return [
            'total_amount' => (\Cart::getTotal() + cartTotalSaleAmount()) . 0,
            'delivery_amount' => cartTotalDeliveryAmount(),
            'coupon_amount' => session()->has('coupon') ? session()->get('coupon.amount') . 0 : 0,
            'paying_amount' => cartTotalAmount(). 0
        ];
    }
    public function getAmountsForSnapp()
    {
        if (session()->has('coupon')) {
            $checkCoupon = checkCoupon(session()->get('coupon.code'));
            if (array_key_exists('error', $checkCoupon)) {
                return $checkCoupon;
            }
        }

        return [
            'total_amount' => (\Cart::getTotal() + cartTotalSaleAmount()),
            'delivery_amount' => cartTotalDeliveryAmount(),
            'coupon_amount' => session()->has('coupon') ? session()->get('coupon.amount')  : 0,
            'paying_amount' => cartTotalAmount()
        ];
    }
}
