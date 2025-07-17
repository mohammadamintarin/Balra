<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IncreaseController extends Controller
{
    public function index()
    {
        return redirect()->route('master.increase.create');
    }
    public function create()
    {
        $categories = Category::where('id' , '!=' , 1)->get();
        $brands = Brand::all();
        $models = Type::all();
        $title = " افزایش قیمت ";
        return view('master.increase.create' , compact('categories' , 'brands' , 'models' , 'title'));
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
            $status = $request->status;

            if($status == 'increase')
            {
                if ($percent != null)
                {
                    $result  = DB::select('
                UPDATE product_variations INNER JOIN products ON product_variations.product_id= products.id
                SET product_variations.price = price *' . $percent + 100 .'/100 WHERE products.'. $type .' =' . $id

                    );
                }
                if ($value != null)
                {
                    $result  = DB::select('
                    UPDATE product_variations INNER JOIN products ON product_variations.product_id= products.id
                    SET product_variations.price = price + '. $value . ' WHERE products.'. $type .' =' . $id
                    );
                }
            }elseif($status == 'decrease')
            {
                if ($percent != null)
                {
                    $result  = DB::select('
                UPDATE product_variations INNER JOIN products ON product_variations.product_id= products.id
                SET product_variations.price = price *' . $percent - 100 .'/100 WHERE products.'. $type .' =' . $id

                    );
                }
                if ($value != null)
                {
                    $result  = DB::select('
                    UPDATE product_variations INNER JOIN products ON product_variations.product_id= products.id
                    SET product_variations.price = price - '. $value . ' WHERE products.'. $type .' =' . $id
                    );
                }
            }

            DB::commit();
        }catch(\Exception $ex){
            DB::rollBack();
            dd($ex);
            return back()->with('error', 'تغییر قیمت انجام نشد!');
        }
        return redirect()->route('master.increase.create')->with('message', 'تغییر قیمت انجام شد!');
    }
}
