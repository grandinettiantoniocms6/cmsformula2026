<?php

namespace App\Console\Commands;


use App\Models\Order;
use App\Models\PluginProductsImages;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ClearImageDuplicates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clear:image_duplicated';

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
        $list = \DB::select('SELECT image, COUNT(*) as tot, GROUP_CONCAT(product_id) as products_ids
                    FROM plugins_products_images
                    GROUP BY image, product_id
                    HAVING tot >1');

        if($list){
            foreach ($list as $item){
                $temp = explode(",", $item->products_ids);

                $temp = array_unique($temp);
                if($temp){
                    foreach ($temp as $product_id){
                        PluginProductsImages::where("image", $item->image)
                            ->where("product_id", $product_id)->delete();

                        PluginProductsImages::insert([
                           "image" => $item->image,
                           "product_id" => $product_id
                        ]);

                        $this->info("image $item->image per product_id $product_id");
                    }
                }
            }
        }

    }
}
