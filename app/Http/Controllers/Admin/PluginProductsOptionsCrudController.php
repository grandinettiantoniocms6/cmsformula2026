<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PluginProductsOptionsRequest;
use App\Models\PluginProductsAttributes;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class PluginProductsOptionsCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PluginProductsOptionsCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ReorderOperation;
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\PluginProductsOptions::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/pluginProductsOptions');
        CRUD::setEntityNameStrings('proprietà', 'proprietà');

        if(request()->has('id')){
            $this->crud->query->where("product_id", request()->get('id'));
        }

        $this->crud->setListView(backpack_view('custom_plugin_products_options'));
        $this->crud->setReorderView(backpack_view('custom_reorder_plugin_products_options'));
        $this->crud->query->orderBy("lft", "asc");

        $this->crud->isReorderEnabled();
    }

    protected function setupReorderOperation()
    {
        // define which model attribute will be shown on draggable elements
        $this->crud->set('reorder.label', 'attribute_id');
        // define how deep the admin is allowed to nest the items
        // for infinite levels, set it to 0
        $this->crud->set('reorder.max_level', 2);
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
        $this->crud->removeButton("update");
        $this->crud->removeButton("delete");

        // Columns.
        $this->crud->setColumns([
            [
                // 1-n relationship
                'label'     => 'Proprietà', // Table column heading
                'type'      => 'select',
                'name'      => 'attribute_id', // the column that contains the ID of that connected entity;
                'entity'    => 'attribute', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user
                'model'     => "App\Models\PluginsProductsAttributes", // foreign key model
            ],
            [
                'name'  => 'value',
                'label' => 'Valore',
                'type'  => 'text',
                'limit' => 10000,
            ],
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'is_in_menu',
                'label' => 'Azioni', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getMenu', // the method in your Model
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                'limit' => 10000, // Limit the number of characters shown
            ]
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
        CRUD::setValidation(PluginProductsOptionsRequest::class);

        $trans = new AdminLanguageController();
        $trans->fields_lang("pluginProductsOptions", $this->crud);

        $attributes = PluginProductsAttributes::get()->pluck("name", "id")->toArray();
        $this->crud->addField([   // select2_from_array
            'name'        => 'attribute_id',
            'label'       => "Proprietà",
            'type'        => 'select2_from_array',
            'options'     => $attributes,
            'allows_null' => true,
            'default'     => null,
            // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
        ]);


        $this->crud->addField([   // Checkbox
            'name'  => 'product_id',
            'value' => request()->get('id'),
            'type'  => 'hidden'
        ]);

        $this->crud->addField([   // Checkbox
            'name'  => 'attribute_new',
            'label' => 'Nuova proprietà?',
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
        $trans = new AdminLanguageController();
        $trans->fields_lang("pluginProductsOptions", $this->crud);

        $attributes = PluginProductsAttributes::get()->pluck("name", "id")->toArray();
        $this->crud->addField([   // select2_from_array
            'name'        => 'attribute_id',
            'label'       => "Proprietà",
            'type'        => 'select2_from_array',
            'options'     => $attributes,
            'allows_null' => true,
            'default'     => null,
            // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
        ]);

        $this->crud->addField([   // Checkbox
            'name'  => 'product_id',
            'value' => request()->get('id'),
            'type'  => 'hidden'
        ]);

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
        $lang->update_lang("pluginProductsOptions", $this->crud, $request);

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
        $lang->update_lang("pluginProductsOptions", $this->crud, $request);
        $this->crud->entry->save();

        $attribute_new = $request->get('attribute_new');
        if($attribute_new != ""){
            $pluginAttribute = PluginProductsAttributes::where("name", $attribute_new)->first();
            if(!$pluginAttribute){
                $pluginAttribute = PluginProductsAttributes::create([
                    "name" =>$attribute_new
                ]);
            }
            $this->crud->entry->attribute_id = $pluginAttribute->id;
            $this->crud->entry->save();
        }

        return $this->crud->performSaveAction($item->getKey());
    }

    public function saveReorder()
    {
        $this->crud->hasAccessOrFail('reorder');

        $all_entries = \Request::input('tree');

        if(!is_array($all_entries)){
            $all_entries = json_decode($all_entries, true);
        }

        if (count($all_entries)) {
            $count = $this->crud->updateTreeOrder($all_entries);
        } else {
            return false;
        }

        return 'success for '.$count.' items';
    }
}
