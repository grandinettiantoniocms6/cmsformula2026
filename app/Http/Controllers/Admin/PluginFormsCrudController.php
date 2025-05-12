<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PluginFormsRequest;
use App\Models\AdminLanguage;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class PluginFormsCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PluginFormsCrudController extends CrudController
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
        CRUD::setModel(\App\Models\PluginForms::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/pluginForms');
        CRUD::setEntityNameStrings('form', 'form');
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

        $this->crud->setColumns([
            [
                'name'  => 'name',
                'label' => 'Nome',
                'type'  => 'text',
            ],
            [
                'name'  => 'object_form',
                'label' => 'Oggetto',
                'type'  => 'text',
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
        CRUD::setValidation(PluginFormsRequest::class);

        $fields = ['text' => 'Testo', 'textarea' => 'Contenuto', 'email' => 'Email', 'date' => 'Data', 'time' => 'Ora', 'checkbox' => 'Checkbox', 'select' => 'Select', 'text_free' => 'Testo libero', 'file' => 'File', 'button' => 'Pulsante invia'];

        $custom = [   // repeatable
            'type'  => 'repeatable',
            'fields' => [
                [
                'name'    => "title",
                'type'    => 'text',
                'label'   => "Label",
                'wrapper' => ['class' => 'form-group col-md-6'],
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
                    'name'    => 'placeholder',
                    'type'    => 'text',
                    'label'   => 'Placeholder',
                    'wrapper' => ['class' => 'form-group col-md-2'],
                ],

                [   // Checkbox
                    'name' => 'required',
                    'label' => 'Campo obbligatorio?',
                    'type' => 'switch',
                    'wrapper' => ['class' => 'form-group col-md-2'],
                ],
                [
                    'name'    => 'url_pagina',
                    'label'   => 'Url pagina per campo checkbox o testo libero',
                    'type' => 'text',
                    'wrapper' => ['class' => 'form-group col-md-3'],
                ],
                [
                    'name'    => 'values',
                    'label'   => 'Valori select (dividere con virgola)',
                    'type' => 'text',
                    'wrapper' => ['class' => 'form-group col-md-3'],
                ],
                [
                    'name'  => 'order',
                    'type'  => 'hidden',
                    'value' => '0'
                ]
            ],

            // optional
            'new_item_label'  => 'Nuovo campo', // customize the text of the button
            'tab' => 'Form contatti',
        ];

       /* CRUD::field([
            'name'  => 'testimonials',
            'label' => 'Client Testimonials',
            'type'  => 'repeatable',
            'fields' => [ // o "subfields"
                [
                    'name'    => 'client_name',
                    'label'   => 'Client Name',
                    'type'    => 'text',
                    'wrapper' => ['class' => 'form-group col-md-6'],
                ],
                [
                    'name'    => 'testimonial_text',
                    'label'   => 'Testimonial',
                    'type'    => 'textarea',
                    'wrapper' => ['class' => 'form-group col-md-6'],
                ],
            ],
            'new_item_label' => 'Add Testimonial',
            'init_rows'      => 0,
            'min_rows'       => 0,
            'max_rows'       => 10,
            'reorder'        => true,
        ]);

        CRUD::field([
            'name'  => 'internal_feedback',
            'label' => 'Internal Feedback Notes',
            'type'  => 'repeatable',
            'fields' => [
                [
                    'name'    => 'author',
                    'label'   => 'Staff Name',
                    'type'    => 'text',
                    'wrapper' => ['class' => 'form-group col-md-4'],
                ],
                [
                    'name'    => 'note',
                    'label'   => 'Note',
                    'type'    => 'textarea',
                    'wrapper' => ['class' => 'form-group col-md-8'],
                ],
            ],
            'new_item_label' => 'Add Feedback',
            'init_rows'      => 0,
            'min_rows'       => 0,
            'max_rows'       => 5,
            'reorder'        => true,
        ]);*/

        $trans = new AdminLanguageController();
        $trans->fields_lang("pluginForms", $this->crud, $custom);

        $this->crud->addField([   // repeatable
            'name'  => 'name',
            'label' => 'Nome form',
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

        $lang = new AdminLanguageController();
        $lang->update_lang("pluginForms", $this->crud, $request);

        $this->crud->entry->save();

        // show a success message
        \Alert::success(trans('backpack::crud.update_success'))->flash();

        // save the redirect choice for next time
        $this->crud->setSaveAction();

        return redirect()->back();
    }

    public function store()
    {
        $this->crud->hasAccessOrFail('create');

        // execute the FormRequest authorization and validation, if one is required
        $request = $this->crud->validateRequest();

        // insert item in the db
        $item = $this->crud->create($this->crud->getStrippedSaveRequest($request));
        $this->data['entry'] = $this->crud->entry = $item;

        $lang = new AdminLanguageController();
        $lang->update_lang("pluginForms", $this->crud, $request);

        $this->crud->entry->save();

        // show a success message
        \Alert::success(trans('backpack::crud.insert_success'))->flash();

        // save the redirect choice for next time
        $this->crud->setSaveAction();

        return $this->crud->performSaveAction($item->getKey());
    }
}
