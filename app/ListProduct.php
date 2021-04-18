<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ListProduct extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'list_products';
    protected $fillable = array('name', 'sort', 'image', 'status', 'price', 'brand_id', 'created_at', 'updated_at');

    public function alias_product()
    {
        return $this->belongsTo('App\AliasProduct', 'id');
    }

    /**
     * @return string
     */
    public function getStatusLabel(): string
    {
        return ($this->status == 1) ? 'Да': 'Нет';
    }

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

}
