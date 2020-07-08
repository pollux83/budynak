<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $table = 'product_image';
    protected $primaryKey = 'id';
    public $timestamps = false;
    
    protected $fillable = ['image', 'product_id', 'sort'];

    public function products()
    {
        return $this->belongsTo('App\Product');
    }
}
