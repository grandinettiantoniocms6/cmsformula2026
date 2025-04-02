<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PluginInterventionsRequest;
use App\Models\PartnerDocument;
use App\Models\PluginInterventions;
use App\Models\PluginInterventionsClients;
use App\Models\PluginInterventionsDrivers;
use App\Models\PluginInterventionsLaborers;
use App\Models\PluginInterventionsSetting;
use App\Models\PluginInterventionsStatus;
use App\Models\PluginInterventionsVehicles;
use App\Models\PluginOrders;
use App\Models\PluginOrdersClients;
use App\Models\PluginOrdersDetail;
use App\Models\PluginOrdersSettings;
use App\Models\PluginOrdersStatuses;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

/**
 * Class PluginInterventionsCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PluginInterventionsCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\EditableColumns\Http\Controllers\Operations\MinorUpdateOperation;

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

        CRUD::setModel(\App\Models\PluginInterventions::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/plugin-interventions');
        CRUD::setEntityNameStrings('intervento', 'interventi');

        $this->crud->query->selectRaw("plugins_interventions.*");
        $this->crud->query->join("plugins_interventions_clients", "plugins_interventions_clients.id", "=", "client_id");

        // ordinamento per data e orario
        //$this->crud->query->orderBy("plugins_interventions.date_intervention", "desc");
        //$this->crud->query->orderBy("plugins_interventions.start", "asc");

        $this->crud->setListView(backpack_view('plugins.pluginInterventions.list'));
        $this->crud->setEditView(backpack_view('plugins.pluginInterventions.edit'));
        $this->crud->setCreateView(backpack_view('plugins.pluginInterventions.create'));
    }

    public function search()
    {
        $this->crud->hasAccessOrFail('list');

        $this->crud->applyUnappliedFilters();

        $totalRows = $this->crud->model->count();
        $filteredRows = $this->crud->query->toBase()->getCountForPagination();
        $startIndex = request()->input('start') ?: 0;
        // if a search term was present
        if (request()->input('search') && request()->input('search')['value']) {
            // filter the results accordingly
            $this->crud->applySearchTerm(request()->input('search')['value']);
            // recalculate the number of filtered rows
            $filteredRows = $this->crud->count();
        }
        // start the results according to the datatables pagination
        if (request()->input('start')) {
            $this->crud->skip((int) request()->input('start'));
        }
        // limit the number of results according to the datatables pagination
        if (request()->input('length')) {
            $this->crud->take((int) request()->input('length'));
        }
        // overwrite any order set in the setup() method with the datatables order
        if (request()->input('order')) {
            // clear any past orderBy rules
            $this->crud->query->getQuery()->orders = null;
            foreach ((array) request()->input('order') as $order) {
                $column_number = (int) $order['column'];
                $column_direction = (strtolower((string) $order['dir']) == 'asc' ? 'ASC' : 'DESC');
                $column = $this->crud->findColumnById($column_number);
                if ($column['tableColumn'] && ! isset($column['orderLogic'])) {
                    // apply the current orderBy rules
                    $this->crud->orderByWithPrefix($column['name'], $column_direction);

                    if($column['name'] == "date_intervention"){
                        $this->crud->orderByWithPrefix("start", "asc");
                    }
                }

                // check for custom order logic in the column definition
                if (isset($column['orderLogic'])) {
                    $this->crud->customOrderBy($column, $column_direction);
                }
            }
        }

        // show newest items first, by default (if no order has been set for the primary column)
        // if there was no order set, this will be the only one
        // if there was an order set, this will be the last one (after all others were applied)
        // Note to self: `toBase()` returns also the orders contained in global scopes, while `getQuery()` don't.
        $orderBy = $this->crud->query->toBase()->orders;
        $table = $this->crud->model->getTable();
        $key = $this->crud->model->getKeyName();

        $hasOrderByPrimaryKey = collect($orderBy)->some(function ($item) use ($key, $table) {
            return (isset($item['column']) && $item['column'] === $key)
                || (isset($item['sql']) && str_contains($item['sql'], "$table.$key"));
        });


        if (! $hasOrderByPrimaryKey) {
           // dump($this->crud->model->getKeyName());
            $this->crud->orderByWithPrefix($this->crud->model->getKeyName(), 'DESC');
        }

        $entries = $this->crud->getEntries();

        return $this->crud->getEntriesAsJsonForDatatables($entries, $totalRows, $filteredRows, $startIndex);
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
        $this->crud->removeButton("update");
        $this->crud->removeButton("delete");

        $this->crud->setColumns([
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'id',
                'label' => '<input type="checkbox" id="select_all"/>', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getCheck', // the method in your Model
                'limit' => 1000,
                'orderable' => false
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
            ],
            /*[
                // run a function on the CRUD model and show its return value
                'name'  => 'id',
                'label' => '#', // Table column heading
                'type'  => 'text',
            ],*/
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'date_intervention',
                'label' => 'Data intervento', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getDate', // the method in your Model
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                'limit' => 10000, // Limit the number of characters shown
            ],
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'client_id',
                'label' => 'Cliente', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getClient', // the method in your Model
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                'limit' => 10000, // Limit the number of characters shown
                'searchLogic' => function ($query, $column, $searchTerm) {
                    $query->orWhere('plugins_interventions_clients.last_name', 'like', '%'.$searchTerm.'%');
                    $query->orWhere('plugins_interventions_clients.first_name', 'like', '%'.$searchTerm.'%');
                    $query->orWhere('plugins_interventions_clients.mobile', 'like', '%'.$searchTerm.'%');
                    $query->orWhere('plugins_interventions.address', 'like', '%'.$searchTerm.'%');
                    $query->orWhere('plugins_interventions.cap', 'like', '%'.$searchTerm.'%');
                    $query->orWhere('plugins_interventions.comune', 'like', '%'.$searchTerm.'%');
                    $query->orWhere('plugins_interventions.frazione', 'like', '%'.$searchTerm.'%');
                }
            ],
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'address',
                'label' => 'Indirizzo', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getAddress', // the method in your Model
                //'function_parameters' => [$one, $two], // pass one/more parameters to that method
                'limit' => 10000, // Limit the number of characters shown
            ],
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'driver_id',
                'label' => 'Autista', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getDriver', // the method in your Model
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                'limit' => 10000, // Limit the number of characters shown
            ],
           /*[
                // run a function on the CRUD model and show its return value
                'name'  => 'laborer_id',
                'label' => 'Manovale', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getLaborer', // the method in your Model
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                'limit' => 10000, // Limit the number of characters shown
            ],*/
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'vehicle_id',
                'label' => 'Mezzo', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getVehicle', // the method in your Model
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                'limit' => 10000, // Limit the number of characters shown
            ],
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'status_id',
                'label' => 'Stato', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getStatus', // the method in your Model
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                'limit' => 10000, // Limit the number of characters shown
            ],
            [
                'name'  => 'is_delivery',
                'label' => 'Con.',
                'type'  => 'editable_switch',

                // Optionals
                // All the options available on editable_checkbox are available here too, plus;
                'color'   => 'success',
                'onLabel' => '✓',
                'offLabel' => '✕',
            ],
            [
                'name'  => 'is_priority',
                'label' => 'Ann.',
                'type'  => 'editable_switch',

                // Optionals
                // All the options available on editable_checkbox are available here too, plus;
                'color'   => 'success',
                'onLabel' => '✓',
                'offLabel' => '✕',
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

        // FILTRI ATTIVATI daterange filter


        // Filtro per data intervento
        $this->crud->addFilter([
            'type'  => 'date_range',
            'name'  => 'from_to',
            'label' => 'Data Intervento'
        ],
            false,
            function ($value) { // if the filter is active, apply these constraints
                $dates = json_decode($value);
                $this->crud->addClause('where', 'date_intervention', '>=', $dates->from);
                $this->crud->addClause('where', 'date_intervention', '<=', $dates->to);

                $this->crud->query->orderBy("plugins_interventions.date_intervention", "desc");
                $this->crud->query->orderBy("plugins_interventions.start", "asc");
            });

        // Filtro per Cliente
        $options = PluginInterventionsClients::selectRaw("CONCAT(first_name, ' ', last_name) as name, id")->get()->pluck("name", "id")->toArray();
        $this->crud->addFilter([
            'name'  => 'client_id',
            'type'  => 'select2',
            'label' => 'Cliente'
        ], function () use ($options) {
            return $options;
        }, function ($value) { // if the filter is active
            $this->crud->addClause('where', 'client_id', $value);
        });

        // Filtro per Stato
        $options = PluginInterventions::get();

        $v_address = [];
        if($options){
            foreach ($options as $option){
                $v_address[$option->client_id] = "$option->first_name $option->last_name | $option->address $option->civico ($option->frazione) $option->cap - $option->comune $option->provincia";
            }
        }

        $this->crud->addFilter([
            'name'  => 'address_id',
            'type'  => 'select2',
            'label' => 'Indirizzo'
        ], function () use ($v_address) {
            return $v_address;
        }, function ($value) { // if the filter is active
            $this->crud->addClause('where', 'plugins_interventions.client_id', $value);
        });


        /*
        // Filtro per via e civico
        $options = PluginInterventionsClients::selectRaw("CONCAT(address, ' ', civico) as name, id")->get()->pluck("name", "id")->toArray();
        $this->crud->addFilter([
            'name'  => 'address_id',
            'type'  => 'select2',
            'label' => 'Via e civico'
        ], function () use ($options) {
            return $options;
        }, function ($value) { // if the filter is active
            $this->crud->addClause('where', 'client_id', $value);
        });

        // Filtro per comune e provincia
        $options = PluginInterventionsClients::selectRaw("CONCAT(comune, ' ', provincia) as name, id")->get()->pluck("name", "id")->toArray();
        $this->crud->addFilter([
            'name'  => 'address2_id',
            'type'  => 'select2',
            'label' => 'Comune e PR'
        ], function () use ($options) {
            return $options;
        }, function ($value) { // if the filter is active
            $this->crud->addClause('where', 'client_id', $value);
        });
        */


        // Filtro per Autista
        $options = PluginInterventionsDrivers::selectRaw("CONCAT(first_name, ' ', last_name) as name, id")->get()->pluck("name", "id")->toArray();
        $this->crud->addFilter([
            'name'  => 'driver_id',
            'type'  => 'select2',
            'label' => 'Autista'
        ], function () use ($options) {
            return $options;
        }, function ($value) { // if the filter is active
            $this->crud->addClause('where', 'driver_id', $value);
        });

        // Filtro per Manovale
        $options = PluginInterventionsLaborers::selectRaw("CONCAT(first_name, ' ', last_name) as name, id")->get()->pluck("name", "id")->toArray();
        $this->crud->addFilter([
            'name'  => 'laborer_id',
            'type'  => 'select2',
            'label' => 'Manovale'
        ], function () use ($options) {
            return $options;
        }, function ($value) { // if the filter is active
            $this->crud->addClause('where', 'laborer_id', $value);
        });

        // Filtro per Mezzo
        $options = PluginInterventionsVehicles::selectRaw("CONCAT(name, ' (', code,')') as name, id")->get()->pluck("name", "id")->toArray();
        $this->crud->addFilter([
            'name'  => 'vehicle_id',
            'type'  => 'select2',
            'label' => 'Mezzo'
        ], function () use ($options) {
            return $options;
        }, function ($value) { // if the filter is active
            $this->crud->addClause('where', 'vehicle_id', $value);
        });

        // Filtro per Stato
        $options = PluginInterventionsStatus::selectRaw("name, id")->get()->pluck("name", "id")->toArray();
        $this->crud->addFilter([
            'name'  => 'status_id',
            'type'  => 'select2',
            'label' => 'Stato'
        ], function () use ($options) {
            return $options;
        }, function ($value) { // if the filter is active
            $this->crud->addClause('where', 'status_id', $value);
        });


        // COMMENTO RICHIESTA DEL 27/06/2024

        // Filtro per Priorità - commentato

        /*
        $this->crud->addFilter([
            'type'  => 'simple',
            'name'  => 'priority',
            'label' => 'Con Priorità'
        ],
            false,
            function() { // if the filter is active
                $this->crud->addClause('where', 'is_priority', 1);
            } );

        // Filtro per consegnato - commentato
        $this->crud->addFilter([
            'type'  => 'simple',
            'name'  => 'delivery',
            'label' => 'Consegnati'
        ],
            false,
            function() { // if the filter is active
                $this->crud->addClause('where', 'is_delivery', 1);
            } );

        // Filtro con fattura - commentato
        $this->crud->addFilter([
            'type'  => 'simple',
            'name'  => 'invoices',
            'label' => 'Con Fattura'
        ],
            false,
            function() { // if the filter is active
                $this->crud->addClause('where', 'is_invoice', 1);
            } );

        // Filtro con fattura - commentato
        $this->crud->addFilter([
            'type'  => 'simple',
            'name'  => 'payed',
            'label' => 'Pagati'
        ],
            false,
            function() { // if the filter is active
                $this->crud->addClause('where', 'is_paid', 1);
            } );

        // Filtro con ricevuta - commentato
        $this->crud->addFilter([
            'type'  => 'simple',
            'name'  => 'ricevuta',
            'label' => 'Ric.Fiscale'
        ],
            false,
            function() { // if the filter is active
                $this->crud->addClause('where', 'is_ricevuta', 1);
            } );

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
        CRUD::setValidation(PluginInterventionsRequest::class);

        $values = PluginInterventionsClients::selectRaw("CONCAT(first_name, ' ', last_name) as name, id")->get()->pluck("name", "id")->toArray();
        $this->crud->addField([   // select2_from_array
            'name'        => 'client_id',
            'label'       => "Cliente",
            'type'        => 'select2_from_array',
            'options'     => $values,
            'allows_null' => true,
            'allows_multiple' => false, // OPTIONAL; needs you to cast this to array in your model;
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
            'attributes' => [
                'id' => 'client_id'
            ],
        ]);

        $parameters = \Route::current()->parameters();
        if(count($parameters)){
            $item = PluginInterventions::find($parameters['id']);
            if($item){
                $data = $item->date_intervetion;
            }
        }else{
            $data = Carbon::now()->toDateString();
            if (\request()->has('data')) {
                $data = \request()->get('data');
            }
        }

        $this->crud->addField([
            'name'  => 'date_intervention',
            'label' => 'Data intervento',
            'type'  => 'date',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-2'
            ],
            'attributes' => [
                'id' => 'date_intervention'
            ],
            'value' => $data
        ]);

        $this->crud->addField([
            'name'  => 'start',
            'label' => 'Ora inizio',
            'type'  => 'time',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-1'
            ],
            'attributes' => [
                'id' => 'start'
            ],
        ]);

        $this->crud->addField([
            'name'  => 'end',
            'label' => 'Ora fine',
            'type'  => 'time',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-1'
            ],
            'attributes' => [
                'id' => 'end'
            ],
        ]);

        $this->crud->addField([   // Checkbox
            'name'  => 'is_all_day',
            'label' => 'Tutto il giorno',
            'type'  => 'switch',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-4'
            ],
            'attributes' => [
                'id' => 'is_all_day'
            ],
        ]);


        $this->crud->addField([
            'name'  => 'first_name',
            'label' => 'Nome',
            'type'  => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-2'
            ],
            'attributes' => [
                'id' => 'first_name'
            ],
        ]);

        $this->crud->addField([
            'name'  => 'last_name',
            'label' => 'Cognome',
            'type'  => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-2'
            ],
            'attributes' => [
                'id' => 'last_name'
            ],
        ]);

        $this->crud->addField([
            'name'  => 'mobile',
            'label' => 'Cellulare',
            'type'  => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-2'
            ],
            'attributes' => [
                'id' => 'mobile'
            ],
        ]);

        $this->crud->addField([
            'name'  => 'company_name',
            'label' => 'Azienda',
            'type'  => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-4'
            ],
            'attributes' => [
                'id' => 'company_name'
            ],
        ]);

        $this->crud->addField([
            'name'  => 'address',
            'label' => 'Indirizzo',
            'type'  => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
            'attributes' => [
                'id' => 'address'
            ],
        ]);

        $this->crud->addField([   // repeatable
            'name'  => 'civico',
            'label' => 'Civico',
            'type'  => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-1'
            ],
            'attributes' => [
                'id' => 'civico'
            ],
        ]);

        $this->crud->addField([   // repeatable
            'name'  => 'interno',
            'label' => 'Interno',
            'type'  => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-1'
            ],
            'attributes' => [
                'id' => 'interno'
            ],
        ]);

        $this->crud->addField([   // repeatable
            'name'  => 'cap',
            'label' => 'Cap',
            'type'  => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-1'
            ],
            'attributes' => [
                'id' => 'cap'
            ],
        ]);

        $this->crud->addField([   // repeatable
            'name'  => 'frazione',
            'label' => 'Frazione',
            'type'  => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-2'
            ],
            'attributes' => [
                'id' => 'frazione'
            ],
        ]);

        $this->crud->addField([   // repeatable
            'name'  => 'comune',
            'label' => 'Comune',
            'type'  => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-2'
            ],
            'attributes' => [
                'id' => 'comune'
            ],
        ]);

        $this->crud->addField([   // repeatable
            'name'  => 'provincia',
            'label' => 'Provincia',
            'type'  => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-2'
            ],
            'attributes' => [
                'id' => 'provincia'
            ],
        ]);



        $values = PluginInterventionsVehicles::selectRaw("CONCAT(name, ' (', code, ')') as name, id")->get()->pluck("name", "id")->toArray();
        $this->crud->addField([   // select2_from_array
            'name'        => 'vehicle_id',
            'label'       => "Mezzo",
            'type'        => 'select2_from_array',
            'options'     => $values,
            'allows_null' => true,
            'allows_multiple' => false, // OPTIONAL; needs you to cast this to array in your model;
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
            'attributes' => [
                'id' => 'vehicle_id'
            ],
        ]);

        $values = PluginInterventionsDrivers::selectRaw("CONCAT(first_name, ' ', last_name) as name, id")->get()->pluck("name", "id")->toArray();
        $this->crud->addField([   // select2_from_array
            'name'        => 'driver_id',
            'label'       => "Autista",
            'type'        => 'select2_from_array',
            'options'     => $values,
            'allows_null' => true,
            'allows_multiple' => false, // OPTIONAL; needs you to cast this to array in your model;
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
            'attributes' => [
                'id' => 'driver_id'
            ],
        ]);

        $values = PluginInterventionsLaborers::selectRaw("CONCAT(first_name, ' ', last_name) as name, id")->get()->pluck("name", "id")->toArray();
        $this->crud->addField([   // select2_from_array
            'name'        => 'laborer_id',
            'label'       => "Manovale",
            'type'        => 'select2_from_array',
            'options'     => $values,
            'allows_null' => true,
            'allows_multiple' => false, // OPTIONAL; needs you to cast this to array in your model;
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
            'attributes' => [
                'id' => 'laborer_id'
            ],
        ]);

        $values = PluginInterventionsStatus::get()->pluck("name", "id")->toArray();
        $this->crud->addField([   // select2_from_array
            'name'        => 'status_id',
            'label'       => "Stato intervento",
            'type'        => 'select2_from_array',
            'options'     => $values,
            'allows_null' => true,
            'allows_multiple' => false, // OPTIONAL; needs you to cast this to array in your model;
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
        ]);

        $this->crud->addField([   // Checkbox
            'name'  => 'is_delivery',
            'label' => 'Consegnato Bollettino',
            'type'  => 'switch',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
        ]);

        /*$this->crud->addField([   // Checkbox
            'name'  => 'is_priority',
            'label' => 'Annullato',
            'type'  => 'switch',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
        ]);*/

        $this->crud->addField([   // Checkbox
            'name'  => 'is_invoice',
            'label' => 'Fattura',
            'type'  => 'switch',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
        ]);

        $this->crud->addField([   // Checkbox
            'name'  => 'is_ricevuta',
            'label' => 'Ricevuta Fiscale',
            'type'  => 'switch',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
        ]);

        $this->crud->addField([   // Checkbox
            'name'  => 'is_paid',
            'label' => 'Pagato',
            'type'  => 'switch',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
        ]);

        $this->crud->addField([   // select2_from_array
            'name'        => 'note_interne',
            'label'       => "Note interne",
            'type'        => 'ckeditor',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-12'
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

        $this->crud->addField([
            'name'  => 'date_call',
            'label' => 'Data chiamata',
            'type'  => 'datetime',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
            'default' => Carbon::now()->toDateTimeString()
        ]);

        $this->crud->addField([
            'name'  => 'referent',
            'label' => 'Referente chiamata',
            'type'  => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
        ]);
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

    public function store()
    {
        $this->crud->hasAccessOrFail('create');

        // execute the FormRequest authorization and validation, if one is required
        $request = $this->crud->validateRequest();

        $client = null;
        if($request->get('client_id') == null){
            $client = PluginInterventionsClients::create([
               "first_name" => $request->get('first_name'),
               "last_name" => $request->get('last_name'),
               "email" => $request->get('email'),
               "mobile" => $request->get('mobile'),
               "address" => $request->get('address'),
               "civico" => $request->get('civico'),
               "interno" => $request->get('interno'),
               "cap" => $request->get('cap'),
               "frazione" => $request->get('frazione'),
               "comune" => $request->get('comune'),
               "provincia" => $request->get('provincia'),
               "company_name" => $request->get('company_name')
            ]);
        }else{
            $client = PluginInterventionsClients::where("id", $request->get('client_id'))->update([
                "first_name" => $request->get('first_name'),
                "last_name" => $request->get('last_name'),
                "email" => $request->get('email'),
                "mobile" => $request->get('mobile'),
                "address" => $request->get('address'),
                "civico" => $request->get('civico'),
                "interno" => $request->get('interno'),
                "cap" => $request->get('cap'),
                "frazione" => $request->get('frazione'),
                "comune" => $request->get('comune'),
                "provincia" => $request->get('provincia'),
                "company_name" => $request->get('company_name')
            ]);

            $client = PluginInterventionsClients::find($request->get('client_id'));
        }

        // insert item in the db
        $item = $this->crud->create($this->crud->getStrippedSaveRequest($request));
        $this->data['entry'] = $this->crud->entry = $item;

        if($client){
            $item->client_id = $client->id;
            $item->save();
        }

        // show a success message
        \Alert::success(trans('backpack::crud.insert_success'))->flash();

        // save the redirect choice for next time
        $this->crud->setSaveAction();

        return $this->crud->performSaveAction($item->getKey());
    }

    public function monitor(Request $request){
        $date_en = \Carbon\Carbon::now()->toDateString();

        if($request->has('data')){
            $date_en = $request->get('data');
        }

        $start = "07:00";
        if($request->has('start')){
            $start = $request->get('start');
            if(!$start){
                $start = "07:00";
            }
        }

        $end = "22:30";
        if($request->has('end')){
            $end = $request->get('end');
            if(!$end){
                $end = "22:30";
            }
        }

        $vehicle_select = (int) $request->get("vehicle_id");

        $status = PluginInterventionsStatus::where("default_annullato", 1)->first();

        if($vehicle_select != 0){
            $reservations  = \App\Models\PluginInterventions::where("vehicle_id", $vehicle_select)
                ->whereRaw("date_intervention = '$date_en' AND ((start >= '$start' and end <= '$end') OR (start <= '$start' and end >= '$start') OR (start <= '$end' and end >= '$end') OR is_all_day = 1)")
                ->whereNotIn("status_id", [$status->id])
                ->orderBy("start", "asc")
                ->get();
        }else{
            $reservations  = \App\Models\PluginInterventions::whereRaw("date_intervention = '$date_en' AND ((start >= '$start' and end <= '$end') OR (start <= '$start' and end >= '$start') OR (start <= '$end' and end >= '$end') OR is_all_day = 1)")
                ->whereNotIn("status_id", [$status->id])
                ->orderBy("start", "asc")
                ->get();
        }


        if($request->get('button') == "export"){
            return Excel::download(new \App\Exports\PluginInterventionsMonitorExport($reservations, $date_en), "panoramica.xlsx");
        }

        return view(backpack_view('plugins.pluginInterventions.monitor'), compact('date_en', 'reservations','vehicle_select', 'start', 'end'));
    }

    public function check(Request $request){
        $date = $request->get('date_intervention');
        $start = $request->get('start');
        $end = $request->get('end');
        $is_all_day = $request->get('is_all_day');
        $vehicle_id = $request->get('vehicle_id');
        $driver_id = $request->get('driver_id');
        $laborer_id = $request->get('laborer_id');

        $vehicle_item = PluginInterventionsVehicles::find($vehicle_id);

        $status = PluginInterventionsStatus::where("default_annullato", 1)->first();

        $trovato = 0;
        if($request->has('id')){
            $id = $request->get('id');

            if($is_all_day){
                $check = PluginInterventions::where("id", "!=", $id)
                    ->whereRaw("(status_id is null OR status_id != $status->id)")
                    ->whereRaw("(vehicle_id = $vehicle_id OR driver_id = $driver_id OR laborer_id = $laborer_id)")
                    ->whereRaw("date_intervention = '$date'")
                    ->get();
            }else{
                $check = PluginInterventions::where("id", "!=", $id)
                    ->whereRaw("(status_id is null OR status_id != $status->id)")
                    ->whereRaw("(vehicle_id = $vehicle_id OR driver_id = $driver_id OR laborer_id = $laborer_id)")
                    ->whereRaw("date_intervention = '$date' AND ((start <= '$start' and end >= '$start')
                                OR (start <= '$end' and end >= '$end') OR is_all_day = 1)")
                    ->get();
            }

        }else{
            if($is_all_day){
                $check = PluginInterventions::whereRaw("date_intervention = '$date'")
                    ->whereRaw("(status_id is null OR status_id != $status->id)")
                    ->whereRaw("(vehicle_id = $vehicle_id OR driver_id = $driver_id OR laborer_id = $laborer_id)")
                    ->get();
            }else{
                $check = PluginInterventions::whereRaw("date_intervention = '$date' AND ((start <= '$start' and end >= '$start')
                                OR (start <= '$end' and end >= '$end') OR is_all_day = 1)")
                    ->whereRaw("(status_id is null OR status_id != $status->id)")
                    ->whereRaw("(vehicle_id = $vehicle_id OR driver_id = $driver_id OR laborer_id = $laborer_id)")
                    ->get();
            }
        }

        if(count($check)){
            $date_ = Carbon::createFromFormat("Y-m-d", $date)->format("d/m/Y");
            if($is_all_day){
                $orario = "Tutto il giorno";
            }else{
                $start_ = "";

                if($start){
                    if(strlen($start) == 8){
                        $start_ = Carbon::createFromFormat("H:i:s", $start)->format("H:i");
                    }else{
                        $start_ = Carbon::createFromFormat("H:i", $start)->format("H:i");
                    }
                }

                $end_ = "";
                if($end){
                    if(strlen($end) == 8){
                        $end_ = Carbon::createFromFormat("H:i:s", $end)->format("H:i");
                    }else{
                        $end_ = Carbon::createFromFormat("H:i", $end)->format("H:i");
                    }

                }
                $orario = "dalle $start_ alle $end_";
            }

            $html = "<p style='font-size: 15px;'>Per il giorno <strong>$date_ $orario</strong>, il mezzo o l'autista o il manovale selezionato è già impegnato:</p>";

            $html .= "<table width='100%' class='table' style='font-size: 14px;'><thead><tr><th>ID</th><th>Mezzo</th><th>Autista</th><th>Manovale</th><th>Orario</th><th>Cliente</th></tr></thead>";
            foreach ($check as $item){
                $driver = PluginInterventionsDrivers::find($item->driver_id);
                $vehicle = PluginInterventionsVehicles::find($item->vehicle_id);
                $laborer = PluginInterventionsLaborers::find($item->laborer_id);

                $orario = "";
                if($item->is_all_day){
                    $orario = "Tutto il giorno";
                }else{
                    $start_ = Carbon::createFromFormat("H:i:s", $item->start)->format("H:i");
                    $end_ = Carbon::createFromFormat("H:i:s", $item->end)->format("H:i");
                    $orario = "Dalle $start_ alle $end_";
                }

                $td1 = "";
                if($vehicle_id == $vehicle->id){
                    $td1 = "style='background-color: yellow'";
                }

                $td2 = "";
                if($driver_id == $driver->id){
                    $td2 = "style='background-color: yellow'";
                }

                $td3 = "";
                if($laborer_id == $laborer->id){
                    $td3 = "style='background-color: yellow'";
                }

                $html .= "<tr>
                        <td>#$item->id</td>
                        <td $td1>$vehicle->name ($vehicle->code)</td>
                        <td $td2>$driver->first_name $driver->last_name</td>
                        <td $td3>$laborer->first_name $laborer->last_name</td>
                        <td>$orario</td>
                        <td>$item->first_name $item->last_name</td>
                        </tr>";
                $trovato++;
            }

            $html .= "</table>";
        }

        if($trovato > 0){
            return response()->json([
                "error" => 1,
                "message" => $html,
                "status" => $status->id,
                "request" => $request->all()
            ]);
        }
    }

    public function print_pdf($id){
        $pdf = \App::make('snappy.pdf.wrapper');

        $list = PluginInterventions::where("id", $id)->get();

        $html = view(backpack_view('plugins.pluginInterventions.pdf'), compact( 'list'))->render();
        $pdf->loadHTML($html)->setPaper('a4');
        return $pdf->download("Intervento_$id.pdf");

    }

    public function send_mail($id){
        $item = PluginInterventions::find($id);

        $setting = PluginInterventionsSetting::first();

        $destinatario = $setting->email;
        try{
            \Mail::send("common.emails.pluginInterventions.riepilogo", ['intervention' => $item], function ($m) use ($destinatario, $setting, $item) {
                $m->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                $m->replyTo(env('MAIL_TO_REPLAY'), env('MAIL_FROM_NAME'));
                $m->to($destinatario)->subject("Riepilogo Intervento n.$item->id");
            });

            if($setting){
                if($setting->email_ccn){
                    $emails = explode(",", $setting->email_ccn);

                    if(count($emails)){
                        foreach ($emails as $k=>$temp_email){
                            $destinatario = trim($temp_email);

                            \Mail::send("common.emails.pluginInterventions.riepilogo", ['intervention' => $item], function ($m) use ($destinatario, $item) {
                                $m->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                                $m->replyTo(env('MAIL_TO_REPLAY'), env('MAIL_FROM_NAME'));
                                $m->to($destinatario)->subject("Riepilogo Intervento n.$item->id");
                            });
                        }
                    }
                }
            }

        } catch (\Throwable $e) {

        }

        \Alert::success("Operazione effettutata con successo")->flash();
        return redirect()->back();
    }

    public function annulla($id){
        $status = PluginInterventionsStatus::where("default_annullato", 1)->first();
        $intervention = PluginInterventions::find($id);
        if($intervention){
            $intervention->status_id = $status->id;
            $intervention->save();
        }

        \Alert::success("Operazione effettutata con successo")->flash();
        return redirect()->back();


    }

    public function actions(Request $request){
        $button = $request->get('button');
        $ids = $request->get('ids');
        if($ids == null){
            return redirect()->back();
        }
        switch ($button){
            case "download_pdf":
                $pdf = \App::make('snappy.pdf.wrapper');

                $list = PluginInterventions::whereIn("id", $ids)
                    ->orderBy("plugins_interventions.date_intervention", "asc")
                    ->orderBy("plugins_interventions.start", "asc")
                    ->get();

                $html = view(backpack_view('plugins.pluginInterventions.pdf'), compact('list'))->render();
                $pdf->loadHTML($html)->setPaper('a4');
                return $pdf->download("Interventi.pdf");
                break;

            case "send_email":
                $setting = PluginInterventionsSetting::first();

                $list = PluginInterventions::whereIn("id", $ids)
                    ->orderBy("plugins_interventions.date_intervention", "asc")
                    ->orderBy("plugins_interventions.start", "asc")
                    ->get();

                $destinatario = $setting->email;
                try{
                    \Mail::send("common.emails.pluginInterventions.riepilogo_multi", ['interventions' => $list], function ($m) use ($destinatario, $setting) {
                        $m->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                        $m->replyTo(env('MAIL_TO_REPLAY'), env('MAIL_FROM_NAME'));
                        $m->to($destinatario)->subject("Riepilogo Interventi");
                    });

                    if($setting){
                        if($setting->email_ccn){
                            $emails = explode(",", $setting->email_ccn);

                            if(count($emails)){
                                foreach ($emails as $k=>$temp_email){
                                    $destinatario = trim($temp_email);

                                    \Mail::send("common.emails.pluginInterventions.riepilogo_multi", ['interventions' => $list], function ($m) use ($destinatario, $item) {
                                        $m->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                                        $m->replyTo(env('MAIL_TO_REPLAY'), env('MAIL_FROM_NAME'));
                                        $m->to($destinatario)->subject("Riepilogo Interventi");
                                    });
                                }
                            }
                        }
                    }

                } catch (\Throwable $e) {

                }
                break;
        }

        \Alert::success("Operazione effettuata con successo!")->flash();

        return redirect()->back();
    }

    // Ajax che cambia stato Consegnato
    public function change_delivery(Request $request){
        $id = $request->get('id');
        $type = $request->get('type');

        PluginInterventions::where("id", $id)->update([
           "is_delivery" => $type
        ]);

        return response()->json(["error" => 0]);
    }

    // Ajax che cambia stato Annullato usando la funzione già fatta priority
    public function change_annullato(Request $request){
        $id = $request->get('id');
        $type = $request->get('type');

        $status = PluginInterventionsStatus::where("default_annullato", 1)->first();

        PluginInterventions::where("id", $id)->update([
            "is_priority" => $type,
            "status_id" => $status->id
        ]);

        $html = "<span style='padding:3px; background-color:{$status->color}; color:black;'>{$status->name}</span>";

        return response()->json(["error" => 0, "html" => $html]);
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

        $status = PluginInterventionsStatus::where("default_annullato", 1)->first();

        if($item->status_id != $status->id){
            $item->is_priority = 0;
            $item->save();
        }

        // show a success message
        \Alert::success(trans('backpack::crud.update_success'))->flash();

        // save the redirect choice for next time
        $this->crud->setSaveAction();

        return $this->crud->performSaveAction($item->getKey());
    }


}
