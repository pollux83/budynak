<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $table = 'option';
    protected $primaryKey = 'id';
    protected $fillable = array('name');

    public $timestamps = false;

    public function value()
    {
        return $this->hasMany('App\Value');
    }
    
    
}
