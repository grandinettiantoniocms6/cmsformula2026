<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PluginOrdersCategoriesRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class PluginOrdersCategoriesCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PluginOrdersCategoriesCrudController extends CrudController
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

        CRUD::setModel(\App\Models\PluginOrdersCategories::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/pluginOrdersCategories');
        CRUD::setEntityNameStrings('categoria', 'categorie');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        if(backpack_user()->roles[0]->id > 3){
            die;
        }

        $this->crud->removeButton("show");

        // Columns.
        $this->crud->setColumns([
            [
                'name'  => 'name',
                'label' => 'Nome',
                'type'  => 'text',
            ],
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'color',
                'label' => 'Colore', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getColor', // the method in your Model
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                'limit' => 10000, // Limit the number of characters shown
            ],
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'type_id',
                'label' => 'Tipo', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getType', // the method in your Model
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                'limit' => 10000, // Limit the number of characters shown
            ],
        ]);

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
        if(backpack_user()->roles[0]->id > 3){
            die;
        }

        CRUD::setValidation(PluginOrdersCategoriesRequest::class);

        $this->crud->addField([
            'label' => "Nome",
            'name' => "name",
            'type'  => 'text',
        ]);

        $this->crud->addField([   // color_picker
            'label'                => 'Colore',
            'name'                 => 'color',
            'type'                 => 'color_picker2',
            'default' => null,
        ]);

        $this->crud->addField([   // select2_from_array
            'name'        => 'type_id',
            'label'       => "Tipo",
            'type'        => 'select2_from_array',
            'options'     => [0 => 'per planning', 1 => 'per prodotti'],
            'allows_null' => false,
            'default'     => 0,
        ]);

        $this->crud->addField([
            'name' => "user_id",
            'value' => backpack_user()->id,
            'type'  => 'hidden',
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
        if(backpack_user()->roles[0]->id > 3){
            die;
        }

        $this->setupCreateOperation();
    }
}
