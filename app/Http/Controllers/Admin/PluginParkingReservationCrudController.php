<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PluginParkingReservationRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
/**
 * Class PluginParkingReservationCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PluginParkingReservationCrudController extends CrudController
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
        CRUD::setModel(\App\Models\PluginParkingReservation::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/plugin-parking-reservation');
        CRUD::setEntityNameStrings('prenotazione', 'prenotazioni');

        $this->crud->setListView(backpack_view('plugins.pluginParking.list'));

        $this->crud->orderBy("created_at", "desc");
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $this->crud->removeButton('show');
        $this->crud->removeButton('update');
        $this->crud->removeButton('delete');

        $this->crud->setColumns([
            [
                'name'  => 'id',
                'label' => 'ID',
                'type'  => 'text',
            ],
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'from',
                'label' => 'Sorgente', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getFrom', // the method in your Model
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                'limit' => 10000, // Limit the number of characters shown
            ],

            [
                'name'  => 'name',
                'label' => 'Nome Cognome',
                'type'  => 'text',
            ],
            [
                'name'  => 'mobile',
                'label' => 'Telefono',
                'type'  => 'text',
            ],
            [
                'name'  => 'email',
                'label' => 'Email',
                'type'  => 'text',
            ],
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'is_blacklist',
                'label' => 'Impostazioni', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getSetting', // the method in your Model
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                'limit' => 10000, // Limit the number of characters shown
            ],
           /* [
                // run a function on the CRUD model and show its return value
                'name'  => 'is_blacklist',
                'label' => 'BlackList', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getIsBlackList', // the method in your Model
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                'limit' => 10000, // Limit the number of characters shown
            ],*/
          /*  [
                // run a function on the CRUD model and show its return value
                'name'  => 'is_newsletter',
                'label' => 'Newsletter', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getIsNewsletter', // the method in your Model
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                'limit' => 10000, // Limit the number of characters shown
            ],*/
           /* [
                // run a function on the CRUD model and show its return value
                'name'  => 'is_payed',
                'label' => 'Pagato', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getIsPayed', // the method in your Model
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                'limit' => 10000, // Limit the number of characters shown
            ],
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'is_checkin',
                'label' => 'Entrata', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getIsCheckin', // the method in your Model
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                'limit' => 10000, // Limit the number of characters shown
            ],*/
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'date_start',
                'label' => 'Ingresso', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getStart', // the method in your Model
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                'limit' => 100000, // Limit the number of characters shown
            ],
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'date_end',
                'label' => 'Uscita', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getEnd', // the method in your Model
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                'limit' => 100000, // Limit the number of characters shown
            ],
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'type_park',
                'label' => 'Tipo', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getType', // the method in your Model
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                'limit' => 100000, // Limit the number of characters shown
            ],
            [
                'name'  => 'number_days',
                'label' => 'N.Giorni',
                'type'  => 'text',
            ],

            [
                // run a function on the CRUD model and show its return value
                'name'  => 'total',
                'label' => 'Totale', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getTotal', // the method in your Model
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                'limit' => 100000, // Limit the number of characters shown
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


        // daterange filter
        $this->crud->addFilter([
            'type'  => 'date_range',
            'name'  => 'from_to',
            'label' => 'Data Ingresso'
        ],
            false,
            function ($value) { // if the filter is active, apply these constraints
                $dates = json_decode($value);
                $this->crud->addClause('where', 'date_start', '>=', $dates->from);
                $this->crud->addClause('where', 'date_start', '<=', $dates->to);
            });


        // daterange filter
        $this->crud->addFilter([
            'type'  => 'date_range',
            'name'  => 'from_to_exit',
            'label' => 'Data uscita'
        ],
            false,
            function ($value) { // if the filter is active, apply these constraints
                $dates = json_decode($value);
                $this->crud->addClause('where', 'date_end', '>=', $dates->from);
                $this->crud->addClause('where', 'date_end', '<=', $dates->to);
            });

        // daterange filter
        $this->crud->addFilter([
            'type'  => 'date',
            'name'  => 'day',
            'label' => 'Giorno'
        ],
            false,
            function ($value) { // if the filter is active, apply these constraints
                $this->crud->addClause('whereRaw', "(date_start <= '$value' AND date_end >= '$value')");
            });



        $status = [1 => "Scoperto", 2 => "Coperto"];
        // select2 filter
        $this->crud->addFilter([
            'name'  => 'type_park',
            'type'  => 'select2',
            'label' => 'Tipo Parcheggio'
        ], function () use ($status) {
            return $status;
        }, function ($value) { // if the filter is active
            $this->crud->addClause('where', 'type_park', $value);
        });

        $status = ["tutti" => "Tutti", "parkos" => "Parkos", "sito" => "Sito"];
        // select2 filter
        $this->crud->addFilter([
            'name'  => 'from',
            'type'  => 'select2',
            'label' => 'Sorgente'
        ], function () use ($status) {
            return $status;
        }, function ($value) { // if the filter is active
            if($value == "parkos"){
                $this->crud->addClause('where', 'from', "parkos");
            }

            if($value == "sito"){
                $this->crud->addClause('where', 'from', null);
            }

        });

        $status = [2034 => "Paga online", 2035 => "Paga in parcheggio"];
        // select2 filter
        $this->crud->addFilter([
            'name'  => 'merchant_id',
            'type'  => 'select2',
            'label' => 'Parkos pagamento'
        ], function () use ($status) {
            return $status;
        }, function ($value) { // if the filter is active
              $this->crud->addClause('where', 'merchant_id', $value);
        });

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(PluginParkingReservationRequest::class);

        $parameters = \Route::current()->parameters();
        if(count($parameters)){
            $this->crud->addField([
                'label' => "ID",
                'name' => "id",
                'type'  => 'text',
                "attributes" => ["readonly" => true],
                'wrapperAttributes' => ['class' => 'form-group col-md-1']
            ]);
        }

        $this->crud->addField([
            'label' => "Nome e Cognome",
            'name' => "name",
            'type'  => 'text',
            'wrapperAttributes' => ['class' => 'form-group col-md-2']
        ]);

        $this->crud->addField([
            'label' => "Email",
            'name' => "email",
            'type'  => 'email',
            'wrapperAttributes' => ['class' => 'form-group col-md-2']
        ]);

        $this->crud->addField([
            'label' => "Telefono",
            'name' => "mobile",
            'type'  => 'text',
            'wrapperAttributes' => ['class' => 'form-group col-md-2']
        ]);

        $this->crud->addField([
            'label' => "Black List?",
            'name' => "is_blacklist",
            'type'  => 'switch',
            'wrapperAttributes' => ['class' => 'form-group col-md-1']
        ]);

        $this->crud->addField([
            'label' => "Newsletter?",
            'name' => "is_newsletter",
            'type'  => 'switch',
            'wrapperAttributes' => ['class' => 'form-group col-md-1']
        ]);

        $this->crud->addField([
            'label' => "Pagato?",
            'name' => "is_payed",
            'type'  => 'switch',
            'wrapperAttributes' => ['class' => 'form-group col-md-1']
        ]);

        $this->crud->addField([
            'label' => "Entrato?",
            'name' => "is_checkin",
            'type'  => 'switch',
            'wrapperAttributes' => ['class' => 'form-group col-md-1']
        ]);

        $this->crud->addField([
            'label' => "Data pagamento",
            'name' => "date_payment",
            'type'  => 'date',
            'wrapperAttributes' => ['class' => 'form-group col-md-2']
        ]);

        $this->crud->addField([
            'label' => "Data ingresso",
            'name' => "date_start",
            'type'  => 'date',
            'wrapperAttributes' => ['class' => 'form-group col-md-3']
        ]);

        $this->crud->addField([
            'label' => "Ora ingresso",
            'name' => "time_start",
            'type'  => 'time',
            'wrapperAttributes' => ['class' => 'form-group col-md-3']
        ]);

        $this->crud->addField([
            'label' => "Data uscita",
            'name' => "date_end",
            'type'  => 'date',
            'wrapperAttributes' => ['class' => 'form-group col-md-3']
        ]);

        $this->crud->addField([
            'label' => "Ora uscita",
            'name' => "time_end",
            'type'  => 'time',
            'wrapperAttributes' => ['class' => 'form-group col-md-3']
        ]);

        $this->crud->addField([
            'label' => "Numero Volo",
            'name' => "number_flight",
            'type'  => 'text',
            'wrapperAttributes' => ['class' => 'form-group col-md-6']
        ]);

        $this->crud->addField([
            'label' => "Targa",
            'name' => "targa",
            'type'  => 'text',
            'wrapperAttributes' => ['class' => 'form-group col-md-6']
        ]);

        $this->crud->addField([   // repeatable
            'name'        => 'type_park',
            'label'   => 'Tipologia Parcheggio',
            'type'        => 'select_from_array',
            'options'     => [1 => 'Scoperto', 2 => 'Coperto'],
            'allows_null' => false,
            'wrapper' => ['class' => 'form-group col-md-3']
        ]);

        $this->crud->addField([   // repeatable
            'name'        => 'number_days',
            'label'   => 'Numero di giorni',
            'type'        => 'number',
            'wrapper' => ['class' => 'form-group col-md-3']
        ]);

        $this->crud->addField([   // repeatable
            'name'        => 'total',
            'label'   => 'Totale &euro;',
            'type'        => 'text',
            'wrapper' => ['class' => 'form-group col-md-3']
        ]);

        $this->crud->addField([   // repeatable
            'name'        => 'note',
            'label'   => 'Note',
            'type'        => 'ckeditor',
            'wrapper' => ['class' => 'form-group col-md-12']
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
        $this->setupCreateOperation();
    }

    public function panoramica(){
        return view(backpack_view('plugins.pluginParking.planning'));
    }

    public function monitor(Request $request){
        $date_en = \Carbon\Carbon::now()->toDateString();

        if($request->has('data')){
            $date_en = $request->get('data');
        }

        $reservations_in  = \App\Models\PluginParkingReservation::whereRaw("date_start = '$date_en'")
            ->orderBy("time_start", "asc")
            ->get();
        $reservations_out  = \App\Models\PluginParkingReservation::whereRaw("date_end = '$date_en'")
            ->orderBy("time_end", "asc")
            ->get();
        if($request->get('button') == "export"){
            return Excel::download(new \App\Exports\PluginParkingMonitorExport($reservations_in, $reservations_out, $date_en), "monitor.xlsx");
        }

        return view(backpack_view('plugins.pluginParking.monitor'), compact('date_en', 'reservations_in', 'reservations_out'));
    }
}
