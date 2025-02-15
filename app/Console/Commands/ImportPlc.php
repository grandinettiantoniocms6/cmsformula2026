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

class ImportPlc extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:plc';

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
        PluginProductsLangs::truncate();
        ShopAttributesCategories::truncate();
        ShopAttributesOptions::truncate();
        ShopAttributesProducts::truncate();
        ShopAttributes::truncate();
        ShopAttributes::create([
            "name" => "Tipologia"
        ]);

        ShopAttributesOptions::create([
            "shop_attribute_id" => 1,
            "value" => "Nuovo"
        ]);

        ShopAttributesOptions::create([
            "shop_attribute_id" => 1,
            "value" => "Ricondizionato"
        ]);

        ShopAttributesOptions::create([
            "shop_attribute_id" => 1,
            "value" => "Riparazione"
        ]);

        PluginProductsBrands::truncate();
        PluginProductsCategories::truncate();
        PluginProductsCategoriesProducts::truncate();
        PluginProducts::truncate();


        $list = \DB::connection('mysql_temp')->table('categories')
            ->get();

        if($list){
            foreach ($list as $item){
                $vet = json_decode($item->name, true);
                $vet_description = json_decode($item->description, true);
                $vet_slug = json_decode($item->slug, true);


                \DB::table("plugins_products_categories")->insert([
                    "name" => json_encode($vet),
                    "description" => json_encode($vet_description),
                    "slug" => json_encode($vet_slug),
                    "parent_id" => $item->parent_id == 0 ? null : $item->parent_id,
                    "lft" => $item->lft,
                    "rgt" => $item->rgt,
                    "depth" => $item->depth,
                    "old_id" => $item->id,
                    "is_active" => $item->is_active,
                    "is_purchasable" => 1,
                    "created_at" => Carbon::now()->toDateTimeString()
                ]);

                $this->info("categoria $item->name");
            }
        }


        $list = \DB::connection('mysql_temp')->table('brands')
            ->get();

        if($list){
            foreach ($list as $item){
                $vet = [];
                $vet["it"] = $item->name;

                $vet_slug = [];
                $vet_slug["it"] = $item->slug;

                \DB::table("plugins_products_brands")->insert([
                    "name" => json_encode($vet),
                    "slug" => json_encode($vet_slug),
                    "old_id" => $item->id,
                    "is_active" => 1,
                    "is_purchasable" => 0,
                    "created_at" => Carbon::now()->toDateTimeString()
                ]);

                $this->info("brand $item->name");
            }
        }


        $list = \DB::connection('mysql_temp')->table('products')
            //->whereRaw("sku LIKE '%6SE6440%'")
            ->get();
        if($list){
            foreach ($list as $item){
                $vet = json_decode($item->name, true);
                $vet_description = json_decode($item->description, true);
                $vet_slug = json_decode($item->slug, true);

                $brand = PluginProductsBrands::where("old_id", $item->brand_id)->first();


                \DB::table("plugins_products")->insert([
                    "name" => json_encode($vet),
                    "description" => json_encode($vet_description),
                    "sku" => $item->sku,
                    "slug" => json_encode($vet_slug),
                    "brand_id" => $brand ? $brand->id : null,
                    "old_id" => $item->id,
                    "is_active" => $item->active,
                    "is_purchasable" => 0,
                    "group_id" => $item->group_id,
                    "is_variant" => $item->is_variant,
                    "qty" => $item->stock,
                    "price" => 1, //$item->price,
                    "tax_id" => 2, //22%
                    "created_at" => Carbon::now()->toDateTimeString()
                ]);

                $this->info("prodotto $item->sku");

                $product = PluginProducts::where("sku", $item->sku)->first();


                if($product){

                    $category_product = \DB::connection('mysql_temp')->table('category_product')
                        ->where("product_id", $item->id)
                        ->get();
                    if($category_product){
                        foreach ($category_product as $cp){
                            $category = PluginProductsCategories::where("old_id", $cp->category_id)->first();

                            PluginProductsCategoriesProducts::insert([
                                "plugin_product_category_id" => $category->id,
                                "plugin_product_product_id" => $product->id
                            ]);

                            $check = ShopAttributesCategories::where("shop_attribute_id", 1)->where("shop_category_id", $category->id)->first();
                            if(!$check){
                                ShopAttributesCategories::create([
                                    "shop_attribute_id" => 1,
                                    "shop_category_id" => $category->id,
                                ]);
                            }

                            $this->info("---category $category->name");
                        }
                    }

                    $temp_sku = explode("-", $item->sku);

                    if(key_exists(1, $temp_sku)){
                        if($temp_sku[1] == "N"){
                            ShopAttributesProducts::create([
                                "attribute_id" => 1,
                                "option_id" => 1,
                                "product_id" => $product->id
                            ]);

                            $product->options = '[{"option_id":"1"}]';
                            $product->save();
                        }

                        if($temp_sku[1] == "U"){
                            ShopAttributesProducts::create([
                                "attribute_id" => 1,
                                "option_id" => 2,
                                "product_id" => $product->id
                            ]);

                            $product->options = '[{"option_id":"2"}]';
                            $product->save();
                        }

                        if($temp_sku[1] == "R"){
                            ShopAttributesProducts::create([
                                "attribute_id" => 1,
                                "option_id" => 3,
                                "product_id" => $product->id
                            ]);

                            $product->options = '[{"option_id":"3"}]';
                            $product->save();
                        }
                    }

                    PluginProductsLangs::create([
                        "product_id" => $product->id,
                        "lang" => "it",
                        "is_active" => 1
                    ]);

                    $images = \DB::connection('mysql_temp')->table('product_images')
                        ->where("product_id", $item->id)
                        ->get();
                    if($images) {
                        foreach ($images as $image) {
                            /*$url = "https://www.plcshop.it/uploads/products/$image->name";

                            $file_data = file_get_contents( $url, false, stream_context_create( [
                                'ssl' => [
                                    'verify_peer'      => false,
                                    'verify_peer_name' => false,
                                ],
                            ] ) );

                            if($file_data){
                                $basename = basename($image->name);

                                $img = \Image::make($file_data)->encode('webp', 60);
                                $img->save(public_path("uploads/products/$basename"));

                                PluginProductsImages::create([
                                    "product_id" => $product->id,
                                    "image" => $basename
                                ]);
                            }*/

                            $this->info("IMAGE: uploads/products/$image->name");

                            \DB::table("plugins_products_images")->insert([
                                "product_id" => $product->id,
                                "image" => "uploads/products/$image->name"
                            ]);


                            //https://www.plcshop.it/uploads/products/790/6SE6440-2UD31-1CA1-1506346354-1560356628.jpg
                        }
                    }
                }
            }
        }
    }
}
