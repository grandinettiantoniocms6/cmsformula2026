<?php

namespace App\Console\Commands;

use App\Models\PluginOrders;
use App\Models\PluginOrdersCategories;
use App\Models\PluginOrdersClients;
use App\Models\PluginOrdersDetail;
use App\Models\PluginOrdersProducts;
use App\Models\PluginOrdersStatuses;
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

class SendReminderRighetto extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:reminder_righetto';

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
        $now = Carbon::now()->toDateString();
        $orders = PluginOrders::where("date_delivery", ">=", $now)->orderBy("date_delivery", "asc")->orderBy("time_delivery", "asc")->take(50)->get();
        if($orders){
            $html = "<h1>Prossimi ordini da consegnare</h1><table class=''>";
            foreach ($orders as $order){
                $client = PluginOrdersClients::find($order->plugin_order_client_id);
                //$status = PluginOrdersStatuses::find($order->plugin_order_status_id);
                $details = PluginOrdersDetail::where("plugin_order_id", $order->id)->get();
                if($details){
                    $htmlDetail = "<strong>Dettaglio ordine</strong> <br><ul>";
                    foreach ($details as $detail){
                        $product = PluginOrdersProducts::find($detail->plugin_product_id);
                        if(!$product){
                            continue;
                        }

                        $category = PluginOrdersCategories::find($detail->plugin_category_id);
                        $htmlDetail .= "<li>$product->name ($category->name) - Qta: $detail->qty - Prezzo: $detail->price - Num: $detail->num</li>";
                    }
                    $htmlDetail .= "</ul>";
                }

                $date_it = Carbon::createFromFormat("Y-m-d", $order->date_delivery)->format("d/m/Y");
                if($order->time_delivery){
                    $time_it = Carbon::createFromFormat("H:i:s", $order->time_delivery)->format("H:i");
                    $date_it .= " ore $time_it";
                }

                $html .= "<tr><td><strong>Data consegna:</strong> $date_it</td><td> <strong>Cliente:</strong> $client->first_name $client->last_name ($client->mobile_1)</td></tr>";
                $html .= "<tr><td colspan='2'>
                            <p><strong>Totale:</strong> $order->total  <strong>Acconto:</strong> $order->acconto <br> <strong>Ritiro:</strong> $order->place_ritiro <strong>Indirizzo:</strong> $order->address</p>
                            <strong>Note</strong> <br>$order->note
                            $htmlDetail
                            <hr>
                            </td></tr>";

            }
            $html .= "</table>";
        }

        $destinatario = "cristiana.righetto@gmail.com";
        \Mail::send("common.emails.reminderOrder", ['html' => $html], function ($m) use ($destinatario) {
           // $m->from(env('PROJECT_EMAIL'), env('PROJECT_NAME_EMAIL'));
            $m->to($destinatario)->subject("Promemoria ordini da consegnare");
            $m->cc(["info@panificiopasticceriarighetto.it"]);
        });

    }
}
