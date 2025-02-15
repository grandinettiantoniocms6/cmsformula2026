<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PluginInvitationsSettingsRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Spatie\Permission\Models\Role;

/**
 * Class PluginInvitationsSettingsCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PluginInvitationsSettingsCrudController extends CrudController
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
        CRUD::setModel(\App\Models\PluginInvitationsSettings::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/pluginInvitationsSettings');
        CRUD::setEntityNameStrings('impostazione', 'impostazioni');

        if(backpack_user()->roles[0]->id > 4){
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
        CRUD::setValidation(PluginInvitationsSettingsRequest::class);

        if(backpack_user()->roles[0]->id <= 2) {

            $trans = new AdminLanguageController();
            $trans->fields_lang("pluginInvitationsSettings", $this->crud);


            $this->crud->addField([
                'name' => 'email',
                'label' => 'Email',
                'type' => 'email'
            ]);

            $item = Role::where("name", "Buyer")->first();
            if ($item) {
                $vet[$item->id] = $item->name;
            }

            $item = Role::where("name", "Cliente")->first();
            if ($item) {
                $vet[$item->id] = $item->name;
            }

            $this->crud->addField([   // select2_from_array
                'name' => 'role_id',
                'label' => "Invito per",
                'type' => 'select2_from_array',
                'options' => $vet,
                'allows_null' => true,
                'default' => null,
                // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
            ]);

            $this->crud->addField([
                'name' => 'logo',
                'label' => 'Logo',
                'type' => 'browse'
            ]);

            $this->crud->addField([
                'name' => 'cover',
                'label' => 'Cover',
                'type' => 'browse'
            ]);
        }

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

    public function update()
    {
        $this->crud->hasAccessOrFail('update');

        // execute the FormRequest authorization and validation, if one is required
        $request = $this->crud->validateRequest();
        // update the row in the db
        $item = $this->crud->update($request->get($this->crud->model->getKeyName()),
            $this->crud->getStrippedSaveRequest());
        $this->data['entry'] = $this->crud->entry = $item;

        // show a success message
        \Alert::success(trans('backpack::crud.update_success'))->flash();

        // save the redirect choice for next time
        $this->crud->setSaveAction();

        $lang = new AdminLanguageController();
        $lang->update_lang("pluginInvitationsSettings", $this->crud, $request);
        $this->crud->entry->save();

        return redirect()->to("/admin/pluginInvitationsSettings/1/edit");
    }
}
