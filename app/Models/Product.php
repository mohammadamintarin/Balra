<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded = [''];
    protected $appends = ['quantity_check' , 'sale_check' , 'price_check' , 'out_check'];


    public function tags()
    {
        return $this->belongsToMany(Tag::class , 'product_tag');
    }

    public function category()
    {
        return  $this->belongsTo(Category::class);
    }
    public function brand()
    {
        return  $this->belongsTo(Brand::class);
    }
    public function type()
    {
        return  $this->belongsTo(Type::class);
    }

    public function attributes()
    {
        return $this->hasMany(ProductAttribute::class );
    }
    public function variations()
    {
        return $this->hasMany(ProductVariation::class);
    }
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function rates()
    {
        return $this->hasMany(ProductRate::class);
    }
    public function getOfferAttribute($offer)
    {
        return $offer ? 'غیرفعال' : 'فعال';
    }
    public function getBestAttribute($best)
    {
        return $best ? 'غیرفعال' : 'فعال';
    }
    public function getQuantityCheckAttribute()
    {
        return $this->variations()->where('quantity' , '>' , 0)->first() ?? 0;
    }
    public function getOutCheckAttribute()
    {
        return $this->variations()->where('quantity' , '=' , 0)->first() ?? 0;
    }
    public function getSaleCheckAttribute()
    {
        return $this->variations()
                ->where('quantity' , '>' , 0)
                ->where('sale_price' , '!=' , null)
                ->where('date_on_sale_from' , '<' , Carbon::now())
                ->where('date_on_sale_to' , '>' , Carbon::now())
                ->orderBy('price')
                ->first() ?? 0;
    }
    public function getPriceCheckAttribute()
    {
        return $this->variations()
                ->where('quantity' , '>' , 0)
                ->orderBy('sale_price')
                ->first() ?? 0;
    }

    public function scopeFilter($query)
    {
        if(request()->has('attribute')){
            foreach (request()->attribute as $attribute){
                $query->whereHas('attributes' , function($query) use($attribute){
                    foreach (explode('-' , $attribute) as $index => $item){
                        if($index == 0){
                            $query->where('value' , $item);
                        }
                        $query->orWhere('value' , $item);
                    }
                });
            }
        }
        if(request()->has('variation')){
            $query->whereHas('variations' , function($query){
                foreach (explode('-' , request()->variation) as $index => $variation){
                    if($index == 0){
                        $query->where('value' , $variation);
                    }
                    $query->orWhere('value' , $variation);
                }
            });
        }
        return $query;
    }
    public function checkUserWishlist($userId)
    {
        return $this->hasMany(Wishlist::class)->where('user_id' , $userId)->exists();
    }
    public function orders()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function comments()
    {
        return $this->hasMany(ProductComment::class);
    }
    public function approvedComments()
    {
        return $this->hasMany(ProductComment::class);
    }
}
