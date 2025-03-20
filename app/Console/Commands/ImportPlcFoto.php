<?php

namespace App\Console\Commands;

use App\Models\PluginProducts;
use App\Models\PluginProductsBrands;
use App\Models\PluginProductsCategories;
use App\Models\PluginProductsCategoriesProducts;
use App\Models\PluginProductsImages;
use App\Models\PluginProductsLangs;
use App\Models\ShopAttributes;
use App\Models\ShopAttributesCategories;
use App\Models\ShopAttributesOptions;
use App\Models\ShopAttributesProducts;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ImportPlcFoto extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:plc_foto';

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

        $list = PluginProducts::get();

        if($list){
            foreach ($list as $item){
                $cont = \DB::connection('mysql_temp')
                    ->table('product_images')
                    ->where("product_id", $item->old_id)
                    ->count();

                if($cont == 0){
                    $cont2 = PluginProductsImages::where("product_id", $item->id)->count();
                    if($cont2 > 0){
                        $this->info("Prodotto OLD ID $item->old_id ($item->sku) ha $cont foto sul vecchio db MA HA $cont2 sul nuovo");
                        PluginProductsImages::where("product_id", $item->id)->forceDelete();
                    }
                }
            }
        }
    }
}
