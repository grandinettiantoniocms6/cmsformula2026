<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\BlockPageRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class BlockPageCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class BlockPageCrudController extends CrudController
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
        if(backpack_user()->roles[0]->id != 1){
            die;
        }

        CRUD::setModel(\App\Models\BlockPage::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/block-page');
        CRUD::setEntityNameStrings('block page', 'Storico blocchi');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $this->crud->removeButton("create");
        $this->crud->removeButton("update");
        $this->crud->removeButton("show");

        $this->crud->setColumns([
            [
                'name'  => 'obj_id',
                'label' => 'Blocco ID',
                'type'  => 'text',
            ],
            [
                'name'  => 'type',
                'label' => 'Tipo Blocco',
                'type'  => 'text',
            ],
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'page_id',
                'label' => 'Pagine', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getPages', // the method in your Model
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                'limit' => 10000, // Limit the number of characters shown
            ],
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'is_ereditable_from_id',
                'label' => 'Ereditato da', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getEreditato', // the method in your Model
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                'limit' => 10000, // Limit the number of characters shown
            ],


        ]);

        $this->crud->addFilter([
            'type'  => 'text',
            'name'  => 'obj_id',
            'label' => 'Blocco ID'
        ],
            false,
            function($value) { // if the filter is active
                 $this->crud->addClause('where', 'obj_id', '=', $value);
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
        CRUD::setValidation(BlockPageRequest::class);



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
}
