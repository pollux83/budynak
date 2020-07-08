<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $primaryKey = 'id';
    protected $fillable = ['title', 'name', 'meta_description','keywords','content', 'user_id'];
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function alias()
    {
        return $this->belongsTo('App\AliasCategory', 'id');
    }
    public function category()
    {
        return $this->belongsTo('App\Category');
    }

}
