<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PluginCacciaHunters extends Model
{
    use CrudTrait;
    use SoftDeletes;
    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'plugins_caccia_hunters';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public function getCheck(){
        return "<input type='checkbox' class='checkbox' name='ids[]' value='{$this->id}'>";
    }

    public function getPoints(){
        $setting = PluginCacciaSettings::first();
        $point = $this->points()->sum("point");
        if($point < $setting->min_points){
            return "<span class='text text-danger'>$point</span>";
        }

        return "<span class='text text-success'>$point</span>";
    }

    public function getChiefs(){
        $count = $this->chiefs()->count();
        return "<a href='/admin/plugin-caccia-hunters-chiefs?hunter_id={$this->id}'>$count</a>";
    }
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function points(){
        return $this->hasMany(PluginCacciaHuntersPoints::class, "hunter_id");
    }

    public function chiefs(){
        return $this->hasMany(PluginCacciaHuntersChiefs::class, "hunter_id");
    }
    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
