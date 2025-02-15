<?php

namespace App\Console\Commands;

use App\Models\PluginProducts;
use App\Models\PluginProductsImages;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class ChangePriceMassive extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'change:price';

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
       $list =  \DB::select("SELECT plugins_products.id, shop_taxes.value as tax, sku, price, (price * ((shop_taxes.value / 100)+1)) as calc, round((price * ((shop_taxes.value / 100)+1)),3) as tot FROM `plugins_products` JOIN shop_taxes ON shop_taxes.id = plugins_products.tax_id");
       if($list){
           foreach ($list as $item){
               try{
                   $product = PluginProducts::find($item->id);
                   if(!$product){
                       continue;
                   }

                   $temp = explode(".", $item->tot);
                   if(key_exists(1, $temp)){

                       if(strlen($temp[1]) == 3){
                           $final = (float) "{$temp[0]}.{$temp[1][0]}{$temp[1][1]}";

                           $vat = ($item->tax / 100) + 1;

                           $price_no_vat = $final / $vat;

                           $temp_2 = explode(".", $price_no_vat);

                           $terza_cifra = (int) $temp_2[1][2] + 1;
                           $keivan = "{$temp_2[0]}.{$temp_2[1][0]}{$temp_2[1][1]}{$terza_cifra}";

                           $start = round($item->price * $vat,2);
                           $end = round($keivan * $vat,2);

                           $product->price = $keivan;
                           $product->save();

                           $this->info("3 CIFRE--- $item->sku nel DB sta $item->price ($start) però deve stare $keivan ($end)");
                       }

                       if(strlen($temp[1]) == 2){
                           $seconda_cifra = (int) $temp[1][1] - 1;
                           $final = (float) "{$temp[0]}.{$temp[1][0]}{$seconda_cifra}";

                           $vat = ($item->tax / 100) + 1;
                           $price_no_vat = $final / $vat;

                           $temp_2 = explode(".", $price_no_vat);

                           if(strlen($temp_2[1]) == 1){
                               $keivan = "{$temp_2[0]}.{$temp_2[1][0]}";
                           }else{
                               $keivan = "{$temp_2[0]}.{$temp_2[1][0]}{$temp_2[1][1]}";
                           }

                           $start = round($item->price * $vat,2);
                           $end = round($keivan * $vat,2);

                           $product->price = $keivan;
                           $product->save();

                           $this->info("2 CIFRE $vat--- $item->sku nel DB sta $item->price ($start) però deve stare $keivan ($end)");
                       }
                   }
               } catch (Throwable $e) {
                   $this->info("ERRORRR $item->sku");
               }



           }
       }
    }
}
