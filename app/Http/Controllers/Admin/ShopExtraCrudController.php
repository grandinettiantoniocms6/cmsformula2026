<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ShopExtraRequest;
use App\Models\PluginProductsCategories;
use App\Models\ShopExtra;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ShopExtraCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ShopExtraCrudController extends CrudController
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
        if(backpack_user()->roles[0]->id > 2){
            die;
        }

        CRUD::setModel(\App\Models\ShopExtra::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/shop-extra');
        CRUD::setEntityNameStrings('extra', 'extra');
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

        $this->crud->removeButton('show');

        $this->crud->setColumns([
            [
                'name'  => 'name',
                'label' => 'Nome',
                'type'  => 'text',
            ],
            [
                'name'  => 'price',
                'label' => 'Prezzo',
                'type'  => 'text',
            ],
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'is_active',
                'label' => 'Attivo', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getIsActive', // the method in your Model
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                'limit' => 10000, // Limit the number of characters shown
            ],
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'type_id',
                'label' => 'Tipo', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getType', // the method in your Model
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                'limit' => 10000, // Limit the number of characters shown
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
        CRUD::setValidation(ShopExtraRequest::class);

        $this->crud->addField([   // repeatable
            'name'        => 'type_id',
            'label'   => 'Tipo',
            'type'        => 'select_from_array',
            'options'     => [1 => 'Prodotto'], //2 => Ordine
            'allows_null' => false,
            'wrapper' => ['class' => 'form-group col-md-4']
        ]);

        $values = null;
        if(\Route::current()->parameter('id')){
            $id = \Route::current()->parameter('id');
            $item = ShopExtra::find($id);
            if($item){
                if($item->categories){
                    $values = explode(";", $item->categories);
                }
            }
        }


        $categories = PluginProductsCategories::get()->pluck("name", "id")->toArray();
        $this->crud->addField([   // select2_from_array
            'name'        => 'categories',
            'label'       => "Categorie non ammesse",
            'type'        => 'select2_from_array',
            'options'     => $categories,
            'allows_null' => true,
            'default'     => null,
            'value' => $values,
            'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
        ]);

        $this->crud->addField([   // Checkbox
            'name'  => 'price',
            'label' => 'Prezzo',
            'type'  => 'text',
            'wrapper' => ['class' => 'form-group col-md-4']
        ]);

        $this->crud->addField([   // Checkbox
            'name'  => 'is_active',
            'label' => 'Attivo?',
            'type'  => 'switch',
            'default' => 1,
            'wrapper' => ['class' => 'form-group col-md-4']
        ]);


        $trans = new AdminLanguageController();
        $trans->fields_lang("shopExtra", $this->crud);

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
        $lang->update_lang("shopExtra", $this->crud, $request);
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
        $lang->update_lang("shopExtra", $this->crud, $request);
        $this->crud->entry->save();

        return $this->crud->performSaveAction($item->getKey());
    }
}
