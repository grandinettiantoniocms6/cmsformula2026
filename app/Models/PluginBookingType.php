<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class PluginBookingType extends Model
{
    use CrudTrait;
    use HasTranslations;
    use SoftDeletes;

    public $translatable = ["title", "description", "label_checkout", "info", "description_post_register", "email_preconferma", "email", "email_pin", "email_sollecito", "description_reminder"];

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'plugins_booking_types';
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
    public function getType(){
        $types = [0 => "Il visitatore seleziona una data", 1 => "Il visitatore seleziona data e un ora di arrivo", 2=> "Il visitatore seleziona data di arrivo e data di fine", 3 => "Il visitatore seleziona data inizio orario inizio e data fine e orario fine"];
        return $types[$this->type_booking];
    }

    public function get_foto_mini(){
        if($this->image){
            $basename = basename($this->image);
            $temp = explode(".", $basename);

            $check = "thumb/plugin_booking_types/$temp[0]-mini.webp";
            if(file_exists($check)){
                $url = url($check);
                return "<img src='$url'>";
            }

            if(is_numeric(strpos($this->image, "uploads"))){
                $url = url("$this->image");
            }else{
                $url = url("uploads/plugin_booking_types/$this->image");
            }
            return "<img src='$url' style='width: 120px; border-radius: 3px;'>";
        }
    }

    public function getPayment(){
        if($this->can_payment == 1){
            $url = route('dashboard.set.field.boolean', ['plugins_booking_types', $this->id, "can_payment", 0]);
            return "<a href='$url' class='text text-success'><i class=\"las la-eye\"></i></a>";
        }else{
            $url = route('dashboard.set.field.boolean', ['plugins_booking_types',$this->id, "can_payment", 1]);
            return "<a href='$url' class='text text-danger'><i class=\"las la-eye\"></i></a>";
        }
    }

    public function getVisible(){
        if($this->is_visible == 1){
            $url = route('dashboard.set.field.boolean', ['plugins_booking_types', $this->id, "is_visible", 0]);
            return "<a href='$url' class='text text-success'><i class=\"las la-eye\"></i></a>";
        }else{
            $url = route('dashboard.set.field.boolean', ['plugins_booking_types',$this->id, "is_visible", 1]);
            return "<a href='$url' class='text text-danger'><i class=\"las la-eye\"></i></a>";
        }
    }

    public function getVisibleCalendar(){
        if($this->is_visible_calendar == 1){
            $url = route('dashboard.set.field.boolean', ['plugins_booking_types', $this->id, "is_visible_calendar", 0]);
            return "<a href='$url' class='text text-success'><i class=\"las la-eye\"></i></a>";
        }else{
            $url = route('dashboard.set.field.boolean', ['plugins_booking_types',$this->id, "is_visible_calendar", 1]);
            return "<a href='$url' class='text text-danger'><i class=\"las la-eye\"></i></a>";
        }
    }

    public function getCheckin(){
        if($this->is_checkin == 1){
            $url = route('dashboard.set.field.boolean', ['plugins_booking_types', $this->id, "is_checkin", 0]);
            return "<a href='$url' class='text text-success'><i class=\"las la-eye\"></i></a>";
        }else{
            $url = route('dashboard.set.field.boolean', ['plugins_booking_types',$this->id, "is_checkin", 1]);
            return "<a href='$url' class='text text-danger'><i class=\"las la-eye\"></i></a>";
        }
    }

    public function getIsPin(){
        if($this->is_pin == 1){
            $url = route('dashboard.set.field.boolean', ['plugins_booking_types', $this->id, "is_pin", 0]);
            return "<a href='$url' class='text text-success'><i class=\"las la-eye\"></i></a>";
        }else{
            $url = route('dashboard.set.field.boolean', ['plugins_booking_types',$this->id, "is_pin", 1]);
            return "<a href='$url' class='text text-danger'><i class=\"las la-eye\"></i></a>";
        }
    }

    public function getIsAddiction(){
        if($this->is_addiction == 1){
            $url = route('dashboard.set.field.boolean', ['plugins_booking_types', $this->id, "is_addiction", 0]);
            return "<a href='$url' class='text text-success'><i class=\"las la-eye\"></i></a>";
        }else{
            $url = route('dashboard.set.field.boolean', ['plugins_booking_types',$this->id, "is_addiction", 1]);
            return "<a href='$url' class='text text-danger'><i class=\"las la-eye\"></i></a>";
        }
    }

    public function getBooleans(){
        echo "<p>Pagamenti ".$this->getPayment()."</p>";
        echo "<p>Visibile ".$this->getVisible()."</p>";
        echo "<p>Filtro ".$this->getVisibleCalendar()."</p>";
        echo "<p>Check-in ".$this->getCheckin()."</p>";
        echo "<p>Pin ".$this->getIsPin()."</p>";
        echo "<p>Dipendenza ".$this->getIsAddiction()."</p>";
    }

    public function getStatus(){
        $status = PluginBookingStatus::find($this->default_status_id);
        if($status){
            return $status->name;
        }
    }

    public function getColor(){
        return "<span style='color: {$this->color_calendar}'>in agenda</span>";
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
