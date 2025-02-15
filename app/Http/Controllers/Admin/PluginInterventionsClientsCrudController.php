<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PluginInterventionsClientsRequest;
use App\Models\PluginInterventionsClients;
use App\Models\PluginOrdersClients;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Http\Request;

/**
 * Class PluginInterventionsClientsCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PluginInterventionsClientsCrudController extends CrudController
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
        if(backpack_user()->roles[0]->id > 3){
            die;
        }

        CRUD::setModel(\App\Models\PluginInterventionsClients::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/plugin-interventions-clients');
        CRUD::setEntityNameStrings('cliente', 'clienti');
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
                'name'  => 'first_name',
                'label' => 'Nome',
                'type'  => 'text',
            ],
            [
                'name'  => 'last_name',
                'label' => 'Cognome',
                'type'  => 'text',
            ],
            [
                'name'  => 'mobile',
                'label' => 'Cellulare',
                'type'  => 'text',
            ],
           /* [
                'name'  => 'email',
                'label' => 'Email',
                'type'  => 'text',
            ],*/
            [
                'name'  => 'address',
                'label' => 'Indirizzo',
                'type'  => 'text',
            ],
            [
                'name'  => 'civico',
                'label' => 'Civico',
                'type'  => 'text',
            ],
            [
                'name'  => 'cap',
                'label' => 'Cap',
                'type'  => 'text',
            ],
            [
                'name'  => 'frazione',
                'label' => 'Frazione',
                'type'  => 'text',
            ],
            [
                'name'  => 'comune',
                'label' => 'Comune',
                'type'  => 'text',
            ],
            [
                'name'  => 'provincia',
                'label' => 'Provincia',
                'type'  => 'text',
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
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(PluginInterventionsClientsRequest::class);

        $this->crud->addField([   // repeatable
            'name'  => 'first_name',
            'label' => 'Nome',
            'type'  => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ],
        ]);

        $this->crud->addField([   // repeatable
            'name'  => 'last_name',
            'label' => 'Cognome',
            'type'  => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ],
        ]);

        $this->crud->addField([   // repeatable
            'name'  => 'mobile',
            'label' => 'Telefono',
            'type'  => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-4'
            ],
        ]);

        $this->crud->addField([   // repeatable
            'name'  => 'email',
            'label' => 'Email',
            'type'  => 'email',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-4'
            ],
        ]);

        $this->crud->addField([   // repeatable
            'name'  => 'company_name',
            'label' => 'Nome Azienda',
            'type'  => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-4'
            ],
        ]);

        $this->crud->addField([   // repeatable
            'name'  => 'address',
            'label' => 'Indirizzo',
            'type'  => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
        ]);

        $this->crud->addField([   // repeatable
            'name'  => 'civico',
            'label' => 'Civico',
            'type'  => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-1'
            ],
        ]);

        $this->crud->addField([   // repeatable
            'name'  => 'interno',
            'label' => 'Interno',
            'type'  => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-1'
            ],
        ]);

        $this->crud->addField([   // repeatable
            'name'  => 'cap',
            'label' => 'Cap',
            'type'  => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-1'
            ],
        ]);

        $this->crud->addField([   // repeatable
            'name'  => 'frazione',
            'label' => 'Frazione',
            'type'  => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-2'
            ],
        ]);

        $this->crud->addField([   // repeatable
            'name'  => 'comune',
            'label' => 'Comune',
            'type'  => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-2'
            ],
        ]);

        $this->crud->addField([   // repeatable
            'name'  => 'provincia',
            'label' => 'Provincia',
            'type'  => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-2'
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

    public function get_client(Request $request){
        $id = $request->get('id');
        $client = PluginInterventionsClients::where("id", $id)->first();
        return response()->json(["client" => $client]);
    }
}
