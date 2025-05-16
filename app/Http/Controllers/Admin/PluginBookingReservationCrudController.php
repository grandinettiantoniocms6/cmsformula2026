<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PluginBookingReservationRequest;
use App\Models\PluginBookingPayments;
use App\Models\PluginBookingReservation;
use App\Models\PluginBookingReservationRoom;
use App\Models\PluginBookingReservationRoomCheckin;
use App\Models\PluginBookingReservationService;
use App\Models\PluginBookingRoom;
use App\Models\PluginBookingRoomAddictions;
use App\Models\PluginBookingRoomServices;
use App\Models\PluginBookingServices;
use App\Models\PluginBookingSettings;
use App\Models\PluginBookingStatus;
use App\User;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * Class PluginBookingReservationCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PluginBookingReservationCrudController extends CrudController
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
        if(backpack_user()->roles[0]->id > 2){
            die;
        }

        CRUD::setModel(\App\Models\PluginBookingReservation::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/plugin-booking-reservation');
        CRUD::setEntityNameStrings('prenotazione', 'Booking prenotazioni');

        $this->crud->query->selectRaw("plugins_booking_reservations.*");
        $this->crud->query->join("users", "users.id", "=", "plugins_booking_reservations.user_id");
        $this->crud->query->where("is_hidden", 0);


        if(\request()->has('ko')){
            $status = PluginBookingStatus::where("is_annullato", 1)->get()->pluck("id", "id")->toArray();
            $this->crud->addClause('whereIn', 'plugin_booking_status_id', $status);
        }else{
            $status = PluginBookingStatus::where("is_annullato", "!=", 1)->get()->pluck("id", "id")->toArray();
            $this->crud->addClause('whereIn', 'plugin_booking_status_id', $status);
        }

        $this->crud->setListView(backpack_view('plugins.pluginBooking.list'));
        $this->crud->setEditView(backpack_view('plugins.pluginBooking.reservation_edit'));
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {

        // nascondo i pulsanti cancella
        $this->crud->removeButton("show");
        $this->crud->removeButton("delete");
        // Columns.

        $this->crud->setColumns([
            [
                'name'  => 'id',
                'label' => 'ID',
                'type'  => 'text',
                ],
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'user_id',
                'label' => 'Prenotazione di', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getUser', // the method in your Model
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                'limit' => 10000, // Limit the number of characters shown
                'searchLogic' => function ($query, $column, $searchTerm) {
                    $query->orWhere('users.name', 'like', '%'.$searchTerm.'%');
                    $query->orWhere('users.email', 'like', '%'.$searchTerm.'%');
                    $query->orWhere('users.mobile', 'like', '%'.$searchTerm.'%');
                }
            ],
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'rooms',
                'label' => 'Struttura', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getRooms', // the method in your Model
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                'limit' => 10000, // Limit the number of characters shown
            ],
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'date_start',
                'label' => 'Quando', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getDateStartEnd', // the method in your Model
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                'limit' => 10000, // Limit the number of characters shown
            ],
            [
                'name'  => 'total',
                'label' => 'Totale',
                'type'  => 'text',
            ],
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'is_processed',
                'label' => 'Proces.', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getIsProcessed', // the method in your Model
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                'limit' => 10000, // Limit the number of characters shown
            ],
            /*[
                'name'  => 'pin',
                'label' => 'PIN',
                'type'  => 'text',
            ],*/
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'plugin_booking_status_id',
                'label' => 'Stato', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getStatus', // the method in your Model
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                'limit' => 10000, // Limit the number of characters shown
            ],
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'is_payed',
                'label' => 'Pagato', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getIsPayed', // the method in your Model
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                'limit' => 10000, // Limit the number of characters shown
            ],
            /*[
                // run a function on the CRUD model and show its return value
                'name'  => 'type_id',
                'label' => 'Tipo', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getType', // the method in your Model
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                'limit' => 10000, // Limit the number of characters shown
            ],*/
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'payment_id',
                'label' => 'Pagamento', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getPayment', // the method in your Model
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                'limit' => 10000, // Limit the number of characters shown
            ],
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'partecipants',
                'label' => 'Ospiti', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'numberPartecipant', // the method in your Model
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                'limit' => 10000, // Limit the number of characters shown
            ],
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'check_document',
                'label' => 'Documenti', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'checkDocument', // the method in your Model
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                'limit' => 10000, // Limit the number of characters shown
            ],
        ]);

        // Filtro di ricerca By Websiland

        $this->crud->addFilter([
            'type'  => 'date_range',
            'name'  => 'from_to',
            'label' => 'Data Soggiorno'
        ],
            false,
            function ($value) { // if the filter is active, apply these constraints
                $dates = json_decode($value);
                $this->crud->addClause('where', 'date_start', '>=', $dates->from);
                $this->crud->addClause('where', 'date_end', '<=', $dates->to);

                $this->crud->query->orderBy("plugins_booking_reservations.date_start", "desc");
                $this->crud->query->orderBy("plugins_booking_reservations.date_end", "asc");

        });



        $status = ["NO", "SI"];
        $this->crud->addFilter([ // select2 filter
            'name' => 'is_processed',
            'type' => 'select2',
            'label'=> 'Processato'
        ], function() use ($status) {
            return $status;
        }, function($value) { // if the filter is active
            $this->crud->addClause('where', 'is_processed', '=', $value);
        });

        $status = ["NO", "SI"];
        $this->crud->addFilter([ // select2 filter
            'name' => 'is_payed',
            'type' => 'select2',
            'label'=> 'Pagato'
        ], function() use ($status) {
            return $status;
        }, function($value) { // if the filter is active
            $this->crud->addClause('where', 'is_payed', '=', $value);
        });



        if(\request()->has('ko')){
            $status = PluginBookingStatus::where("is_annullato", 1)->get()->pluck("name", "id")->toArray();
        }else{
            $status = PluginBookingStatus::where("is_annullato", 0)->get()->pluck("name", "id")->toArray();
        }

        // dropdown filter
        $this->crud->addFilter([
            'name'  => 'name',
            'type'  => 'select2',
            'label' => 'Stato Prenotazione'
        ], $status, function($value) { // if the filter is active
            $this->crud->addClause('where', 'plugin_booking_status_id', $value);
        });

        $options = User::selectRaw("CONCAT(name, ' (', email, ')') as name, id")->get()->pluck("name", "id")->toArray();
        $this->crud->addFilter([
            'name'  => 'user_id',
            'type'  => 'select2',
            'label' => 'Prenotazione di'
        ], function () use ($options) {
            return $options;
        }, function ($value) { // if the filter is active
            $this->crud->addClause('where', 'user_id', $value);
        });


        $setting = PluginBookingSettings::first();
        if($setting->is_pin == 0){
            $this->crud->removeColumn('pin');
        }
        if($setting->is_payment == 0){
            $this->crud->removeColumn('payment_id');
            $this->crud->removeColumn('is_payed');
        }

        if($setting->is_checkin == 0){
            $this->crud->removeColumn('check_document');
        }


        $rooms = PluginBookingRoom::get()->pluck("name", "id")->toArray();
        $this->crud->addFilter([
            'name'  => 'plugin_booking_room_id',
            'type'  => 'select2',
            'label' => 'Camera'
        ], function () use ($rooms) {
            return $rooms;
        }, function ($value) { // if the filter is active
            $this->crud->addClause('where', 'plugin_booking_room_id', $value);
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
        CRUD::setValidation(PluginBookingReservationRequest::class);

        $start = null;
        $time_start = null;
        $time_end = null;
        if(\request()->has('date_start')){
            $start = \request()->get('date_start');
            $temp = explode("T", $start);

            if(count($temp) > 1){
                $start = $temp[0];
                $time_start = substr($temp[1],0,5);
            }
        }

        $end = null;
        if(\request()->has('date_end')){
            if(\request()->get('date_end')){
                $end_carbon = Carbon::createFromFormat("Y-m-d", \request()->get('date_end'))->subDay()->toDateString();
                $end = $end_carbon;
            }
        }else{
             $end = $start;
        }

        $this->crud->addField([
            'name'  => 'date_start',
            'label' => 'Data inizio',
            'type'  => 'date',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
            'value' => $start
        ]);


        $this->crud->addField([
            'name'  => 'date_end',
            'label' => 'Data fine',
            'type'  => 'date',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
            'value' => $end
        ]);

        $this->crud->addField([
            'name'  => 'start_time',
            'label' => 'Ora inizio',
            'type'  => 'time',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
            'value' => $time_start
        ]);

        $this->crud->addField([
            'name'  => 'end_time',
            'label' => 'Ora fine',
            'type'  => 'time',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ]
        ]);

        $rooms = PluginBookingRoom::get()->pluck("name", "id")->toArray();
        $this->crud->addField([   // select2_from_array
            'name'        => 'rooms',
            'label'       => "Struttura",
            'type'        => 'select2_from_array',
            'options'     => $rooms,
            'allows_null' => false,
            'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ],
        ]);

        $users = User::get()->pluck("name", "id")->toArray();
        $this->crud->addField([   // select2_from_array
            'name'        => 'user_id',
            'label'       => "Prenotazione a nome di",
            'type'        => 'select2_from_array',
            'options'     => $users,
            'allows_null' => false,
            'allows_multiple' => false, // OPTIONAL; needs you to cast this to array in your model;
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ],
        ]);

        $this->crud->addField([   // select2_from_array
            'name'        => 'note',
            'label'       => "Note",
            'type'        => 'ckeditor',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-12'
            ],
        ]);

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
        CRUD::setValidation(PluginBookingReservationRequest::class);

        $setting = PluginBookingSettings::first();

        $rooms = [];
        $services = [];
        $id = null;
        $type = null;
        $parameters = \Route::current()->parameters(); //se sono in modifica
        $item = null;
        if(count($parameters) > 0){
            $rooms = PluginBookingReservationRoom::where("plugin_booking_reservation_id",  $parameters['id'])->get();
            $services = PluginBookingReservationService::where("plugin_booking_reservation_id",  $parameters['id'])->get();
            $id = $parameters['id'];

            $item = PluginBookingReservation::find($parameters['id']);
            $room = \App\Models\PluginBookingRoom::find($item->plugin_booking_room_id);

            if($room){
                $type = \App\Models\PluginBookingType::find($room->plugin_booking_type_id);
            }

        }

        $this->crud->addField([
            'name'  => 'date_start',
            'label' => 'Data inizio',
            'type'  => 'date',
            'wrapperAttributes' => [
                'class' => 'form-group col-xl-2 col-md-3'
            ],
        ]);

        $this->crud->addField([
            'name'  => 'date_end',
            'label' => 'Data fine',
            'type'  => 'date',
            'wrapperAttributes' => [
                'class' => 'form-group col-xl-2 col-md-3'
            ],
        ]);

        $this->crud->addField([
            'name'  => 'start_time',
            'label' => 'Ora inizio',
            'type'  => 'time',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ]
        ]);

        $this->crud->addField([
            'name'  => 'end_time',
            'label' => 'Ora fine',
            'type'  => 'time',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ]
        ]);

        $users = User::get()->pluck("name", "id")->toArray();
        $this->crud->addField([   // select2_from_array
            'name'        => 'user_id',
            'label'       => "Prenotato da",
            'type'        => 'select2_from_array',
            'options'     => $users,
            'allows_null' => false,
            'allows_multiple' => false, // OPTIONAL; needs you to cast this to array in your model;
            'wrapperAttributes' => [
                'class' => 'form-group col-xl-2 col-md-3'
            ],
        ]);

        if($setting->is_payment == 1){
            $payments = PluginBookingPayments::get()->pluck("name", "id")->toArray();
            $this->crud->addField([   // select2_from_array
                'name'        => 'plugin_booking_payment_id',
                'label'       => "Pagamento",
                'type'        => 'select2_from_array',
                'options'     => $payments,
                'allows_null' => true,
                'allows_multiple' => false, // OPTIONAL; needs you to cast this to array in your model;
                'wrapperAttributes' => [
                    'class' => 'form-group col-xl-2 col-md-2'
                ],
            ]);
        }


        $this->crud->addField([
            'name'  => 'total',
            'label' => 'Totale',
            'type'  => 'text',
            'attributes' => ['readonly' => 'readonly'],
            'wrapperAttributes' => [
                'class' => 'form-group col-md-1'
            ],
        ]);

        $status = PluginBookingStatus::get()->pluck("name", "id")->toArray();
        $this->crud->addField([   // select2_from_array
            'name'        => 'plugin_booking_status_id',
            'label'       => "Stato",
            'type'        => 'select2_from_array',
            'options'     => $status,
            'allows_null' => false,
            'allows_multiple' => false, // OPTIONAL; needs you to cast this to array in your model;
            'wrapperAttributes' => [
                'class' => 'form-group col-md-2'
            ],
        ]);

        $this->crud->addField([   // select2_from_array
            'name'        => 'send_status',
            'label'       => "Invia email cambio stato",
            'type'        => 'switch',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-2'
            ],
        ]);


        if($setting->is_payment == 1){
            $this->crud->addField([
                'name'  => 'is_payed',
                'label' => 'Pagato',
                'type'  => 'switch',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-1'
                ],
            ]);
        }

        if($type){
            if($type->is_pin == 1){
                $this->crud->addField([
                    'name'  => 'id',
                    'label' => '#ID',
                    'type'  => 'text',
                    'wrapperAttributes' => [
                        'class' => 'form-group col-xl-1 col-md-2'
                    ],
                    'attributes' => ['readonly' => 'readonly']
                ]);

                $this->crud->addField([
                    'name'  => 'is_block_upload',
                    'label' => 'Upload Block',
                    'type'  => 'switch',
                    'wrapperAttributes' => [
                        'class' => 'form-group col-xl-2 col-md-2'
                    ],
                ]);

                $this->crud->addField([
                    'name'  => 'pin',
                    'label' => 'PIN',
                    'type'  => 'text',
                    'wrapperAttributes' => [
                        'class' => 'form-group col-xl-1 col-md-2'
                    ],
                    'attributes' => ['disabled' => 'disabled']
                ]);

                $this->crud->addField([
                    'name'  => 'date_send_pin',
                    'label' => 'Data ultimo invio PIN',
                    'type'  => 'datetime',
                    'wrapperAttributes' => [
                        'class' => 'form-group col-xl-2 col-md-4'
                    ],
                    'attributes' => ['disabled' => 'disabled']
                ]);

                $this->crud->addField([
                    'name'  => 'date_last_sollecito',
                    'label' => 'Data ultimo sollecito',
                    'type'  => 'datetime',
                    'wrapperAttributes' => [
                        'class' => 'form-group col-xl-2 col-md-4'
                    ],
                    'attributes' => ['disabled' => 'disabled']
                ]);
            }

            if($type->can_payment == 1){
                $payment_date = null;
                if($item){
                    if($item->payment_date){
                        $payment_date = Carbon::createFromFormat("Y-m-d H:i:s", $item->payment_date)->format("Y-m-d");
                    }
                }

                $this->crud->addField([
                    'name'  => 'payment_date',
                    'label' => 'Data pagamento',
                    'type'  => 'date',
                    'wrapperAttributes' => [
                        'class' => 'form-group col-xl-2 col-md-4'
                    ],
                    "value" => $payment_date
                ]);
            }
        }


        $this->crud->addField([   // Checkbox
            'name'  => 'is_processed',
            'label' => 'Processata?',
            'type'  => 'switch',
            'default' => 1,
            'wrapperAttributes' => [
                'class' => 'form-group col-md-2'
            ],
        ]);

        $this->crud->addField([   // Checkbox
            'name'  => 'total_qty',
            'label' => 'Totale Adulti',
            'type'  => 'number',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-1'

            ],
            'attributes' => ['readonly' => 'readonly'],
        ]);

        $this->crud->addField([   // Checkbox
            'name'  => 'total_qty_bimbi',
            'label' => 'Totale Bimbi',
            'type'  => 'number',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-1'
            ],
            'attributes' => ['readonly' => 'readonly'],
        ]);

        $this->crud->addField([   // select2_from_array
            'name'        => 'note',
            'label'       => "Note",
            'type'        => 'ckeditor',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-12'
            ],
        ]);


        if($type){
            $this->crud->addField([   // CustomHTML
                'name' => 'separator_products',
                'type' => 'custom_html',
                'value' => view(backpack_view('plugins.pluginBooking.reservation_rooms'), compact('rooms', 'id', 'type'))->render(),
                'tab' => $type->is_checkin ? 'Check-in' : 'Prenotazione',
            ]);
        }



        $this->crud->addField([   // CustomHTML
            'name' => 'separator_services',
            'type' => 'custom_html',
            'value' => view(backpack_view('plugins.pluginBooking.reservation_rooms_services'), compact('services', 'id'))->render(),
            'tab' => 'Servizi aggiuntivi',
        ]);


        $this->crud->addField([
            'name'  => 'business_name',
            'label' => 'Ragione sociale',
            'type'  => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
            'tab' => "Fatturazione"
        ]);

        $this->crud->addField([
            'name'  => 'vat',
            'label' => 'P.Iva/CodiceFiscale',
            'type'  => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
            'tab' => "Fatturazione"
        ]);

        $this->crud->addField([
            'name'  => 'pec',
            'label' => 'Pec',
            'type'  => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
            'tab' => "Fatturazione"
        ]);

        $this->crud->addField([
            'name'  => 'sdi',
            'label' => 'Sdi',
            'type'  => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
            'tab' => "Fatturazione"
        ]);

        $this->crud->addField([
            'name'  => 'address_invoice',
            'label' => 'Indirizzo',
            'type'  => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
            'tab' => "Fatturazione"
        ]);

        $this->crud->addField([
            'name'  => 'street_invoice',
            'label' => 'Civico',
            'type'  => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-1'
            ],
            'tab' => "Fatturazione"
        ]);

        $this->crud->addField([
            'name'  => 'zip_invoice',
            'label' => 'Cap',
            'type'  => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-1'
            ],
            'tab' => "Fatturazione"
        ]);

        $this->crud->addField([
            'name'  => 'city_invoice',
            'label' => 'Città',
            'type'  => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-2'
            ],
            'tab' => "Fatturazione"
        ]);

        $this->crud->addField([
            'name'  => 'province_invoice',
            'label' => 'Provincia',
            'type'  => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-2'
            ],
            'tab' => "Fatturazione"
        ]);

        $this->crud->addField([
            'name'  => 'state_invoice',
            'label' => 'Nazione',
            'type'  => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-2'
            ],
            'tab' => "Fatturazione"
        ]);



    }

    public function getUrl(Request $request){
        $video = $request->get('url');
        $path = storage_path().'/'.'app'.'/'.$video;
        if (file_exists($path)) {
            return \Response::download($path);
        }
    }

    public function store()
    {
        $this->crud->hasAccessOrFail('create');

        // execute the FormRequest authorization and validation, if one is required
        $request = $this->crud->validateRequest();

        // insert item in the db
        $item = $this->crud->create($this->crud->getStrippedSaveRequest($request));
        $this->data['entry'] = $this->crud->entry = $item;

        $date_start = Carbon::createFromFormat('Y-m-d', $this->crud->entry->date_start);
        $date_end = Carbon::createFromFormat('Y-m-d', $this->crud->entry->date_end);
        $diff_in_day = $date_start->diffInDays($date_end);

        // show a success message
        \Alert::success(trans('backpack::crud.insert_success'))->flash();

        // save the redirect choice for next time
        $this->crud->setSaveAction();

        $tot = 0;
        $rooms = $request->get('rooms');
        if($rooms){
            $type_id = null;
            $plugin_booking_room_id = null;

            foreach ($rooms as $room_id){
                $room = PluginBookingRoom::find($room_id);

                PluginBookingReservationRoom::create([
                   "plugin_booking_reservation_id" => $this->crud->entry->id,
                   "plugin_booking_room_id" => $room_id,
                   "price" => $room->price * $diff_in_day,
                ]);

                $type_id = $room->plugin_booking_type_id;
                $plugin_booking_room_id = $room->id;
                $tot = $tot + ($room->price * $diff_in_day);
            }
        }

        $this->crud->entry->plugin_booking_room_id = $plugin_booking_room_id;
        $this->crud->entry->type_id = $type_id;
        $this->crud->entry->total = $tot;
        $this->crud->entry->save();

        return redirect()->to("/admin/plugin-booking-reservation/{$this->crud->entry->id}/edit");
    }

    public function update()
    {
        $this->crud->hasAccessOrFail('update');


        // execute the FormRequest authorization and validation, if one is required
        $request = $this->crud->validateRequest();


        // update the row in the db
        $item = $this->crud->update($request->get($this->crud->model->getKeyName()),
            $this->crud->getStrippedSaveRequest($request));
        $this->data['entry'] = $this->crud->entry = $item;

        // show a success message
        \Alert::success(trans('backpack::crud.update_success'))->flash();

        PluginBookingReservationRoomCheckin::where("plugin_booking_reservation_room_id", $item->id)->delete();

        if($request->has('first_name')){
            $first_name = $request->get('first_name');
            $last_name = $request->get('last_name');
            $birthdate = $request->get('birthdate');
            $email = $request->get('email');
            $mobile = $request->get('mobile');
            $carta = $request->get('carta');
            $scadenza_carta = $request->get('scadenza_carta');
            $comune = $request->get('comune');
            $documento = $request->file('file');
            $document_file = $request->get('document_file');
            if($document_file == null){
                $document_file = [];
            }

            if($documento == null){
                $documento = [];
            }


            foreach ($first_name as $k=>$value){

                $path = null;

                if($request->has('file')){
                    if($documento[$k]){
                        //Storage::delete('/public/avatars/'.$user->avatar);

                        // Get filename with the extension
                        $filenameWithExt = $documento[$k]->getClientOriginalName();
                        //Get just filename
                        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                        // Get just ext
                        $extension = $documento[$k]->getClientOriginalExtension();
                        // Filename to store
                        $fileNameToStore = $filename.'_'.time().'.'.$extension;
                        // Upload Image
                        $path = $documento[$k]->storeAs('public/plugins_booking/documents',$fileNameToStore);
                    }
                }

                if(count($document_file)){
                    if(key_exists($k, $document_file)){
                        $path = $document_file[$k];
                    }
                }



                PluginBookingReservationRoomCheckin::create([
                   "plugin_booking_reservation_room_id" => $item->id,
                   "first_name" => $value,
                   "last_name" => $last_name[$k],
                   "email" => $email[$k],
                   "mobile" => $mobile[$k],
                   "birthdate" => $birthdate[$k],
                   "numero_carta_identita" => $carta[$k],
                   "scadenza_carta_identita" => $scadenza_carta[$k],
                   "comune_carta_identita" => $comune[$k],
                   "document_file" => $path
                ]);
            }

        }

        if($request->has('prices_rooms')){
            $prices_rooms = $request->get('prices_rooms');
            if(count($prices_rooms)){
                foreach ($prices_rooms as $room_id => $price){
                    PluginBookingReservationRoom::where("plugin_booking_reservation_id", $item->id)
                        ->where("plugin_booking_room_id", $room_id)
                        ->update([
                           "price" => $price
                        ]);
                }
            }
        }

        $tot = 0;
        PluginBookingReservationService::where("plugin_booking_reservation_id", $item->id)->delete();
        if($request->get('service_id')){
            $service_id = $request->get('service_id');
            $service_qty = $request->get('service_qty');
            $service_price = $request->get('service_price');
            foreach ($service_id as $k=>$v){
                $serv_item = PluginBookingServices::find($v);

                PluginBookingReservationService::create([
                   "plugin_booking_reservation_id" => $item->id,
                   "plugin_booking_service_id" => $v,
                   "name" => $serv_item->name,
                   "price" => $service_price[$k],
                   "qty" => $service_qty[$k],
                ]);

                $tot = $tot + ($service_price[$k] * $service_qty[$k]);
            }
        }


        $reservation_room = PluginBookingReservationRoom::where("plugin_booking_reservation_id", $this->crud->entry->id)->first();
        $item->total = $reservation_room->price + $tot;
        $item->save();


        PluginBookingReservation::where("parent_id", $this->crud->entry->id)
            ->update([
                "date_start" => $this->crud->entry->date_start,
                "date_end" => $this->crud->entry->date_end,
                "is_payed" => $this->crud->entry->is_payed,
                "plugin_booking_status_id" => $this->crud->entry->plugin_booking_status_id,
                "start_time" => $this->crud->entry->start_time,
                "end_time" => $this->crud->entry->end_time
            ]);

        // save the redirect choice for next time
        $this->crud->setSaveAction();

        if($request->has('send_status')){

            $send_status = $request->get('send_status');

            if($send_status == 1){
                $user = User::find($item->user_id);

                $vet_email = ["user" => $user, "reservation" => $item];
                $destinatario = $user->email;

                \Mail::send("common.emails.pluginBooking.change_status", ['data' => $vet_email], function ($m) use ($destinatario, $user) {
                    $m->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                    $m->replyTo(env('MAIL_TO_REPLAY'), env('MAIL_FROM_NAME'));
                    $m->to($destinatario)->subject("Cambio stato della tua prenotazione!");
                });
            }

        }


        return $this->crud->performSaveAction($item->getKey());
    }


    public function planning(Request $request){
        if($request->has('type')){
            if($request->get('type') != 0){
                $units = PluginBookingRoom::where("plugin_booking_type_id", $request->get('type'))->get();
            }else{
                $units = PluginBookingRoom::get();
            }
        }else{
            $units = PluginBookingRoom::get();
        }

        return view(backpack_view("plugins.pluginBooking.planning"), compact('units'));
    }

    public function events(Request $request){
        $type = $request->get('type');

        $start = substr($request->get('start'),0,10);
        $end = substr($request->get('end'),0,10);
        $v_json = [];

        $start_ca = Carbon::createFromFormat("Y-m-d", $start);
        $end_ca = Carbon::createFromFormat("Y-m-d", $end);
        $diff = $start_ca->diffInDays($end_ca);

        $status_no_block = PluginBookingStatus::where("is_unblock", 0)->pluck("id", "id")->toArray();

        if($diff == 1){
            if($type == 0){
                $reservations = PluginBookingReservation::whereRaw("'$start' BETWEEN date_start AND date_end")
                    ->whereIn("plugin_booking_status_id", $status_no_block)
                    ->get();
            }else{
                $reservations = PluginBookingReservation::whereRaw("'$start' BETWEEN date_start AND date_end")
                    ->whereIn("plugin_booking_status_id", $status_no_block)
                    ->where("type_id", $type)
                    ->get();
            }
        }else{
            if($type == 0){
                $reservations = PluginBookingReservation::whereRaw("date_start >= '$start' && date_end <= '$end'")
                    ->whereIn("plugin_booking_status_id", $status_no_block)
                    ->get();
            }else{
                $reservations = PluginBookingReservation::whereRaw("date_start >= '$start' && date_end <= '$end'")
                    ->whereIn("plugin_booking_status_id", $status_no_block)
                    ->where("type_id", $type)
                    ->get();
            }
        }

        if($reservations){
            foreach ($reservations as $reservation){
                if($reservation->user_id == null){
                    $client_name = "ADMIN";
                }else{
                    $user = User::withTrashed()->find($reservation->user_id);
                    if($user){
                        $client_name = $user->name;
                    }
                }

                $title = strtoupper("$client_name");

                $reservations_rooms = PluginBookingReservationRoom::where("plugin_booking_reservation_id", $reservation->id)->get();
                if(count($reservations_rooms) > 0){
                    foreach ($reservations_rooms as $rc){
                        $room = PluginBookingRoom::withTrashed()->where("id", $rc->plugin_booking_room_id)->first();
                        if(!$room){
                            continue;
                        }

                        $className = "";
                        $categoryName = "- {$room->name}";

                        $status = PluginBookingStatus::where("id", $reservation->plugin_booking_status_id)->first();

                        $classNameStatus = "";
                        $color_event = "black";
                        if($status){
                            $color_event = $status->color_admin;
                        }

                        $start_time = "00:00:00";
                        $end_time = "23:59:59";
                        $allday = true;

                        if($reservation->start_time){
                            $start_time = $reservation->start_time;
                            $allday = false;
                        }

                        if($reservation->end_time){
                            $end_time = $reservation->end_time;
                        }

                        if($reservation->date_end == null){
                            $reservation->date_end = $reservation->date_start;
                        }

                        $icon_parent = "";
                        if($reservation->parent_id){
                            $reservation->id = $reservation->parent_id;
                            $rc->id = $reservation->parent_id;

                            $parent = PluginBookingRoom::find($reservation->id);

                            $icon_parent = "\n***$parent->name***";
                        }

                        $v_json[] = [
                            'id' => $reservation->id,
                            'id_res' => $reservation->id,
                            'resourceId' => $reservation->plugin_booking_room_id,
                            'start' => $reservation->date_start. 'T' . "$start_time",
                            'end' => $reservation->date_end. 'T' . "$end_time",
                            'backgroundColor' => $color_event,
                            'className' => ["event-cms", "event-$className", "event-$classNameStatus"],
                            'borderColor'=> 'transparent',
                            'textColor' => '#FFFFFF',
                            'title' => "$title $categoryName $icon_parent",
                            "mobile" => "",
                            "status_name" => "",
                            "allDay" => $allday
                        ];
                    }
                }

            }
        }
        return $v_json;
    }

    public function generate_pin($id){
        $reservation = PluginBookingReservation::find($id);
        if($reservation){
            $pin = random_int(100000, 999999);
            $reservation->pin = $pin;
            $reservation->save();

            \Alert::success("Pin generato con successo")->flash();
        }


        return redirect()->back();

    }

    public function send_pin($id){
        $reservation = PluginBookingReservation::find($id);
        if($reservation){
            $reservation->is_block_upload = 1;
            $reservation->date_send_pin = Carbon::now()->toDateTimeString();
            $reservation->save();

            $user = User::find($reservation->user_id);

            $vet_email = ["pin" => $reservation->pin, "user" => $user, "reservation" => $reservation];
            $destinatario = $user->email;

            \Mail::send("common.emails.pluginBooking.send_pin", ['data' => $vet_email], function ($m) use ($destinatario, $user) {
                $m->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                $m->replyTo(env('MAIL_TO_REPLAY'), env('MAIL_FROM_NAME'));
                $m->to($destinatario)->subject("Il PIN per la tua prenotazione!");
            });

            \Alert::success("Inviato con successo")->flash();
        }

        return redirect()->back();
    }

    public function send_sollecito($id){
        $reservation = PluginBookingReservation::find($id);
        if($reservation){
            $reservation->date_last_sollecito = Carbon::now()->toDateTimeString();
            $reservation->save();

            $user = User::find($reservation->user_id);

            $vet_email = ["pin" => $reservation->pin, "user" => $user, "reservation" => $reservation];
            $destinatario = $user->email;

            \Mail::send("common.emails.pluginBooking.send_sollecito", ['data' => $vet_email], function ($m) use ($destinatario, $user) {
                $m->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                $m->replyTo(env('MAIL_TO_REPLAY'), env('MAIL_FROM_NAME'));
                $m->to($destinatario)->subject("Non hai caricato ancora i documenti!");
            });

            \Alert::success("Inviato con successo")->flash();
        }

        return redirect()->back();
    }
}
