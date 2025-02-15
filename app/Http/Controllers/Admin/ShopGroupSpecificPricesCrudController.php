<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ShopGroupSpecificPricesRequest;
use App\Models\PluginProductsCategories;
use App\Models\SpecificPrice;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ShopGroupSpecificPricesCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ShopGroupSpecificPricesCrudController extends CrudController
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

        CRUD::setModel(\App\Models\CategorySpecificPrice::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/shopGroupSpecificPrices');
        CRUD::setEntityNameStrings('prezzo specifico', 'prezzi specifici');
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
        $this->crud->addColumns([
            [
                // 1-n relationship
                'label' => "Categoria", // Table column heading
                'type' => "select",
                'name' => 'category_id', // the column that contains the ID of that connected entity;
                'entity' => 'category', // the method that defines the relationship in your Model
                'attribute' => "name", // foreign key attribute that is shown to user
                'model' => "App\Models\Category", // foreign key model
            ],
            [
                // 1-n relationship
                'label' => "Brand", // Table column heading
                'type' => "select",
                'name' => 'brand_id', // the column that contains the ID of that connected entity;
                'entity' => 'brand', // the method that defines the relationship in your Model
                'attribute' => "name", // foreign key attribute that is shown to user
                'model' => "App\Models\Brand", // foreign key model
            ],
            [
                'label' => "#Prod.",
                'type' => "model_function",
                'function_name' => 'checkNumberProduct',
            ],
            [
                'name'  => 'discount_type',
                'label' => 'Tipo sconto',
            ],
            [
                'name'  => 'reduction',
                'label' => 'Riduzione',
            ],
            [
                'name'  => 'start_date',
                'label' => 'Data inizio',
                'type' => 'datetime'
            ],
            [
                'name'  => 'expiration_date',
                'label' => 'Data fine',
                'type' => 'datetime'
            ],
            [
                'name'  => 'from_quantity',
                'label' => 'Quantità',
                'type' => 'number'
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
        CRUD::setValidation(ShopGroupSpecificPricesRequest::class);

        $this->crud->addField([
            // 1-n relationship
            'label' => "Seleziona Categoria", // Table column heading
            'type' => "select2_from_ajax",
            'name' => 'category_id', // the column that contains the ID of that connected entity
            'entity' => 'category', // the method that defines the relationship in your Model
            'attribute' => "name", // foreign key attribute that is shown to user
            'model' => "App\Models\PluginProductsCategories", // foreign key model
            'data_source' => url("api/category"), // url to controller search function (with /{id} should return model)
            'placeholder' => "Seleziona categoria", // placeholder for the select
            'minimum_input_length' => 2, // minimum characters to type before querying results,
        ]);


        $this->crud->addField([
            // 1-n relationship
            'label' => "Oppure seleziona Brand", // Table column heading
            'type' => "select2_from_ajax",
            'name' => 'brand_id', // the column that contains the ID of that connected entity
            'entity' => 'brand', // the method that defines the relationship in your Model
            'attribute' => "name", // foreign key attribute that is shown to user
            'model' => "App\Models\PluginProductsBrands", // foreign key model
            'data_source' => url("api/brand"), // url to controller search function (with /{id} should return model)
            'placeholder' => "Seleziona brand", // placeholder for the select
            'minimum_input_length' => 2, // minimum characters to type before querying results,
        ]);

        $this->crud->addFields([
            [   // select_from_array
                'name' => 'discount_type',
                'label' => "Tipo promozione",
                'type' => 'select_from_array',
                'options' => config('config.cart_rule_discount_promotion'),
                'allows_null' => false,
                'default' => null,
            ],
            [
                'name'  => 'reduction',
                'label' => "Riduzione",
                'type'  => 'number',
            ],
            [
                'name'  => 'start_date',
                'label' => "Data inizio",
                'type'  => 'datetime_picker',
            ],

            [
                'name'  => 'expiration_date',
                'label' => "Data fine",
                'type'  => 'datetime_picker',
            ],
            [
                'name'  => 'from_quantity',
                'label' => "Min pezzi",
                'type'  => 'number',
            ],
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

        // show a success message
        \Alert::success(trans('backpack::crud.insert_success'))->flash();

        // save the redirect choice for next time
        $this->crud->setSaveAction();

        if($request->has('category_id')){
            $category = PluginProductsCategories::find($request->get('category_id'));
            $list_ids_categories = $category->get_tree_categories($category->id);

            if($list_ids_categories){
                foreach ($list_ids_categories as $category_id){
                    $products_list = \DB::table('plugins_products_categories_products')->where("plugin_product_category_id", $category_id)->get();
                    if($products_list){
                        foreach ($products_list as $product){
                            SpecificPrice::where("product_id", $product->plugin_product_product_id)->where("from_quantity", $request->get('from_quantity'))->delete();
                            SpecificPrice::insert([
                                "reduction" => $request->get('reduction'),
                                "discount_type" => $request->get('discount_type'),
                                "start_date" => $request->get('start_date'),
                                "expiration_date" => $request->get('expiration_date'),
                                "from_quantity" => $request->get('from_quantity'),
                                "product_id" => $product->plugin_product_product_id,
                                "category_specific_price_id" => $this->crud->entry->id
                            ]);
                        }
                    }
                }
            }
        }

        if($request->has('brand_id')){
            $brand_id = $request->get('brand_id');
            if($brand_id){
                $products_list = \DB::table('plugins_products_categories_products')->where("brand_id", $brand_id)->get();
                if($products_list){
                    foreach ($products_list as $product){
                        SpecificPrice::where("product_id", $product->plugin_product_product_id)->where("from_quantity", $request->get('from_quantity'))->delete();
                        SpecificPrice::insert([
                            "reduction" => $request->get('reduction'),
                            "discount_type" => $request->get('discount_type'),
                            "start_date" => $request->get('start_date'),
                            "expiration_date" => $request->get('expiration_date'),
                            "from_quantity" => $request->get('from_quantity'),
                            "product_id" => $product->plugin_product_product_id,
                            "category_specific_price_id" => $this->crud->entry->id
                        ]);
                    }
                }
            }
        }

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

        SpecificPrice::where("category_specific_price_id", $this->crud->entry->id)
            ->update([
                "reduction" => $request->get('reduction'),
                "discount_type" => $request->get('discount_type'),
                "start_date" => $request->get('start_date'),
                "expiration_date" => $request->get('expiration_date'),
                "from_quantity" => $request->get('from_quantity')
            ]);

        return $this->crud->performSaveAction($item->getKey());
    }

    public function destroy($id)
    {
        $this->crud->hasAccessOrFail('delete');

        // get entry ID from Request (makes sure its the last ID for nested resources)
        $id = $this->crud->getCurrentEntryId() ?? $id;

        SpecificPrice::where("category_specific_price_id", $id)->delete();

        return $this->crud->delete($id);
    }

}
