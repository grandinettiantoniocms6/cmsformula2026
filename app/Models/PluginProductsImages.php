<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;

class PluginProductsImages extends Model
{

    use CrudTrait;
    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'plugins_products_images';
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

    public function get_foto_mini(){
        if($this->image){
            $basename = basename($this->image);
            $temp = explode(".", $basename);

            $check = "thumb/plugin_products/$temp[0]-mini.webp";
            if(file_exists($check)){
                $url = url($check);
                return "<img src='$url'>";
            }

            if(is_numeric(strpos($this->image, "uploads"))){
                $url = url("$this->image");
            }else{
                $url = url("uploads/products/$this->image");
            }
            return "<img src='$url' style='width: 120px; border-radius: 3px;'>";
        }
    }

    // Funzione nuova che genera le THUMB Plugin Prodotti
    public function setImageAttribute($value)
    {
        $attribute_name = "image";
        $disk = config('backpack.base.root_disk_name');
        $destination_path = "public/thumb/plugin_products";

        if ($value != null) {
            $this->attributes[$attribute_name] = null;
        }

        //qual'è il blocco thumb impostato per i prodotti?
        $adminBlock = AdminBlock::where("name", "blockPluginProduct")->first();
        $adminThumb = AdminThumb::where("admin_block_id", $adminBlock->id)->get();
        $websiteSetting = WebsiteSetting::first();

        if(!file_exists($value)){
            //da dropzone
            $this->attributes[$attribute_name] = $value;

            $value = "uploads/products/$value";

            $basename = basename($value);
            $nameFile = explode(".", $basename);

            if(count($adminThumb)){
                foreach ($adminThumb as $thumb){
                    $image = \Image::make($value)->encode('webp', 90);
                    if($websiteSetting->watermark_url){
                        $image->insert(url($websiteSetting->watermark_url), $websiteSetting->watermark_position, $websiteSetting->watermark_x, $websiteSetting->watermark_y);
                    }

                    $width = $thumb->width_max != 0 ? $thumb->width_max : null;
                    $height = $thumb->height_max != 0 ? $thumb->height_max : null;
                    $suffix = $thumb->suffix;

                    $image->fit($width, $height, function ($constraint) {
                        $constraint->upsize();
                    });

                    $filename = "$nameFile[0]-{$suffix}.webp";
                    \Storage::disk($disk)->put($destination_path.'/'.$filename, $image->stream());
                }
            }

        }else{
            //non DROPZONE
            $basename = basename($value);
            $nameFile = explode(".", $basename);

            if(count($adminThumb)){
                foreach ($adminThumb as $thumb){
                    $image = \Image::make($value)->encode('webp', 90);
                    if($websiteSetting->watermark_url){
                        $image->insert(url($websiteSetting->watermark_url), $websiteSetting->watermark_position, $websiteSetting->watermark_x, $websiteSetting->watermark_y);
                    }

                    $width = $thumb->width_max != 0 ? $thumb->width_max : null;
                    $height = $thumb->height_max != 0 ? $thumb->height_max : null;
                    $suffix = $thumb->suffix;

                    $image->fit($width, $height, function ($constraint) {
                        $constraint->upsize();
                    });

                    $filename = "$nameFile[0]-{$suffix}.webp";
                    \Storage::disk($disk)->put($destination_path.'/'.$filename, $image->stream());
                }
            }

            $this->attributes[$attribute_name] = $value;
        }

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
