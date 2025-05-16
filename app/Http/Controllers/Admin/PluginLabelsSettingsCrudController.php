<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PluginLabelsSettingsRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class PluginLabelsSettingsCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PluginLabelsSettingsCrudController extends CrudController
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
        CRUD::setModel(\App\Models\PluginLabelsSettings::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/plugin-labels-settings');
        CRUD::setEntityNameStrings('etichette impostazioni', 'etichette impostazioni');

        if(backpack_user()->roles[0]->id > 2){
            die;
        }

    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {

        die;

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
        CRUD::setValidation(PluginLabelsSettingsRequest::class);

        $this->crud->addField([
            'name' => 'logo',
            'label' => 'Testata Header',
            'type' => 'browse'
        ]);

        $this->crud->addField([
            'name' => 'address',
            'label' => 'Indirizzo Footer',
            'type' => 'summernote'
        ]);

        $this->crud->addField([
            'name' => 'photo',
            'label' => 'Foto di sfondo',
            'type' => 'browse'
        ]);

        $this->crud->addField([   // repeatable
            'name'  => 'bgcolor',
            'label' => 'Oppure usa un colore di sfondo',
            'type'  => 'color_picker',
            // optional
            'default' => '#ffffff',
            'color_picker_options' => ['customClass' => 'custom-class'],
            'wrapperAttributes' => ['class' => 'form-group col-md-6']
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
