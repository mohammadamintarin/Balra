<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Discount;
use App\Models\ProductVariation;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DiscountController extends Controller
{
    public function index()
    {
        $discounts = Discount::latest()->get();
        $count = count($discounts);
        $title = "تخفیف های فروشگاه";
        return view('master.discount.index' , compact('discounts' , 'count' , 'title'));
    }

    public function create()
    {
        $categories = Category::where('id' , '!=' , 1)->get();
        $brands = Brand::all();
        $models = Type::all();
        $title = "تخفیف های فروشگاه";
        return view('master.discount.create' , compact('categories' , 'brands' , 'models' , 'title'));
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $type = "";
            $id = "";
            if ($request->category_id != null)
            {
                $type = "category_id";
                $id = $request->category_id;
            }elseif($request->brand_id != null)
            {
                $type = "brand_id";
                $id = $request->brand_id;
            }elseif ($request->type_id != null)
            {
                $type = "type_id";
                $id = $request->type_id;
            }

            $percent = $request->percent;
            $value = $request->value;
            $start = convertShamsiToGregorianDate($request->started_at);
            $expire = convertShamsiToGregorianDate($request->expired_at);

            Discount::create([
                'title' =>$request->title,
                'type' => $type,
                'query_id' => $id,
                'percent' => $percent,
                'value' => $value,
                'started_at' => $start,
                'expired_at' => $expire,
                'category_id' => $request->category_id,
                'brand_id' => $request->brand_id,
                'type_id' => $request->type_id,
            ]);

            if ($percent != null)
            {
                $result  = DB::select('
                UPDATE product_variations INNER JOIN products ON product_variations.product_id= products.id
                SET product_variations.sale_price = price - price *' . $percent .'/100,
                product_variations.date_on_sale_from = "' . $start . '"'.
                    ',product_variations.date_on_sale_to ="' . $expire . '"'.
                    'WHERE products.'. $type .' =' . $id
                );
            }
            if ($value != null)
            {

                $result  = DB::select('
                UPDATE product_variations INNER JOIN products ON product_variations.product_id = products.id
                SET product_variations.sale_price = price - '. $value . ',
                product_variations.date_on_sale_from = "' . $start . '"'.
                    ',product_variations.date_on_sale_to ="' . $expire . '"'.
                    'WHERE products.'. $type .' =' . $id
                );

            }
            DB::commit();
            }catch(\Exception $ex){
                DB::rollBack();
                dd($ex);
                return back()->with('error', 'تخفیف ایجاد نشد!');
            }
        return redirect()->route('master.discount.index')->with('message', 'تخفیف ایجاد شد!');
    }

    public function setDiscount ($type)
    {

    }

    public function changeToDefualt(Request $request , Discount $discount)
    {
        try {
        DB::beginTransaction();
        $type = "";
        $id = "";
        if ($discount->category_id != null)
        {
            $type = "category_id";
            $id = $discount->category_id;
        }elseif($discount->brand_id != null)
        {
            $type = "brand_id";
            $id = $discount->brand_id;
        }elseif ($discount->type_id != null)
        {
            $type = "type_id";
            $id = $discount->type_id;
        }
        $percent = $discount->percent;
        $value = $discount->value;
        $start = $discount->started_at;
        $expire = '2020-02-17 12:46:19';
        if ($percent != null)
        {
            $result  = DB::select('
                UPDATE product_variations INNER JOIN products ON product_variations.product_id= products.id
                SET product_variations.sale_price = price - price *' . $percent .'/100,
                product_variations.date_on_sale_from = "' . $start . '"'.
                ',product_variations.date_on_sale_to ="' . $expire . '"'.
                ' WHERE products.'. $type .' =' . $id
            );
        }
            if ($value != null)
            {
                $result  = DB::select('
                UPDATE product_variations INNER JOIN products ON product_variations.product_id= products.id
                SET product_variations.sale_price ='.$value.',
                product_variations.date_on_sale_from = "' . $start . '"'.
                    ',product_variations.date_on_sale_to ="' . $expire . '"'.
                    ' WHERE products.'. $type .' =' . $id
                );
            }

        $this->destroy($discount);

        DB::commit();
        }catch(\Exception $ex){
            DB::rollBack();
            dd($ex);
            return back()->with('error', 'حذف انجام نشد!');
        }
        return redirect()->route('master.discount.index')->with('error', 'حذف انجام نشد!');
    }


    public function destroy(Discount $discount)
    {
        $discount->delete();
    }
}
