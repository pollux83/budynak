<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'products';
    protected $fillable = array('name', 'title','meta_description', 'keywords', 'status', 'description','price','brand_id','created_at_ip', 'updated_at_ip');

    public function brand()
    {
        return $this->belongsTo('App\Brand');
    }
    public function categories()
    {
        return $this->belongsToMany('App\Category','product_categories','product_id','category_id');
    }
    public function product_category()
    {
        return $this->belongsToMany('App\ProductCategory');
    }

    public function aliases()
    {
        return $this->belongsTo('App\AliasProduct');
    }

    public function product_discount()
    {
        return $this->belongsTo('App\ProductDiscount');
    }

}