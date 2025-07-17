<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $guarded = [''];

    public function parent()
    {
        return $this->belongsTo(self::class,'parent_id' , 'id')->withDefault(['name' => "---"]);
    }

    public function children()
    {
        return $this->hasMany(self::class,'parent_id' , 'id');
    }

    public static function getcategories(): array
    {
        $array = [];
        $categoires = self::with('children')->where('parent_id' , 0)->get();
        foreach ($categoires as $category1)
        {
            $array[$category1->id] = $category1->name;
            foreach ($category1->children as $category2)
            {
                $array[$category2->id] = ' • ' .  $category2->name;
                foreach ($category2->children as $category3)
                {
                    $array[$category3->id] = ' ••• ' . $category3->name;
                    foreach ($category3->children as $category4)
                    {
                        $array[$category4->id] = ' ••••• ' . $category4->name;
                        foreach ($category4->children as $category5)
                        {
                            $array[$category5->id] = ' ••••••• ' . $category5->name;
                        }
                    }
                }
            }
        }
        return $array;
    }
    public function attributes()
    {
        return $this->belongsToMany(Attribute::class , 'attribute_category');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
