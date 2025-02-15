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

class ImportEditWoocommerce extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:edit_woocommerce';

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
        $list = \DB::connection('mysql_temp')
            ->table('wp_posts')
            ->where("post_type", "product")
            //->where("ID", 13154)
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

                $price = $post_meta_general_price->meta_value;

                $product = PluginProducts::where("old_id", $item->ID)->first();
                if($product){
                    $product->price = $price/1.22;
                    $product->save();

                    //proprieta
                    if($post_meta_attributes){

                        PluginProductsOptions::where("product_id", $product->id)->delete();

                        $string = $post_meta_attributes->meta_value;
                        $v_attr = unserialize($string);

                        if(count($v_attr)){
                            foreach ($v_attr as $k=> $vet){
                                if($vet['is_visible'] == 0){
                                    continue;
                                }

                                $rela = \DB::connection('mysql_temp')
                                    ->table('wp_term_relationships')
                                    ->where("object_id", $post_meta_attributes->post_id)
                                    ->get()->pluck('term_taxonomy_id')->toArray();

                                $ter_tax = \DB::connection('mysql_temp')
                                    ->table('wp_term_taxonomy')
                                    ->where("taxonomy", $k)
                                    ->whereIn("term_taxonomy_id", $rela)
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

                                            //$this->info("OPZIONE $option->name");
                                        }
                                    }
                                }
                            }
                        }
                    }
                    $this->info("PRODUCT($item->ID): $product->name");
                }
            }
        }
    }
}
