<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{

    protected $table = 'shop_cart';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = ['product_id','user_id','qty','price','file','message','services', 'price_unit', 'price_add', 'total_cart'];

    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public function product(){
        return $this->belongsTo(PluginProducts::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
