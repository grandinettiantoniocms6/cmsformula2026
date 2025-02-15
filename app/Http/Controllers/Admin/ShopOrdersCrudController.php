<?php

namespace App\Http\Controllers\Admin;

use App\Exports\Cedolini\ReportPartnerExport;
use App\Exports\OrderExport;
use App\Http\Requests\ShopOrdersRequest;
use App\Models\Message;
use App\Models\MessageTemplate;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\OrderStatusHistory;
use App\Models\Payment;
use App\Models\PluginOrdersSettings;
use App\Models\ShopOrders;
use App\Models\ShopShippings;
use App\User;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

/**
 * Class ShopOrdersCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ShopOrdersCrudController extends CrudController
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
        if(in_array(backpack_user()->roles[0]->id, [4,5,6,8,9])){
            die;
        }

        CRUD::setModel(\App\Models\Order::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/shopOrders');
        CRUD::setEntityNameStrings('ordine', 'ordini');

        if(backpack_user()->roles[0]->id == 7){
            $users = User::where("user_id", backpack_user()->id)->pluck("id", "id")->toArray();
            if(count($users)){
                $this->crud->query->whereIn("user_id", $users);
            }else{
                $this->crud->query->whereIn("user_id", [0]);
            }
        }

        $this->crud->orderBy("updated_at", "desc");
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $this->crud->removeButton('create');
        $this->crud->removeButton('update');
        $this->crud->removeButton('show');
        $this->crud->removeButton('delete');

        //$this->crud->addButtonFromModelFunction('line', 'view_order', 'view_order', 'beginning'); // add a button whose HTML is returned by a method in the CRUD model


        $this->crud->addColumns([
            [
                'name'  => 'id',
                'label' => '#',
            ],
            [
                'label'     => "Cliente",
                'type'      => 'select',
                'name'      => 'user_id',
                'entity'    => 'user',
                'attribute' => 'name',
                'model'     => 'App\User',
            ],
            [
                // run a function on the CRUD model and show its return value
                'name' => "status_id",
                'label' => "Stato", // Table column heading
                'type' => "model_function",
                'function_name' => 'get_status', // the method in your Model
                'limit' => 1000, // Limit the number of characters shown
            ],
            [
                // run a function on the CRUD model and show its return value
                'name' => "total_tax",
                'label' => "Totale", // Table column heading
                'type' => "model_function",
                'function_name' => 'get_total', // the method in your Model
                'limit' => 1000, // Limit the number of characters shown
            ],
            [
                'name'  => 'total_shipping_tax',
                'label' => 'Spedizione',
            ],
            [
                // run a function on the CRUD model and show its return value
                'name' => "payment_id",
                'label' => "Pagamento", // Table column heading
                'type' => "model_function",
                'function_name' => 'get_payment', // the method in your Model
                'limit' => 1000, // Limit the number of characters shown
            ],
            [
                'name'  => 'created_at',
                'label' => 'Data ordine',
                'type' => 'datetime'
            ],
            [
                'name'  => 'updated_at',
                'label' => 'Ultima modifica',
                'type' => 'datetime'
            ],
            [
                // run a function on the CRUD model and show its return value
                'name' => "buyer",
                'label' => "Creato da", // Table column heading
                'type' => "model_function",
                'function_name' => 'get_user', // the method in your Model
                'limit' => 1000, // Limit the number of characters shown
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

        $orderStatus = OrderStatus::get()->pluck("name", "id")->toArray();
        $this->crud->addFilter([ // select2 filter
            'name' => 'status',
            'type' => 'select2',
            'label'=> 'Stato'
        ], function() use ($orderStatus) {
            return $orderStatus;
        }, function($value) { // if the filter is active
            $this->crud->addClause('where', 'status_id', '=', $value);
        });

        $this->crud->addFilter([ // daterange filter
            'type' => 'date_range',
            'name' => 'from_to',
            'label'=> 'Data ordine'
        ],
            false,
            function($value) { // if the filter is active, apply these constraints
                $dates = json_decode($value);
                $this->crud->addClause('where', 'created_at', '>=', "$dates->from 00:00:00");
                $this->crud->addClause('where', 'created_at', '<=', "$dates->to 23:59:59");
            });

        if(in_array(backpack_user()->roles[0]->id, [1,2])) {
            $buyers = User::join("model_has_roles", "model_has_roles.model_id", "=", "id")
                ->where("role_id", 7)
                ->pluck("name", "id")->toArray();

            if (count($buyers)) {
                $this->crud->addFilter([ // select2 filter
                    'name' => 'is_user',
                    'type' => 'select2',
                    'label' => 'Buyer'
                ], function () use ($buyers) {
                    return $buyers;
                }, function ($value) { // if the filter is active
                    $users = User::where("user_id", $value)->pluck("id", "id")->toArray();
                    if (count($users)) {
                        $this->crud->addClause('whereIn', 'user_id', $users);
                    } else {
                        $this->crud->addClause('whereIn', 'user_id', [0]);
                    }
                });
            }
        }
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(ShopOrdersRequest::class);

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


    public function show($id)
    {
        $this->crud->hasAccessOrFail('show');

        $order = $this->crud->getEntry($id);
        $order->load("shipping", "products");
        $orderStatuses = OrderStatus::get();
        $payments = Payment::withTrashed()->get();
        $crud = $this->crud;
        $payment = Payment::withTrashed()->find($order->payment_id);

        $history = Order::selectRaw("shop_orders.*, shop_order_statuses.name, shop_order_statuses.className")
            ->join("shop_order_statuses", "shop_order_statuses.id", "=", "shop_orders.status_id")
            ->where("user_id", $order->user_id)
            ->where("shop_orders.id", "!=", $order->id)
            ->orderBy("shop_orders.id", "desc")
            ->get();

        $templates = null;
        $messages = [];

        return view('admin.order.view', compact('crud', 'order', 'orderStatuses','templates','messages','payment','payments', 'history'));
    }


    public function updateStatus(Request $request, OrderStatusHistory $orderStatusHistory)
    {

        // Create history entry
        $orderStatusHistory->create($request->except('_token'));
        $this->crud->update($request->input('order_id'), ['status_id' => $request->input('status_id')]);

        if($request->has('notify')){
            $order = Order::find($request->input('order_id'));
            if($order){
                $status = OrderStatus::find($request->input('status_id'));
                $user = User::find($order->user_id);

                if($user){
                    $vet_email = ["status" => $status, "user" => $user, "country_id" => $user->country_id];
                    $destinatario = $user->email;

                    $shipping = ShopShippings::where("id", $order->shipping_id)->where("is_send_email", 1)->whereNotNull("email_description")->first();

                    if(!$shipping){
                        \Mail::send("common.emails.change_status_order", ['data' => $vet_email], function ($m) use ($destinatario, $user, $order) {
                            $m->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                            $m->replyTo(env('MAIL_TO_REPLAY'), env('MAIL_FROM_NAME'));
                            if($user->country_id == config('config.default_country_user_it')){
                                $m->to($destinatario)->subject("Cambio stato ordine n.$order->id");
                            }else{
                                $m->to($destinatario)->subject("Change of order no.$order->id");
                            }
                        });
                    }

                    if($shipping){
                        if($status->id == 4){ //STATO == COMPLETATO
                            $vet_email = ["status" => $status, "message" => $shipping->email_description, "user" => $user, "order" => $order, "country_id" => $user->country_id];
                            $destinatario = $user->email;

                            \Mail::send("common.emails.change_status_order_shipping", ['data' => $vet_email], function ($m) use ($destinatario, $user, $order) {
                                $m->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                                $m->replyTo(env('MAIL_TO_REPLAY'), env('MAIL_FROM_NAME'));
                                if($user->country_id == config('config.default_country_user_it')){
                                    $m->to($destinatario)->subject("Comunicazione ordine n.$order->id");
                                }else{
                                    $m->to($destinatario)->subject("Message order no.$order->id");
                                }
                            });
                        }
                    }

                }
            }
        }

        \Alert::success(trans('order.status_updated'))->flash();

        return redirect()->back();
    }

    public function updateOrderPayment(Request $request)
    {
        $this->crud->update($request->input('order_id'), ['payment_id' => $request->input('payment_id')]);
        \Alert::success("Metodo di pagamento modificato!")->flash();

        return redirect()->back();
    }

    public function deleteOrder(Request $request){
        $order = Order::find($request->input('order_id'));
        $order->delete();
        \Alert::success("Ordine cancellato con successo!")->flash();
        return redirect()->back();
    }

    public function saveTracking(Request $request){
        $theme = env('THEME');

        $this->crud->update($request->input('order_id'), ['status_id' => 3, 'tracking_code' => $request->input('code'), 'template_tracking_id' => $request->input('template_id')]);

        $template = MessageTemplate::find($request->input('template_id'));
        if($template){
            $order = Order::find($request->input('order_id'));
            $user = User::find($order->user_id);
            if($user) {
                $code = $request->input('code');
                $data['message'] = $template->content. "<br><strong>$code</strong>";

                if(is_numeric(strpos($template->name, "GLS"))){
                    $codeTC = substr($code, 0,2);
                    $codeREST = substr($code, 2);
                    $url_gls = "https://www.gls-italy.com/tracktraceuser/$codeTC/$codeREST";

                    $data['message'] .= "<br><a href='$url_gls'>Clicca qui per monitorare la spedizione!</a>";
                }

                $destinatario = $user->email;
                \Mail::send("$theme.emails.generic", ['data' => $data], function ($m) use ($destinatario) {
                    $m->from(env('PROJECT_EMAIL'), env('PROJECT_NAME_EMAIL'));
                    $m->replyTo(env('MAIL_TO_REPLAY'), env('MAIL_FROM_NAME'));
                    $project_name = env('PROJECT_NAME');
                    $m->to($destinatario)->subject("Messaggio da $project_name");
                });
            }
        }

        \Alert::success("Tracking code salvato con successo!")->flash();
        return redirect()->back();
    }


    public function sendMessage(Request $request){
        $theme = env('THEME');

        $user = User::find($request->get('to'));
        Message::insert([
            "name" => $request->get('name'),
            "content" => $request->get('content'),
            "from" => $request->get('from'),
            "to" => $request->get('to'),
            "created_at" => Carbon::now()->toDateTimeString()
        ]);

        if($user){
            $data['message'] = $request->get('content');

            $destinatario = $user->email;
            \Mail::send("$theme.emails.generic", ['data' => $data], function ($m) use ($destinatario) {
                $m->from(env('PROJECT_EMAIL'), env('PROJECT_NAME_EMAIL'));
                $m->replyTo(env('MAIL_TO_REPLAY'), env('MAIL_FROM_NAME'));
                $project_name = env('PROJECT_NAME');
                $m->to($destinatario)->subject("Messaggio da $project_name");
            });

            $destinatario = env('PROJECT_EMAIL');
            \Mail::send("$theme.emails.generic", ['data' => $data], function ($m) use ($destinatario) {
                $m->from(env('PROJECT_EMAIL'), env('PROJECT_NAME_EMAIL'));
                $m->replyTo(env('MAIL_TO_REPLAY'), env('MAIL_FROM_NAME'));
                $project_name = env('PROJECT_NAME');
                $m->to($destinatario)->subject("Copia Messaggio da $project_name a $destinatario");
            });
        }

        \Alert::success("Messaggio inviato con successo")->flash();

        return redirect()->back();
    }

    public function export_excel($id){
        $order = $this->crud->getEntry($id);
        return Excel::download(new OrderExport($order), "Ordine_$order->id.xlsx");
    }


    public function print_pdf($id, Request $request){
        $pdf = \App::make('snappy.pdf.wrapper');

        $price = 1;
        if($request->has('no-price')){
            $price = 0;
        }

        $order = $this->crud->getEntry($id);
        $order->load("shipping", "products");
        $orderStatuses = OrderStatus::get();
        $payments = Payment::withTrashed()->get();
        $crud = $this->crud;
        $payment = Payment::withTrashed()->find($order->payment_id);

        $history = Order::selectRaw("shop_orders.*, shop_order_statuses.name, shop_order_statuses.className")
            ->join("shop_order_statuses", "shop_order_statuses.id", "=", "shop_orders.status_id")
            ->where("user_id", $order->user_id)
            ->where("shop_orders.id", "!=", $order->id)
            ->orderBy("shop_orders.id", "desc")
            ->get();

        $templates = null;
        $messages = [];

        $html = view('vendor.backpack.base.plugins.ecommerce.pdf', compact('crud', 'order', 'orderStatuses','templates','messages','payment','payments', 'history', 'price'))->render();

        if($request->has('print')) {
            die($html);
        }

        $pdf->loadHTML($html)->setPaper('a4');
        return $pdf->download("Ordine_$id.pdf");

    }
}
