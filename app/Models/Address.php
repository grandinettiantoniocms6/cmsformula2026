<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use CrudTrait;
    use SoftDeletes;
    /*
	|--------------------------------------------------------------------------
	| GLOBAL VARIABLES
	|--------------------------------------------------------------------------
	*/

    protected $table = 'shop_addresses';
    //protected $primaryKey = 'id';
    // public $timestamps = true;
    // protected $guarded = ['id'];
    protected $fillable = [
    	'user_id',
    	'country_id',
    	'name',
    	'address1',
    	'address2',
    	'county',
    	'city',
    	'postal_code',
    	'phone',
    	'mobile_phone',
    	'comment',
        'number_street',
        'old_id',
        'custom_fields_shipping'
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
	public function country()
	{
		return $this->hasOne('App\Models\Country', 'id', 'country_id');
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
