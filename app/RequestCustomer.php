<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestCustomer extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'requests';
    protected $fillable = ['name', 'email', 'content', 'status'];
}
