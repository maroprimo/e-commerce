<?php

namespace App;


//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
   // use HasFactory;

   protected $fillable = ['nom', 'adresse', 'pays', 'total_price', 'payment_id'];

    public function items()
    {
        return $this->hasMany(OrderArticle::class);
    }
}
