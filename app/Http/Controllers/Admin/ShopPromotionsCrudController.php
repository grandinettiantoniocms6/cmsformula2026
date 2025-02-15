<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ShopPromotionsRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ShopPromotionsCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ShopPromotionsCrudController extends CrudController
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

        CRUD::setModel(\App\Models\Promotion::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/shopPromotions');
        CRUD::setEntityNameStrings('promozione', 'promozioni');

        $this->crud->orderBy("start_date", "desc");
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
                'name'  => 'name',
                'label' => 'Nome',
            ],
            [
                'name'          => 'product_id',
                'label'         => "Categoria/Brand",
                'type'          => "model_function",
                'function_name' => 'getObjName',
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
                'name' => 'is_forced',
                'label' => 'Priorità',
                'type' => 'boolean',
                // optionally override the Yes/No texts
                // 'options' => [0 => 'Active', 1 => 'Inactive']
            ],
            [
                'name'           => "reduction",
                'label'          => "Promo",
                'type'           => "model_function",
                'function_name'  => 'getDiscount',
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
        CRUD::setValidation(ShopPromotionsRequest::class);

        $this->crud->addFields([
            [
                'name'  => 'name',
                'label' => 'Nome',
                'type'  => 'text',
            ],
            [
                'name'  => 'description',
                'label' => 'Descrizione',
                'type'  => 'summernote',
            ],
            [
                // 1-n relationship
                'label' => "Categoria", // Table column heading
                'type' => "select2_from_ajax",
                'name' => 'category_id', // the column that contains the ID of that connected entity
                'entity' => 'category', // the method that defines the relationship in your Model
                'attribute' => "name", // foreign key attribute that is shown to user
                'model' => "App\Models\PluginProductsCategories", // foreign key model
                'data_source' => url("api/category"), // url to controller search function (with /{id} should return model)
                'placeholder' => "Seleziona categoria", // placeholder for the select
                'minimum_input_length' => 2, // minimum characters to type before querying results
            ],
            [
                // 1-n relationship
                'label' => "Brand", // Table column heading
                'type' => "select2_from_ajax",
                'name' => 'brand_id', // the column that contains the ID of that connected entity
                'entity' => 'brand', // the method that defines the relationship in your Model
                'attribute' => "name", // foreign key attribute that is shown to user
                'model' => "App\Models\PluginProductsBrands", // foreign key model
                'data_source' => url("api/brand"), // url to controller search function (with /{id} should return model)
                'placeholder' => "Seleziona brand", // placeholder for the select
                'minimum_input_length' => 2, // minimum characters to type before querying results
            ],
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
            [   // Checkbox
                'name' => 'is_forced',
                'label' => 'Abilita priorità? (Se attiva, questa promozione sovrascrive eventuali promozioni attive sui singoli prodotti)',
                'type' => 'checkbox'
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
}
