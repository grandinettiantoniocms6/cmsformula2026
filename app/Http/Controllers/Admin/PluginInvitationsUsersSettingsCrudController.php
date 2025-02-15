<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PluginInvitationsUsersSettingsRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class PluginInvitationsUsersSettingsCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PluginInvitationsUsersSettingsCrudController extends CrudController
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
        CRUD::setModel(\App\Models\PluginInvitationsUsersSettings::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/pluginInvitationsUsersSettings');
        if(backpack_user()->country_id == config('config.default_country_user_it')){
            CRUD::setEntityNameStrings('impostazione', 'impostazione');
        }else{
            CRUD::setEntityNameStrings('setting', 'setting');
        }    }

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
        CRUD::setValidation(PluginInvitationsUsersSettingsRequest::class);

        $this->crud->addField([   // repeatable
            'name'  => 'user_id',
            'value' => backpack_user()->id,
            'type'  => 'hidden'
        ]);

        $this->crud->addField([   // repeatable
            'name'  => 'description',
            'label' => (backpack_user()->country_id == config('config.default_country_user_it')) ? 'Testo invito' : 'Invitation text',
            'type'  => 'ckeditor',
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
