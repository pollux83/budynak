<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OptionValue extends Model
{
    protected $table = 'option_value';
    protected $fillable = ['value_id', 'option_id', 'image', 'sort_order'];
    public $timestamps = false;

    public function value()
    {
        return $this->belongsTo('App\Value', 'value_id', 'option_id');
    }
}
