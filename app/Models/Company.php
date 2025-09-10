<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use CrudTrait;
    use SoftDeletes;
    /*
	|--------------------------------------------------------------------------
	| GLOBAL VARIABLES
	|--------------------------------------------------------------------------
	*/

    protected $table = 'shop_companies';
    //protected $primaryKey = 'id';
    public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = [
    	'user_id',
    	'name',
    	'address1',
    	'address2',
    	'county',
    	'city',
        'mobile',
        'heading_invoice',
        'fiscal_code_vat',
        'fiscal_code',
    	'tin',
    	'trn',
        'country_id',
        'business_name',
        'old_id',
        'pec',
        'number_street',
        'sdi',
        'postal_code',
        'custom_fields_checkout'
	];
    // protected $hidden = [];
    // protected $dates = [];

    /*
	|--------------------------------------------------------------------------
	| FUNCTIONS
	|--------------------------------------------------------------------------
	*/

    /*
	|--------------------------------------------------------------------------
	| RELATIONS
	|--------------------------------------------------------------------------
	*/
    /*public function country()
    {
        return $this->hasOne('App\Models\Country', 'id', 'country_id');
    }*/
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
