<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'menus';
    protected $fillable = array('name', 'alias');
    public $timestamps = false;

    public function category()
    {
        return $this->hasMany('App\Category');
    }
}