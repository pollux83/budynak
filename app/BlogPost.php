<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    protected $primaryKey = 'id';
    protected $fillable = [
         'name',
         'title',
         'meta_description',
         'keywords',
         'content',
         'user_id'
    ];
    public $timestamps = false;

    public function author()
    {
        return $this->belongsTo('App\User');
    }
    public function list_blog()
    {
        return $this->belongsTo('App\ListBlog', 'id');
    }
    public function alias_post(){
        return $this->belongsTo('App\AliasPost', 'id');
    }
}
