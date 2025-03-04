<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PluginBookingServicesRequest;
use App\Models\AdminBlock;
use App\Models\PluginBookingServices;
use App\Models\PluginBookingType;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Http\Request;

/**
 * Class PluginBookingServicesCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PluginBookingServicesCrudController extends CrudController
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
        CRUD::setModel(\App\Models\PluginBookingServices::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/plugin-booking-services');
        CRUD::setEntityNameStrings('servizio', 'Booking servizi');

        if(backpack_user()->roles[0]->id > 2){
            die;
        }

        $this->crud->query->orderBy("lft", "asc");

    }

    protected function setupReorderOperation()
    {
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

        // Columns.
        $this->crud->setColumns([
            [
                'name'  => 'name',
                'label' => 'Nome',
                'type'  => 'text',
            ],
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'plugin_booking_type_id',
                'label' => 'Tipologia', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getType', // the method in your Model
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                'limit' => 10000, // Limit the number of characters shown
            ],
            [
                'name'  => 'price_1',
                'label' => 'Prezzo 1',
                'type'  => 'text',
            ],
            [
                'name'  => 'price_2',
                'label' => 'Prezzo 2',
                'type'  => 'text',
            ],
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'is_active',
                'label' => 'Visibile', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getIsActive', // the method in your Model
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                'limit' => 10000, // Limit the number of characters shown
            ],
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'is_edit_qty',
                'label' => 'Qta richiesta', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getIsEditQty', // the method in your Model
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                'limit' => 10000, // Limit the number of characters shown
            ],
        ]);

        $types = PluginBookingType::orderBy("name", "asc")->get()->pluck("name", "id")->toArray();
        // select2 filter
        $this->crud->addFilter([
            'name' => 'type_id',
            'type' => 'select2',
            'label' => 'Tipologia'
        ], function () use ($types) {
            return $types;
        }, function ($value) { // if the filter is active
            $this->crud->addClause('where', 'plugin_booking_type_id', $value);
        });

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
        CRUD::setValidation(PluginBookingServicesRequest::class);

        $this->crud->addField([   // Browse
            'name'  => 'photo',
            'label' => 'Immagine',
            'type'  => 'browse'
        ]);

        $this->crud->addField([   // Browse
            'name'  => 'price_1',
            'label' => 'Prezzo 1',
            'type'  => 'text',
            'wrapper' => ['class' => 'form-group col-md-1']
        ]);

        $this->crud->addField([   // Browse
            'name'  => 'price_2',
            'label' => 'Prezzo 2',
            'type'  => 'text',
            'wrapper' => ['class' => 'form-group col-md-1']
        ]);

        $this->crud->addField([   // Checkbox
            'name'  => 'is_active',
            'label' => 'Visibile?',
            'type'  => 'switch',
            'wrapper' => ['class' => 'form-group col-md-2']
        ]);

        $this->crud->addField([   // Checkbox
            'name'  => 'is_edit_qty',
            'label' => 'Qty richiesta?',
            'type'  => 'switch',
            'wrapper' => ['class' => 'form-group col-md-2']
        ]);

        $types = PluginBookingType::get()->pluck("name", "id")->toArray();
        $this->crud->addField([   // select2_from_array
            'name'        => 'plugin_booking_type_id',
            'label'       => "Tipologia",
            'type'        => 'select2_from_array',
            'options'     => $types,
            'allows_null' => false,
            'default' => \request()->has('type') ?  \request()->get('type') : null,
            'allows_multiple' => false, // OPTIONAL; needs you to cast this to array in your model;
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
        ]);

        $trans = new AdminLanguageController();
        $trans->fields_lang("pluginBookingServices", $this->crud);

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

        // show a success message
        \Alert::success(trans('backpack::crud.update_success'))->flash();

        // save the redirect choice for next time
        $this->crud->setSaveAction();

        $lang = new AdminLanguageController();
        $lang->update_lang("pluginBookingServices", $this->crud, $request);
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
        $lang->update_lang("pluginBookingServices", $this->crud, $request);
        $this->crud->entry->save();

        return $this->crud->performSaveAction($item->getKey());
    }

    public function get_info(Request $request){
        $id = $request->get('id');
        $item = PluginBookingServices::find($id);

        return response()->json([
           "item" => $item
        ]);
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
