<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\BlockContactRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class BlockContactCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class BlockContactCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public $block = "blockContact";
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\BlockContact::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/blockContact');
        CRUD::setEntityNameStrings('form contatti', 'form contatti');
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
        CRUD::setValidation(BlockContactRequest::class);

        $fields = ['text' => 'Testo', 'textarea' => 'Contenuto', 'email' => 'Email', 'button' => 'Captcha + Pulsante', 'checkbox' => 'Checkbox', 'select' => 'Select', 'text_free' => 'Testo libero'];

        $custom = [   // repeatable
            'name'  => 'content',
            'label' => 'Campi form <strong>Obbligatorio ci sia un campo email</strong>',
            'type'  => 'repeatable',
            'fields' => [
                [
                    'name'    => 'title',
                    'type'    => 'text',
                    'label'   => 'Label',
                    'wrapper' => ['class' => 'form-group col-md-4'],
                ],
                [
                    'name'    => 'col',
                    'label'   => 'Colonna',
                    'type' => 'select_from_array',
                    'options' => ['12' => '12', '6' => '6', '4' => '4'],
                    'allows_null' => false,
                    'default' => '12',
                    'wrapper' => ['class' => 'form-group col-md-2'],
                ],
                [   // select_from_array
                    'name' => 'type',
                    'label' => "Tipo",
                    'type' => 'select_from_array',
                    'options' => $fields,
                    'allows_null' => false,
                    'default' => 'text',
                    'wrapper' => ['class' => 'form-group col-md-4'],
                ],
                [
                    'name'    => 'ordine',
                    'type'    => 'text',
                    'label'   => 'Ordine',
                    'wrapper' => ['class' => 'form-group col-md-2'],
                ],
                [   // Checkbox
                    'name' => 'required',
                    'label' => 'Campo obbligatorio?',
                    'type' => 'checkbox'
                ],
                [
                    'name'    => 'url_pagina',
                    'label'   => 'Url pagina per campo checkbox o testo libero',
                    'type' => 'text',
                    'wrapper' => ['class' => 'form-group col-md-6'],
                ],
                [
                    'name'    => 'values',
                    'label'   => 'Valori select (dividere con virgola)',
                    'type' => 'text',
                    'wrapper' => ['class' => 'form-group col-md-6'],
                ],

            ],

            // optional
            'new_item_label'  => 'Nuovo campo', // customize the text of the button
        ];

        $this->crud->addField([   // repeatable
            'name'  => 'name',
            'label' => 'Nome blocco',
            'type'  => 'text',
        ]);

        $this->crud->addField([   // repeatable
            'name'  => 'email',
            'label' => 'Email ricezione',
            'type'  => 'text',
        ]);

        $this->crud->addField([   // repeatable
            'name'  => 'cc',
            'label' => 'Email in copia (separare con virgola)',
            'type'  => 'text',
        ]);

        $this->crud->addField([   // repeatable
            'name'  => 'ccn',
            'label' => 'Email in copia nascosta (separare con virgola)',
            'type'  => 'text',
        ]);

        $trans = new AdminLanguageController();
        $trans->fields_lang($this->block, $this->crud, $custom);

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
        $lang->update_lang($this->block, $this->crud, $request);
        $this->crud->entry->save();

        return $this->crud->performSaveAction($item->getKey());
    }
}
