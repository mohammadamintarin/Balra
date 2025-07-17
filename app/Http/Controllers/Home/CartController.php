<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\Province;
use App\Models\UserAddress;
use Cart;
use Illuminate\Http\Request;
use function Laravel\Prompts\alert;

class CartController extends Controller
{
    public function index()
    {
        $title = 'سبد خرید';
        $description = ' ';
        $addresses = UserAddress::where('user_id', auth()->id())->get();
        $provinces = Province::all();
        $amount = cartTotalAmount();
        $eligible = $this->eligiblePayment($amount*10);
        return view('home.cart.index' , compact('title' , 'description' , 'addresses' , 'provinces' , 'eligible'));
    }
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'quantity' => 'required',
            'variation' => 'required'
        ]);
        $product = Product::findOrFail($request->product_id);
        $variation = ProductVariation::findOrFail(json_decode($request->variation)->id);
        if($request->quntity > $variation->quantity)
        {
            return redirect()->back()->with('error', 'تعداد وارد شده از محصول صحیح نمی‌باشد!');
        }
        $id = $product->id . '-'  . $variation->id;

        if(Cart::get($id) == null)
        {
            Cart::add(array(
                'id' => $id,
                'name' => $product->name,
                'price' => $variation->is_sale ? $variation->sale_price : $variation->price,
                'quantity' => $request->quantity,
                'attributes' => $variation->toArray(),
                'associatedModel' => $product
            ));
        }else{
            return redirect()->back()->with('error', 'محصول قبلا به سبد خرید اضافه شده است!');
        }
        return redirect()->back()->with('message', 'محصول به سبد خرید اضافه شد!');
    }
    public function update(Request $request)
    {
        $request->validate([
            'quantity' => 'required'
        ]);
        foreach ($request->quantity as $id => $quantity) {

            $item = Cart::get($id);

            if ($quantity > $item->attributes->quantity) {
                return redirect()->back()->with('error', 'تعداد وارد شده از محصول صحیح نمی‌باشد!');
            }
            Cart::update($id, array(
                'quantity' => array(
                'relative' => false,
                'value' => $quantity
                ),
            ));
        }
        return redirect()->back()->with('info', 'سبد خرید ویرایش شد!');
    }

    public function remove($userID ,$rowId)
    {
//        dd($userID , $rowId);
//        Cart::session($userID)->remove($rowId);
        Cart::remove($rowId);

        return redirect()->back()->with('error', 'محصول مورد نظر از سبد خرید شما حذف شد!');
    }

    public function clear()
    {
        Cart::clear();
        return redirect()->back()->with('error', 'سبد خرید شما خالی می‌باشد!');
    }
    public function checkCoupon(Request $request)
    {
        $request->validate([
            'code' => 'required'
        ]);
        if (!auth()->check()) {
            return redirect()->back()->with('error', 'برای استفاده از کد تخفیف نیاز هست ابتدا وارد وب سایت شوید!');
        }
        $result = checkCoupon($request->code);
        if (array_key_exists('error', $result)) {
            return redirect()->back()->with('error', $result['error']);
        }
        return redirect()->back()->with('message', 'کد تخفیف اعمال شد!');
    }
    private function eligiblePayment($amount)
    {

        $token = self::getSnapToken();
        if (is_null($token)){
            return false;
        }
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.snapppay.ir/api/online/offer/v1/eligible?amount='.$amount,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$token['access_token'],
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response,true);

    }
}
