<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PluginBookingTypeRequest;
use App\Models\PluginBookingStatus;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class PluginBookingTypeCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PluginBookingTypeCrudController extends CrudController
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
        CRUD::setModel(\App\Models\PluginBookingType::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/plugin-booking-type');
        CRUD::setEntityNameStrings('tipologia struttura', 'tipologie strutture');

        $this->crud->query->orderBy("lft", "asc");
    }

    protected function setupReorderOperation()
    {
        // define which model attribute will be shown on draggable elements
        $this->crud->set('reorder.label', 'name');
        // define how deep the admin is allowed to nest the items
        // for infinite levels, set it to 0
        $this->crud->set('reorder.max_level', 0);
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

        if(backpack_user()->roles[0]->id > 2){
            $this->crud->removeButton("create");
            // $this->crud->removeButton("update");
            $this->crud->removeButton("delete");
        }

        // Columns.
        $this->crud->setColumns([
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'image',
                'label' => 'Foto', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'get_foto_mini', // the method in your Model
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                'limit' => 10000, // Limit the number of characters shown
            ],
            [
                'name'  => 'name',
                'label' => 'Nome',
                'type'  => 'text',
            ],
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'type_booking',
                'label' => 'Tipo', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getType', // the method in your Model
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                'limit' => 10000, // Limit the number of characters shown
            ],
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'default_status_id',
                'label' => 'Stato', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getStatus', // the method in your Model
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                'limit' => 10000, // Limit the number of characters shown
            ],
            [
                'name'  => 'number_hours_for_cancellation',
                'label' => 'Ore Disdetta',
                'type'  => 'number',
            ],
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'booleans',
                'label' => 'Impostazioni', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getBooleans', // the method in your Model
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                'limit' => 10000, // Limit the number of characters shown
            ],

            /*[
                // run a function on the CRUD model and show its return value
                'name'  => 'can_payment',
                'label' => 'Pagamenti', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getPayment', // the method in your Model
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                'limit' => 10000, // Limit the number of characters shown
            ],
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'is_visible',
                'label' => 'Visibile', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getVisible', // the method in your Model
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                'limit' => 10000, // Limit the number of characters shown
            ],
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'is_visible_calendar',
                'label' => 'Filtro', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getVisibleCalendar', // the method in your Model
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                'limit' => 10000, // Limit the number of characters shown
            ],
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'is_checkin',
                'label' => 'Checkin', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getCheckin', // the method in your Model
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                'limit' => 10000, // Limit the number of characters shown
            ], */
        ]);
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        if(backpack_user()->roles[0]->id > 2){
            die;
        }

        CRUD::setValidation(PluginBookingTypeRequest::class);

        $trans = new AdminLanguageController();
        $trans->fields_lang("pluginBookingTypes", $this->crud, null);

        $this->crud->addField([   // Browse
            'name'  => 'image',
            'label' => 'Foto',
            'type'  => 'browse',
        ]);

        $this->crud->addField([   // repeatable
            'name'  => 'name',
            'label' => 'Nome',
            'type'  => 'text',
            'wrapper' => ['class' => 'form-group col-md-6']
        ]);

        $this->crud->addField([   // repeatable
            'name'        => 'type_booking',
            'label'   => 'Seleziona tipologia di prenotazione',
            'type'        => 'select_from_array',
            'options'     => [0 => "Il visitatore seleziona una data", 1 => "Il visitatore seleziona data e un ora di arrivo", 2=> "Il visitatore seleziona data di arrivo e data di fine", 3 => "Il visitatore seleziona data inizio orario inizio e data fine e orario fine"],
            'allows_null' => false,
            'default'     => 0,
            'wrapper' => ['class' => 'form-group col-md-6']
        ]);

        $this->crud->addField([   // repeatable
            'name'  => 'can_payment',
            'label' => 'Attiva pagamenti',
            'type'  => 'switch',
            'wrapper' => ['class' => 'form-group col-md-2']
        ]);

        $this->crud->addField([   // repeatable
            'name'  => 'is_visible',
            'label' => 'Visibile nel front-end?',
            'type'  => 'switch',
            'wrapper' => ['class' => 'form-group col-md-2']
        ]);

        $this->crud->addField([   // repeatable
            'name'  => 'is_visible_calendar',
            'label' => 'Filtrabile in Agenda?',
            'type'  => 'switch',
            'wrapper' => ['class' => 'form-group col-md-2']
        ]);

        $this->crud->addField([   // repeatable
            'name'  => 'is_checkin',
            'label' => 'Check-in?',
            'type'  => 'switch',
            'wrapper' => ['class' => 'form-group col-md-2']
        ]);

        $this->crud->addField([   // repeatable
            'name'  => 'is_addiction',
            'label' => 'Dipendenze?',
            'type'  => 'switch',
            'wrapper' => ['class' => 'form-group col-md-2']
        ]);

        $this->crud->addField([   // repeatable
            'name'  => 'is_pin',
            'label' => 'Pin?',
            'type'  => 'switch',
            'wrapper' => ['class' => 'form-group col-md-2']
        ]);

        /*$this->crud->addField([   // color_picker
            'label'                => 'Colore in Agenda',
            'name'                 => 'color_calendar',
            'type'                 => 'color_picker2',
            'default'              => '#000000',
            'wrapper' => ['class' => 'form-group col-md-6']
        ]);*/

        $this->crud->addField([   // repeatable
            'name'  => 'number_hours_for_cancellation',
            'label' => 'Numero di ore prima per la disdetta',
            'type'  => 'number',
            'default' => 24,
            'wrapper' => ['class' => 'form-group col-md-3']
        ]);

        $this->crud->addField([   // repeatable
            'name'  => 'duration',
            'label' => 'Durata di occupazione (in minuti - Solo quando il visitatore seleziona data e un ora di arrivo)',
            'type'  => 'number',
            'default' => 0,
            'wrapper' => ['class' => 'form-group col-md-3']
        ]);

        $this->crud->addField([   // repeatable
            'name'  => 'icon',
            'label' => 'Icona menu',
            'type'  => 'text',
            'default' => "bed",
            'wrapper' => ['class' => 'form-group col-md-3']
        ]);

        $status = PluginBookingStatus::get()->pluck("name", "id")->toArray();
        $this->crud->addField([   // select2_from_array
            'name'        => 'default_status_id',
            'label'       => "Stato Default",
            'type'        => 'select2_from_array',
            'options'     => $status,
            'allows_null' => false,
            'allows_multiple' => false, // OPTIONAL; needs you to cast this to array in your model;
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
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
        CRUD::setValidation(PluginBookingTypeRequest::class);

        $trans = new AdminLanguageController();
        $trans->fields_lang("pluginBookingTypes", $this->crud, null);

        $this->crud->addField([   // Browse
            'name'  => 'image',
            'label' => 'Foto',
            'type'  => 'browse',
        ]);

        $this->crud->addField([   // repeatable
            'name'  => 'name',
            'label' => 'Nome',
            'type'  => 'text',
            'wrapper' => ['class' => 'form-group col-md-6']
        ]);

        $this->crud->addField([   // repeatable
            'name'        => 'type_booking',
            'label'   => 'Seleziona tipologia di prenotazione',
            'type'        => 'select_from_array',
            'options'     => [0 => "Il visitatore seleziona una data", 1 => "Il visitatore seleziona data e un ora di arrivo", 2=> "Il visitatore seleziona data di arrivo e data di fine", 3 => "Il visitatore seleziona data inizio orario inizio e data fine e orario fine"],
            'allows_null' => false,
            'default'     => 0,
            'wrapper' => ['class' => 'form-group col-md-6']
        ]);

        $this->crud->addField([   // repeatable
            'name'  => 'can_payment',
            'label' => 'Attiva pagamenti',
            'type'  => 'switch',
            'wrapper' => ['class' => 'form-group col-md-2']
        ]);

        $this->crud->addField([   // repeatable
            'name'  => 'is_visible',
            'label' => 'Visibile nel front-end?',
            'type'  => 'switch',
            'wrapper' => ['class' => 'form-group col-md-2']
        ]);

        $this->crud->addField([   // repeatable
            'name'  => 'is_visible_calendar',
            'label' => 'Filtrabile in Agenda?',
            'type'  => 'switch',
            'wrapper' => ['class' => 'form-group col-md-2']
        ]);

        $this->crud->addField([   // repeatable
            'name'  => 'is_checkin',
            'label' => 'Check-in?',
            'type'  => 'switch',
            'wrapper' => ['class' => 'form-group col-md-2']
        ]);

        $this->crud->addField([   // repeatable
            'name'  => 'is_addiction',
            'label' => 'Dipendenze?',
            'type'  => 'switch',
            'wrapper' => ['class' => 'form-group col-md-2']
        ]);

        $this->crud->addField([   // repeatable
            'name'  => 'is_pin',
            'label' => 'Pin?',
            'type'  => 'switch',
            'wrapper' => ['class' => 'form-group col-md-2']
        ]);

        /*$this->crud->addField([   // color_picker
            'label'                => 'Colore in Agenda',
            'name'                 => 'color_calendar',
            'type'                 => 'color_picker2',
            'default'              => '#000000',
            'wrapper' => ['class' => 'form-group col-md-6']
        ]);*/

        $this->crud->addField([   // repeatable
            'name'  => 'number_hours_for_cancellation',
            'label' => 'Numero di ore prima per la cancellazione',
            'type'  => 'number',
            'wrapper' => ['class' => 'form-group col-md-3']
        ]);

        $this->crud->addField([   // repeatable
            'name'  => 'duration',
            'label' => 'Durata di occupazione (in minuti - Solo quando il visitatore seleziona data e un ora di arrivo)',
            'type'  => 'number',
            'default' => 0,
            'wrapper' => ['class' => 'form-group col-md-3']
        ]);

        $this->crud->addField([   // repeatable
            'name'  => 'icon',
            'label' => 'Icona menu',
            'type'  => 'text',
            'default' => "bed",
            'wrapper' => ['class' => 'form-group col-md-3']
        ]);

        $status = PluginBookingStatus::get()->pluck("name", "id")->toArray();
        $this->crud->addField([   // select2_from_array
            'name'        => 'default_status_id',
            'label'       => "Stato Default",
            'type'        => 'select2_from_array',
            'options'     => $status,
            'allows_null' => false,
            'allows_multiple' => false, // OPTIONAL; needs you to cast this to array in your model;
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
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

        $lang = new AdminLanguageController();
        $lang->update_lang("pluginBookingTypes", $this->crud, $request);
        $this->crud->entry->save();

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

        $lang = new AdminLanguageController();
        $lang->update_lang("pluginBookingTypes", $this->crud, $request);
        $this->crud->entry->save();

        // show a success message
        \Alert::success(trans('backpack::crud.insert_success'))->flash();

        // save the redirect choice for next time
        $this->crud->setSaveAction();

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
