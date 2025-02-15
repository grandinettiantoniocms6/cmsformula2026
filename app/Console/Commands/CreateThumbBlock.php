<?php

namespace App\Console\Commands;

use App\Models\AdminBlock;
use App\Models\AdminThumb;
use App\Models\BlockBanner;
use App\Models\BlockBrand;
use App\Models\BlockContactgmap;
use App\Models\BlockGallery;
use App\Models\BlockGrid;
use App\Models\BlockHtmlImage;
use App\Models\BlockImageLink;
use App\Models\BlockParallax;
use App\Models\BlockSlideshow;
use App\Models\PluginProductsImages;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class CreateThumbBlock extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:thumb_blocks';

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

            $adminBlock = AdminBlock::where("name", "blockPluginProduct")->first();
            $adminThumb = AdminThumb::where("admin_block_id", "!=", $adminBlock->id)
                ->groupBy("admin_block_id")
                ->get();

            if($adminThumb){
                foreach ($adminThumb as $admin_t){
                    $adminBlock = AdminBlock::where("id", $admin_t->admin_block_id)->first();
                    if(!$adminBlock){
                        continue;
                    }

                    $this->info("BLOCK: $adminBlock->name_table");


                    $list = null;

                    switch ($adminBlock->name_table){

                        // Istruzioni per creare le thumb dei blocchi
                        case "blocks_slideshows":
                            $folder = "blocks_slideshows";
                            $destination_path = "public/thumb/$folder";
                            \File::deleteDirectory(public_path("thumb/$folder"));

                            $adminThumb_temp = AdminThumb::where("admin_block_id", "=", $adminBlock->id)
                                ->get();

                            $list = BlockSlideshow::orderBy("id", "desc")->get();
                            break;

                        case "blocks_banners":
                            $folder = "blocks_banners";
                            $destination_path = "public/thumb/$folder";
                            \File::deleteDirectory(public_path("thumb/$folder"));

                            $adminThumb_temp = AdminThumb::where("admin_block_id", "=", $adminBlock->id)
                                ->get();

                            $list = BlockBanner::orderBy("id", "desc")->get();
                            break;

                        case "blocks_images_links":
                            $folder = "blocks_images_links";
                            $destination_path = "public/thumb/$folder";
                            \File::deleteDirectory(public_path("thumb/$folder"));

                            $adminThumb_temp = AdminThumb::where("admin_block_id", "=", $adminBlock->id)
                                ->get();

                            $list = BlockImageLink::orderBy("id", "desc")->get();
                            break;

                        case "blocks_htmlimages":
                            $folder = "blocks_htmlimages";
                            $destination_path = "public/thumb/$folder";
                            \File::deleteDirectory(public_path("thumb/$folder"));

                            $adminThumb_temp = AdminThumb::where("admin_block_id", "=", $adminBlock->id)
                                ->get();

                            $list = BlockHtmlImage::orderBy("id", "desc")->get();
                            break;

                        case "blocks_parallaxs":
                            $folder = "blocks_parallaxs";
                            $destination_path = "public/thumb/$folder";
                            \File::deleteDirectory(public_path("thumb/$folder"));

                            $adminThumb_temp = AdminThumb::where("admin_block_id", "=", $adminBlock->id)
                                ->get();

                            $list = BlockParallax::orderBy("id", "desc")->get();
                            break;

                        case "blocks_gallerys":
                            $folder = "blocks_gallerys";
                            $destination_path = "public/thumb/$folder";
                            \File::deleteDirectory(public_path("thumb/$folder"));

                            $adminThumb_temp = AdminThumb::where("admin_block_id", "=", $adminBlock->id)
                                ->get();

                            $list = BlockGallery::orderBy("id", "desc")->get();
                            break;

                        case "blocks_brands":
                            $folder = "blocks_brands";
                            $destination_path = "public/thumb/$folder";
                            \File::deleteDirectory(public_path("thumb/$folder"));

                            $adminThumb_temp = AdminThumb::where("admin_block_id", "=", $adminBlock->id)
                                ->get();

                            $list = BlockBrand::orderBy("id", "desc")->get();
                            break;

                        case "blocks_contactgmaps":
                            $folder = "blocks_contactgmaps";
                            $destination_path = "public/thumb/$folder";
                            \File::deleteDirectory(public_path("thumb/$folder"));

                            $adminThumb_temp = AdminThumb::where("admin_block_id", "=", $adminBlock->id)
                                ->get();

                            $list = BlockContactgmap::orderBy("id", "desc")->get();
                            break;

                        case "blocks_grids":
                            $folder = "blocks_grids";
                            $destination_path = "public/thumb/$folder";
                            \File::deleteDirectory(public_path("thumb/$folder"));

                            $adminThumb_temp = AdminThumb::where("admin_block_id", "=", $adminBlock->id)
                                ->get();

                            $list = BlockGrid::orderBy("id", "desc")->get();
                            break;



                    }


                    if($list){
                        foreach ($list as $item){
                            try{
                                if(isset($item->foto)){
                                    $basename = basename($item->foto);
                                    $nameFile = explode(".", $basename);

                                    $url_check = "public/$item->foto";
                                    $value = $url_check;

                                    if(file_exists($url_check)){
                                        if(count($adminThumb_temp)){
                                            foreach ($adminThumb_temp as $thumb){
                                                $image = \Image::make($value)->encode('webp', 80);

                                                $width = $thumb->width_max != 0 ? $thumb->width_max : null;
                                                $height = $thumb->height_max != 0 ? $thumb->height_max : null;
                                                $suffix = $thumb->suffix;

                                                $image->fit($width, $height, function ($constraint) {
                                                    $constraint->upsize();
                                                });

                                                $filename = "$nameFile[0]-{$suffix}.webp";
                                                \Storage::disk($disk)->put($destination_path.'/'.$filename, $image->stream());

                                                $this->info("---- create thumb $item->id");
                                            }
                                        }
                                    }else{
                                        $this->info("--- not found");
                                    }
                                }

                                if(isset($item->foto2)){
                                    $basename = basename($item->foto2);
                                    $nameFile = explode(".", $basename);

                                    $url_check = "public/$item->foto2";
                                    $value = $url_check;

                                    if(file_exists($url_check)){
                                        if(count($adminThumb_temp)){
                                            foreach ($adminThumb_temp as $thumb){
                                                $image = \Image::make($value)->encode('webp', 90);

                                                $width = $thumb->width_max != 0 ? $thumb->width_max : null;
                                                $height = $thumb->height_max != 0 ? $thumb->height_max : null;
                                                $suffix = $thumb->suffix;

                                                $image->fit($width, $height, function ($constraint) {
                                                    $constraint->upsize();
                                                });

                                                $filename = "$nameFile[0]-{$suffix}.webp";
                                                \Storage::disk($disk)->put($destination_path.'/'.$filename, $image->stream());

                                                $this->info("---- create thumb $item->id");
                                            }
                                        }
                                    }else{
                                        $this->info("--- not found");
                                    }
                                }

                                if(isset($item->foto3)){
                                    $basename = basename($item->foto3);
                                    $nameFile = explode(".", $basename);

                                    $url_check = "public/$item->foto3";
                                    $value = $url_check;

                                    if(file_exists($url_check)){
                                        if(count($adminThumb_temp)){
                                            foreach ($adminThumb_temp as $thumb){
                                                $image = \Image::make($value)->encode('webp', 90);

                                                $width = $thumb->width_max != 0 ? $thumb->width_max : null;
                                                $height = $thumb->height_max != 0 ? $thumb->height_max : null;
                                                $suffix = $thumb->suffix;

                                                $image->fit($width, $height, function ($constraint) {
                                                    $constraint->upsize();
                                                });

                                                $filename = "$nameFile[0]-{$suffix}.webp";
                                                \Storage::disk($disk)->put($destination_path.'/'.$filename, $image->stream());

                                                $this->info("---- create thumb $item->id");
                                            }
                                        }
                                    }else{
                                        $this->info("--- not found");
                                    }
                                }

                                if(isset($item->foto4)){
                                    $basename = basename($item->foto4);
                                    $nameFile = explode(".", $basename);

                                    $url_check = "public/$item->foto4";
                                    $value = $url_check;

                                    if(file_exists($url_check)){
                                        if(count($adminThumb_temp)){
                                            foreach ($adminThumb_temp as $thumb){
                                                $image = \Image::make($value)->encode('webp', 90);

                                                $width = $thumb->width_max != 0 ? $thumb->width_max : null;
                                                $height = $thumb->height_max != 0 ? $thumb->height_max : null;
                                                $suffix = $thumb->suffix;

                                                $image->fit($width, $height, function ($constraint) {
                                                    $constraint->upsize();
                                                });

                                                $filename = "$nameFile[0]-{$suffix}.webp";
                                                \Storage::disk($disk)->put($destination_path.'/'.$filename, $image->stream());

                                                $this->info("---- create thumb $item->id");
                                            }
                                        }
                                    }else{
                                        $this->info("--- not found");
                                    }
                                }

                                if(isset($item->foto_sx)){
                                    $basename = basename($item->foto_sx);
                                    $nameFile = explode(".", $basename);

                                    $url_check = "public/$item->foto_sx";
                                    $value = $url_check;

                                    if(file_exists($url_check)){
                                        if(count($adminThumb_temp)){
                                            foreach ($adminThumb_temp as $thumb){
                                                $image = \Image::make($value)->encode('webp', 90);

                                                $width = $thumb->width_max != 0 ? $thumb->width_max : null;
                                                $height = $thumb->height_max != 0 ? $thumb->height_max : null;
                                                $suffix = $thumb->suffix;

                                                $image->fit($width, $height, function ($constraint) {
                                                    $constraint->upsize();
                                                });

                                                $filename = "$nameFile[0]-{$suffix}.webp";
                                                \Storage::disk($disk)->put($destination_path.'/'.$filename, $image->stream());

                                                $this->info("---- create thumb $item->id");
                                            }
                                        }
                                    }else{
                                        $this->info("--- not found");
                                    }
                                }

                                if(isset($item->foto_dx)){
                                    $basename = basename($item->foto_dx);
                                    $nameFile = explode(".", $basename);

                                    $url_check = "public/$item->foto_dx";
                                    $value = $url_check;

                                    if(file_exists($url_check)){
                                        if(count($adminThumb_temp)){
                                            foreach ($adminThumb_temp as $thumb){
                                                $image = \Image::make($value)->encode('webp', 90);

                                                $width = $thumb->width_max != 0 ? $thumb->width_max : null;
                                                $height = $thumb->height_max != 0 ? $thumb->height_max : null;
                                                $suffix = $thumb->suffix;

                                                $image->fit($width, $height, function ($constraint) {
                                                    $constraint->upsize();
                                                });

                                                $filename = "$nameFile[0]-{$suffix}.webp";
                                                \Storage::disk($disk)->put($destination_path.'/'.$filename, $image->stream());

                                                $this->info("---- create thumb $item->id");
                                            }
                                        }
                                    }else{
                                        $this->info("--- not found");
                                    }
                                }

                            } catch (\Throwable $e) {
                                $this->info("---- $basename");
                            }
                        }
                    }
                }
            }
        } catch (Throwable $e) {
            $this->info("---- $basename");

        }


    }
}
