<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Translatable\HasTranslations;

class WebsiteSetting extends Model
{
    use CrudTrait;
    use HasTranslations;

    public $translatable = ["title", "dati", "title_footer_1", "text_footer_1", "title_footer_2", "text_footer_2", "title_footer_3", "text_footer_3", "title_footer_4", "text_footer_4", "meta_description", "meta_keywords", "topbar_contact_description", "offline_description", "popup_title", "popup_text", "iubenda_privacy", "iubenda_cookie", "iubenda_cookie_banner", "iubenda_termini"];
    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'website_settings';
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
    /*public function setFaviconAttribute($value)
    {
        $attribute_name = "favicon";
        $disk = "public_uploads";
        $destination_path = "img";

        $this->uploadFileToDisk($value, $attribute_name, $disk, $destination_path);

        // return $this->attributes[{$attribute_name}]; // uncomment if this is a translatable field
    }*/

    /*public function setLogoAttribute($value)
    {
        $attribute_name = "logo";
        // or use your own disk, defined in config/filesystems.php
        $disk = config('backpack.base.root_disk_name');
        // destination path relative to the disk above
        $destination_path = "public/uploads/img";

        // if the image was erased
        if ($value==null) {
            // delete the image from disk
            \Storage::disk($disk)->delete($this->{$attribute_name});

            // set null in the database column
            $this->attributes[$attribute_name] = null;
        }

        // if a base64 was sent, store it in the db
        if (Str::startsWith($value, 'data:image'))
        {
            $temp = explode(";", $value);
            $temp_temp = explode("/", $temp[0]);
            // 0. Make the image
            $image = \Image::make($value)->encode($temp_temp[1], 90);

            // 1. Generate a filename.
            $filename = md5($value.time()).'.'.$temp_temp[1];

            // 2. Store the image on disk.
            \Storage::disk($disk)->put($destination_path.'/'.$filename, $image->stream());

            // 3. Delete the previous image, if there was one.
            \Storage::disk($disk)->delete($this->{$attribute_name});

            // 4. Save the public path to the database
            // but first, remove "public/" from the path, since we're pointing to it
            // from the root folder; that way, what gets saved in the db
            // is the public URL (everything that comes after the domain name)
            $public_destination_path = Str::replaceFirst('public/', '', $destination_path);
            $this->attributes[$attribute_name] = $public_destination_path.'/'.$filename;
        }
    }*/
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
