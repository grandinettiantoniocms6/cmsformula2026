<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\BlockPluginParkingRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class BlockPluginParkingCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class BlockPluginParkingCrudController extends CrudController
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
        CRUD::setModel(\App\Models\BlockPluginParking::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/blockPluginParking');
        CRUD::setEntityNameStrings('plugin parking', 'plugin parking');
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
        CRUD::setValidation(BlockPluginParkingRequest::class);

        $this->crud->addField([   // repeatable
            'name'  => 'name',
            'label' => 'Nome blocco',
            'type'  => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ],
        ]);

        $this->crud->addField([   // repeatable
            'name'  => 'link_iubenda',
            'label' => 'Link Iubenda Privacy',
            'type'  => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ],
        ]);

        $this->crud->addField([   // select_from_array
            'name'        => 'style',
            'label'       => "Seleziona stile",
            'type'        => 'select_from_array',
            'options'     => [
                1 => 'Style 1: Form prenotazione parking con tabella prezzi visibile',
                2 => 'Style 2: Solo Form prenotazione parking (tabella prezzi non visibile)',

            ],
            'allows_null' => false,
            'default'     => 1,
            // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
            'wrapperAttributes' => ['class' => 'form-group col-md-12']
        ]);

        $trans = new AdminLanguageController();
        $trans->fields_lang("blockPluginParking", $this->crud);


        $this->crud->addField([   // repeatable
            'name'  => 'name',
            'label' => 'Nome blocco',
            'type'  => 'text',
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

    public function update()
    {
        $this->crud->hasAccessOrFail('update');

        // execute the FormRequest authorization and validation, if one is required
        $request = $this->crud->validateRequest();
        // update the row in the db
        $item = $this->crud->update($request->get($this->crud->model->getKeyName()),
            $this->crud->getStrippedSaveRequest($request));
        $this->data['entry'] = $this->crud->entry = $item;

        // show a success message
        \Alert::success(trans('backpack::crud.update_success'))->flash();

        // save the redirect choice for next time
        $this->crud->setSaveAction();

        $lang = new AdminLanguageController();
        $lang->update_lang("blockPluginParking", $this->crud, $request);

        if($request->has('name')){
            // solo name se non ho aggiunto campi aggiuntivi al blocco
            $this->crud->entry->name = $request->get('name');
            // qui eventuali input aggiuntivi
            $this->crud->entry->style = $request->get('style');

            $this->crud->entry->save();
        }

        $this->crud->entry->save();

        return $this->crud->performSaveAction($item->getKey());
    }

    public function store()
    {
        $this->crud->hasAccessOrFail('create');

        // execute the FormRequest authorization and validation, if one is required
        $request = $this->crud->validateRequest();

        // insert item in the db
        $item = $this->crud->create($this->crud->getStrippedSaveRequest($request));
        $this->data['entry'] = $this->crud->entry = $item;

        // show a success message
        \Alert::success(trans('backpack::crud.insert_success'))->flash();

        // save the redirect choice for next time
        $this->crud->setSaveAction();

        $lang = new AdminLanguageController();
        $lang->update_lang("blockPluginParking", $this->crud, $request);

        $this->crud->entry->save();

        return $this->crud->performSaveAction($item->getKey());
    }
}
