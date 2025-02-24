<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PluginParkingPriceRequest;
use App\Models\PluginParkingPriceRule;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class PluginParkingPriceCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PluginParkingPriceCrudController extends CrudController
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
        CRUD::setModel(\App\Models\PluginParkingPrice::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/plugin-parking-price');
        CRUD::setEntityNameStrings('tariffa', 'tariffe parcheggio');

        $this->crud->setCreateView(backpack_view('plugins.pluginParking.create'));
        $this->crud->setEditView(backpack_view('plugins.pluginParking.edit'));

        $this->crud->query->orderBy("day", "asc");
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
                'name'  => 'day',
                'label' => 'N.Giorni',
                'type'  => 'text',
            ],
            [
                'name'  => 'price_scoperto',
                'label' => '&euro; scoperto',
                'type'  => 'text',
            ],
            [
                'name'  => 'price_coperto',
                'label' => '&euro; coperto',
                'type'  => 'text',
            ],
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'promo',
                'label' => 'Promo', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getPromo', // the method in your Model
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                'limit' => 100000, // Limit the number of characters shown
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
        CRUD::setValidation(PluginParkingPriceRequest::class);

        $this->crud->addField([
            'label' => "Num. Giorni",
            'name' => "day",
            'type'  => 'number',
        ]);

        $this->crud->addField([
            'label' => "Tariffa Parcheggio SCOPERTO",
            'name' => "price_scoperto",
            'type'  => 'text',
        ]);

        $this->crud->addField([
            'label' => "Tariffa Parcheggio COPERTO",
            'name' => "price_coperto",
            'type'  => 'text',
        ]);

        $list_promos = null;
        $parameters = \Route::current()->parameters(); //se sono in modifica
        if(count($parameters) > 0){
            $list_promos = PluginParkingPriceRule::where("plugin_parking_price_id", $parameters['id'])->get();
        }

        $this->crud->addField([   // CustomHTML
            'name' => 'html_promos',
            'type' => 'custom_html',
            'value' => view(backpack_view("plugins.pluginParking.promos"), compact('list_promos'))->render(),
            'tab' => 'Promozioni',
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

    public function update()
    {
        $this->crud->hasAccessOrFail('update');

        // execute the FormRequest authorization and validation, if one is required
        $request = $this->crud->validateRequest();
        // update the row in the db
        $item = $this->crud->update($request->get($this->crud->model->getKeyName()),
            $this->crud->getStrippedSaveRequest($request));
        $this->data['entry'] = $this->crud->entry = $item;

        PluginParkingPriceRule::where("plugin_parking_price_id", $this->crud->entry->id)->delete();
        $discount = $request->get('discount');
        $type_discount = $request->get('type_discount');
        $rule_discount = $request->get('rule_discount');
        $discount_date_start = $request->get('discount_date_start');
        $discount_date_end = $request->get('discount_date_end');
        $lft_discount = $request->get('lft_discount');
        $condition_discount = $request->get('condition_discount');


        if($discount){
            foreach ($discount as $k=>$v){
                PluginParkingPriceRule::create([
                    "plugin_parking_price_id" => $this->crud->entry->id,
                    "discount" => $v,
                    "rule_discount" => $rule_discount[$k],
                    "type_discount" => $type_discount[$k],
                    "date_start" => $discount_date_start[$k],
                    "date_end" => $discount_date_end[$k],
                    "lft" => $lft_discount[$k],
                    "condition_discount" => $condition_discount[$k],
                ]);
            }
        }

        // show a success message
        \Alert::success(trans('backpack::crud.update_success'))->flash();

        // save the redirect choice for next time
        $this->crud->setSaveAction();

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

        PluginParkingPriceRule::where("plugin_parking_price_id", $this->crud->entry->id)->delete();
        $discount = $request->get('discount');
        $rule_discount = $request->get('rule_discount');
        $type_discount = $request->get('type_discount');
        $discount_date_start = $request->get('discount_date_start');
        $discount_date_end = $request->get('discount_date_end');
        $lft_discount = $request->get('lft_discount');
        $condition_discount = $request->get('condition_discount');

        if($discount){
            foreach ($discount as $k=>$v){
                PluginParkingPriceRule::create([
                    "plugin_parking_price_id" => $this->crud->entry->id,
                    "discount" => $v,
                    "rule_discount" => $rule_discount[$k],
                    "type_discount" => $type_discount[$k],
                    "date_start" => $discount_date_start[$k],
                    "date_end" => $discount_date_end[$k],
                    "condition_discount" => $condition_discount[$k],
                    "lft" => $lft_discount[$k]
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
