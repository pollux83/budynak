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

}
