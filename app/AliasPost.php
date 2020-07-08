<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AliasPost extends Model
{
    protected $table = 'aliases_posts';
    protected $fillable = array('id', 'alias');
    public $timestamps = false;

    public function post()
    {
        return $this->belongsTo('App\Post');
    }
}
