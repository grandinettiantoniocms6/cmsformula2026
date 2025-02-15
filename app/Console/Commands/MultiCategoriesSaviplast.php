<?php

namespace App\Console\Commands;

use App\Models\PluginProducts;
use App\Models\PluginProductsAttachments;
use App\Models\PluginProductsAttributes;
use App\Models\PluginProductsCategories;
use App\Models\PluginProductsCategoriesProducts;
use App\Models\PluginProductsImages;
use App\Models\PluginProductsOptions;
use App\Models\PluginProductsRelated;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

class MultiCategoriesSaviplast extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'multi_categories:saviplast';

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
        $products = PluginProducts::whereNotNull("category_id")->get();
        if($products){
            foreach ($products as $product){
                PluginProductsCategoriesProducts::where("plugin_product_product_id", $product->id)->delete();
                PluginProductsCategoriesProducts::insert([
                    "plugin_product_product_id" => $product->id,
                    "plugin_product_category_id" => $product->category_id,
                    "created_at" => Carbon::now()->toDateTimeString()
                ]);

                $product->category_id = null;
                $product->save();

                $this->info("ok categories $product->id");
            }
        }

    }
}
