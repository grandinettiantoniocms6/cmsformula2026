<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PluginInterventionsNoteRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Carbon\Carbon;

/**
 * Class PluginInterventionsNoteCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PluginInterventionsNoteCrudController extends CrudController
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

        CRUD::setModel(\App\Models\PluginInterventionsNote::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/plugin-interventions-note');
        CRUD::setEntityNameStrings('Nota', 'Note');

        $this->crud->setListView(backpack_view('plugins.pluginInterventions.listNote'));
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

        $this->crud->setColumns([
            [
                'name'  => 'day',
                'label' => 'Data',
                'type'  => 'date',
            ],
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'note',
                'label' => 'Nota', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getNote', // the method in your Model
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                'limit' => 10000, // Limit the number of characters shown
            ],
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'is_closed',
                'label' => 'Stato', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getIsClosed', // the method in your Model
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                'limit' => 10000, // Limit the number of characters shown
            ],
        ]);

        $this->crud->addFilter([
            'type'  => 'date',
            'name'  => 'day',
            'label' => 'Giorno'
        ],
            false,
            function ($value) { // if the filter is active, apply these constraints
                 $this->crud->addClause('where', 'day', $value);
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
        CRUD::setValidation(PluginInterventionsNoteRequest::class);

        $this->crud->addField([   // repeatable
            'name'  => 'day',
            'label' => 'Data',
            'type'  => 'date',
            'default' => Carbon::now()->toDateString()
        ]);

        $this->crud->addField([   // repeatable
            'name'  => 'note',
            'label' => 'Nota',
            'type'  => 'summernote',
        ]);

        $this->crud->addField([   // repeatable
            'name'  => 'is_closed',
            'label' => 'Chiusa?',
            'type'  => 'switch',
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
