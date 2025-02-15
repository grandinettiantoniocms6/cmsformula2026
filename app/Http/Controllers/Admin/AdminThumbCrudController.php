<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AdminThumbRequest;
use App\Models\AdminBlock;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class AdminThumbCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class AdminThumbCrudController extends CrudController
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

        CRUD::setModel(\App\Models\AdminThumb::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/admin-thumb');
        CRUD::setEntityNameStrings('admin thumb', 'admin thumbs');
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
        //$this->crud->removeButton("delete");
        //$this->crud->removeButton("update");

        $this->crud->setColumns([
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'admin_block_id',
                'label' => 'Blocco', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getBlock', // the method in your Model
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                'limit' => 10000, // Limit the number of characters shown
            ],
            [
                'name'  => 'suffix',
                'label' => 'Suffisso',
                'type'  => 'text',
            ],
            [
                'name'  => 'width_max',
                'label' => 'Larghezza max',
                'type'  => 'text',
            ],
            [
                'name'  => 'height_max',
                'label' => 'Altezza max',
                'type'  => 'text',
            ],
        ]);


        $blocks = AdminBlock::where("is_active", 1)->orderBy("label", "asc")->get()->pluck("label", "id")->toArray();
        // select2 filter
        $this->crud->addFilter([
            'name' => 'admin_block_id',
            'type' => 'select2',
            'label' => 'Blocco'
        ], function () use ($blocks) {
            return $blocks;
        }, function ($value) { // if the filter is active
            $this->crud->addClause('where', 'admin_block_id', $value);
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
        CRUD::setValidation(AdminThumbRequest::class);

        $blocks = AdminBlock::where("is_active", 1)->orderBy("label", "asc")->get()->pluck("label", "id")->toArray();
        $this->crud->addField([   // select2_from_array
            'name'        => 'admin_block_id',
            'label'       => "Blocco",
            'type'        => 'select2_from_array',
            'options'     => $blocks,
            'allows_null' => false,
            'default'     => null,
            'attributes' => ['class' => 'form-control'],
            'wrapperAttributes' => [
                'class' => 'form-group col-md-12'
            ],
            // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
        ]);

        $this->crud->addField([
            'name' => 'suffix',
            'label' => "Suffisso",
            'type' => 'text',
            'attributes' => ['class' => 'form-control'],
            'wrapperAttributes' => [
                'class' => 'form-group col-md-12'
            ],
        ]);

        $this->crud->addField([
            'name' => 'width_max',
            'label' => "Larghezza Max",
            'type' => 'number',
            'attributes' => ['class' => 'form-control'],
            'wrapperAttributes' => [
                'class' => 'form-group col-md-12'
            ],
        ]);

        $this->crud->addField([   // Checkbox
            'name'  => 'height_max',
            'label' => 'Altezza max',
            'type'  => 'number',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
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
        $this->setupCreateOperation();
    }
}
