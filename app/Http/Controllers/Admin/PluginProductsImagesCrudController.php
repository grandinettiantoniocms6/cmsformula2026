<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PluginProductsImagesRequest;
use App\Models\Order;
use App\Models\PluginProductsImages;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class PluginProductsImagesCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PluginProductsImagesCrudController extends CrudController
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
        CRUD::setModel(\App\Models\PluginProductsImages::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/pluginProductsImages');
        CRUD::setEntityNameStrings('Foto', 'Foto');

        if(backpack_user()->roles[0]->id >= 4){
            die;
        }

        if(request()->has('id')){
            $this->crud->query->orderBy("id", "asc");
            $this->crud->query->where("product_id", request()->get('id'));
        }

        $this->crud->setListView('vendor.backpack.base.custom_products_images');
        $this->crud->setCreateView('vendor.backpack.base.custom_products_images_create');
        $this->crud->setEditView('vendor.backpack.base.custom_products_images_edit');


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
                // run a function on the CRUD model and show its return value
                'name'  => 'photo',
                'label' => 'Foto', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'get_foto_mini', // the method in your Model
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                'limit' => 10000, // Limit the number of characters shown
            ],
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'order',
                'label' => 'Ordine', // Table column heading
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
        CRUD::setValidation(PluginProductsImagesRequest::class);

        if(request()->has('id')){
            $this->crud->addField([   // Browse
                'name'  => 'product_id',
                'value' => request()->get('id'),
                'type'  => 'hidden'
            ]);
        }

        $this->crud->addField([   // Browse
            'name'  => 'image',
            'label' => 'Foto',
            'type'  => 'browse',
        ]);

        $this->crud->addField([   // Browse
            'name'  => 'order',
            'label' => 'Ordine',
            'type'  => 'number',
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

    public function store()
    {
        $this->crud->hasAccessOrFail('create');

        // execute the FormRequest authorization and validation, if one is required
        $request = $this->crud->validateRequest();

        // insert item in the db
        $item = $this->crud->create($this->crud->getStrippedSaveRequest($request));
        $this->data['entry'] = $this->crud->entry = $item;

        $list = PluginProductsImages::where("product_id", $request['product_id'])->orderBy("order", "desc")->first();
        if(!$list){
            $this->crud->entry->order = 0;
        }else{
            $this->crud->entry->order = $list->order+1;
        }

        $this->crud->entry->product_id = $request['product_id'];
        $this->crud->entry->save();

        // show a success message
        \Alert::success(trans('backpack::crud.insert_success'))->flash();

        // save the redirect choice for next time
        $this->crud->setSaveAction();

        return $this->crud->performSaveAction($item->getKey());
    }
}
