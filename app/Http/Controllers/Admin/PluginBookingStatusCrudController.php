<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PluginBookingStatusRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class PluginBookingStatusCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PluginBookingStatusCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public $block = "pluginBookingStatus";

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

        CRUD::setModel(\App\Models\PluginBookingStatus::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/plugin-booking-status');
        CRUD::setEntityNameStrings('stato', 'stati prenotazione');
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


        // Columns.
        $this->crud->setColumns([
            [
                'name'  => 'name',
                'label' => 'Nome',
                'type'  => 'text',
            ],
            [   // Checkbox
                'name' => 'is_payment',
                'label' => 'Abilita pagamento',
                'type' => 'check'
            ],
            [   // Checkbox
                'name' => 'is_unblock',
                'label' => 'Sblocca slot',
                'type' => 'check'
            ],
            [   // Checkbox
                'name' => 'is_annullato',
                'label' => 'Annullato',
                'type' => 'check'
            ],
            [   // Checkbox
                'name' => 'is_completato',
                'label' => 'Completato',
                'type' => 'check'
            ],
            [
                'name'  => 'class',
                'label' => 'Classe css',
                'type'  => 'text',
            ],
        ]);
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(PluginBookingStatusRequest::class);

        $trans = new AdminLanguageController();
        $trans->fields_lang($this->block, $this->crud);

        $this->crud->addField([   // Browse
            'name'  => 'name',
            'label' => 'Nome',
            'type'  => 'text',
            'wrapper' => ['class' => 'form-group col-md-6']
        ]);

        $this->crud->addField([   // Browse
            'name'  => 'class',
            'label' => 'Classe Css',
            'type'  => 'text',
            'wrapper' => ['class' => 'form-group col-md-6']
        ]);

        $this->crud->addField([   // Checkbox
            'name'  => 'is_unblock',
            'label' => 'Libera prenotazione?',
            'type'  => 'switch',
            'wrapper' => ['class' => 'form-group col-md-4']
        ]);

        $this->crud->addField([   // Checkbox
            'name'  => 'is_annullato',
            'label' => 'Stato annullato?',
            'type'  => 'switch',
            'wrapper' => ['class' => 'form-group col-md-4']
        ]);

        $this->crud->addField([   // Checkbox
            'name'  => 'is_completato',
            'label' => 'Stato completato?',
            'type'  => 'switch',
            'wrapper' => ['class' => 'form-group col-md-4']
        ]);

        $this->crud->addField([   // Checkbox
            'name'  => 'color_admin',
            'label' => 'Colore Agenda',
            'type'    => 'color',
            'default' => '#000000',
            'wrapper' => ['class' => 'form-group col-md-4']
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
            $this->crud->getStrippedSaveRequest());
        $this->data['entry'] = $this->crud->entry = $item;

        $lang = new AdminLanguageController();
        $lang->update_lang($this->block, $this->crud, $request);

        $item->save();

        // show a success message
        \Alert::success(trans('backpack::crud.update_success'))->flash();

        // save the redirect choice for next time
        $this->crud->setSaveAction();

        return $this->crud->performSaveAction($item->getKey());
    }


    public function store()
    {
        $this->crud->hasAccessOrFail('create');

        // execute the FormRequest authorization and validation, if one is required
        $request = $this->crud->validateRequest();

        // insert item in the db
        $item = $this->crud->create($this->crud->getStrippedSaveRequest());
        $this->data['entry'] = $this->crud->entry = $item;

        $lang = new AdminLanguageController();
        $lang->update_lang($this->block, $this->crud, $request);

        $item->save();

        // show a success message
        \Alert::success(trans('backpack::crud.insert_success'))->flash();

        // save the redirect choice for next time
        $this->crud->setSaveAction();

        return $this->crud->performSaveAction($item->getKey());
    }


}
