<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class PluginBookingServices extends Model
{
    use CrudTrait;
    use HasTranslations;
    use SoftDeletes;

    public $translatable = ["name", "description"];

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'plugins_booking_services';
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
    public function getIsEditQty(){
        if($this->is_edit_qty == 1){
            $url = route('dashboard.set.field.boolean', ['plugins_booking_services', $this->id, "is_edit_qty", 0]);
            return "<a href='$url' class='text text-success'><i class=\"las la-eye\"></i></a>";
        }else{
            $url = route('dashboard.set.field.boolean', ['plugins_booking_services',$this->id, "is_edit_qty", 1]);
            return "<a href='$url' class='text text-danger'><i class=\"las la-eye\"></i></a>";
        }
    }

    public function getType(){
        if($this->type){
            return $this->type->name;
        }
    }

    // Funzione nuova che genera le THUMB Plugin Prodotti
    public function setPhotoAttribute($value)
    {
        $attribute_name = "photo";
        $disk = config('backpack.base.root_disk_name');
        $destination_path = "public/thumb/plugin_bookings";

        if ($value != null) {
            $this->attributes[$attribute_name] = null;
        }

        //qual'è il blocco thumb impostato per i prodotti?
        $adminBlock = AdminBlock::where("name", "blockPluginBooking")->first();
        $adminThumb = AdminThumb::where("admin_block_id", $adminBlock->id)->get();

        if(file_exists($value)){
            $basename = basename($value);
            $nameFile = explode(".", $basename);

            if(count($adminThumb)){
                foreach ($adminThumb as $thumb){
                    $image = \Image::make($value)->encode('webp', 90);

                    $width = $thumb->width_max != 0 ? $thumb->width_max : null;
                    $height = $thumb->height_max != 0 ? $thumb->height_max : null;
                    $suffix = $thumb->suffix;

                    $image->fit($width, $height, function ($constraint) {
                        $constraint->upsize();
                    });

                    $filename = "$nameFile[0]-{$suffix}.webp";
                    \Storage::disk($disk)->put($destination_path.'/'.$filename, $image->stream());
                }
            }else{
                $image = \Image::make($value);
                $image->fit(990, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $filename = "$nameFile[0]-list.{$nameFile[1]}";
                \Storage::disk($disk)->put($destination_path.'/'.$filename, $image->stream());
            }

            $this->attributes[$attribute_name] = $value;
        }

    }

    public function get_foto_front($type){
        if($this->photo){
            $basename = basename($this->photo);
            $temp = explode(".", $basename);

            $check = "thumb/plugin_bookings/$temp[0]-$type.webp";

            if(file_exists($check)){
                $url = url($check);
                return $url;
            }

            if(is_numeric(strpos($this->photo, "uploads"))){
                $url = url("$this->photo");
            }else{
                $url = url("uploads/products/$this->photo");
            }
            return $url;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function type(){
        return $this->belongsTo(PluginBookingType::class, "plugin_booking_type_id");
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
