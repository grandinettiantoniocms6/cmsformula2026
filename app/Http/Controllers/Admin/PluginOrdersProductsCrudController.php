<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PluginOrdersProductsRequest;
use App\Models\PluginOrdersCategories;
use App\Models\PluginOrdersProducts;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Http\Request;

/**
 * Class PluginOrdersProductsCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PluginOrdersProductsCrudController extends CrudController
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
        if(backpack_user()->roles[0]->id > 3){
            die;
        }

        CRUD::setModel(\App\Models\PluginOrdersProducts::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/pluginOrdersProducts');
        CRUD::setEntityNameStrings('prodotti', 'prodotto');
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

        if(backpack_user()->roles[0]->id > 3){
            die;
        }

        // Columns.
        $this->crud->setColumns([
            [
                'name'  => 'name',
                'label' => 'Nome',
                'type'  => 'text',
            ],
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'plugin_order_category_id',
                'label' => 'Categoria', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getCategory', // the method in your Model
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
        CRUD::setValidation(PluginOrdersProductsRequest::class);

        if(backpack_user()->roles[0]->id > 3){
            die;
        }

        $this->crud->addField([
            'name' => 'name',
            'label' => "Nome",
            'type' => 'text',
            'attributes' => ['class' => 'form-control'],
            'wrapperAttributes' => [
                'class' => 'form-group col-md-12'
            ],
        ]);


        $categories = PluginOrdersCategories::where("type_id", 1)->get()->pluck("name", "id")->toArray();
        $this->crud->addField([   // select2_from_array
            'name'        => 'plugin_order_category_id',
            'label'       => "Categoria",
            'type'        => 'select2_from_array',
            'options'     => $categories,
            'allows_null' => true,
            'default'     => null,
            // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
        ]);

        $this->crud->addField([
            'name' => 'description',
            'label' => "Descrizione",
            'type' => 'ckeditor',
            'attributes' => ['class' => 'form-control'],
            'wrapperAttributes' => [
                'class' => 'form-group col-md-12'
            ],
        ]);

        $this->crud->addField([
            'name' => 'note',
            'label' => "Note",
            'type' => 'ckeditor',
            'attributes' => ['class' => 'form-control'],
            'wrapperAttributes' => [
                'class' => 'form-group col-md-12'
            ],
        ]);


        $this->crud->addField([
            'name' => "user_id",
            'value' => backpack_user()->id,
            'type'  => 'hidden',
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
        if(backpack_user()->roles[0]->id > 3){
            die;
        }

        $this->setupCreateOperation();
    }

    public function get_row_products(Request $request){
        $id = $request->get('id');
        $resourceId = $request->get('resourceId');
        $units = PluginOrdersCategories::where("type_id", 0)->get();

        $product = PluginOrdersProducts::find($id);
        if($product){
            $rand = rand(3000,9999);
            $html = view("vendor.backpack.base.plugins.pluginOrders.row_table_new_reservation", compact('rand','product','units', 'resourceId'))->render();
            return response()->json(['html' => $html]);
        }
        return response()->json(['html' => ""]);
    }

    public function add_new_products(Request $request){
        $resourceId = $request->get('resourceId');
        $units = PluginOrdersCategories::where("type_id", 0)->get();

        $rand = rand(3000,9999);
        $html = view("vendor.backpack.base.plugins.pluginOrders.row_table_new_reservation_new_product", compact('rand','units', 'resourceId'))->render();
        return response()->json(['html' => $html]);
    }
}
