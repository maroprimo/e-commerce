<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
   
    protected $fillable = ['title', 'content', 'image', 'category_name']; // Ajoutez 'category_id' si nécessaire


}
