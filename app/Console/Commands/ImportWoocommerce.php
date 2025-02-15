<?php

namespace App\Console\Commands;

use App\Models\PluginProducts;
use App\Models\PluginProductsAttachments;
use App\Models\PluginProductsAttributes;
use App\Models\PluginProductsBrands;
use App\Models\PluginProductsCategories;
use App\Models\PluginProductsCategoriesProducts;
use App\Models\PluginProductsImages;
use App\Models\PluginProductsOptions;
use App\Models\PluginProductsRelated;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

class ImportWoocommerce extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:woocommerce';

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
        /*PluginProductsAttributes::truncate();
        PluginProducts::truncate();
        PluginProductsImages::truncate();
        PluginProductsAttachments::truncate();
        PluginProductsRelated::truncate();
        PluginProductsOptions::truncate();
        PluginProductsCategoriesProducts::truncate();*/
        //PluginProductsBrands::truncate();

        /*$categories = \DB::connection('mysql_temp')
            ->table('wp_term_taxonomy')
            ->where("taxonomy", "product_cat")
            ->get();
        if($categories){
            foreach ($categories as $category){
                $term = \DB::connection('mysql_temp')
                    ->table('wp_terms')
                    ->where("term_id", $category->term_id)
                    ->first();

                if($term){
                    if(is_numeric(strpos($term->name, '[:en]'))){
                        $term->name = trim(str_replace("[:]", "", $term->name));
                        $term->name = trim(str_replace("[:en]", "", $term->name));
                        $term->name = trim(str_replace("[:it]", ",", $term->name));

                        $temp_name = explode(",", $term->name);

                        $vet = [];
                        $vet["it"] = $temp_name[1];
                        $vet["en"] = $temp_name[0];

                        $vetSlug = [];
                        $vetSlug["it"] = \Str::slug($temp_name[1]);
                        $vetSlug["en"] = \Str::slug($temp_name[0]);
                    }else{
                        $vet = [];
                        $vet["it"] = $term->name;
                        $vet["en"] = $term->name;

                        $vetSlug = [];
                        $vetSlug["it"] = \Str::slug("{$term->name}-it");
                        $vetSlug["en"] = \Str::slug("{$term->name}-en");
                    }

                    $check = \DB::table("plugins_products_categories")->where("old_id", $term->term_id)->first();
                    if(!$check){
                        \DB::table("plugins_products_categories")->insert([
                            "name" => json_encode($vet),
                            "slug" => json_encode($vetSlug),
                            "is_active" => 1,
                            "is_purchasable" => 1,
                            "old_id" => $term->term_id,
                            "parent_id" => 20
                        ]);

                        $this->info($term->name);
                    }
                }
            }
        }*/

        $list = \DB::connection('mysql_temp')
            ->table('wp_posts')
            ->where("post_type", "product")
            ->where("ID", 13154)
            ->where("post_status", "publish")
            ->get();

        if($list){
            foreach ($list as $item){
                $vet = [];
                $vet["it"] = $item->post_title;
                $vet["en"] = $item->post_title;

                $vet_description = [];
                $vet_description["it"] = $item->post_content;
                $vet_description["en"] = $item->post_content;

                //.$item->post_excerpt

                $vet_seo = [];
                $vet_seo["it"] = $item->post_name;
                $vet_seo["en"] = $item->post_name;

                $post_meta_attributes = \DB::connection('mysql_temp')
                    ->table('wp_postmeta')
                    ->where("meta_key", "_product_attributes")
                    ->where("post_id", $item->ID)
                    ->first();

                $post_meta_general_price = \DB::connection('mysql_temp')
                    ->table('wp_postmeta')
                    ->where("post_id", $item->ID)
                    ->where("meta_key", "_regular_price")
                    ->first();

                $post_meta_general_price_sale = \DB::connection('mysql_temp')
                    ->table('wp_postmeta')
                    ->where("post_id", $item->ID)
                    ->where("meta_key", "_sale_price")
                    ->first();


                $other = \DB::connection('mysql_temp')
                    ->table('wp_wc_product_meta_lookup')
                    ->where("product_id", $item->ID)
                    ->first();

                if(!$other){
                    continue;
                }

                $sku = $other->sku;
                $price = $post_meta_general_price->meta_value;

                dd($price);
                $active =  $other->onsale;
                $qty = 1; //(int) $other->stock_quantity;

                $product = PluginProducts::where("old_id", $item->ID)->first();
                if(!$product){

                    $group = PluginProducts::whereNotNull("group_id")->orderBy("group_id", "desc")->first();
                    if($group){
                        $group_id = $group->group_id + 1;
                    }else{
                        $group_id = 1;
                    }

                    \DB::table("plugins_products")->insert([
                        "name" => json_encode($vet),
                        "meta_title" => json_encode($vet),
                        "slug" => json_encode($vet_seo),
                        "tax_id" => 1,
                        "sku" => $sku,
                        "brand_id" => null,
                        "price" => round($price /1.22,1),
                        "qty" => $qty,
                        "description" => json_encode($vet_description),
                        "old_id" => $item->ID,
                        "is_active" => $active,
                        "is_purchasable" => 1,
                        "is_variant" => 0,
                        "group_id" => $group_id,
                        "created_at" => Carbon::now()->toDateTimeString()
                    ]);

                    $product = PluginProducts::where("old_id", $item->ID)->first();
                }

                $this->info("PRODUCT($item->ID): $product->name");

                if($post_meta_general_price_sale) {
                    if ($post_meta_general_price->meta_value > $post_meta_general_price_sale->meta_value) {
                        $product->promo_price = round($post_meta_general_price_sale->meta_value / 1.22, 1);
                        $product->data_promo_start = Carbon::now()->toDateString();
                        $product->data_promo_end = Carbon::now()->addYears(10)->toDateString();
                        $product->hidden_promo_countdown = 1;
                        $product->save();
                    }
                }

                //categorie
                \DB::table("plugins_products_categories_products")->where("plugin_product_product_id", $product->id)->delete();
                $categories_product = \DB::connection('mysql_temp')
                    ->table('wp_term_relationships')
                    ->where("object_id", $item->ID)
                    ->get();

                if(count($categories_product)){
                    foreach ($categories_product as $cp){
                        $ter_tax = \DB::connection('mysql_temp')
                            ->table('wp_term_taxonomy')
                            ->where("term_id", $cp->term_taxonomy_id)
                            ->first();
                        $this->info("TAXONOMY $ter_tax->taxonomy");

                        if($ter_tax->taxonomy == "brand"){
                            $brand = \DB::connection('mysql_temp')
                                ->table('wp_terms')
                                ->where("term_id", $ter_tax->term_id)
                                ->first();

                            $check = PluginProductsBrands::whereRaw("name LIKE '%$brand->name%'")->first();
                            if(!$check){
                                \DB::table("plugins_products_brands")->insert([
                                    "name" => json_encode(["it" => $brand->name, "en" => $brand->name]),
                                    "slug" => json_encode(["it" => $brand->slug, "en" => $brand->slug]),
                                    "is_active" => 1
                                ]);

                                $check = PluginProductsBrands::where("name", $brand->name)->first();
                            }

                            if($check) {
                                $product->brand_id = $check->id;
                                $product->save();
                                $this->info("BRAND $check->name");
                            }

                        }


                        $category = PluginProductsCategories::where("old_id", $cp->term_taxonomy_id)->first();
                        if($category){
                            \DB::table("plugins_products_categories_products")->insert([
                                "plugin_product_product_id" => $product->id,
                                "plugin_product_category_id" => $category->id
                            ]);

                            $this->info("----- PRODUCT CATEGORY: $category->name");
                        }
                    }
                }

                //image
                PluginProductsImages::where("product_id", $product->id)->delete();

                $post_meta = \DB::connection('mysql_temp')
                    ->table('wp_postmeta')
                    ->where("meta_key", "_thumbnail_id")
                    ->where("post_id", $item->ID)
                    ->get();
                if(count($post_meta)) {
                    $contImage = 0;
                    foreach ($post_meta as $pM){
                        $image = \DB::connection('mysql_temp')
                            ->table('wp_postmeta')
                            ->where('meta_key', '_wp_attached_file')
                            ->where("post_id", $pM->meta_value)
                            ->first();

                        if($image){
                            PluginProductsImages::insert([
                                "product_id" => $product->id,
                                "image" => "uploads/products/wp-content/$image->meta_value",
                                "order" => $contImage,
                                "created_at" => Carbon::now()->toDateTimeString()
                            ]);

                            $this->info("----- PRODUCT IMAGE: $image->meta_value");
                            $contImage++;
                        }
                    }
                }

                $post_meta = \DB::connection('mysql_temp')
                    ->table('wp_postmeta')
                    ->where("meta_key", "_product_image_gallery")
                    ->where("post_id", $item->ID)
                    ->get();
                if(count($post_meta)) {
                    $contImage = 1;
                    foreach ($post_meta as $pM){
                        $image = \DB::connection('mysql_temp')
                            ->table('wp_postmeta')
                            ->where('meta_key', '_wp_attached_file')
                            ->where("post_id", $pM->meta_value)
                            ->first();

                        if($image){
                            PluginProductsImages::insert([
                                "product_id" => $product->id,
                                "image" => "uploads/products/wp-content/$image->meta_value",
                                "order" => $contImage,
                                "created_at" => Carbon::now()->toDateTimeString()
                            ]);

                            $this->info("----- PRODUCT IMAGE: $image->meta_value");
                            $contImage++;
                        }
                    }

                }

                //proprieta
                if($post_meta_attributes){

                    $string = $post_meta_attributes->meta_value;
                    $v_attr = unserialize($string);


                    if(count($v_attr)){
                        foreach ($v_attr as $k=> $vet){
                            if($vet['is_visible'] == 0){
                                continue;
                            }
                            $ter_tax = \DB::connection('mysql_temp')
                                ->table('wp_term_taxonomy')
                                ->where("taxonomy", $k)
                                ->first();

                            $ttt = explode("_", $k);

                            if(!key_exists(1, $ttt)){
                                continue;
                            }

                            $old_attribute = \DB::connection('mysql_temp')
                                ->table('wp_woocommerce_attribute_taxonomies')
                                ->where("attribute_name", $ttt[1])
                                ->first();



                            if($old_attribute){
                                if(is_numeric(strpos($old_attribute->attribute_label, '[:en]'))){
                                    $old_attribute->attribute_label = trim(str_replace("[:]", "",  $old_attribute->attribute_label));
                                    $old_attribute->attribute_label = trim(str_replace("[:en]", "",  $old_attribute->attribute_label));
                                    $old_attribute->attribute_label = trim(str_replace("[:it]", ",",  $old_attribute->attribute_label));

                                    $temp_name = explode(",",  $old_attribute->attribute_label);

                                    $vet = [];
                                    $vet["it"] = $temp_name[1];
                                    $vet["en"] = $temp_name[0];
                                }else{
                                    $vet = [];
                                    $vet["it"] = $old_attribute->attribute_label;
                                    $vet["en"] = $old_attribute->attribute_label;
                                }
                                $check = PluginProductsAttributes::where("old_id", $old_attribute->attribute_id)->first();
                                if(!$check) {
                                    \DB::table("plugins_products_attributes")->insert([
                                        "name" => json_encode($vet),
                                        "old_id" => $old_attribute->attribute_id
                                    ]);

                                    $this->info("ATTRIBUTO $old_attribute->attribute_label");

                                    $check = PluginProductsAttributes::where("old_id", $old_attribute->attribute_id)->first();
                                }

                                if($ter_tax){
                                    $option = \DB::connection('mysql_temp')
                                        ->table('wp_terms')
                                        ->where("term_id", $ter_tax->term_id)
                                        ->first();


                                    if($option){
                                        if(is_numeric(strpos($option->name, '[:en]'))){
                                            $option->name = trim(str_replace("[:]", "",  $option->name));
                                            $option->name = trim(str_replace("[:en]", "",  $option->name));
                                            $option->name = trim(str_replace("[:it]", ",",  $option->name));

                                            $temp_name = explode(",",  $option->name);

                                            $vet = [];
                                            $vet["it"] = $temp_name[1];
                                            $vet["en"] = $temp_name[0];
                                        }else{
                                            $vet = [];
                                            $vet["it"] = $option->name;
                                            $vet["en"] = $option->name;
                                        }

                                        PluginProductsOptions::insert([
                                            "product_id" => $product->id,
                                            "attribute_id" => $check->id,
                                            "value" => json_encode($vet)
                                        ]);

                                        $this->info("OPZIONE $option->name");
                                    }
                                }

                            }
                        }
                    }
                }
            }
        }
        die;


    }
}
