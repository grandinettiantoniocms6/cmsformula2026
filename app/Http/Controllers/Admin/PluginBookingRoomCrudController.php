<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PluginBookingRoomRequest;
use App\Models\AdminPlugin;
use App\Models\PluginBookingRoom;
use App\Models\PluginBookingRoomAddictions;
use App\Models\PluginBookingRoomPrices;
use App\Models\PluginBookingRoomPromos;
use App\Models\PluginBookingRoomServices;
use App\Models\PluginBookingServices;
use App\Models\PluginBookingType;
use App\Models\PluginProductsCategoriesProducts;
use App\Models\SampleOrderDetail;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Carbon\Carbon;

/**
 * Class PluginBookingRoomCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PluginBookingRoomCrudController extends CrudController
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
        if(backpack_user()->roles[0]->id > 2){
            die;
        }

        CRUD::setModel(\App\Models\PluginBookingRoom::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/plugin-booking-room');

        $type = PluginBookingType::where("id", \request()->get('type'))->first();
        if(!$type){
            $type = PluginBookingType::first();
        }

        CRUD::setEntityNameStrings('', "$type->name");

        $this->crud->setListView(backpack_view('plugins.pluginBooking.rooms'));
        $this->crud->setCreateView(backpack_view('plugins.pluginBooking.room_create'));
        $this->crud->setEditView(backpack_view('plugins.pluginBooking.room_edit'));

        if($type){
            $this->crud->query->where("plugin_booking_type_id", $type->id);
        }

        $this->crud->query->orderBy("lft", "asc");
    }

    protected function setupReorderOperation()
    {
        if(\request()->has('type')){
            $this->crud->query->where("plugin_booking_type_id", \request()->get('type'));
        }

        // define which model attribute will be shown on draggable elements
        $this->crud->set('reorder.label', 'name');
        // define how deep the admin is allowed to nest the items
        // for infinite levels, set it to 0
        $this->crud->set('reorder.max_level', 1);
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

        $this->crud->addButtonFromModelFunction('line', 'getGallery', 'getGallery', 'beginning');

        // Columns.
        $this->crud->setColumns([
            [
                'name'  => 'name',
                'label' => 'Nome',
                'type'  => 'text',
            ],
           /* [
                // run a function on the CRUD model and show its return value
                'name'  => 'price',
                'label' => 'Prezzo ora', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getPriceNow', // the method in your Model
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                'limit' => 10000, // Limit the number of characters shown
            ], */
            /*[
                'name'  => 'data_bookable_start',
                'label' => 'Data inizio',
                'type'  => 'date',
            ],
            [
                'name'  => 'data_bookable_end',
                'label' => 'Data fine',
                'type'  => 'date',
            ],*/
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'is_active',
                'label' => 'Visibile', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getIsActive', // the method in your Model
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
        CRUD::setValidation(PluginBookingRoomRequest::class);

        $trans = new AdminLanguageController();
        $trans->fields_lang("pluginBookingRooms", $this->crud);

        $this->crud->addField([   // Browse
            'name'  => 'cover_photo',
            'label' => 'Foto struttura (visibile nel riepilogo prenotazione)',
            'type'  => 'browse',
        ]);

        $this->crud->addField([
            'name'  => 'sku',
            'label' => 'Sku',
            'type'  => 'text',
            'tab' => 'Impostazioni',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-4'
            ],
        ]);

        $this->crud->addField([   // Checkbox
            'name'  => 'is_active',
            'label' => 'Visibile?',
            'type'  => 'switch',
            'default' => 1,
            'wrapperAttributes' => [
                'class' => 'form-group col-md-4'
            ],
            'tab' => 'Impostazioni'
        ]);

        $types = PluginBookingType::get()->pluck("name", "id")->toArray();
        $this->crud->addField([   // select2_from_array
            'name'        => 'plugin_booking_type_id',
            'label'       => "Tipologia",
            'type'        => 'select2_from_array',
            'options'     => $types,
            'allows_null' => false,
            'tab' => 'Impostazioni',
            'default' => \request()->has('type') ?  \request()->get('type') : null,
            'allows_multiple' => false, // OPTIONAL; needs you to cast this to array in your model;
            'wrapperAttributes' => [
                'class' => 'form-group col-md-4'
            ],
        ]);

        $this->crud->addField([   // Checkbox
            'name'  => 'qty_bambini',
            'label' => 'Numero max bambini',
            'type'  => 'number',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
            'tab' => 'Impostazioni'
        ]);

        $this->crud->addField([   // Checkbox
            'name'  => 'min_anni_bambini',
            'label' => 'Età minima bambino',
            'type'  => 'number',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
            'tab' => 'Impostazioni'
        ]);

        $this->crud->addField([   // Checkbox
            'name'  => 'max_anni_bambini',
            'label' => 'Età massima bambino',
            'type'  => 'number',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
            'tab' => 'Impostazioni'
        ]);

        $this->crud->addField([   // Checkbox
            'name'  => 'price_bambini',
            'label' => 'Prezzo al giorno bambino',
            'type'  => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
            'tab' => 'Impostazioni'
        ]);


        /*$this->crud->addField([   // Checkbox
            'name'  => 'data_bookable_start',
            'label' => 'Data inizio prenotabile',
            'type'  => 'date',
            'tab' => 'Impostazioni'
        ]);

        $this->crud->addField([   // Checkbox
            'name'  => 'data_bookable_end',
            'label' => 'Data fine prenotabile',
            'type'  => 'date',
            'tab' => 'Impostazioni'
        ]);*/

        /*$this->crud->addField([
            'name'  => 'price',
            'label' => 'Prezzo (&euro;) (iva inclusa)',
            'type'  => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-4'
            ],
            'tab' => 'Impostazioni'
        ]);*/

        /*$this->crud->addField([
            'name'  => 'qty_min',
            'label' => 'Posti letto min',
            'type'  => 'number',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-4'
            ],
            'tab' => 'Impostazioni'
        ]);

        $this->crud->addField([
            'name'  => 'qty_max',
            'label' => 'Posti letto max',
            'type'  => 'number',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-4'
            ],
            'tab' => 'Impostazioni'
        ]);*/

        /*$this->crud->addField([
            'name'  => 'promo_price',
            'label' => 'Prezzo (€) in promozione - (Iva inclusa)  ',
            'type'  => 'text',
            'tab' => 'Promozione',
        ]);

        $this->crud->addField([
            'name'  => 'data_promo_start',
            'label' => 'Data inizio promo',
            'type'  => 'date',
            'tab' => 'Promozione',
        ]);

        $this->crud->addField([
            'name'  => 'data_promo_end',
            'label' => 'Data fine promo',
            'type'  => 'date',
            'tab' => 'Promozione',
        ]);

        $this->crud->addField([
            'name'  => 'hidden_promo_countdown',
            'label' => 'Nascondere countdown?',
            'type'  => 'switch',
            'tab' => 'Promozione',
        ]);*/

        $list_values_free = null;
        $list_values = null;
        $services = PluginBookingServices::whereNull("price_1")->whereNull("price_2")
            ->where("plugin_booking_type_id", \request()->get('type'))
            ->get()->pluck("name", "id")->toArray();

        $services_payments = PluginBookingServices::whereNotNull("price_1")
            ->where("plugin_booking_type_id", \request()->get('type'))
            ->whereNotNull("price_2")->get()->pluck("name", "id")->toArray();

        $list_prices = null;
        $list_promos = null;
        $list_addictions = null;

        $room = null;

        $parameters = \Route::current()->parameters(); //se sono in modifica
        if(count($parameters) > 0){
            $item = PluginBookingRoom::find($parameters['id']);

            $list_values_free = PluginBookingRoomServices::where("plugin_booking_room_id", $parameters['id'])
                ->where("is_free", 1)->get();

            $list_values = PluginBookingRoomServices::where("plugin_booking_room_id", $parameters['id'])
                ->whereNull("is_free")->get();

            $services = PluginBookingServices::whereNull("price_1")->whereNull("price_2")
                ->where("plugin_booking_type_id", $item->plugin_booking_type_id)
                ->get()->pluck("name", "id")->toArray();

            $services_payments = PluginBookingServices::whereNotNull("price_1")
                ->where("plugin_booking_type_id", $item->plugin_booking_type_id)
                ->whereNotNull("price_2")->get()->pluck("name", "id")->toArray();

            $list_prices = PluginBookingRoomPrices::where("plugin_booking_room_id", $parameters['id'])->get();
            $list_promos = PluginBookingRoomPromos::where("plugin_booking_room_id", $parameters['id'])->get();
            $list_addictions = PluginBookingRoomAddictions::where("plugin_booking_room_id", $parameters['id'])->get();

            $room = $item;
        }

        $this->crud->addField([   // CustomHTML
            'name' => 'html_prices',
            'type' => 'custom_html',
            'value' => view(backpack_view("plugins.pluginBooking.inc.prices"), compact('list_prices', 'room'))->render(),
            'tab' => 'Prezzi',
        ]);

        $this->crud->addField([   // CustomHTML
            'name' => 'html_promos',
            'type' => 'custom_html',
            'value' => view(backpack_view("plugins.pluginBooking.inc.promos"), compact('list_promos'))->render(),
            'tab' => 'Promozioni',
        ]);

        $this->crud->addField([   // CustomHTML
            'name' => 'html_services',
            'type' => 'custom_html',
            'value' => view(backpack_view("plugins.pluginBooking.inc.services"), compact('list_values_free', 'list_values','services_payments', 'services'))->render(),
            'tab' => 'Servizi',
        ]);

        if(count($parameters) > 0){
            $type = PluginBookingType::find($item->plugin_booking_type_id);

            if($type->is_addiction){
                $this->crud->addField([   // CustomHTML
                    'name' => 'html_addictions',
                    'type' => 'custom_html',
                    'value' => view(backpack_view("plugins.pluginBooking.inc.addictions"), compact('list_addictions'))->render(),
                    'tab' => 'Dipendenze',
                ]);
            }
        }

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
        $price = $request->get('price');
        if(!$price){
            \Alert::error("Inserire almeno un prezzo")->flash();
            return redirect()->back();
        }

        // insert item in the db
        $item = $this->crud->create($this->crud->getStrippedSaveRequest($request));
        $this->data['entry'] = $this->crud->entry = $item;

        // show a success message
        \Alert::success(trans('backpack::crud.insert_success'))->flash();

        // save the redirect choice for next time
        $this->crud->setSaveAction();

        $lang = new AdminLanguageController();
        $lang->update_lang("pluginBookingRooms", $this->crud, $request);
        $this->crud->entry->save();

        PluginBookingRoomPrices::where("plugin_booking_room_id", $this->crud->entry->id)->delete();

        $min = $request->get('min');
        $max = $request->get('max');
        $min_day = $request->get('min_day');
        $max_day = $request->get('max_day');
        $date_start = $request->get('date_start');
        $date_end = $request->get('date_end');
        $all_years = $request->get('all_years');

        if($price){
            foreach ($price as $k=>$v){
                PluginBookingRoomPrices::create([
                    "plugin_booking_room_id" => $this->crud->entry->id,
                    "price" => $v,
                    "min" => $min[$k],
                    "max" => $max[$k],
                    "min_day" => $min_day[$k],
                    "max_day" => $max_day[$k],
                    "date_start" => $date_start[$k],
                    "date_end" => $date_end[$k],
                    "all_years" => $all_years[$k]
                ]);
            }
        }

        PluginBookingRoomPromos::where("plugin_booking_room_id", $this->crud->entry->id)->delete();
        $discount = $request->get('discount');
        $type_discount = $request->get('type_discount');
        $discount_date_start = $request->get('discount_date_start');
        $discount_date_end = $request->get('discount_date_end');
        $condition_discount = $request->get('condition_discount');
        $rule_discount = $request->get('rule_discount');
        $value_discount = $request->get('value_discount');
        $lft_discount = $request->get('lft_discount');
        if($discount){
            foreach ($discount as $k=>$v){
                PluginBookingRoomPromos::create([
                    "plugin_booking_room_id" => $this->crud->entry->id,
                    "discount" => $v,
                    "type_discount" => $type_discount[$k],
                    "date_start" => $discount_date_start[$k],
                    "date_end" => $discount_date_end[$k],
                    "condition_discount" => $condition_discount[$k],
                    "rule_discount" => $rule_discount[$k],
                    "value_discount" => $value_discount[$k],
                    "lft" => $lft_discount[$k]
                ]);
            }
        }

        PluginBookingRoomServices::where("plugin_booking_room_id", $this->crud->entry->id)->delete();
        $categories_free = $request->get('services_list_free');
        $categories = $request->get('services_list');

        $lft_free = $request->get('lft_free');
        $lft = $request->get('lft');

        if($categories){
            foreach ($categories as $catID){
                PluginBookingRoomServices::insert([
                    "plugin_booking_room_id" => $this->crud->entry->id,
                    "plugin_booking_service_id" => $catID,
                    "lft" => $lft[$k],
                    "created_at" => Carbon::now()->toDateTimeString()
                ]);
            }
        }

        if($categories_free){
            foreach ($categories_free as $k=>$catID){
                PluginBookingRoomServices::insert([
                    "plugin_booking_room_id" => $this->crud->entry->id,
                    "plugin_booking_service_id" => $catID,
                    "is_free" => 1,
                    "lft" => $lft_free[$k],
                    "created_at" => Carbon::now()->toDateTimeString()
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
        $price = $request->get('price');
        if(!$price){
            \Alert::error("Inserire almeno un prezzo")->flash();
            return redirect()->back();
        }

        // update the row in the db
        $item = $this->crud->update($request->get($this->crud->model->getKeyName()),
            $this->crud->getStrippedSaveRequest($request));
        $this->data['entry'] = $this->crud->entry = $item;

        // show a success message
        \Alert::success(trans('backpack::crud.update_success'))->flash();

        // save the redirect choice for next time
        $this->crud->setSaveAction();


        PluginBookingRoomPrices::where("plugin_booking_room_id", $this->crud->entry->id)->delete();

        $min = $request->get('min');
        $max = $request->get('max');
        $min_day = $request->get('min_day');
        $max_day = $request->get('max_day');
        $date_start = $request->get('date_start');
        $date_end = $request->get('date_end');
        $all_years = $request->get('all_years');


        if($price){
            foreach ($price as $k=>$v){
                PluginBookingRoomPrices::create([
                    "plugin_booking_room_id" => $this->crud->entry->id,
                    "price" => $v,
                    "min" => $min[$k],
                    "max" => $max[$k],
                    "min_day" => $min_day[$k],
                    "max_day" => $max_day[$k],
                    "date_start" => $date_start[$k],
                    "date_end" => $date_end[$k],
                    "all_years" => $all_years[$k]
                ]);
            }
        }

        PluginBookingRoomPromos::where("plugin_booking_room_id", $this->crud->entry->id)->delete();
        $discount = $request->get('discount');
        $type_discount = $request->get('type_discount');
        $discount_date_start = $request->get('discount_date_start');
        $discount_date_end = $request->get('discount_date_end');
        $condition_discount = $request->get('condition_discount');
        $rule_discount = $request->get('rule_discount');
        $value_discount = $request->get('value_discount');
        $lft_discount = $request->get('lft_discount');

        if($discount){
            foreach ($discount as $k=>$v){
                PluginBookingRoomPromos::create([
                    "plugin_booking_room_id" => $this->crud->entry->id,
                    "discount" => $v,
                    "type_discount" => $type_discount[$k],
                    "date_start" => $discount_date_start[$k],
                    "date_end" => $discount_date_end[$k],
                    "condition_discount" => $condition_discount[$k],
                    "rule_discount" => $rule_discount[$k],
                    "value_discount" => $value_discount[$k],
                    "lft" => $lft_discount[$k]
                ]);
            }
        }

        PluginBookingRoomServices::where("plugin_booking_room_id", $this->crud->entry->id)->delete();
        $categories_free = $request->get('services_list_free');
        $categories = $request->get('services_list');

        $lft_free = $request->get('lft_free');
        $lft = $request->get('lft');

        if($categories){
            foreach ($categories as $k=>$catID){
                PluginBookingRoomServices::insert([
                    "plugin_booking_room_id" => $this->crud->entry->id,
                    "plugin_booking_service_id" => $catID,
                    "lft" => key_exists($k, $lft) ? $lft[$k] : 0,
                    "created_at" => Carbon::now()->toDateTimeString()
                ]);
            }
        }

        if($categories_free){
            foreach ($categories_free as $k=>$catID){
                PluginBookingRoomServices::insert([
                    "plugin_booking_room_id" => $this->crud->entry->id,
                    "plugin_booking_service_id" => $catID,
                    "is_free" => 1,
                    "lft" => key_exists($k, $lft_free) ? $lft_free[$k] : 1,
                    "created_at" => Carbon::now()->toDateTimeString()
                ]);
            }
        }

        PluginBookingRoomAddictions::where("plugin_booking_room_id", $this->crud->entry->id)->delete();
        $addictions = $request->get('addictions');

        if($addictions){
            foreach ($addictions as $k=>$catID){
                PluginBookingRoomAddictions::insert([
                    "plugin_booking_room_id" => $this->crud->entry->id,
                    "room_id" => $catID,
                    "created_at" => Carbon::now()->toDateTimeString()
                ]);
            }
        }


        $lang = new AdminLanguageController();
        $lang->update_lang("pluginBookingRooms", $this->crud, $request);
        $this->crud->entry->save();

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
