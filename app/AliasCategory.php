<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AliasCategory extends Model
{
    protected $table = 'aliases_categories';
    protected $fillable = array('id', 'alias');
    public $timestamps = false;

    public function category()
    {
        return $this->belongsTo('App\Category');
    }
}
