<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PluginInterventionsStatus extends Model
{
    use CrudTrait;
    use SoftDeletes;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'plugins_interventions_status';
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
    public function getIsAnnullato(){
        if($this->default_annullato == 1){
            $url = route('dashboard.set.field.boolean', ['plugins_interventions_status', $this->id, "default_annullato", 0]);
            return "<a href='$url' class='text text-success'><i class=\"las la-check\"></i></a>";
        }else{
            $url = route('dashboard.set.field.boolean', ['plugins_interventions_status',$this->id, "default_annullato", 1]);
            return "<a href='$url' class='text text-dark'><i class=\"las la-check\"></i></a>";
        }
    }

    public function getColor(){
        return "<span style='color: {$this->color}'>Testo colore</span>";
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
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
