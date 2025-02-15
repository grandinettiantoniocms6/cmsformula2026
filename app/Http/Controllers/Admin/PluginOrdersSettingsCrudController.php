<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PluginOrdersSettingsRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class PluginOrdersSettingsCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PluginOrdersSettingsCrudController extends CrudController
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

        CRUD::setModel(\App\Models\PluginOrdersSettings::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/pluginOrdersSettings');
        CRUD::setEntityNameStrings('impostazioni', 'impostazioni');
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
        if(backpack_user()->roles[0]->id > 3){
            die;
        }

        CRUD::setValidation(PluginOrdersSettingsRequest::class);

        $this->crud->addField([   // Checkbox
            'name'  => 'planning_start',
            'label' => 'Calendario orario apertura',
            'type'  => 'time'
        ]);

        $this->crud->addField([   // Checkbox
            'name'  => 'planning_end',
            'label' => 'Calendario orario chiusura',
            'type'  => 'time'
        ]);

       /* $this->crud->addField([   // Checkbox
            'name'  => 'planning_slot',
            'label' => 'Calendario slot in minuti',
            'type'  => 'text'
        ]);*/

        $this->crud->addField([
            'label' => "Logo per PDF",
            'name' => "logo_pdf",
            'type'  => 'browse',
            // 'disk'      => 's3_bucket', // in case you need to show images from a different disk
            // 'prefix'    => 'uploads/images/profile_pictures/' // in case your db value is only the file name (no path), you can use this to prepend your path to the image src (in HTML), before it's shown to the user;
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
