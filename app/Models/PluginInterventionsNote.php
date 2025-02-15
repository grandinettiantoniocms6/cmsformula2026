<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class PluginInterventionsNote extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'plugins_interventions_notes';
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
    public function getIsClosed(){
        if($this->is_closed == 1){
            $url = route('dashboard.set.field.boolean', ['plugins_interventions_notes', $this->id, "is_closed", 0]);
            return "<a href='$url' class='text text-danger'>Chiusa</a>";
        }else{
            $url = route('dashboard.set.field.boolean', ['plugins_interventions_notes',$this->id, "is_closed", 1]);
            return "<a href='$url' class='text text-success'>Aperta</a>";
        }
    }

    public function getNote(){
        return '<small>' . $this->note . '</small>';
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
