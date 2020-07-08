<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Value extends Model
{
    protected $table = 'value';
    protected $primaryKey = 'id';
    protected $fillable = array('option_id', 'name');

    public $timestamps = false;

    public function option()
    {
        return $this->belongsTo('App\Option');
    }
    public function product_option_value()
    {
        return $this->belongsTo('App\ProductOptionValue');
    }
}
