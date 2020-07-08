<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductOption extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'product_option';
    protected $fillable = ['product_id', 'option_id', 'option_value', 'required'];
    public $timestamps = false;

    public function products()
    {
        return $this->belongsTo('App\Product');
    }

    public function option_value()
    {
        return $this->belongsTo('App\OptionValue');
    }

    public function option()
    {
        return $this->belongsTo('App\Option');
    }
}
