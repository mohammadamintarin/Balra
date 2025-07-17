<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductImage;
use App\Models\ProductTag;
use App\Models\ProductVariation;
use App\Models\Tag;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "محصولات";
        $products  = Product::latest()->get();
        $count = count($products);
        return view('master.product.index' , compact(['title' , 'products' , 'count']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "افزودن محصول";
        $categories=  Category::where('parent_id' , '!=', 0)->get();
        $brands = Brand::all();
        $tags = Tag::all();
        $types = Type::all();
        return view('master.product.create' , compact(['title' , 'categories' , 'brands' , 'tags' , 'types']));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:products,name',
            'en' => 'required|unique:products,en',
            'sku' => 'required|unique:products,sku',
            'title' => 'required',
            'description' => 'required',
            'brand_id' => 'required',
            'category_id' => 'required',
            'file' => 'required|mimes:jpg,jpeg,png,svg,webp',
            'images.*' => 'required|mimes:jpg,jpeg,png,svg,webp',
        ]);
        $image = " ";
        $video = " ";
        $cover = " ";
        try {
            DB::beginTransaction();
            if($request->file){
                $image = generateFileName($request->file->getClientOriginalName());
                $request->file->move(public_path('/images/product/'), $image);
            }
            if($request->cover){
                $cover = generateFileName($request->cover->getClientOriginalName());
                $request->cover->move(public_path('/images/cover/'), $cover);
            }
            $product = Product::create([
                'name' => $request->name,
                'en' => $request->en,
                'slug' =>str()->slug($request->en),
                'title' =>$request->title,
                'description' =>$request->description,
                'canonical' =>$request->canonical,
                'brand_id' =>$request->brand_id,
                'type_id' =>$request->type_id,
                'category_id' =>$request->category_id,
                'image' =>$image,
                'content' => $request->contents,
                'sku' => $request->sku,
                'offer' => $request->offer,
                'best' => $request->best,
                'delivery' => $request->delivery,
                'delivery_per_product' => $request->delivery_per_product,
                'status' => 1,
                'user_id' => 1,
                'video' => $request->video,
                'cover' => $cover
            ]);
            $images = $this->galleryImage($request->images);
            foreach ($images as $image)
            {
                ProductImage::create([
                    'product_id' =>  $product->id,
                    'image' => $image
                ]);
            }
            foreach ($request->attribute_ids as $key => $attribute)
            {
                ProductAttribute::create([
                    'attribute_id' => $key,
                    'product_id' => $product->id,
                    'value' => $attribute
                ]);
            }

            $counter = count($request->variation_values['value']);
            $category = Category::find($request->category_id);
            $brand = Brand::find($request->brand_id);
            for ($i=0; $i<$counter; $i++)
            {
                ProductVariation::create([
                    'attribute_id' => $category->attributes()->wherePivot('variation' , 1)->first()->id,
                    'product_id' => $product->id,
                    'value' => $request->variation_values['value'][$i],
                    'price' =>$request->variation_values['price'][$i] ,
                    'quantity' =>$request->variation_values['quantity'][$i]
                ]);
            }
            $product->tags()->attach($request->tag_ids);
            $category->increment('count');
            $brand->increment('count');
            if ($request->tag_ids  != null)
            {
                foreach ($request->tag_ids as $tag_id)
                {
                    $tag = Tag::find($tag_id);
                    $tag->increment('count');
                }
            }
            DB::commit();
        }catch(\Exception $ex){
            DB::rollBack();
            dd($ex);
            return back()->with('error', 'محصول' . ' ' . $request->name . ' ' . 'ایجاد نشد!');
        }
        return redirect()->route('master.product.index')->with('message', 'محصول' . ' ' . $request->name . ' ' . 'ایجاد شد!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $attributes = $product->attributes()->with('attribute' )->get();
        $variations = $product->variations;
        $images = $product->images;
        $tags = Tag::all();
        return view('master.product.view' , compact('product' , 'attributes' , 'variations' , 'images' , 'tags'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $title = "ویرایش" ." ". $product->name;
        $brands = Brand::all();
        $tags = Tag::all();
        $types = Type::all();
        $attributes = $product->attributes()->with('attribute' )->get();
        $variations = $product->variations;
        return view('master.product.edit' , compact(['title' , 'brands' , 'tags' , 'types' , 'product' , 'attributes' , 'variations']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|unique:products,name,'.$product->id,
            'en' => 'required|unique:products,en,'.$product->id,
        ]);
        $cover = " ";
        try {
            if($request->cover){
                $cover = generateFileName($request->cover->getClientOriginalName());
                $request->cover->move(public_path('/images/cover/'), $cover);
            }
            DB::beginTransaction();
            $product->update([
                'name' => $request->name,
                'en' => $request->en,
                'slug' =>str()->slug($request->en),
                'title' =>$request->title,
                'description' =>$request->description,
                'canonical' =>$request->canonical,
                'brand_id' =>$request->brand_id,
                'type_id' =>$request->type_id,
                'content' => $request->contents,
                'sku' => $request->sku,
                'offer' => $request->offer,
                'best' => $request->best,
                'delivery' => $request->delivery,
                'delivery_per_product' => $request->delivery_per_product,
                'status' => 1,
                'user_id' => 1,
                'video' => $request->video,
                'cover' => $cover

            ]);
            foreach ($request->attribute_values as $key => $attribute)
            {
                $productAttribute = ProductAttribute::findOrFail($key);
                $productAttribute->update([
                    'value' => $attribute
                ]);
            }
            foreach ($request->variation_values as $key => $variation)
            {
                $productVariation = ProductVariation::findOrFail($key);
                $productVariation->update([
                    'value' => $variation['value'],
                    'price' =>$variation['price'] ,
                    'quantity' =>$variation['quantity'],
                    'sale_price' =>$variation['sale_price'],
                    'date_on_sale_from' =>convertShamsiToGregorianDate($variation['date_on_sale_from']),
                    'date_on_sale_to' =>convertShamsiToGregorianDate($variation['date_on_sale_to'])
                ]);
            }




            $product->tags()->sync($request->tag_ids);

            DB::commit();
        }catch(\Exception $ex){
            DB::rollBack();
            dd($ex);
            return back()->with('error', 'محصول' . ' ' . $request->name . ' ' . 'ایجاد نشد!');
        }
        return redirect()->route('master.product.index')->with('info', 'محصول' . ' ' . $request->name . ' ' . 'ویرایش شد!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        try {
            DB::beginTransaction();
            $product->delete();
            $category = Category::find($product->category_id);
            $brand = Brand::find($product->brand_id);
            $category->decrement('count');
            $brand->decrement('count');
            DB::commit();
        }catch(\Exception $ex){
            dd($ex);
            DB::rollBack();
            return back()->with('error', 'حذف محصول' . ' ' . $product->name . ' ' . 'انجام نشد!');
        }
        return back()->with('error', 'محصول' . ' ' . $product->name . ' ' . 'حذف شد!');
    }
    public function galleryImage($images)
    {
        $galleryImages =  [];
        foreach($images as $image)
        {
            $prefixImageName = Carbon::now()->year . "_" . Carbon::now()->month . "_" . Carbon::now()->microsecond . "_" . rand(1,9999);
            $imageName = $prefixImageName . $image->getClientOriginalName();
            $image->move(public_path('images/product/gallery') , $imageName);
            array_push($galleryImages , $imageName);
        }
        return $galleryImages;
    }
    public function editCategory (Request $request,Product $product)
    {
        $title  = "ویرایش دسته‌بندی";
        $categories = Category::where('parent_id' , '!=' , 0)->get();
        return view('master.product.category' , compact('product' , 'categories' , 'title'));
    }

    public function updateCategory(Product $product , Request $request)
    {

        try {
            DB::beginTransaction();
            $product->update([
                'category_id' => $request->category_id,
            ]);
            $productAttributeController = new ProductAttributeController();
            $productAttributeController->change($request->attribute_ids , $product);
            $category = Category::find($request->category_id);
            $productVariationController = new ProductVariationController();
            $productVariationController->change($request->variation_values , $category->attributes()->wherePivot('variation' , 1)->first()->id , $product);
            DB::commit();
        }catch(\Exception $ex){
            dd($ex);
            DB::rollBack();
            return back()->with('error', 'ویرایش محصول' . ' ' . $request->name . ' ' . 'انجام نشد!');
        }
        return redirect()->route('master.product.index')->with('message', 'دسته بندی محصول' . ' ' . $request->name . ' ' . 'ویرایش شد!');
    }
}
