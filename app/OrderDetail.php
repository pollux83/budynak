<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'order_details';
    protected $fillable = ['order_id', 'quantity','price', 'name'];


    public function order()
    {
        return $this->belongsTo('App\Order');
    }
}
