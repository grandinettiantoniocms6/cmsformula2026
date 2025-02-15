<?php

namespace App\Console\Commands;

use App\Http\Controllers\ParkosController;
use App\Imports\ParkingImport;
use App\Models\PluginParkingReservation;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class ImportParkos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:parkos';

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
        $class = new ParkosController();

        $result = $class->get_token();

        $token = $result['access_token'];

        $result = $class->get_list($token);

        $data = $result['data'];

        /* "code" => "96NPB4"
          "name" => "andrea beggiato"
          "lang" => "it"
          "phone" => "+39 3475984588"
          "car_brand_model" => null
          "car_license_plate" => null
          "arrival_date" => "2023-12-30"
          "arrival_time" => "03:00"
          "departure_date" => "2024-01-07"
          "departure_time" => "05:00"
          "flight_departure_nr" => null
          "flight_return_nr" => "no6022"
          "persons" => 2
          "days" => 9
          "parking_type" => "shuttle"
          "location_type" => "outdoor"
          "airport" => "Verona"
          "products" => null
          "currency" => "EUR"
          "total_price" => 49
          "paid" => false
          "merchant" => "Autopal Parking (Paga in parcheggio)"
          "merchant_id" => 2035
          "created_at" => "2023-12-27T10:24:08.000000Z"
          "updated_at" => "2023-12-27T10:24:09.000000Z"
          "cancelled_at" => null*/

        if($data){
            foreach ($data as $item){
                $check = PluginParkingReservation::where("parkos_code", $item['code'])->first();
                if($check){
                    continue;
                }

                PluginParkingReservation::insert([
                   "parkos_code" => $item['code'],
                   "from" => "parkos",
                   "name" => $item['name'],
                   "mobile" => $item['phone'],
                   "targa" => $item['car_license_plate'],
                   "type_park" => $item['location_type'] == "outdoor" ? 1 : 2,
                   "date_start" => $item['departure_date'],
                   "time_start" => $item['departure_time'],
                   "date_end" => $item['arrival_date'],
                   "time_end"  => $item['arrival_time'],
                   "number_days" => $item['days'],
                   "total" => $item['total_price'],
                   "is_payed" => $item['paid'],
                   "parkos_parking_type" => $item['parking_type'],
                   "parkos_airport" => $item['airport'],
                   "merchant" => $item['merchant'],
                   "merchant_id" => $item['merchant_id'],
                   "created_at" => $item['created_at']
                ]);

                $this->info($item['code']);
            }
        }
    }
}
