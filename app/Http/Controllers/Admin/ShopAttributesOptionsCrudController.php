<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ShopAttributesOptionsRequest;
use App\Models\ShopAttributes;
use App\Models\ShopAttributesOptions;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ShopAttributesOptionsCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ShopAttributesOptionsCrudController extends CrudController
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
        if(in_array(backpack_user()->roles[0]->id, [4,5,6,7,8,9])){
            die;
        }

        CRUD::setModel(\App\Models\ShopAttributesOptions::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/shopAttributesOptions');
        CRUD::setEntityNameStrings('opzione', 'opzioni');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $this->crud->removeButton('show');

        $this->crud->setColumns([
            [
                'name'  => 'value',
                'label' => 'Opzione',
                'type'  => 'text',
            ],
            [
                'name'  => 'code',
                'label' => 'SKU Code',
                'type'  => 'text',
            ],
            [
                'name'  => 'icon',
                'label' => 'Icona',
                'type'  => 'text',
            ],
            [
                // 1-n relationship
                'label'     => 'Attributo', // Table column heading
                'type'      => 'select',
                'name'      => 'shop_attribute_id', // the column that contains the ID of that connected entity;
                'entity'    => 'attribute', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user
                'model'     => "App\Models\ShopAttributes", // foreign key model
            ],
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'background_color',
                'label' => 'Sfondo', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getBackgroundColor', // the method in your Model
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                'limit' => 10000, // Limit the number of characters shown
            ],
            [
                'name'  => 'ordine',
                'label' => 'Ordine',
                'type'  => 'text',
            ],
        ]);

        $attributes = ShopAttributes::orderBy("lft", "asc")->get()->pluck("name", "id")->toArray();
        $this->crud->addFilter([
            'name'  => 'shop_attribute_id',
            'type'  => 'select2',
            'label' => 'Attributi'
        ], function () use ($attributes) {
            return $attributes;
        }, function ($value) { // if the filter is active
            $this->crud->addClause('where', 'shop_attribute_id', $value);
        });

    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(ShopAttributesOptionsRequest::class);

        $attributes = ShopAttributes::get()->pluck("name", "id")->toArray();


        $this->crud->addFields([
            [   // select2_from_array
                'name'        => 'shop_attribute_id',
                'label'       => "Attributo",
                'type'        => 'select2_from_array',
                'options'     => $attributes,
                'allows_null' => false,
                // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
            ],
            [   // repeatable
                'name'  => 'icon',
                'label' => 'Icona',
                'type'  => 'browse',
                'wrapper' => ['class' => 'form-group col-md-4'],
            ],
            [
                'name'  => 'code',
                'label' => 'SKU Code',
                'type'  => 'text',
            ],
            [   // color_picker
                'label'                => 'Colore sfondo',
                'name'                 => 'background_color',
                'type'                 => 'color_picker',

                // optional
                // Anything your define inside `color_picker_options` will be passed as JS
                // to the JavaScript plugin. For more information about the options available
                // please see the plugin docs at:
                //  ### https://itsjavi.com/bootstrap-colorpicker/module-options.html
                'color_picker_options' => [
                    'customClass' => 'custom-class',
                    'horizontal' => true,
                    'extensions' => [
                        [
                            'name' => 'swatches', // extension name to load
                            'options' => [ // extension options
                                'colors' => [
                                    'primary' => '#337ab7',
                                    'success' => '#5cb85c',
                                    'info' => '#5bc0de',
                                    'warning' => '#f0ad4e',
                                    'danger' => '#d9534f'
                                ],
                                'namesAsValues' => false
                            ]
                        ]
                    ]
                ]
            ],
            [
                'name'  => 'ordine',
                'label' => 'Ordine',
                'type'  => 'number',
            ],
        ]);

        $trans = new AdminLanguageController();
        $trans->fields_lang("shopAttributesOptions", $this->crud);
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

    public function store()
    {
        $this->crud->hasAccessOrFail('create');

        // execute the FormRequest authorization and validation, if one is required
        $request = $this->crud->validateRequest();

        $value = $request['value'];
        $shop_attribute_id = $request['shop_attribute_id'];

        $count = ShopAttributesOptions::where("value", $value)->where("shop_attribute_id", $shop_attribute_id)->count();
        if($count > 0){
            \Alert::error("Valore già esistente")->flash();
            return redirect()->back();
        }

        // insert item in the db
        $item = $this->crud->create($this->crud->getStrippedSaveRequest());
        $this->data['entry'] = $this->crud->entry = $item;

        // show a success message
        \Alert::success(trans('backpack::crud.insert_success'))->flash();

        // save the redirect choice for next time
        $this->crud->setSaveAction();

        $lang = new AdminLanguageController();
        $lang->update_lang("shopAttributesOptions", $this->crud, $request);
        $this->crud->entry->save();

        return $this->crud->performSaveAction($item->getKey());
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
        $lang->update_lang("shopAttributesOptions", $this->crud, $request);
        $this->crud->entry->save();

        return $this->crud->performSaveAction($item->getKey());
    }
}
