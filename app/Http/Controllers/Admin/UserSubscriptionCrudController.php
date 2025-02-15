<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserSubscriptionRequest;
use App\Models\OrderStatus;
use App\Models\PluginProducts;
use App\Models\PluginProductsCategories;
use App\User;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class UserSubscriptionCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class UserSubscriptionCrudController extends CrudController
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

        CRUD::setModel(\App\Models\UserSubscription::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/user-subscription');
        CRUD::setEntityNameStrings('Abbonamento', 'Abbonamenti');
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

        $this->crud->setColumns([
            [
                // 1-n relationship
                'label'     => 'Cliente', // Table column heading
                'type'      => 'select',
                'name'      => 'user_id', // the column that contains the ID of that connected entity;
                'entity'    => 'user', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user
                'model'     => User::class, // foreign key model
            ],
            [
                // 1-n relationship
                'label'     => 'Prodotto', // Table column heading
                'type'      => 'select',
                'name'      => 'product_id', // the column that contains the ID of that connected entity;
                'entity'    => 'product', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user
                'model'     => PluginProducts::class, // foreign key model
            ],
            [
                'name'  => 'name',
                'label' => 'Nominativo Card',
                'type'  => 'text',
            ],
            [
                'name'  => 'start',
                'label' => 'Data inizio',
                'type'  => 'date',
            ],
            [
                'name'  => 'end',
                'label' => 'Data fine',
                'type'  => 'date',
            ],
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'order_id',
                'label' => 'ID Ordine', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getOrder', // the method in your Model
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                'limit' => 10000, // Limit the number of characters shown
            ]
        ]);

        $clients = User::get()->pluck("name", "id")->toArray();
        $this->crud->addFilter([ // select2 filter
            'name' => 'client_id',
            'type' => 'select2',
            'label'=> 'Cliente'
        ], function() use ($clients) {
            return $clients;
        }, function($value) { // if the filter is active
            $this->crud->addClause('where', 'user_id', '=', $value);
        });

        $subscriptions = PluginProducts::where("is_subscription", 1)->get()->pluck("name", "id")->toArray();
        $this->crud->addFilter([ // select2 filter
            'name' => 'product_id',
            'type' => 'select2',
            'label'=> 'Abbonamento'
        ], function() use ($subscriptions) {
            return $subscriptions;
        }, function($value) { // if the filter is active
            $this->crud->addClause('where', 'product_id', '=', $value);
        });

        // daterange filter
        /*$this->crud->addFilter([
            'type'  => 'date_range',
            'name'  => 'from_to',
            'label' => 'Inizio'
        ],
            false,
            function ($value) { // if the filter is active, apply these constraints
                $dates = json_decode($value);
                $this->crud->addClause('where', 'start', '>=', $dates->from);
                $this->crud->addClause('where', 'start', '<=', $dates->to . ' 23:59:59');
            });*/

        // daterange filter
        $this->crud->addFilter([
            'type'  => 'date_range',
            'name'  => 'from_to',
            'label' => 'Scadenza'
        ],
            false,
            function ($value) { // if the filter is active, apply these constraints
                $dates = json_decode($value);
                $this->crud->addClause('where', 'end', '>=', $dates->from);
                $this->crud->addClause('where', 'end', '<=', $dates->to . ' 23:59:59');
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
        CRUD::setValidation(UserSubscriptionRequest::class);

        $subscriptions = PluginProducts::where("is_subscription", 1)->get()->pluck("name", "id")->toArray();
        $this->crud->addField([   // select2_from_array
            'name'        => 'product_id',
            'label'       => "Abbonamento",
            'type'        => 'select2_from_array',
            'options'     => $subscriptions,
            'allows_null' => true,
            'default'     => null,
            'allows_multiple' => false // OPTIONAL; needs you to cast this to array in your model;
        ]);

        $this->crud->addField([   // select2_from_array
            'name'        => 'name',
            'label'       => "Nominativo Card",
            'type'        => 'text'
        ]);

        $this->crud->addField([   // select2_from_array
            'name'        => 'start',
            'label'       => "Data inizio",
            'type'        => 'date'
        ]);

        $this->crud->addField([   // select2_from_array
            'name'        => 'end',
            'label'       => "Data fine",
            'type'        => 'date'
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
}
