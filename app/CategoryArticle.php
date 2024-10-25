<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryArticle extends Model
{
    //
    public function articles()
    {
        return $this->hasMany(Article::class, 'category_name', 'name');
    }
}
