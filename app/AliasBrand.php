<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AliasBrand extends Model
{
    protected $table = 'aliases_brands';
    protected $fillable = array('id', 'alias');
    public $timestamps = false;

    public function brand()
    {
        return $this->belongsTo('App\Brand');
    }
    public function list_brand()
    {
        return $this->belongsTo('App\ListBrand');
    }
}
