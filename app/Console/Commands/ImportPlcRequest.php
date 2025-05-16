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
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ImportPlcRequest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:plc_request';

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
      \DB::table("plugins_products_requests")->truncate();

        $list = \DB::connection('mysql_temp')
            ->table('products_requests')
            ->get();

        if($list){
            foreach ($list as $item){
                $product =  \DB::table("plugins_products")->where("old_id", $item->product_id)->first();

                $vet = [];
                $vet["nome"] = $item->name;
                $vet["email"] = $item->email;
                $vet["telefono"] = $item->mobile;
                $vet["oggetto"] = $item->message;
                $vet["prodotto"] = $product ? $product->sku : null;

                \DB::table("plugins_products_requests")->insert([
                    "product_id" => $product ? $product->id : null,
                    "email" => $item->email,
                    "object" => $item->object,
                    "content" => json_encode($vet),
                    "is_done" => 1,
                    "is_read" => 1,
                    "created_at" => $item->created_at
                ]);

                $this->info("request $item->id");
            }
        }

    }
}
