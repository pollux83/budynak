<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductOptionValue extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'product_option_value';
    protected $fillable = ['product_option_id', 'product_id', 'option_id', 'value_id', 'price'];
    public $timestamps = false;

    public function product()
    {
        return $this->belongsTo('App\Product');
    }

    public function product_option()
    {
        return $this->belongsTo('App\ProductOption');
    }

    public function option_value()
    {
        return $this->belongsTo('App\OptionValue');
    }

    public function option()
    {
        return $this->belongsTo('App\Option');
    }
    public function value()
    {
        return $this->belongsTo('App\Value');
    }
}
