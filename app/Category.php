<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'categories';
    protected $fillable = array('name', 'image', 'category', 'sort', 'status', 'menu', 'created_at_ip', 'updated_at_ip', 'brand');// ..._at_ip созданы не через миграцию. Если не указать по умолчание Null, то не будет работать
    public $timestamps = true;

    public function products()
    {
        return $this->belongsToMany('App\Product','product_categories','category_id','product_id');
    }
    public function menus()
    {
        return $this->belongsTo('App\Menu');
    }
    public function page()
    {
        return $this->belongsTo('App\Page');
    }
    public function alias_category()
    {
        return $this->belongsTo('App\AliasCategory', 'id');
    }
}