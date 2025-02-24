<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PluginOrdersRequest;
use App\Models\Baseuser;
use App\Models\Cash;
use App\Models\Category;
use App\Models\Notification;
use App\Models\PluginOrders;
use App\Models\PluginOrdersCategories;
use App\Models\PluginOrdersClients;
use App\Models\PluginOrdersDetail;
use App\Models\PluginOrdersProducts;
use App\Models\PluginOrdersSettings;
use App\Models\PluginOrdersStatuses;
use App\Models\PluginProducts;
use App\Models\Reservation;
use App\Models\ReservationCategory;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * Class PluginOrdersCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PluginOrdersCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\PluginOrders::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/pluginOrders');
        CRUD::setEntityNameStrings('ordine', 'ordini');

        $this->crud->query->selectRaw('plugins_orders.*');
        $this->crud->addClause('join', 'plugins_orders_clients', 'plugins_orders_clients.id', 'plugin_order_client_id');

        if(\request()->has('s')){
            $this->crud->query->where("plugin_order_status_id", \request()->get('s'));
        }
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $this->crud->removeButton("show");
        $this->crud->removeButton("create");
        $this->crud->removeButton("update");
        $this->crud->removeButton("delete");

        $this->crud->setColumns([
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'plugins_orders.id',
                'label' => '#ID', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getId', // the method in your Model
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                'limit' => 10000, // Limit the number of characters shown
            ],
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'plugin_order_client_id',
                'label' => 'Cliente', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getClient', // the method in your Model
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                'limit' => 10000, // Limit the number of characters shown
                'searchLogic' => function ($query, $column, $searchTerm) {
                    $query->where('plugins_orders_clients.mobile_1', 'like', '%'.$searchTerm.'%');
                    $query->orWhere('plugins_orders_clients.last_name', 'like', '%'.$searchTerm.'%');
                    $query->orWhere('plugins_orders_clients.first_name', 'like', '%'.$searchTerm.'%');
                }
            ],
            [
                'name'  => 'date_delivery',
                'label' => 'Data consegna',
                'type'  => 'date',
            ],
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'time_delivery',
                'label' => 'Orario', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getTime', // the method in your Model
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                'limit' => 10000, // Limit the number of characters shown
            ],
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'total',
                'label' => 'Totale', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getTotal', // the method in your Model
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                'limit' => 10000, // Limit the number of characters shown
            ],
            [
                // 1-n relationship
                'label'     => 'Stato', // Table column heading
                'type'      => 'select',
                'name'      => 'plugin_order_status_id', // the column that contains the ID of that connected entity;
                'entity'    => 'status', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user
                'model'     => "App\Models\PluginOrderStatus", // foreign key model
            ],
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'is_in_menu',
                'label' => 'Azioni', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getMenu', // the method in your Model
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                'limit' => 10000, // Limit the number of characters shown
            ]
        ]);

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */

        // date filter
        $this->crud->addFilter([
            'type'  => 'date',
            'name'  => 'date',
            'label' => 'Data consegna'
        ],
            false,
            function ($value) { // if the filter is active, apply these constraints
                 $this->crud->addClause('where', 'date_delivery', $value);
            });


        $status = PluginOrdersStatuses::get()->pluck("name", "id")->toArray();
        // dropdown filter
        $this->crud->addFilter([
            'name'  => 's',
            'type'  => 'dropdown',
            'label' => 'Stato'
        ], $status, function($value) { // if the filter is active
             $this->crud->addClause('where', 'plugin_order_status_id', $value);
        });
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(PluginOrdersRequest::class);

        CRUD::setFromDb(); // fields

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    public function planning(){
        $units = PluginOrdersCategories::where("type_id", 0)->get();
        $setting = PluginOrdersSettings::first();

        return view(backpack_view('plugins.pluginOrders.planning'), compact('units','setting'));
    }

    public function open_reservation_new(Request $request){

        $products = PluginOrdersProducts::orderBy("name", "asc")->get();
        $date_str = $request->get('dateStr');
        $resourceId = $request->get('resourceId');

        $day = substr($date_str, 0, 10);
        $hour = substr($date_str, 11, 5);

        $html_modal = view(backpack_view("plugins.pluginOrders.new_reservation"), compact("day", "hour", "products", "resourceId"))->render();
        return response()->json([
            "modal" => $html_modal
        ]);
    }

    public function open_reservation(Request $request){
        $id = (int) $request->get('id');
        $reservation = PluginOrders::find($id);
        if(!$reservation){
            return response()->json([
                "error" => "Prenotazione non trovata"
            ]);
        }


        $client = PluginOrdersClients::withTrashed()->find($reservation->plugin_order_client_id);
        if(!$client){
            return response()->json([
                "error" => "Cliente non trovato"
            ]);
        }

        $products = PluginOrdersProducts::orderBy("name", "asc")->get();
        $units = PluginOrdersCategories::where("type_id", 0)->get();
        $status = PluginOrdersStatuses::get();

        $reservation_detail = PluginOrdersDetail::where("plugin_order_id", $reservation->id)->get();
        $html_modal = view(backpack_view("plugins.pluginOrders.reservation"), compact("reservation", "client", "products", "units", "reservation_detail", "status"))->render();

        return response()->json([
            "modal" => $html_modal
        ]);
    }

    public function update_from_planning(Request $request){
        $baseuser_id = $request->get('client_id');
        $order_id = $request->get('reservation_id');

        $first_name = $request->get('first_name');
        $last_name = $request->get('last_name');
        $email = $request->get('email');
        $mobile = $request->get('mobile');

        $note = $request->get('note');
        $place_ritiro = $request->get('place_ritiro');
        $address = $request->get('address');
        $status_id = $request->get('status_id');

        $day = $request->get('day');
        $start = $request->get('start');

        $acconto = $request->get('acconto');

        $products = $request->get('products');
        $products_qty = $request->get('products_qty');
        $products_prices = $request->get('products_price');
        $products_units = $request->get('products_units');
        $products_num = $request->get('products_num');

        $baseuser = PluginOrdersClients::where("id", $baseuser_id)->first();
        if($baseuser){
            if($first_name && trim($first_name) != ""){
                $baseuser->first_name = $first_name;
            }
            if($last_name && trim($last_name) != ""){
                $baseuser->last_name = $last_name;
            }
            if($email && trim($email) != ""){
                $baseuser->email = $email;
            }
            if($mobile && trim($mobile) != ""){
                $baseuser->mobile_1 = $mobile;
            }
            $baseuser->save();
        }

        $day_start = Carbon::createFromFormat("Y-m-d", $day);

        if(backpack_user()->roles[0]->id > 3){
            PluginOrders::where("id", $order_id)->update([
                "plugin_order_status_id" => $status_id,
                "user_id" => backpack_user()->id
            ]);

            \Alert::success("Ordine salvato con successo!")->flash();
            return redirect()->back();
        }else{
            PluginOrders::where("id", $order_id)->update([
                "plugin_order_status_id" => $status_id,
                "date_delivery" => $day_start,
                "time_delivery" => $start,
                "place_ritiro" => $place_ritiro,
                "address" => $address,
                "note" => $note,
                "user_id" => backpack_user()->id
            ]);
        }

        $order = PluginOrders::find($order_id);

        if($order){
            PluginOrdersDetail::where("plugin_order_id", $order_id)->delete();

            $tot = 0;

            if($products){
                foreach ($products as $key=>$value){
                    if($products_prices[$key] === null){
                        $products_prices[$key] = 0;
                    }

                    $products_prices[$key] = str_replace(",", ".", $products_prices[$key]);
                    $products_qty[$key] = str_replace(",", ".", $products_qty[$key]);

                    PluginOrdersDetail::insert([
                        "plugin_order_id" => $order->id,
                        "plugin_product_id" => $value,
                        "plugin_category_id" => $products_units[$key],
                        "qty" => $products_qty[$key],
                        "price" => $products_prices[$key],
                        "num" => (int) $products_num[$key],
                        "user_id" => backpack_user()->id,
                        "created_at" => Carbon::now()->toDateTimeString()
                    ]);

                    $tot = $tot + ($products_qty[$key] * $products_prices[$key]);
                }
            }


            if($acconto === null){
                $acconto = 0;
            }

            $tot = str_replace(",", ".", $tot);
            $acconto = str_replace(",", ".", $acconto);

            $order->total = $tot;
            $order->acconto = $acconto;

            $order->save();
        }

        \Alert::success("Ordine salvato con successo!")->flash();
        return redirect()->back();
    }


    public function store_from_planning(Request $request){
        $baseuser_id = $request->get('baseuser_id');
        $first_name = $request->get('first_name');
        $last_name = $request->get('last_name');
        $email = $request->get('email');
        $mobile = $request->get('mobile');

        $note = $request->get('note');
        $place_ritiro = $request->get('place_ritiro');
        $address = $request->get('address');

        $day = $request->get('day');
        $start = $request->get('start');

        $products = $request->get('products');
        $products_qty = $request->get('products_qty');
        $products_prices = $request->get('products_price');
        $products_units = $request->get('products_units');
        $products_num = $request->get('products_num');


        $new_products = $request->get('new_products');
        $new_products_qty = $request->get('new_products_qty');
        $new_products_prices = $request->get('new_products_price');
        $new_products_units = $request->get('new_products_units');
        $new_products_num = $request->get('new_products_num');


        $acconto = $request->get('acconto');

        if($baseuser_id != 0){
            $baseuser = PluginOrdersClients::where("id", $baseuser_id)->first();
            if($baseuser){
                if($first_name && trim($first_name) != ""){
                    $baseuser->first_name = $first_name;
                }
                if($last_name && trim($last_name) != ""){
                    $baseuser->last_name = $last_name;
                }
                if($email && trim($email) != ""){
                    $baseuser->email = $email;
                }
                if($mobile && trim($mobile) != ""){
                    $baseuser->mobile_1 = $mobile;
                }
                $baseuser->save();
            }

        }else{
            $baseuser = PluginOrdersClients::create([
                "first_name" => $first_name,
                "last_name" => $last_name,
                "email" => $email,
                "mobile_1" => $mobile,
                "user_id" => backpack_user()->id
            ]);

        }

        $day_start = Carbon::createFromFormat("Y-m-d", $day);

        $order = PluginOrders::create([
           "plugin_order_client_id" => $baseuser->id,
           "plugin_order_status_id" => 1,
           "date_delivery" => $day_start,
           "time_delivery" => $start,
           "place_ritiro" => $place_ritiro,
           "address" => $address,
           "note" => $note,
           "user_id" => backpack_user()->id
        ]);

        if($order){
            $tot = 0;

            if($products) {
                foreach ($products as $key => $value) {
                    if ($products_prices[$key] === null) {
                        $products_prices[$key] = 0;
                    }

                    $products_prices[$key] = (float) str_replace(",", ".", $products_prices[$key]);
                    $products_qty[$key] = (float) str_replace(",", ".", $products_qty[$key]);

                    PluginOrdersDetail::insert([
                        "plugin_order_id" => $order->id,
                        "plugin_product_id" => $value,
                        "plugin_category_id" => $products_units[$key],
                        "qty" => $products_qty[$key],
                        "price" => $products_prices[$key],
                        "num" => (int) $products_num[$key],
                        "user_id" => backpack_user()->id,
                        "created_at" => Carbon::now()->toDateTimeString()
                    ]);

                    $tot = $tot + ($products_qty[$key] * $products_prices[$key]);
                }
            }

            //NUOVI PRODOTTI
            if($new_products){
                foreach ($new_products as $key=>$value){
                    $prod = PluginOrdersProducts::create([
                        "name" => $value,
                        "slug" => null,
                        "price" => $new_products_prices[$key],
                        "user_id" => backpack_user()->id
                    ]);

                    if($new_products_prices[$key] === null){
                        $new_products_prices[$key] = 0;
                    }

                    $new_products_prices[$key] = (float) str_replace(",", ".", $new_products_prices[$key]);
                    $new_products_qty[$key] = (float) str_replace(",", ".", $new_products_qty[$key]);

                    PluginOrdersDetail::insert([
                        "plugin_order_id" => $order->id,
                        "plugin_product_id" => $prod->id,
                        "plugin_category_id" => $new_products_units[$key],
                        "qty" => $new_products_qty[$key],
                        "price" => $new_products_prices[$key],
                        "num" => $new_products_num[$key],
                        "user_id" => backpack_user()->id,
                        "created_at" => Carbon::now()->toDateTimeString()
                    ]);

                    $tot = $tot + ($new_products_qty[$key] * $new_products_prices[$key]);
                }
            }


            if($acconto === null){
                $acconto = 0;
            }

            $tot = str_replace(",", ".", $tot);
            $acconto = str_replace(",", ".", $acconto);

            $order->total = $tot;
            $order->acconto = $acconto;
            $order->save();
        }

        \Alert::success("Ordine salvato con successo!")->flash();
        return redirect()->back();
    }

    public function delete_reservation(Request $request){
        $order_id = $request->get('id');

        $order = PluginOrders::find($order_id);
        $order->delete();
        \Alert::success("Ordine eliminato con successo!")->flash();
    }

    public function events(Request $request){
        $start = substr($request->get('start'),0,10);
        $end = substr($request->get('end'),0,10);
        $v_json = [];

        $start_ca = Carbon::createFromFormat("Y-m-d", $start);
        $end_ca = Carbon::createFromFormat("Y-m-d", $end);
        $diff = $start_ca->diffInDays($end_ca);

        if($diff == 1){
            $reservations = PluginOrders::where("date_delivery", $start)->get();
        }else{
            $reservations = PluginOrders::whereRaw("date_delivery >= '$start' && date_delivery <= '$end'")->get();
        }

        if($reservations){
            foreach ($reservations as $reservation){
                $client = PluginOrdersClients::withTrashed()->find($reservation->plugin_order_client_id);
                if(!$client){
                    continue;
                }

                $title = strtoupper("$client->first_name $client->last_name");

                $reservations_categories = PluginOrdersDetail::where("plugin_order_id", $reservation->id)->get();
                if(count($reservations_categories) > 0){
                    foreach ($reservations_categories as $rc){
                        $product = PluginOrdersProducts::withTrashed()->where("id", $rc->plugin_product_id)->first();
                        if(!$product){
                            continue;
                        }

                        $unit = PluginOrdersCategories::withTrashed()->where("type_id", 0)->where("id", $rc->plugin_category_id)->first();
                        if(!$unit){
                            continue;
                        }

                        $className = "";
                        $categoryName = "- {$product->name}";

                        $classNameStatus = "";
                        $status = PluginOrdersStatuses::find($reservation->plugin_order_status_id);

                        $color_event = $unit->color;

                        if($status->name == "Completato"){
                            $color_event = $status->color;
                        }

                        $time_end = Carbon::createFromFormat("H:i:s", $reservation->time_delivery)->addMinutes(20)->format("H:i:s");

                        $v_json[] = [
                            'id' => $rc->id,
                            'id_res' => $reservation->id,
                            'resourceId' => $rc->plugin_category_id,
                            'start' => $reservation->date_delivery . 'T' . $reservation->time_delivery,
                            'end' => $reservation->date_delivery . 'T' . $time_end,
                            'backgroundColor' => $color_event,
                            'className' => ["event-cms", "event-$className", "event-$classNameStatus"],
                            'borderColor'=> 'transparent',
                            'textColor' => '#FFFFFF',
                            'title' => "$title $categoryName",
                            "mobile" => $client->mobile_1,
                            "status_name" => $status->name
                        ];
                    }
                }

            }
        }
        return $v_json;
    }

    public function print_pdf($id){
        $pdf = \App::make('snappy.pdf.wrapper');

        $setting = PluginOrdersSettings::first();
        $order = PluginOrders::find($id);
        $details = PluginOrdersDetail::where("plugin_order_id", $order->id)->get();
        $status = PluginOrdersStatuses::find($order->plugin_order_status_id);
        $client = PluginOrdersClients::find($order->plugin_order_client_id);

        $html = view(backpack_view('plugins.pluginOrders.pdf'), compact('order','details','status','client','setting'))->render();

        $pdf->loadHTML($html)->setPaper('a4');
        return $pdf->download("Ordine_$id.pdf");

    }

    public function drop_and_resize(Request $request){
        $date = explode(" ", trim($request->get('date')));
        $date_end = explode(" ", trim($request->get('date_end')));

        dd($date, $request->all());

        $day = $date[0];
        $start = $date[1];
        $id_rc = (int) $request->get('id');
        $unit_id = (int) $request->get('unit_id');

        return response()->json([
            "result" => true
        ]);

    }
}
