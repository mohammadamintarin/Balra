<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ProductImageController extends Controller
{
    public function edit(Product $product)
    {
        $title = "ویرایش تصاویر" . " " . $product->name;
        $images = $product->images;
        return view('master.product.image' , compact('product' , 'images' , 'title'));
    }

    public function destroy(Request $request ,Product $product)
    {
        ProductImage::destroy($request->image_id);
        return back();
    }
    public function primary(Request $request, Product $product)
    {
        $productImage =  ProductImage::findOrFail($request->image_id);
        $product->update([
            'image' => $productImage->image
        ]);
        return back();
    }

    public function add(Request $request, Product $product)
    {
        if($request->image == null && $request->images == null)
        {
            return redirect()->route('master.product.index')->with('info', 'تصویر جدیدی در آلبوم تصاویر اضافه نشد!');
        }
        if($request->has('image')){
            $image = generateFileName($request->image->getClientOriginalName());
            $request->image->move(public_path('/images/product/'), $image);
            $product->update([
                'image' => $image
            ]);
        }
        if($request->has('images')){
            foreach ($request->images as $image){
                $fileNameImage = generateFileName($image->getClientOriginalName());
                $image->move(public_path('/images/product/gallery') , $fileNameImage);
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $fileNameImage
                ]);
            }


        }
        return redirect()->route('master.product.index')->with('message', 'تصویر یا تصاویر جدید به محصول اضافه شد!');
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
}
