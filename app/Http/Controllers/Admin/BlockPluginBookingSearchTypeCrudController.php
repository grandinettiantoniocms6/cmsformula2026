<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\BlockPluginBookingSearchTypeRequest;
use App\Http\Requests\BlockPluginFormRequest;
use App\Models\PluginBookingType;
use App\Models\PluginForms;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class BlockPluginBookingSearchTypeCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class BlockPluginBookingSearchTypeCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public $block = "blockPluginBookingSearchType";

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\BlockPluginBookingSearchType::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/blockPluginBookingSearchType');
        CRUD::setEntityNameStrings('Blocco Booking tipo di prenotazione', 'Blocco Booking tipi di prenotazione');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        die;
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
        CRUD::setValidation(BlockPluginBookingSearchTypeRequest::class);

        $this->crud->addField([   // repeatable
            'name'  => 'name',
            'label' => 'Nome blocco',
            'type'  => 'text',
            'wrapperAttributes' => ['class' => 'form-group col-md-12']
        ]);

        $types = PluginBookingType::get()->pluck("name", "id")->toArray();
        $this->crud->addField([   // select2_from_array
            'name'        => 'plugin_booking_type_id',
            'label'       => "Tipologia prenotazione",
            'type'        => 'select2_from_array',
            'options'     => $types,
            'allows_null' => false,
            'allows_multiple' => false, // OPTIONAL; needs you to cast this to array in your model;
            'wrapperAttributes' => ['class' => 'form-group col-md-6']
        ]);

        // Permette di scegliere uno o stili di un blocco (parte html)
        $this->crud->addField([   // select_from_array
            'name'        => 'style',
            'label'       => "Seleziona lo style",
            'type'        => 'select_from_array',
            'options'     => [
                '1' => 'Style 1: Form Booking in una sola riga',
                '2' => 'Style 2: Form Booking a sinistra, testo a destra',
                '3' => 'Style 3: Form Booking a destra, testo a sinistra',
            ],
            'allows_null' => false,
            'default'     => 1,
            // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
            'wrapperAttributes' => ['class' => 'form-group col-md-6']
        ]);

        $this->crud->addField([   // Browse
            'name'  => 'foto',
            'label' => 'Immagine di sfondo (Misure consigliate: 1920x600 pixel)',
            'type'  => 'browse',
            'wrapperAttributes' => ['class' => 'form-group col-md-6']
        ]);

        $this->crud->addField([   // repeatable
            'name'  => 'alpha',
            'label' => 'Filigrana (00 nulla - 10 leggera - 90 pesante - tra 20 e 80 custom)',
            'type'  => 'number',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ],
        ]);

        $this->crud->addField([   // repeatable
            'name'  => 'bgcolor',
            'label' => 'Oppure usa un colore di sfondo',
            'type'  => 'color_picker2',
            // optional
            'default' => '#ffffff',
            'color_picker_options' => ['customClass' => 'custom-class'],
            'wrapperAttributes' => ['class' => 'form-group col-md-6']
        ]);

        $this->crud->addField([   // repeatable
            'name'  => 'padding',
            'label' => 'Specificare il padding (Esempio: 10px 5px 5px 10px)',
            'type'  => 'text',
            'default' => '30px 30px 30px 30px',
            'wrapperAttributes' => ['class' => 'form-group col-md-6'],
        ]);

        $this->crud->addField([   // repeatable
            'name'  => 'form_booking_bgcolor',
            'label' => 'Colore sfondo form Booking',
            'type'  => 'color_picker2',
            // optional
            //'default' => '#1ab42f',
            'color_picker_options' => ['customClass' => 'custom-class'],
            'wrapperAttributes' => ['class' => 'form-group col-md-4']
        ]);

        $this->crud->addField([   // repeatable
            'name'  => 'form_booking_border_color',
            'label' => 'Colore bordo form Booking',
            'type'  => 'color_picker2',
            // optional
            //'default' => '#1ab42f',
            'color_picker_options' => ['customClass' => 'custom-class'],
            'wrapperAttributes' => ['class' => 'form-group col-md-4']
        ]);

        $this->crud->addField([   // repeatable
            'name'  => 'form_booking_border_radius',
            'label' => 'Arrotondamento Bordo (es: 20px)',
            'type'  => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-4'
            ],
        ]);

        $this->crud->addField([   // repeatable
            'name'  => 'form_booking_border_width',
            'label' => 'Spessore Bordo (es: 5px)',
            'type'  => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-4'
            ],
        ]);

        $this->crud->addField([   // repeatable
            'name'  => 'form_booking_top',
            'label' => 'Distaza dal margine basso (es: 300px)',
            'type'  => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-4'
            ],
        ]);


       /* $this->crud->addField([   // repeatable
            'name'  => 'description',
            'label' => 'Descrizione',
            'type' => 'ckeditor',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-12'
            ],
        ]);*/

        $trans = new AdminLanguageController();
        $trans->fields_lang($this->block, $this->crud);
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

        if($request->has('name')){
            $this->crud->entry->name = $request->get('name');
            // qui se serve metto i nuovi campi
            $this->crud->entry->plugin_booking_type_id = $request->get('plugin_booking_type_id');
            $this->crud->entry->save();
        }

        $lang = new AdminLanguageController();
        $lang->update_lang($this->block, $this->crud, $request);

        $this->crud->entry->save();

        return $this->crud->performSaveAction($item->getKey());
    }
}
