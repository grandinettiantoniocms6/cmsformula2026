<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PluginCounterRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Carbon\Carbon;

/**
 * Class PluginCounterCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PluginCounterCrudController extends CrudController
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
        CRUD::setModel(\App\Models\PluginCounter::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/pluginCounter');
        CRUD::setEntityNameStrings('contatore', 'contatore');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        if(backpack_user()->roles[0]->id > 2){
            die;
        }

        $this->crud->removeButton("show");

        $this->crud->setColumns([
            [
                'name'  => 'title',
                'label' => 'Titolo',
                'type'  => 'text',
            ],
            [
                'name'  => 'start',
                'label' => 'Da',
                'type'  => 'number',
            ],
            [
                'name'  => 'end',
                'label' => 'A',
                'type'  => 'number',
            ],
            [
                'name'  => 'step',
                'label' => 'Step',
                'type'  => 'number',
            ],
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'days',
                'label' => 'Giorni', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getDays', // the method in your Model
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
        CRUD::setValidation(PluginCounterRequest::class);

        $trans = new AdminLanguageController();
        $trans->fields_lang("pluginCounters", $this->crud);

        $this->crud->addField([   // Upload
            'label' => "Scegli un'icona <a href=\"https://fontawesome.com/icons?d=gallery\" target=\"_blank\">Clicca qui</a> - Incolla il codice HTML",
            'name' => "icon",
            'type' => 'text',
            'wrapperAttributes' => [ 'class' => 'form-group col-md-6']
        ]);

        $this->crud->addField([   // Browse
            'name'  => 'foto',
            'label' => 'Oppure carica una foto (dimensioni consigliate: 48px x 48px)',
            'type'  => 'browse',
            'wrapperAttributes' => [ 'class' => 'form-group col-md-6']
        ]);

        $this->crud->addField([   // repeatable
            'name'  => 'icon_color',
            'label' => 'Colore Icona',
            'type'  => 'color_picker',
            'default' => '#000000',
            // optional
            'color_picker_options' => ['customClass' => 'custom-class'],
            'wrapperAttributes' => [ 'class' => 'form-group col-md-6'],
        ]);

        $this->crud->addField([   // Upload
            'label' => "Grandezza Icona (Esempio: 50px )",
            'name' => "icon_size",
            'type' => 'text',
            'wrapperAttributes' => [ 'class' => 'form-group col-md-6']
        ]);

        $this->crud->addField([   // repeatable
            'name'  => 'number_color',
            'label' => 'Colore numeri Contatore',
            'type'  => 'color_picker',
            'default' => '#000000',
            // optional
            'color_picker_options' => ['customClass' => 'custom-class'],
            'wrapperAttributes' => [ 'class' => 'form-group col-md-6'],
        ]);

        $this->crud->addField([   // Upload
            'label' => "Grandezza numeri Contatore (Esempio: 100px )",
            'name' => "counter_size",
            'type' => 'text',
            'wrapperAttributes' => [ 'class' => 'form-group col-md-6']
        ]);

        $this->crud->addField([   // repeatable
            'name'  => 'title_color',
            'label' => 'Colore Titolo',
            'type'  => 'color_picker',
            'default' => '#000000',
            // optional
            'color_picker_options' => ['customClass' => 'custom-class'],
            'wrapperAttributes' => [ 'class' => 'form-group col-md-6'],
        ]);

        $this->crud->addField([   // repeatable
            'name'  => 'subtitle_color',
            'label' => 'Colore Frase',
            'type'  => 'color_picker',
            'default' => '#000000',
            // optional
            'color_picker_options' => ['customClass' => 'custom-class'],
            'wrapperAttributes' => [ 'class' => 'form-group col-md-6'],
        ]);

        $this->crud->addField([   // repeatable
            'name'        => 'text_align',
            'label'   => 'Scegli allineamento del testo',
            'type'        => 'select_from_array',
            'options'     => ['left' => 'Sinistra', 'right' => 'Destra', 'center' => 'Centrato'],
            'allows_null' => false,
            'default'     => 'left',
            'wrapper' => ['class' => 'form-group col-md-12']
        ]);

        $this->crud->addField([
            'name'  => 'start',
            'label' => 'Inizio conteggio',
            'type'  => 'number',
            'wrapperAttributes' => [ 'class' => 'form-group col-md-4']
        ]);

        $this->crud->addField([
            'name'  => 'end',
            'label' => 'Fine conteggio',
            'type'  => 'number',
            'wrapperAttributes' => [ 'class' => 'form-group col-md-4']
        ]);

        $this->crud->addField([
            'name'  => 'step',
            'label' => 'Di quanto vuoi incrementare al giorno?',
            'type'  => 'number',
            'wrapperAttributes' => [ 'class' => 'form-group col-md-4']
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

        $lang = new AdminLanguageController();
        $lang->update_lang("pluginCounters", $this->crud, $request);

        $start = $request->get('start');
        $end = (int) $request->get('end');
        $step = (int) $request->get('step');

        if($step > 0){
            $calculate = (int) ($end / $step); //mi procuro num d giorni

            $vet = [];
            $now = Carbon::now();
            $vet["{$now->format('Y-m-d')}"] = (int) $start;
            for($i=1; $i<=$calculate; $i++){
                $date = $now->addDay()->format("Y-m-d");
                $start = $start + $step;

                $vet["{$date}"] = $start;
            }

            $this->crud->entry->days = json_encode($vet);
            $this->crud->entry->save();
        }else{
            $this->crud->entry->days = null;
            $this->crud->entry->save();
        }

        // show a success message
        \Alert::success(trans('backpack::crud.insert_success'))->flash();

        // save the redirect choice for next time
        $this->crud->setSaveAction();

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

        $lang = new AdminLanguageController();
        $lang->update_lang("pluginCounters", $this->crud, $request);

        $start = $request->get('start');
        $end = (int) $request->get('end');
        $step = (int) $request->get('step');

        if($step > 0) {
            $calculate = (int)($end / $step); //mi procuro num d giorni

            $vet = [];
            $now = Carbon::now();
            $vet["{$now->format('Y-m-d')}"] = (int)$start;
            for ($i = 1; $i <= $calculate; $i++) {
                $date = $now->addDay()->format("Y-m-d");
                $start = $start + $step;

                $vet["{$date}"] = $start;
            }

            $this->crud->entry->days = json_encode($vet);
            $this->crud->entry->save();
        }else{
            $this->crud->entry->days = null;
            $this->crud->entry->save();
        }

        // show a success message
        \Alert::success(trans('backpack::crud.update_success'))->flash();

        // save the redirect choice for next time
        $this->crud->setSaveAction();

        if($request->has('name')){
            $this->crud->entry->text_align = $request->get('text_align');
            $this->crud->entry->icon_size = $request->get('icon_size');
            $this->crud->entry->counter_size = $request->get('counter_size');



            $this->crud->entry->save();
        }


        $this->crud->entry->save();

        return $this->crud->performSaveAction($item->getKey());
    }
}
