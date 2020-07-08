<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ListBrand extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'list_brands';
    protected $fillable = array('name', 'sort', 'image', 'status','created_at', 'updated_at');
    
    public function products()
    {
        return $this->hasMany('App\Product');
    }
    public function alias_brand()
    {
        return $this->belongsTo('App\AliasBrand', 'id');
    }

}
