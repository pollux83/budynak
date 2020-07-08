<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AliasInformation extends Model
{
    protected $table = 'aliases_informations';
    protected $fillable = array('id', 'alias');
    public $timestamps = false;

    public function information()
    {
        return $this->belongsTo('App\Information');
    }
}
