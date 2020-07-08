<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Information extends Model
{
    protected $table = 'informations';
    protected $primaryKey = 'id';
    protected $fillable = array('title', 'name', 'meta_description', 'keywords', 'content', 'status', 'user_id', 'sort', 'published_at');
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function alias_information()
    {
        return $this->belongsTo('App\AliasInformation', 'id');
    }
}
