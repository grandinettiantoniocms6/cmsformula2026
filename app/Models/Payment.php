<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use CrudTrait;
    use SoftDeletes;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'shop_payments';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id','store'];
    protected $fillable = ["name", "info", "is_contrassegno", "is_paypal", "price_contrassegno", "total_min_cart_contrassegno", "total_max_cart_contrassegno"];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public function getName(){
        $html = $this->name;
        if($this->is_paypal){
            $env = env("PAYPAL_MODE");
            if($env == "sandbox"){
                $html .= "<span class='badge badge-danger'>SANDBOX</span>";
            }else{
                $html .= "<span class='badge badge-success'>LIVE</span>";
            }
        }

        return $html;
    }
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

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
