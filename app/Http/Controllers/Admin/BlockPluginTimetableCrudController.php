<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\BlockPluginTimetableRequest;
use App\Models\PluginTimetables;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class BlockPluginTimetableCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class BlockPluginTimetableCrudController extends CrudController
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
        CRUD::setModel(\App\Models\BlockPluginTimetable::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/blockPluginTimetable');
        CRUD::setEntityNameStrings('Block plugin orari', 'Block plugin orari');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::setFromDb(); // columns

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
        CRUD::setValidation(BlockPluginTimetableRequest::class);

        $this->crud->addField([   // repeatable
            'name'  => 'name',
            'label' => 'Nome blocco',
            'type'  => 'text',
            'wrapperAttributes' => [ 'class' => 'form-group col-md-12'],
        ]);

        $timetables = PluginTimetables::get()->pluck("name", "id")->toArray();
        $this->crud->addField([   // select2_from_array
            'name'        => 'plugin_timetable_id',
            'label'       => "Orario",
            'type'        => 'select2_from_array',
            'options'     => $timetables,
            'allows_null' => false,
            'default'     => null
        ]);

        $this->crud->addField([   // Browse
            'name'  => 'download_pdf',
            'label' => 'Possibilità di scaricare il pdf?',
            'type'  => 'switch',
            'wrapperAttributes' => [ 'class' => 'form-group col-md-6'],
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
