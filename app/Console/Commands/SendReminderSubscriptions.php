<?php

namespace App\Console\Commands;

use App\Models\PluginBookingReservation;
use App\Models\PluginBookingRoom;
use App\Models\PluginBookingSettings;
use App\Models\PluginBookingStatus;
use App\Models\PluginBookingType;
use App\Models\PluginProducts;
use App\Models\ShopSettings;
use App\Models\UserSubscription;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendReminderSubscriptions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:reminder_subscriptions';

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
        $setting = ShopSettings::where("is_subscriptions", 1)->first();
        if(!$setting){
            die;
        }

        if(!$setting->gg_before_subscriptions){
            die;
        }

        if(!$setting->email_subscriptions){
            die;
        }


        $now = Carbon::now()->addDays($setting->gg_before_subscriptions)->toDateString();

        $this->info("ABBONAMENTI CON DATA FINE $now");

        $users = UserSubscription::where("end", "=", $now)
            ->groupBy("user_id")
            ->get();

        if($users){
            foreach ($users as $item){
                $user = User::find($item->user_id);
                if(!$user){
                    continue;
                }

                $html = $setting->email_subscriptions;
                if(trim($html) != "" && $user){
                    $destinatario = $user->email;

                    $vet_email = ["user" => $user, "html" => $html];

                    if($user->code == null){
                        $code = unique_random("users", "code", "25");
                        $user->code = $code;
                        $user->save();
                    }

                    $subscriptions = UserSubscription::selectRaw("plugins_products.*, users_subscriptions.end, users_subscriptions.name as nominativo")
                        ->join("plugins_products", "plugins_products.id", "=", "product_id")
                        ->where("end", "=", $now)
                        ->where("user_id", $user->id)
                        ->get();

                    \Mail::send("common.emails.reminder_subscription", ['data' => $vet_email, "subscriptions" => $subscriptions], function ($m) use ($destinatario) {
                        // $m->from(env('PROJECT_EMAIL'), env('PROJECT_NAME_EMAIL'));
                        $m->to($destinatario)->subject("Promemoria scadenza abbonamento");
                    });

                    $this->info("Invio promemoria $user->name");
                }
            }
        }
    }
}
