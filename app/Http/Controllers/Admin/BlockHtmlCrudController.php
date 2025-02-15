<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\BlockHtmlRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class BlockHtmlCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class BlockHtmlCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public $block = "blockHtml";
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\BlockHtml::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/'.$this->block);
        CRUD::setEntityNameStrings('blocco Html', 'blocco Html');
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
        CRUD::setValidation(BlockHtmlRequest::class);

        /*$this->crud->addField([   // Checkbox
            'name'  => 'is_with_section',
            'label' => 'Inserire spazio section?',
            'value' => 1,
            'type'  => 'hidden',
            'default' => 1
        ]);*/

        $this->crud->addField([   // repeatable
            'name'  => 'mt',
            'label' => 'Margin verticale: Imposta un valore da 0 a max 120 (Es: 10, 20, 30 eccetera - 0 nessun margine)',
            'type'  => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ],
        ]);

        $this->crud->addField([   // repeatable
            'name'        => 'col',
            'label'   => 'Seleziona larghezza colonna',
            'type'        => 'select_from_array',
            'options'     => ['3' => 'Larghezza minima col-3', '6' => 'Larghezza media col-6', '9' => 'Larghezza alta col-9', '12' => 'Larghezza massima col-12'],
            'allows_null' => false,
            'default'     => '12',
            'wrapper' => ['class' => 'form-group col-md-6']
        ]);

        $this->crud->addField([   // Browse
            'name'  => 'foto',
            'label' => 'Se vuoi puoi scegliere un\'immagine di sfondo per la sezione testo',
            'type'  => 'browse',
            'wrapperAttributes' => ['class' => 'form-group col-md-12']
        ]);

        $this->crud->addField([   // repeatable
            'name'  => 'bgcolor',
            'label' => 'Oppure seleziona un colore di sfondo.',
            'type'  => 'color_picker',
            // optional
            //'default' => '#1ab42f',
            'color_picker_options' => ['customClass' => 'custom-class'],
            'wrapperAttributes' => ['class' => 'form-group col-md-12']
        ]);

        //--------------------LANGUAGES
        $trans = new AdminLanguageController();
        $trans->fields_lang($this->block, $this->crud);

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

    public function store()
    {
        $this->crud->hasAccessOrFail('create');

        // execute the FormRequest authorization and validation, if one is required
        $request = $this->crud->validateRequest();

        // insert item in the db
        $item = $this->crud->create($this->crud->getStrippedSaveRequest());
        $this->data['entry'] = $this->crud->entry = $item;

        // show a success message
        \Alert::success(trans('backpack::crud.insert_success'))->flash();

        // save the redirect choice for next time
        $this->crud->setSaveAction();

        $lang = new AdminLanguageController();
        $lang->update_lang($this->block, $this->crud, $request);
        $this->crud->entry->save();

        return $this->crud->performSaveAction($item->getKey());
    }
}
