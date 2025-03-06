<?php

namespace App\Console\Commands;

use App\Models\PluginProducts;
use App\Models\PluginProductsCategoriesProducts;
use App\Models\PluginProductsImages;
use App\Models\PluginProductsLangs;
use App\Models\PluginProductsSearch;
use App\Models\ShopAttributes;
use App\Models\ShopAttributesProducts;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class SetProductsSearch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'set:products_search {id}';

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

        $id = $this->argument('id');

        $shopSetting = \App\Models\ShopSettings::first();

        if($id == 0){
            PluginProductsSearch::truncate();
            $list = PluginProducts::with("tax")->selectRaw("plugins_products.*")
                ->where("plugins_products.is_active", 1)
                ->get();
        }else{
            PluginProductsSearch::where("plugin_product_id", $id)->delete();
            $list = PluginProducts::with("tax")->selectRaw("plugins_products.*")
                ->where("plugins_products.is_active", 1)
                ->where("id", $id)
                ->get();
       }

       if($list){
           foreach ($list as $item){
               $brands = [];
               $tags = [];
               $attributes = [];
               $options = [];

                $categories = PluginProductsCategoriesProducts::where("plugin_product_product_id", $item->id)
                    ->pluck("plugin_product_category_id", "plugin_product_category_id")
                    ->toArray();

                $langs = PluginProductsLangs::where("product_id", $item->id)
                   ->where("is_active", 1)
                   ->pluck("lang", "lang")
                   ->toArray();

               $brands[] = $item->brand_id;
               $tags[] = $item->tags;

               $attributes_shop = ShopAttributesProducts::where("product_id", "=", $item->id)
                   ->get();

               if($attributes_shop){
                   foreach ($attributes_shop as $attr){
                       if(key_exists($attr->attribute_id, $attributes)){
                           $attributes[$attr->attribute_id][] = $attr->option_id;
                       }else{
                           $attributes[$attr->attribute_id] = [];
                           $attributes[$attr->attribute_id][] = $attr->option_id;
                       }

                       $options[$attr->option_id] = $attr->option_id;
                   }
               }

               if(env('VIEW_WITH_IVA') == 1){
                   $vat = $item->tax ? $item->tax->value : 22;
                   $vat_calculate = ($vat / 100) + 1;
                   $promo_price = $item->price * $vat_calculate;
               }else{
                   $promo_price = $item->price;
               }

               $vet_ids = null;
               if($item->is_variant == 0){
                   $vet_ids = $item->get_vet_ids_search($shopSetting);
                   $encode = json_encode($vet_ids);
                   $this->info("json $encode");
               }

               PluginProductsSearch::create([
                   "plugin_product_id" => $item->id,
                   "categories" => ','.implode(",", $categories).',',
                   "langs" => ','.implode(",", $langs).',',
                   "brands" => ','.implode(",", $brands).',',
                   "tags" => ','.implode(",", $tags).',',
                   "attributes" => count($attributes) ? json_encode($attributes) : null,
                   "options" => ','.implode(",", $options).',',
                   "price" => $promo_price,
                   "group_id" => $item->group_id,
                   "is_variant" => $item->is_variant,
                   "is_active" => $item->is_active,
                   "vet_ids_list" => json_encode($vet_ids)

               ]);

               $this->info("product $item->id");

           }
       }
    }
}
