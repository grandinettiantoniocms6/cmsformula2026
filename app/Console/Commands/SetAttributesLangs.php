<?php

namespace App\Console\Commands;

use App\Models\PluginProducts;
use App\Models\PluginProductsImages;
use App\Models\PluginProductsLangs;
use App\Models\ShopAttributes;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class SetAttributesLangs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'set:attributes_langs';

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
       $list = \DB::table("shop_attributes")->get();
       if($list){
           foreach ($list as $item){
               if($item->name[0] == "{"){
                 continue;
               }

               $vet_value = [];
               foreach ($langs as $lang){
                   $vet_value[$lang] = $item->name;
               }



               \DB::table("shop_attributes")->where("id", $item->id)->update([
                   "name" => json_encode($vet_value)
               ]);

               $this->info("$item->id $item->name");
           }
       }


        $list = \DB::table("shop_attributes_options")->get();
        if($list){
            foreach ($list as $item){
                if($item->value[0] == "{"){
                    continue;
                }

                $vet_value = [];
                foreach ($langs as $lang){
                    $vet_value[$lang] = $item->value;
                }

                \DB::table("shop_attributes_options")->where("id", $item->id)->update([
                    "value" => json_encode($vet_value)
                ]);

                $this->info("$item->id $item->value");
            }
        }
    }
}
