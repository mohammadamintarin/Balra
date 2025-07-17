<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $guarded = [''];

    public function parentBlog()
    {
        return $this->belongsTo(self::class,'parent' , 'id')->withDefault(['name' => "---"]);
    }

    public function childrenBlog()
    {
        return $this->hasMany(self::class,'parent' , 'id');
    }

    public static function getBlogs(): array
    {
        $array = [];
        $blogs = self::with('childrenBlog')->where('parent' , 0)->get();
        foreach ($blogs as $category1)
        {
            $array[$category1->id] = $category1->name;
            foreach ($category1->childrenBlog as $category2)
            {
                $array[$category2->id] = ' • ' .  $category2->name;
                foreach ($category2->childrenBlog as $category3)
                {
                    $array[$category3->id] = ' ••• ' . $category3->name;
                    foreach ($category3->childrenBlog as $category4)
                    {
                        $array[$category4->id] = ' ••••• ' . $category4->name;
                        foreach ($category4->childrenBlog as $category5)
                        {
                            $array[$category5->id] = ' ••••••• ' . $category5->name;
                        }
                    }
                }
            }
        }
        return $array;
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

}
