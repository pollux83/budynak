<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AliasProduct extends Model
{
    protected $table = 'aliases_products';
    protected $primaryKey = 'id';
    protected $fillable = array('alias');
    public $timestamps = false;

    public function product()
    {
        return $this->belongsTo('App\Product');
    }
    public function list_product()
    {
        return $this->belongsTo('App\ListProduct');
    }
}
