<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderArticle extends Model
{
    //
    protected $fillable = ['product_name', 'quantity', 'price', 'order_id'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
