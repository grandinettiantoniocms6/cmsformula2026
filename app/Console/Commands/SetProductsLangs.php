<?php

namespace App\Console\Commands;

use App\Models\PluginProducts;
use App\Models\PluginProductsImages;
use App\Models\PluginProductsLangs;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class SetProductsLangs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'set:products_langs';

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

       $langs = \App\Models\AdminLanguage::where("is_active", 1)->get()->pluck("name", "name")->toArray();

       $list = PluginProducts::get();
       if($list){
           foreach ($list as $item){

               foreach ($langs as $lang){
                   $check = PluginProductsLangs::where("product_id", $item->id)->where("lang", $lang)->first();
                   if(!$check){
                       PluginProductsLangs::create([
                          "product_id" => $item->id,
                          "lang" => "$lang",
                          "is_active" => 1
                       ]);

                       $this->info("Product $item->id - $lang attivato a 1");
                   }
               }
           }
       }
    }
}
