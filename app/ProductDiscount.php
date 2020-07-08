<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductDiscount extends Model
{
    protected $table = 'product_discounts';
    protected $fillable = ['product_id', 'discount', 'date_start', 'date_end'];
    public $timestamps = false;

    public function product(){
        return $this->belongsTo('App\Product');
    }
}
