<?php

namespace App\Models;

use App\User;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PluginCacciaHuntersChiefs extends Model
{
    use CrudTrait;
    use SoftDeletes;
    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'plugins_caccia_hunters_chiefs';
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
    public function getHunter(){
        $point  = $this->hunter->points()->sum("point");
        return "{$this->hunter->code} - {$this->hunter->first_name} {$this->hunter->last_name} ($point punti)";
    }

    public function getChief(){
        if($this->chief){
            return $this->chief->code;
        }
    }

    public function getRps(){
        if($this->user){
            return $this->user->name;
        }
    }

    public function getStatus(){
        if(is_numeric($this->status_id)){
            if($this->status_id == 0){
                return "<span class='text text-warning'>In valutazione</span>";
            }

            if($this->status_id == 1){
                return "<span class='text text-success'>Accettato</span>";
            }

            if($this->status_id == 2){
                return "<span class='text text-danger'>Rifiutato</span>";
            }
        }
    }

    public function getEsito(){
        if(is_numeric($this->esito_id)){
            if($this->esito_id == 1){
                return "<span class='text text-success'>Capo abbattuto</span>";
            }

            if($this->esito_id == 2){
                return "<span class='text text-danger'>Capo non abbattuto</span>";
            }
        }
    }
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function hunter(){
        return $this->belongsTo(PluginCacciaHunters::class);
    }

    public function chief(){
        return $this->belongsTo(PluginCacciaChiefs::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
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
