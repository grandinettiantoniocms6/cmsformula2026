<?php

namespace App\Console\Commands;

use App\Models\PluginBookingReservation;
use App\Models\PluginBookingRoom;
use App\Models\PluginBookingSettings;
use App\Models\PluginBookingStatus;
use App\Models\PluginBookingType;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendReminderBooking extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:reminder_booking';

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
        $setting = PluginBookingSettings::first();
        if(!$setting){
            die;
        }

        if(!$setting->hours_reminder){
            die;
        }

        $now = Carbon::now()->addDays($setting->hours_reminder)->toDateString();

        $status = PluginBookingStatus::where("is_completato", 1)->first();
        if(!$status){
            die;
        }


        $orders = PluginBookingReservation::where("plugin_booking_status_id", $status->id)
            ->where("date_start", $now)
            ->orderBy("date_start", "asc")
            ->get();

        if($orders){
            foreach ($orders as $order){
                $user = User::find($order->user_id);
                $html = "";
                $room = PluginBookingRoom::find($order->plugin_booking_room_id);
                if($room){
                    $type = PluginBookingType::find($room->plugin_booking_type_id);
                    if($type){
                        if($type->description_reminder){
                            $html = $type->description_reminder;
                        }
                    }
                }

                if(trim($html) != "" && $user){
                    $destinatario = $user->email;

                    $vet_email = ["user" => $user, "reservation" => $order];

                    \Mail::send("common.emails.pluginBooking.reminder", ['data' => $vet_email], function ($m) use ($destinatario, $order) {
                        // $m->from(env('PROJECT_EMAIL'), env('PROJECT_NAME_EMAIL'));
                        $m->to($destinatario)->subject("Promemoria prenotazione n.$order->id");
                    });

                    $this->info("Invio promemoria $order->id");
                }
            }
        }
    }
}
