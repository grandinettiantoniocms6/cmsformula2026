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
        if($this->is_ext == 1){
            $url = $this->image;
            return "<img src='$url' width='60'>";
        }

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
        if($this->is_ext == 1){
            return;
        }

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
                    // $value può essere assoluto o relativo
                    $absolute = $this->resolveImagePath($value);

                    // Se è un URL remoto, meglio usare i byte/stream
                    if (\Str::startsWith($absolute, ['http://', 'https://'])) {
                        $bytes  = file_get_contents($absolute); // o Http::get(...)->body()
                        $image  = \Image::make($bytes)->encode('webp', 90);
                    } else {
                        $image  = \Image::make($absolute)->encode('webp', 90);
                    }
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
                    // $value può essere assoluto o relativo
                    $absolute = $this->resolveImagePath($value);

                    // Se è un URL remoto, meglio usare i byte/stream
                    if (\Str::startsWith($absolute, ['http://', 'https://'])) {
                        $bytes  = file_get_contents($absolute); // o Http::get(...)->body()
                        $image  = \Image::make($bytes)->encode('webp', 90);
                    } else {
                        $image  = \Image::make($absolute)->encode('webp', 90);
                    }
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

    function resolveImagePath(string $value): string
    {
        // 1) URL remoti → li lasci così (poi passerai i byte/stream)
        if (\Str::startsWith($value, ['http://', 'https://'])) {
            return $value;
        }

        // 2) Già assoluto (/home/..., /var/..., /... )
        if (\Str::startsWith($value, '/')) {
            return $value;
        }

        // 3) Relativo che esiste dalla CWD
        if (is_file($value)) {
            return realpath($value);
        }

        // 4) Relativo sotto public/ (es. "uploads/hero/foo.png" o "storage/foo.png")
        $pub = public_path(ltrim($value, '/'));
        if (is_file($pub)) {
            return $pub;
        }

        // 5) Relativo sul disco 'public' (storage/app/public/...)
        if (\Storage::disk('public')->exists($value)) {
            return \Storage::disk('public')->path($value);
        }

        throw new \RuntimeException("File non trovato: {$value}");
    }
}
