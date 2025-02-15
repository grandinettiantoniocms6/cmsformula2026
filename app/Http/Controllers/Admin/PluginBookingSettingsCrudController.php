<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PluginBookingSettingsRequest;
use App\Models\PluginBookingStatus;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class PluginBookingSettingsCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PluginBookingSettingsCrudController extends CrudController
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
        CRUD::setModel(\App\Models\PluginBookingSettings::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/plugin-booking-settings');
        CRUD::setEntityNameStrings('plugin booking settings', 'plugin booking settings');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::setFromDb(); // columns

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
        CRUD::setValidation(PluginBookingSettingsRequest::class);

        $trans = new AdminLanguageController();
        $trans->fields_lang("pluginBookingSettings", $this->crud);

        $this->crud->addField([
            'label' => "Foto",
            'name' => "image",
            'type'  => 'browse',
            'tab' => 'Generale',
            // 'disk'      => 's3_bucket', // in case you need to show images from a different disk
            // 'prefix'    => 'uploads/images/profile_pictures/' // in case your db value is only the file name (no path), you can use this to prepend your path to the image src (in HTML), before it's shown to the user;
        ]);

        $this->crud->addField([   // Checkbox
            'name'  => 'image_height',
            'label' => 'Altezza Header (Misure consigliate: min 200 max 600) in pixel',
            'type'  => 'number',
            'tab' => 'Generale'
        ]);

        $this->crud->addField([   // Checkbox
            'name'  => 'hours_reminder',
            'label' => 'Quanti giorni prima mandare il promemoria prenotazione al Cliente?',
            'type'  => 'number',
            'tab' => 'Generale'
        ]);

        $status = PluginBookingStatus::get()->pluck("name", "id")->toArray();
        $this->crud->addField([   // select2_from_array
            'name'        => 'default_status_id',
            'label'       => "Stato Default Post Pagamento",
            'type'        => 'select2_from_array',
            'options'     => $status,
            'allows_null' => false,
            'allows_multiple' => false, // OPTIONAL; needs you to cast this to array in your model;
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
        ]);

        $this->crud->addField([   // repeatable
            'name'  => 'is_pin',
            'label' => 'Pin?',
            'type'  => 'switch',
            'wrapper' => ['class' => 'form-group col-md-2']
        ]);

        $this->crud->addField([   // repeatable
            'name'  => 'is_payment',
            'label' => 'Pagamenti?',
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
            'name'  => 'want_invoice',
            'label' => 'Ti serve la fattura?',
            'type'  => 'switch',
            'wrapper' => ['class' => 'form-group col-md-2']
        ]);


        $this->crud->addField([   // Checkbox
            'name'  => 'ccn_registered',
            'label' => 'Emails (divisi per virgola) in copia nascosta quando avviene una registrazione',
            'type'  => 'textarea',
            'tab' => 'Email'
        ]);

        $this->crud->addField([   // Checkbox
            'name'  => 'ccn_ordered',
            'label' => 'Emails (divisi per virgola) in copia nascosta quando avviene una prenotazione',
            'type'  => 'textarea',
            'tab' => 'Email'
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
            $this->crud->getStrippedSaveRequest());
        $this->data['entry'] = $this->crud->entry = $item;

        $lang = new AdminLanguageController();
        $lang->update_lang("pluginBookingSettings", $this->crud, $request);

        $this->crud->entry->save();

        // show a success message
        \Alert::success(trans('backpack::crud.update_success'))->flash();

        // save the redirect choice for next time
        $this->crud->setSaveAction();

        return redirect()->back();
    }
}
