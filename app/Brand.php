<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $table = 'brands';
    protected $fillable = array('id', 'title', 'name', 'meta_description', 'keywords', 'content', 'image', 'user_id', 'created_at', 'updated_at');
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function list_brand()
    {
        return $this->belongsTo('App\ListBrand');
    }

    public function category()
    {
        return $this->belongsToMany('App\Category');
    }
    public function product()
    {
        return $this->belongsToMany('App\Product');
    }

    public function alias_brand()
    {
        return $this->belongsTo('App\AliasBrand');
    }

}
