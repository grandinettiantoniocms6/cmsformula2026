<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class ShopOrderProductExtra extends Model
{

    protected $table = 'shop_order_product_extra';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];

    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public function orderProduct(){
        return $this->belongsTo(OrderProduct::class);
    }
    public function extra(){
        return $this->belongsTo(ShopExtra::class);
    }
}
