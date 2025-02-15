<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;

class Promotion extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'shop_promotions';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = ['reduction',
        'start_date',
        'expiration_date',
        'product_id',
        'currency_id',
        'discount_type',
        'category_id',
        'brand_id',
        'description',
        'banner',
        'name',
        'is_forced'
    ];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public function getDiscount(){
        $label = "%";
        if($this->discount_type == "Amount"){
            $label = "&euro;";
        }

        return "- {$this->reduction} {$label}";
    }

    public function getObjName(){
        if($this->category_id){
            $item = PluginProductsCategories::withTrashed()->find($this->category_id);
        }else{
            $item = PluginProductsBrands::withTrashed()->find($this->brand_id);
        }

        if($item){
            return $item->name;
        }

    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function category(){
        return $this->belongsTo(PluginProductsCategories::class);
    }
    public function brand(){
        return $this->belongsTo(PluginProductsBrands::class);
    }
    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
