<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ListBlog extends Model
{
    protected $fillable = ['id', 'name', 'status', 'image','created_at', 'updated_at', 'published_at'];

    public $timestamps = true;

    public function alias_post(){
        return $this->belongsTo('App\AliasPost', 'id');
    }

}
