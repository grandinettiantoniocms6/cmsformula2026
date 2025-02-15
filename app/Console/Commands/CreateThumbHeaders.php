<?php

namespace App\Console\Commands;

use App\Models\AdminBlock;
use App\Models\AdminThumb;
use App\Models\PluginProducts;
use App\Models\PluginProductsBrands;
use App\Models\PluginProductsImages;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class CreateThumbHeaders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:thumb_headers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $disk = config('backpack.base.root_disk_name');
        $destination_path = "public/thumb/plugin_products_headers";

        //\File::deleteDirectory(public_path('thumb/plugin_products_headers'));
        try{
        $images = PluginProducts::orderBy("id", "desc")
            ->whereNotNull("cover_photo")
            ->get();
        if($images){
            foreach ($images as $item){
                $this->info("processing $item->cover_photo");
                $basename = basename($item->cover_photo);
                $nameFile = explode(".", $basename);

                if(is_numeric(strpos($item->cover_photo, "uploads"))){
                    $url_check = "public/$item->cover_photo";
                    $value = $url_check;
                }

                if(file_exists($url_check)){
                    $image = \Image::make($value)->encode('webp', 80);

                    $width = 1920;
                    $height = 600;

                    $image->fit($width, $height, function ($constraint) {
                        $constraint->upsize();
                    });

                    $filename = "$nameFile[0].webp";
                    \Storage::disk($disk)->put($destination_path.'/'.$filename, $image->stream());

                    $this->info("create thumb $item->id - FILENAME: $filename");

                }else{
                    $this->info("--- not found");
                }

            }
        }
        } catch (Throwable $e) {
            $this->info("---- $basename");

        }

    }
}
