<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Brand;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Company;
use App\Models\Order;
use App\Models\Page;
use App\Models\PluginProducts;
use App\Models\Product;
use App\Models\Promotion;
use App\Models\Slider;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

use Spatie\ArrayToXml\ArrayToXml;


class ParkosController extends Controller
{

    public function index(){
        echo "<h1>First call: GET https://api.parkos.com/oauth/token</h1>";
        echo "<p><strong>username</strong> info@webisland.it</p>";
        echo "<p><strong>password</strong> Webisland1!</p>";
        echo "<p><strong>grant_type</strong> password</p>";
        echo "<p><strong>client_id</strong> 1495</p>";
        echo "<p><strong>secret</strong> TuqHVsLUrsbf7XoVDDekqobhmBj9YokuC5xPzp5g</p>";

        $result = $this->get_token();

        echo "<h3>Result First call</h3>";
        echo "<p><strong>access token</strong> {$result['access_token']}</p>";

        echo "<h1>Second call: GET https://api.parkos.com/v1/reservations?merchant_id=2035</h1>";
        echo "<p>Pass <strong>Authorization: Bearer + access token</strong> in second call</p>";
        echo "<h3>Result Second call</h3>";

        $token = $result['access_token'];

        $result = $this->get_list($token);
        dd($result);

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

    }

    public function get_token(){
        $username = "info@webisland.it";
        $password = "Webisland1!";
        $grant_type = "password";
        $client_id = "1495";
        $secret = "TuqHVsLUrsbf7XoVDDekqobhmBj9YokuC5xPzp5g";

        $data = array(
            "username" => $username,
            "password" => $password,
            "grant_type" => $grant_type,
            "client_id" => $client_id,
            "client_secret" => $secret
        );

        $payload = json_encode($data);

        $ch = curl_init('https://api.parkos.com/oauth/token');

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

        $headr = array();
        $headr[] = 'Content-length: '. strlen($payload);
        $headr[] = 'Content-type: application/json';

        curl_setopt($ch, CURLOPT_HTTPHEADER,$headr);

        $result = curl_exec($ch);
        $vet = json_decode($result, true);

        return $vet;
    }

    public function get_list($accesstoken){

        //parking_type=shuttle&location_type=outdoor&
        $ch = curl_init("https://api.parkos.com/v1/reservations");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        //curl_setopt($ch, CURLOPT_HEADER, true);

        $headr = array();
        $headr[] = 'Accepts: application/json';
        $headr[] = 'Authorization: Bearer '.$accesstoken;

        curl_setopt($ch, CURLOPT_HTTPHEADER,$headr);

        $result = curl_exec($ch);
        $vet = json_decode($result, true);

        return $vet;
    }
}
