<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    protected $table = 'shop_wishlist';

    public function product(){
        return $this->belongsTo(PluginProducts::class);
    }
}
