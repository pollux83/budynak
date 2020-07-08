<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    protected $table = 'product_categories';
    protected $fillable = ['product_id', 'category_id', 'created_at', 'updated_at'];

    public function product(){
        return $this->belongsToMany('App\Product');
    }
}
