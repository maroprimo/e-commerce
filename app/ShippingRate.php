<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShippingRate extends Model
{
    protected $fillable = ['country_id', 'weight_min', 'weight_max', 'price'];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}