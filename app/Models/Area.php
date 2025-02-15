<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;

class Area extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'shop_areas';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['cities'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public function getNumberCountry(){
        return $this->countries()->count();
    }

    public function getNumberCity(){
        return $this->cities()->count();
    }
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function countries(){
        return $this->belongsToMany(Country::class, "shop_areas_countries", "area_id");
    }

    public function cities(){
        return $this->belongsToMany(City::class, "shop_areas_cities", "area_id");
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

    public function setRegionsAttribute($value){
        if($value) {
            $this->attributes["regions"] = implode(",", $value);
        }

    }

    public function setProvincesAttribute($value){
        if($value) {
            $this->attributes["provinces"] = implode(",", $value);
        }

    }

}
