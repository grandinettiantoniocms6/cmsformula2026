<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ShopCartRulesRequest;
use App\Models\Currency;
use App\Models\PluginProductsCategories;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ShopCartRulesCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ShopCartRulesCrudController extends CrudController
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

        CRUD::setModel(\App\Models\CartRule::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/shopCartRules');
        CRUD::setEntityNameStrings('codice sconto', 'codici sconto');
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
                'label' => "Nome",
                'type'  => 'text',
            ],
            [
                'name'  => 'code',
                'label' => "Codice",
            ],
            [
                'name'  => 'start_date',
                'label' => "Data inizio",
                'type' => "datetime"
            ],
            [
                'name'  => 'expiration_date',
                'label' => "Data fine",
                'type' => "datetime"
            ],
            [
                'name'  => 'status',
                'label' => "Stato",
                'type' => "check"
            ],
            [
                'name'  => 'total_available',
                'label' => "Disponibilità",
                'type' => "text"
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
        CRUD::setValidation(ShopCartRulesRequest::class);

        $categories = PluginProductsCategories::orderBy("name", "desc")->get()->pluck("name", "id")->toArray();
        if($categories){
            foreach ($categories as $category_id=>$category_label){
                $item = PluginProductsCategories::find($category_id);
                if($item->parent_id == 0 || $item->parent_id == null){
                    $categories[$category_id] = $category_label;
                }else{
                    $parent = PluginProductsCategories::find($item->parent_id);
                    if($parent->parent_id == 0 || $parent->parent_id == null){
                        $categories[$category_id] = "$parent->name > $category_label";
                    }else{
                        $parent_parent = PluginProductsCategories::find($parent->parent_id);
                        if($parent_parent->parent_id == 0 || $parent_parent->parent_id == null){
                            $categories[$category_id] = "$parent_parent->name > $parent->name > $category_label";
                        }else{
                            $parent_parent_parent = PluginProductsCategories::find($parent_parent->parent_id);
                            $categories[$category_id] = "$parent_parent_parent->name > $parent_parent->name > $parent->name > $category_label";
                        }
                    }
                }
            }
        }
        asort($categories);

        $ids_categories = null;
        $parameters = \Route::current()->parameters();
        if(count($parameters)){
            $ids_categories = \DB::table('shop_cart_rules_categories')->where("cart_rule_id", $parameters['id'])->get()->pluck("category_id")->toArray();
        }

        $defaultCurrencyName = Currency::getDefaultCurrencyName();
        $defaultCurrencyId = Currency::getDefaultCurrencyId();

        $this->crud->addFields([
            // INFORMATION TAB
            [
                'name'      => 'name',
                'label'     => trans('cartrule.name'),
                'type'      => 'text',
                'attributes'=> ['required' => 'true'],
                'tab'       => "Informazioni",
            ],
            [
                'name'  => 'code',
                'label' => trans('cartrule.code'),
                'tab'       => "Informazioni",
            ],
            [
                'name'  => 'status',
                'label' => trans('cartrule.status'),
                'type'  => 'switch',
                'tab'       => "Informazioni",
            ],
            [
                'name'  => 'promo_label',
                'label' => "Label Titolo quando coupon OK",
                'tab'       => "Informazioni",
            ],
            [
                'name'  => 'promo_text',
                'label' => "Label testo quando coupon ok",
                'tab'       => "Informazioni",
                'type'  => 'textarea',
            ],

            // CONDITIONS TAB
            [
                'name'  => 'start_date',
                'label' => trans('cartrule.start_date'),
                'type'  => 'datetime_picker',
                'tab'   => trans('cartrule.conditions_tab'),
            ],
            [
                'name'  => 'expiration_date',
                'label' => trans('cartrule.expiration_date'),
                'type'  => 'datetime_picker',
                'tab'   => trans('cartrule.conditions_tab'),
            ],
            [
                'name'      => 'total_available',
                'label'     => trans('cartrule.total_available'),
                'type'      => 'number',
                'attributes'=> [
                    'step'  => 'any',
                ],
                'tab'       => trans('cartrule.conditions_tab'),
            ],
            [
                'name'      => 'total_available_each_user',
                'label'     => trans('cartrule.total_available_each_user'),
                'type'      => 'number',
                'attributes'=> [
                    'step'  => 'any',
                ],
                'tab'       => trans('cartrule.conditions_tab'),
            ],
            [
                'name'      => 'min_nr_products',
                'label'     => trans('cartrule.min_nr_products'),
                'type'      => 'number',
                'attributes'=> [
                    'step'  => 'any',
                ],
                'tab'       => trans('cartrule.conditions_tab'),
            ],
            [
                'name'      => 'minimum_amount',
                'label'     => trans('cartrule.minimum_amount'),
                'type'      => 'number',
                'attributes'=> [
                    'step'  => 'any',
                ],
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-8'
                ],
                'tab'       => trans('cartrule.conditions_tab'),
            ],
            [
                'name'  => 'restrictions',
                'label' => '',
                'type'  => 'custom_html',
                'value' => '<h3>Restrizioni</h3>',
                'tab'   => trans('cartrule.conditions_tab'),

            ],
            /*[
                'name'      => 'categories',
                'label'     => trans('cartrule.categories_rule'),
                'type'      => 'select2_multiple',
                'entity'    => 'categories',
                'attribute' => 'name',
                'model'     => 'App\Models\PluginProductsCategories',
                'pivot'     => true,
                'tab'       => trans('cartrule.conditions_tab'),
            ],*/
            [   // select2_from_array
                'name'        => 'categories_list',
                'label'       => "Categoria",
                'type'        => 'select2_from_array',
                'options'     => $categories,
                'allows_null' => false,
                'default'     => "",
                "value" => $ids_categories,
                'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
                'tab'       => trans('cartrule.conditions_tab'),
            ],
            [
                // 1-n relationship
                'label' => trans('cartrule.products_rule'), // Table column heading
                'type' => "select2_from_ajax_multiple",
                'name' => 'products', // the column that contains the ID of that connected entity
                'entity' => 'products', // the method that defines the relationship in your Model
                'attribute' => "name", // foreign key attribute that is shown to user
                'model' => "App\Models\PluginProducts", // foreign key model
                'data_source' => url("api/product"), // url to controller search function (with /{id} should return model)
                'placeholder' => "Seleziona un prodotto", // placeholder for the select
                'minimum_input_length' => 2, // minimum characters to type before querying results,
                'pivot' => true,
                'tab'       => trans('cartrule.conditions_tab')
            ],
            // ACTIONS TAB
            [
                'name'  => 'free_delivery',
                'label' => trans('cartrule.free_delivery'),
                'tab'   => trans('cartrule.actions_tab'),
                'type'  => 'switch',
            ],
            [   // select_from_array
                'name' => 'discount_type',
                'label' => "Tipo promozione",
                'type' => 'select_from_array',
                'options' => config('config.cart_rule_discount'),
                'allows_null' => false,
                'default' => null,
                'wrapper' => ['class' => 'form-group col-md-4'],
                'tab'   => trans('cartrule.actions_tab'),
            ],
            [
                'name'      => 'reduction_amount',
                'label'     => trans('cartrule.reduction_value'),
                'type'      => 'number',
                'attributes'=> [
                    'step'  => 'any',
                ],
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-8'
                ],
                'tab'       => trans('cartrule.actions_tab'),
            ],
           /* [
                'name'              => 'reduction_currency_id',
                'label'             => trans('cartrule.currency'),
                'entity'            => 'currency',
                'attribute'         => 'name',
                'model'             => 'App\Models\Currency',
                'attributes'        => ['disabled' => 'disabled'],
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-4'
                ],
                'type'      => 'select2_currency',
                'default_currency'   => $defaultCurrencyName,
                'default_currency_id' => $defaultCurrencyId,
                'tab'       => trans('cartrule.actions_tab'),
            ],*/
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

        if($request->has('categories_list')){
            $categories = $request->get('categories_list');
            foreach ($categories as $categoryID){
                \DB::table('shop_cart_rules_categories')->insert([
                    "cart_rule_id" =>  $this->crud->entry->id,
                    "category_id" => $categoryID
                ]);
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

        if($request->has('categories_list')){
            $categories = $request->get('categories_list');
            \DB::table('shop_cart_rules_categories')->where("cart_rule_id", $this->crud->entry->id)->delete();
            foreach ($categories as $categoryID){
                \DB::table('shop_cart_rules_categories')->insert([
                   "cart_rule_id" =>  $this->crud->entry->id,
                   "category_id" => $categoryID
                ]);
            }
        }

        return $this->crud->performSaveAction($item->getKey());
    }
}
