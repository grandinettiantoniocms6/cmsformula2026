<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class ShopCartExtra extends Model
{

    protected $table = 'shop_cart_extra';
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
    public function cart(){
        return $this->belongsTo(Cart::class);
    }
    public function extra(){
        return $this->belongsTo(ShopExtra::class);
    }
}
