<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class PluginBookingRoom extends Model
{
    use CrudTrait;
    use HasTranslations;
    use SoftDeletes;

    public $translatable = ["name", "meta_title", "meta_description", "meta_key", "abstract", "description"];


    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'plugins_booking_rooms';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id','services_list_free','services_list'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    public function getType(){
        if($this->type){
            return $this->type->name;
        }
    }

    public function getPriceNow(){
        $now = Carbon::now();
        /*->whereRaw("((date_visible_start is null AND date_visible_end IS NULL)
                                                OR (date_visible_start <= '$now' AND date_visible_end IS NULL)
                                                OR (date_visible_start IS NULL AND date_visible_end >= '$now')
                                                OR (date_visible_start <= '$now' AND date_visible_end >= '$now'))")*/

    }

    public function getGallery(){
        return '<a href="/admin/plugin-booking-room-images?room_id='.$this->id.'" class="btn btn-sm btn-link"><i class="la la-edit"></i> Gallery</a>';
    }


    // Funzione nuova che genera le THUMB Plugin Prodotti
    public function setCoverPhotoAttribute($value)
    {
        $attribute_name = "cover_photo";
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
                $filename = "$nameFile[0]-cover.{$nameFile[1]}";
                \Storage::disk($disk)->put($destination_path.'/'.$filename, $image->stream());
            }

            $this->attributes[$attribute_name] = $value;
        }

    }

    public function get_foto_front($type){
        if($this->cover_photo){
            $basename = basename($this->cover_photo);
            $temp = explode(".", $basename);

            $check = "thumb/plugin_bookings/$temp[0]-$type.webp";

            if(file_exists($check)){
                $url = url($check);
                return $url;
            }

            if(is_numeric(strpos($this->cover_photo, "uploads"))){
                $url = url("$this->cover_photo");
            }else{
                $url = url("uploads/products/$this->cover_photo");
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

    public function prices(){
        return $this->hasMany(PluginBookingRoomPrices::class, "plugin_booking_room_id");
    }

    public function promos(){
        return $this->hasMany(PluginBookingRoomPromos::class, "plugin_booking_room_id");
    }

    public function services(){
        return $this->hasMany(PluginBookingRoomServices::class, "plugin_booking_room_id");
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
