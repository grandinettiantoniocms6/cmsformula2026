<?php


namespace App\Http\Controllers;


use App\Http\Requests\PluginProductsRequest;
use App\Models\AdminBlock;
use App\Models\AdminLanguage;
use App\Models\BlockContact;
use App\Models\BlockNews;
use App\Models\Cart;
use App\Models\Page;
use App\Models\PageBlock;
use App\Models\PluginBookingReservation;
use App\Models\PluginBookingReservationRoom;
use App\Models\PluginBookingReservationRoomCheckin;
use App\Models\PluginBookingReservationService;
use App\Models\PluginBookingRoom;
use App\Models\PluginBookingRoomAddictions;
use App\Models\PluginBookingRoomPrices;
use App\Models\PluginBookingRoomPromos;
use App\Models\PluginBookingRoomServices;
use App\Models\PluginBookingServices;
use App\Models\PluginBookingSettings;
use App\Models\PluginBookingType;
use App\Models\PluginParkingHoliday;
use App\Models\PluginParkingPrice;
use App\Models\PluginParkingPriceRule;
use App\Models\PluginParkingReservation;
use App\Models\PluginParkingSetting;
use App\Models\PluginProducts;
use App\Models\PluginProductsAttachments;
use App\Models\PluginProductsBrands;
use App\Models\PluginProductsCategories;
use App\Models\PluginProductsCategoriesProducts;
use App\Models\PluginProductsContacts;
use App\Models\PluginProductsImages;
use App\Models\PluginProductsImagesSize;
use App\Models\PluginProductsLabels;
use App\Models\PluginProductsOptions;
use App\Models\PluginProductsRelated;
use App\Models\PluginProductsRequests;
use App\Models\PluginProductsSettings;
use App\Models\Promotion;
use App\Models\ShopAttributes;
use App\Models\ShopAttributesOptions;
use App\Models\ShopAttributesProducts;
use App\Models\ShopSettings;
use App\Models\WebsiteSetting;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class PluginParkingController extends Controller
{

    public function send_request(Request $request){
        $labels = \App\Models\PluginParkingLabel::get()->pluck("value", "key")->toArray();


        $check_email =  PluginParkingReservation::where("email", $request->get('email'))->
            where("is_blacklist", 1)->first();

        if($check_email){
            return redirect()->back()->withErrors([$labels['parking-invio-richiesta-ko']]);
        }

        $setting = PluginParkingSetting::first();

        $item = PluginParkingReservation::create([
                  "type_park" => $request->get('type_park'),
                  "date_start" => Carbon::createFromFormat("d-m-Y", $request->get('date_start'))->toDateString(),
                  "time_start" =>  $request->get('time_start'),
                  "date_end" => Carbon::createFromFormat("d-m-Y", $request->get('date_end'))->toDateString(),
                  "time_end" => $request->get('time_end'),
                  "name" => $request->get('name'),
                  "mobile" => $request->get('mobile'),
                  "email" => $request->get('email'),
                  "number_flight" => $request->get('number_flight'),
                  "number_partecipants" =>  $request->get('number_partecipants'),
                  "targa" => $request->get('targa'),
                  "newsletter" => $request->get('newsletter'),
                  "number_days" => $request->get('number_days'),
                  "total" => $request->get('total')
                ]);


        $destinatario = $item->email;
        try{
            \Mail::send("common.emails.pluginParking.riepilogo", ['data' => $item], function ($m) use ($destinatario, $setting, $item) {
                $m->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                $m->replyTo(env('MAIL_TO_REPLAY'), env('MAIL_FROM_NAME'));
                $m->to($destinatario)->subject("Riepilogo Prenotazione n.$item->id");
            });


            if($setting){
                if($setting->ccn_email){
                    $destinatario = trim($setting->email);

                    \Mail::send("common.emails.pluginParking.riepilogo_staff", ['data' => $item], function ($m) use ($destinatario, $item) {
                        $m->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                        $m->replyTo(env('MAIL_TO_REPLAY'), env('MAIL_FROM_NAME'));
                        $m->to($destinatario)->subject("Riepilogo Prenotazione n.$item->id");
                    });

                    $emails = explode(",", $setting->ccn_email);

                    if(count($emails)){
                        foreach ($emails as $k=>$temp_email){
                            $destinatario = trim($temp_email);

                            \Mail::send("common.emails.pluginParking.riepilogo_staff", ['data' => $item], function ($m) use ($destinatario, $item) {
                                $m->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                                $m->replyTo(env('MAIL_TO_REPLAY'), env('MAIL_FROM_NAME'));
                                $m->to($destinatario)->subject("Riepilogo Prenotazione n.$item->id");
                            });
                        }
                    }
                }else{
                    $destinatario = trim($setting->email);

                    \Mail::send("common.emails.pluginParking.riepilogo_staff", ['data' => $item], function ($m) use ($destinatario, $item) {
                        $m->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                        $m->replyTo(env('MAIL_TO_REPLAY'), env('MAIL_FROM_NAME'));
                        $m->to($destinatario)->subject("Riepilogo Prenotazione n.$item->id");
                    });
                }
            }

        } catch (\Throwable $e) {
           // dd($e->getMessage());
        }

        return redirect()->back()->with('message', $labels['parking-invio-richiesta-ok']);

       /* return response()->json([
            "error" => 0,
            "item" => $item
        ]);*/

    }


    public function calculate_price(Request $request){
        $type = $request->get('type');
        $date_start = $request->get('date_start');
        $date_end = $request->get('date_end');

        if($date_start === null || $date_end === null){
            return response()->json([
                "error" => 0,
                "item" => null,
                "days" => 0,
                "price" => 0,
                "discount" => 0,
                "rules" => 0,
                "price_view" => 0
            ]);
        }

        $setting = PluginParkingSetting::first();

        $price_view = "";
        $discount = 0;
        $rules = null;

        $date_start_carbon = Carbon::createFromFormat("d-m-Y", $date_start);
        $date_end_carbon = Carbon::createFromFormat("d-m-Y", $date_end);

        $diff = $date_start_carbon->diffInDays($date_end_carbon);
        $diff++;

        $last = PluginParkingPrice::orderBy("day", "desc")->first();


        if($diff >= $last->day){
            $item = $last;
        }else{
            $item = PluginParkingPrice::where("day", $diff)->first();
        }

        //$item = PluginParkingPrice::where("day", $diff)->first();

        $price = 0;
        if($item){
            if($type == 1){
                $price = $item->price_scoperto;
            }
            if($type == 2){
                $price = $item->price_coperto;
            }

            if($diff > $last->day){
                $giorni_sforo = $diff - $last->day;
                if($type == 1){
                    $price = $price + ($giorni_sforo * $setting->euro_park_scoperto);
                }

                if($type == 2){
                    $price = $price + ($giorni_sforo * $setting->euro_park_coperto);
                }

            }

            $date_start_carbon = $date_start_carbon->subDay();

            $discount = 0;

            $html_no_disp = "<table width='100%'>";
            $cont_no_disp = 0;

            for($i=0; $i<$diff; $i++){
                $gg = $date_start_carbon->addDay()->format("Y-m-d");

                $gg_ita = Carbon::createFromFormat("Y-m-d", $gg)->format("d/m/Y");

                $holiday = PluginParkingHoliday::where("day", $gg)->first();
                if($holiday){
                    $cont_no_disp++;
                    $html_no_disp .= "<tr><td><strong>$gg_ita</strong></td><td>PARCHEGGIO CHIUSO</td></tr>";
                    continue;
                }



                $reservations_tot  = \App\Models\PluginParkingReservation::whereRaw("(date_start <= '$gg' AND date_end >= '$gg')")->where("type_park", $type)
                    ->count();

                if($type == 2){
                    $disponibili = $setting->total_park_coperto - $reservations_tot;
                }else{
                    $disponibili = $setting->total_park_scoperto - $reservations_tot;
                }

                if($disponibili < 0){
                    $disponibili = 0;
                }

                if($disponibili == 0){
                    $cont_no_disp++;

                    $html_no_disp .= "<tr><td><strong>$gg_ita</strong></td><td>POSTI ESAURITI</td></tr>";
                }
            }

            $html_no_disp .= "</table>";

            if($cont_no_disp > 0){
                return response()->json([
                    "error" => 1,
                    "html" => $html_no_disp
                ]);
            }


            for($i=0; $i<=$diff; $i++){
                $gg = $date_start_carbon->addDay()->format("Y-m-d");

                $rule = PluginParkingPriceRule::where("plugin_parking_price_id", $item->id)
                    ->whereRaw("(date_start <= '$gg' AND date_end >= '$gg')")
                    ->where("condition_discount", $type)
                    ->first();

                if($rule){
                    if($rule->type_discount == 0){ // euro
                        if($rule->rule_discount == 0) {
                            $discount += $rule->discount;
                        }else{
                            $price = $price + $rule->discount;
                        }
                    }else{
                        if($rule->rule_discount == 0){
                            if($type == 1){
                                $calc = $item->price_scoperto - (($item->price_scoperto * (100 - $rule->discount)) / 100);
                            }else{
                                $calc = $item->price_coperto - (($item->price_coperto * (100 - $rule->discount)) / 100);
                            }
                            $discount += $calc;
                        }else{
                            if($type == 1){
                                $calc = $item->price_scoperto + (($item->price_scoperto * (100 - $rule->discount)) / 100);
                            }else{
                                $calc = $item->price_coperto + (($item->price_coperto * (100 - $rule->discount)) / 100);
                            }

                            $price = $price + $calc;
                            $discount = 0;
                        }


                    }

                    break;
                }
            }

            $rules = PluginParkingPriceRule::where("plugin_parking_price_id", $item->id)->get();

            $price_view = "&euro; ".number_format($price,2,",",".");
            if($discount > 0){
                $price_view = "<del>&euro; ".number_format($price,2,",",".")."</del> &euro; ".number_format($price - $discount,2,",",".")."";
            }
        }

        return response()->json([
            "error" => 0,
            "item" => $item,
            "days" => $diff,
            "price" => $price - $discount,
            "discount" => $discount,
            "rules" => $rules,
            "price_view" => $price_view
        ]);
    }

}
