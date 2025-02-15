<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PluginProductsImagesRequest;
use App\Http\Requests\PluginProductsImagesSizeRequest;
use App\Models\PluginProducts;
use App\Models\PluginProductsImagesSize;
use App\Models\PluginProductsRelated;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class PluginProductsImagesSizeCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PluginProductsImagesSizeCrudController extends CrudController
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
        CRUD::setModel(\App\Models\PluginProductsImagesSize::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/pluginProductsImagesSize');
        CRUD::setEntityNameStrings('Foto taglie', 'Foto taglie');

        if(backpack_user()->roles[0]->id >= 4){
            die;
        }

        if(request()->has('id')){
            $this->crud->query->orderBy("id", "asc");
            $this->crud->query->where("product_id", request()->get('id'));
        }

        $this->crud->setListView('vendor.backpack.base.custom_products_images_size');
        $this->crud->setCreateView('vendor.backpack.base.custom_products_images_size_create');
        $this->crud->setEditView('vendor.backpack.base.custom_products_images_size_edit');
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
                'function_name' => 'getFoto', // the method in your Model
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
        CRUD::setValidation(PluginProductsImagesSizeRequest::class);

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
        $item = $this->crud->create($this->crud->getStrippedSaveRequest());
        $this->data['entry'] = $this->crud->entry = $item;

        $list = PluginProductsImagesSize::where("product_id", $request['product_id'])->orderBy("order", "desc")->first();
        if(!$list){
            $this->crud->entry->order = 0;
        }else{
            $this->crud->entry->order = $list->order+1;
        }

        $this->crud->entry->product_id = $request['product_id'];
        $this->crud->entry->save();


        $product = PluginProducts::where("id", $this->crud->entry->product_id)->first();
        if($product->is_variant == 0){
            $figli = PluginProducts::where("group_id", $product->group_id)->where("is_variant", 1)->get();
            foreach ($figli as $figlio){
                PluginProductsImagesSize::create([
                    "product_id" => $figlio->id,
                    "image" => $this->crud->entry->image,
                    "order" => $this->crud->entry->order
                ]);
            }
        }


        // show a success message
        \Alert::success(trans('backpack::crud.insert_success'))->flash();

        // save the redirect choice for next time
        $this->crud->setSaveAction();

        return $this->crud->performSaveAction($item->getKey());
    }
}
