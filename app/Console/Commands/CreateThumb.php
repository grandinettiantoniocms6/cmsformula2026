<?php

namespace App\Console\Commands;

use App\Models\AdminBlock;
use App\Models\AdminThumb;
use App\Models\PluginProductsImages;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class CreateThumb extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:thumb';

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
        try{
        $disk = config('backpack.base.root_disk_name');
        $destination_path = "public/thumb/plugin_products";

        //qual'è il blocco thumb impostato per i prodotti?
        $adminBlock = AdminBlock::where("name", "blockPluginProduct")->first();
        $adminThumb = AdminThumb::where("admin_block_id", $adminBlock->id)->get();

        //\File::deleteDirectory(public_path('thumb/plugin_products'));

        $images = PluginProductsImages::orderBy("id", "desc")
            //la riga 56 se si blocca da shell l'attivo dal numero +1 che si blocca
            //->where("id", "<=", 278)
            ->get();
        if($images){
            foreach ($images as $item){
                $this->info("processing $item->image");


                    $basename = basename($item->image);
                    $nameFile = explode(".", $basename);

                    if(is_numeric(strpos($item->image, "uploads"))){
                        $url_check = "public/$item->image";
                        $value = $url_check;
                    }else{
                        $url_check = "public/uploads/products/$item->image";
                        $value = $url_check;
                    }

                    if(file_exists($url_check)){
                        if(count($adminThumb)){
                            foreach ($adminThumb as $thumb){
                                $image = \Image::make($value)->encode('webp', 80);

                                $width = $thumb->width_max != 0 ? $thumb->width_max : null;
                                $height = $thumb->height_max != 0 ? $thumb->height_max : null;
                                $suffix = $thumb->suffix;

                                $image->fit($width, $height, function ($constraint) {
                                    $constraint->upsize();
                                });

                                $filename = "$nameFile[0]-{$suffix}.webp";
                                \Storage::disk($disk)->put($destination_path.'/'.$filename, $image->stream());

                                $this->info("create thumb $item->id (prodotto id: $item->product_id) - FILENAME: $filename");
                            }
                        }
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
