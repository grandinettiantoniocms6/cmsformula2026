<?php

namespace App\Console\Commands;

use App\Models\PluginProducts;
use App\Models\PluginProductsAttachments;
use App\Models\PluginProductsAttributes;
use App\Models\PluginProductsCategories;
use App\Models\PluginProductsImages;
use App\Models\PluginProductsOptions;
use App\Models\PluginProductsRelated;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

class ImportSaviplast extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:saviplast';

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
        $noAttribute = [2,3,9,10,39];

        /*PluginProductsAttributes::truncate();
        PluginProducts::truncate();
        PluginProductsImages::truncate();
        PluginProductsAttachments::truncate();
        PluginProductsRelated::truncate();
        PluginProductsOptions::truncate();*/

        /*$list = \DB::connection('mysql_temp')->table('proprieta')->whereNotIn("id", $noAttribute)->get();
        if($list){
            foreach ($list as $item){
                $vet = [];
                $vet["it"] = $item->nome__it;
                $vet["en"] = $item->nome__en;

                $check = PluginProductsAttributes::where("old_id", $item->id)->first();
                if(!$check){
                    \DB::table("plugins_products_attributes")->insert([
                        "name" => json_encode($vet),
                        "old_id" => $item->id,
                        "created_at" => Carbon::now()->toDateTimeString()
                    ]);
                    $this->info("attributo $item->nome__it");
                }
            }
        }

        $list = \DB::connection('mysql_temp')->table('categorie')->get();
        if($list){
            foreach ($list as $item){
                $vet = [];
                $vet["it"] = $item->nome__it;
                $vet["en"] = $item->nome__en;

                $vetCat = [];
                $vetCat["it"] = Str::slug($item->nome__it, '-');
                $vetCat["en"] = Str::slug($item->nome__en, '-');

                $check = PluginProductsCategories::where("old_id", $item->id)->first();
                if(!$check){

                    $parent_id = null;
                    if($item->padre != 0){
                        $itemCat = PluginProductsCategories::where("old_id", $item->padre)->first();
                        if($itemCat){
                            $parent_id = $itemCat->id;
                        }
                    }

                    \DB::table("plugins_products_categories")->insert([
                        "name" => json_encode($vet),
                        "slug" => json_encode($vetCat),
                        "parent_id" => $parent_id,
                        "is_active" => 1,
                        "old_id" => $item->id,
                        "created_at" => Carbon::now()->toDateTimeString()
                    ]);
                    $this->info("categoria $item->nome__it");
                }
            }
        }*/


        $list = \DB::connection('mysql_temp')->table('prodotti')
            ->where("codice", "SAV.BFM.30")
            ->get();
        if($list){
            foreach ($list as $item){
                $vet = [];
                $vet["it"] = $item->nome__it;
                $vet["en"] = $item->nome__en;

                $vet_description = [];
                $vet_description["it"] = $item->descrizione__it;
                $vet_description["en"] = $item->descrizione__en;

                $vet_tags = [];
                $vet_tags["it"] = $item->tags;
                $vet_tags["en"] = $item->tags;

                $check = PluginProducts::where("old_id", $item->id)->first();
                if(!$check){
                    $category = PluginProductsCategories::where("old_id", $item->id_categoria)->first();

                    $vet_seo = [];
                    $seo = \DB::connection('mysql_temp')->table('prodotti_seo')->where("reference", $item->codice)->where("language", "it")->first();
                    if($seo){
                        $vet_seo["it"] = $seo->seo_uri;
                    }else{
                        $vet_seo["it"] = Str::slug($item->nome__it, '-');
                    }

                    $seo = \DB::connection('mysql_temp')->table('prodotti_seo')->where("reference", $item->codice)->where("language", "en")->first();
                    if($seo){
                        $vet_seo["en"] = $seo->seo_uri;
                    }else{
                        $vet_seo["en"] = Str::slug($item->nome__en, '-');
                    }

                    \DB::table("plugins_products")->insert([
                        "name" => json_encode($vet),
                        "meta_title" => json_encode($vet),
                        "slug" => json_encode($vet_seo),
                        "sku" => $item->codice,
                        "brand_id" => null,
                        "category_id" => $category ? $category->id : null,
                        "description" => json_encode($vet_description),
                        "tags" => json_encode($vet_tags),
                        "old_id" => $item->id,
                        "is_active" => $item->attivo,
                        "is_evidenza" => $item->evidenza,
                        "created_at" => Carbon::now()->toDateTimeString()
                    ]);

                    $product = PluginProducts::where("sku", $item->codice)->first();
                    if($product){

                        //ALLEGATI
                        $attachments = \DB::connection('mysql_temp')->table('prodotti_allegati')->where("id_prodotto", $item->id)->get();
                        if($attachments) {
                            PluginProductsAttachments::where("product_id", $product->id)->delete();

                            foreach ($attachments as $p) {
                                $vet_value = [];
                                $vet_value["it"] = $p->nome;
                                $vet_value["en"] = $p->nome;

                                $itemA = PluginProducts::where("old_id", $p->id_prodotto)->first();
                                if($itemA){
                                    \DB::table("plugins_products_attachments")->insert([
                                        "product_id" => $product->id,
                                        "name" => json_encode($vet_value),
                                        "file" => trim(str_replace("uploads/", "", $p->file)),
                                        "created_at" => Carbon::now()->toDateTimeString()
                                    ]);
                                }
                            }
                        }


                        //FOTO

                        if(trim($item->foto1) != ""){
                            $check = PluginProductsImages::where("product_id", $product->id)->where("image", $item->foto1)->first();
                            if(!$check){
                                $f = trim(str_replace("uploads/", "", $item->foto1));
                                $url = "https://new.saviplast.com/uploads/products/$f";
                                $fileget = @file_get_contents($url);

                                if ($fileget === false) {
                                    $basename = basename($f);
                                    $temp = explode(".", $basename);

                                    $url = "https://new.saviplast.com/uploads/products/prodotti/$temp[0]-zoom.$temp[1]";
                                    $fileget = @file_get_contents($url);
                                    if($fileget){
                                        $f = "prodotti/$temp[0]-zoom.$temp[1]";
                                    }
                                }

                                PluginProductsImages::insert([
                                    "product_id" => $product->id,
                                    "image" => $f,
                                    "order" => 0,
                                    "created_at" => Carbon::now()->toDateTimeString()
                                ]);
                            }
                        }


                        if(trim($item->foto2) != ""){
                            $check = PluginProductsImages::where("product_id", $product->id)->where("image", $item->foto2)->first();
                            if(!$check){
                                $f = trim(str_replace("uploads/", "", $item->foto2));
                                $url = "https://new.saviplast.com/uploads/products/$f";
                                $fileget = @file_get_contents($url);

                                if ($fileget === false) {
                                    $basename = basename($f);
                                    $temp = explode(".", $basename);

                                    $url = "https://new.saviplast.com/uploads/products/prodotti/$temp[0]-zoom.$temp[1]";
                                    $fileget = @file_get_contents($url);
                                    if($fileget){
                                        $f = "prodotti/$temp[0]-zoom.$temp[1]";
                                    }
                                }

                                PluginProductsImages::insert([
                                    "product_id" => $product->id,
                                    "image" => $f,
                                    "order" => 1,
                                    "created_at" => Carbon::now()->toDateTimeString()
                                ]);
                            }
                        }

                        if(trim($item->foto3) != ""){
                            $check = PluginProductsImages::where("product_id", $product->id)->where("image", $item->foto3)->first();
                            if(!$check){
                                $f = trim(str_replace("uploads/", "", $item->foto3));
                                $url = "https://new.saviplast.com/uploads/products/$f";
                                $fileget = @file_get_contents($url);

                                if ($fileget === false) {
                                    $basename = basename($f);
                                    $temp = explode(".", $basename);

                                    $url = "https://new.saviplast.com/uploads/products/prodotti/$temp[0]-zoom.$temp[1]";
                                    $fileget = @file_get_contents($url);
                                    if($fileget){
                                        $f = "prodotti/$temp[0]-zoom.$temp[1]";
                                    }
                                }

                                PluginProductsImages::insert([
                                    "product_id" => $product->id,
                                    "image" => $f,
                                    "order" => 2,
                                    "created_at" => Carbon::now()->toDateTimeString()
                                ]);
                            }
                        }

                        if(trim($item->foto4) != ""){
                            $check = PluginProductsImages::where("product_id", $product->id)->where("image", $item->foto4)->first();
                            if(!$check){
                                $f = trim(str_replace("uploads/", "", $item->foto4));
                                $url = "https://new.saviplast.com/uploads/products/$f";
                                $fileget = @file_get_contents($url);

                                if ($fileget === false) {
                                    $basename = basename($f);
                                    $temp = explode(".", $basename);

                                    $url = "https://new.saviplast.com/uploads/products/prodotti/$temp[0]-zoom.$temp[1]";
                                    $fileget = @file_get_contents($url);
                                    if($fileget){
                                        $f = "prodotti/$temp[0]-zoom.$temp[1]";
                                    }
                                }

                                PluginProductsImages::insert([
                                    "product_id" => $product->id,
                                    "image" => $f,
                                    "order" => 3,
                                    "created_at" => Carbon::now()->toDateTimeString()
                                ]);
                            }
                        }

                        //PROPRIETA
                        $proprietes = \DB::connection('mysql_temp')->table('prodotti_proprieta')->where("id_prodotto", $item->id)->get();
                        if($proprietes){
                            PluginProductsOptions::where("product_id", $product->id)->delete();

                            foreach ($proprietes as $p){
                                $itemA = PluginProductsAttributes::where("old_id", $p->id_proprieta)->first();
                                if($itemA){
                                    $vet_value = [];
                                    $vet_value["it"] = utf8_decode($p->valore__it);
                                    $vet_value["en"] = utf8_decode($p->valore__en);

                                    \DB::table("plugins_products_options")->insert([
                                        "product_id" => $product->id,
                                        "attribute_id" => $itemA->id,
                                        "value" => json_encode($vet_value),
                                        "created_at" => Carbon::now()->toDateTimeString()
                                    ]);
                                }
                            }
                        }
                    }

                    $this->info("prodotto $item->nome__it");
                }else{
                    $proprietes = \DB::connection('mysql_temp')->table('prodotti_proprieta')->where("id_prodotto", $item->id)->get();
                    if($proprietes){
                        PluginProductsOptions::where("product_id", $check->id)->delete();

                        foreach ($proprietes as $p){
                            $itemA = PluginProductsAttributes::where("old_id", $p->id_proprieta)->first();
                            if($itemA){
                                $vet_value = [];
                                $vet_value["it"] = utf8_decode($p->valore__it);
                                $vet_value["en"] = utf8_decode($p->valore__en);

                                \DB::table("plugins_products_options")->insert([
                                    "product_id" => $check->id,
                                    "attribute_id" => $itemA->id,
                                    "value" => json_encode($vet_value),
                                    "created_at" => Carbon::now()->toDateTimeString()
                                ]);
                            }
                        }
                    }

                    $this->info("edit prodotto $item->nome__it");
                }
            }
        }

        //ASSOCIAZIONI
        /*$relations = \DB::connection('mysql_temp')->table('prodotti_associazioni')->get();
        if($relations){
            foreach ($relations as $r){
                PluginProductsRelated::where("product_id", $r->id_prodotto);
                $itemP = PluginProducts::where("old_id", $r->id_prodotto)->first();
                $itemA = PluginProducts::where("old_id", $r->id_associato)->first();
                if($itemA && $itemP){
                    \DB::table("plugins_products_related")->insert([
                        "product_id" => $itemP->id,
                        "product_related_id" => $itemA->id,
                        "created_at" => Carbon::now()->toDateTimeString()
                    ]);
                }
            }
        }*/

    }
}
