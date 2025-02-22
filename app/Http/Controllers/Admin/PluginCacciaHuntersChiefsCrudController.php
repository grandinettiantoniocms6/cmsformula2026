<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PluginCacciaHuntersChiefsRequest;
use App\Models\PluginCacciaChiefs;
use App\Models\PluginCacciaHunters;
use App\Models\PluginCacciaHuntersPoints;
use App\Models\PluginCacciaSettings;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Carbon\Carbon;

/**
 * Class PluginCacciaHuntersChiefsCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PluginCacciaHuntersChiefsCrudController extends CrudController
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
        CRUD::setModel(\App\Models\PluginCacciaHuntersChiefs::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/plugin-caccia-hunters-chiefs');
        CRUD::setEntityNameStrings('assegnazione', 'assegnazioni Capi');
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
                // run a function on the CRUD model and show its return value
                'name'  => 'hunter_id',
                'label' => 'Cacciatore', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getHunter', // the method in your Model
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                'limit' => 10000, // Limit the number of characters shown
            ],
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'chief_id',
                'label' => 'Capo', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getChief', // the method in your Model
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                'limit' => 10000, // Limit the number of characters shown
            ],
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'user_id',
                'label' => 'RPS', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getRps', // the method in your Model
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                'limit' => 10000, // Limit the number of characters shown
            ],
            [
                'name'  => 'date_associate',
                'label' => 'Data',
                'type'  => 'date',
            ],
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'status_id',
                'label' => 'Stato', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getStatus', // the method in your Model
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                'limit' => 10000, // Limit the number of characters shown
            ],
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'esito_id',
                'label' => 'Esito', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getEsito', // the method in your Model
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                'limit' => 10000, // Limit the number of characters shown
            ],
            [
                'name'  => 'point',
                'label' => 'Punti',
                'type'  => 'text',
            ],
        ]);


        $hunters = PluginCacciaHunters::selectRaw("CONCAT(first_name, ' ', last_name, ' (', code, ')') as name, id")
            ->orderBy("name", "asc")
            ->get()->pluck("name", "id")->toArray();

        // select2 filter
        $this->crud->addFilter([
            'name'  => 'hunter_id',
            'type'  => 'select2',
            'label' => 'Cacciatore'
        ], function () use ($hunters) {
            return $hunters;
        }, function ($value) { // if the filter is active
             $this->crud->addClause('where', 'hunter_id', $value);
        });

        $chiefs = PluginCacciaChiefs::orderBy("code", "asc")
            ->get()->pluck("code", "id")->toArray();

        // select2 filter
        $this->crud->addFilter([
            'name'  => 'chief_id',
            'type'  => 'select2',
            'label' => 'Capo'
        ], function () use ($chiefs) {
            return $chiefs;
        }, function ($value) { // if the filter is active
            $this->crud->addClause('where', 'chief_id', $value);
        });

        // daterange filter
        $this->crud->addFilter([
            'type'  => 'date_range',
            'name'  => 'from_to',
            'label' => 'Data'
        ],
            false,
            function ($value) { // if the filter is active, apply these constraints
                 $dates = json_decode($value);
                 $this->crud->addClause('where', 'date_associate', '>=', $dates->from);
                 $this->crud->addClause('where', 'date_associate', '<=', $dates->to);
            });


        $status = [0 => "In Valutazione", 1 => "Accettato", 2 => "Rifiutato"];
        // select2 filter
        $this->crud->addFilter([
            'name'  => 'status_id',
            'type'  => 'select2',
            'label' => 'Stato'
        ], function () use ($status) {
            return $status;
        }, function ($value) { // if the filter is active
            $this->crud->addClause('where', 'status_id', $value);
        });

        $status = [1 => "Capo abbattuto", 2 => "Capo non abbattuto"];
        // select2 filter
        $this->crud->addFilter([
            'name'  => 'esito_id',
            'type'  => 'select2',
            'label' => 'Esito'
        ], function () use ($status) {
            return $status;
        }, function ($value) { // if the filter is active
            $this->crud->addClause('where', 'esito_id', $value);
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
        CRUD::setValidation(PluginCacciaHuntersChiefsRequest::class);
        $setting = PluginCacciaSettings::first();

        $hunters = PluginCacciaHunters::selectRaw("CONCAT(first_name, ' ', last_name) as name, id")
            ->orderBy("name", "asc")
            ->get()->pluck("name", "id")->toArray();
        if($hunters){
            foreach ($hunters as $k=>$hunter){
                $item = PluginCacciaHunters::find($k);
                $point = $item->points()->sum("point");

                if($point < $setting->min_points){
                    unset($hunters[$k]);
                    continue;
                }

                $hunters[$k] = "$hunter ($point punti)";
            }
        }


        $this->crud->addField([   // select2_from_array
            'name'        => 'hunter_id',
            'label'       => "Cacciatore",
            'type'        => 'select2_from_array',
            'options'     => $hunters,
            'allows_null' => true,
            'default'     => null,
            'allows_multiple' => false,
            'wrapperAttributes' => ['class' => 'form-group col-md-4']
        ]);

        $chiefs = PluginCacciaChiefs::orderBy("code", "asc")
            ->get()->pluck("code", "id")->toArray();

        $this->crud->addField([   // select2_from_array
            'name'        => 'chief_id',
            'label'       => "Capo",
            'type'        => 'select2_from_array',
            'options'     => $chiefs,
            'allows_null' => true,
            'default'     => null,
            'allows_multiple' => false,
            'wrapperAttributes' => ['class' => 'form-group col-md-4']
        ]);

        $status = [0 => "In Valutazione", 1 => "Accettato", 2 => "Rifiutato"];
        $this->crud->addField([   // select2_from_array
            'name'        => 'status_id',
            'label'       => "Stato",
            'type'        => 'select2_from_array',
            'options'     => $status,
            'allows_null' => true,
            'default'     => null,
            'allows_multiple' => false,
            'wrapperAttributes' => ['class' => 'form-group col-md-4']
        ]);




        $this->crud->addField([   // select2_from_array
            'name'        => 'user_id',
            'value'       => backpack_user()->id,
            'type'        => 'hidden',
        ]);

        $status = [1 => "Capo abbattuto", 2 => "Capo non abbattuto"];
        $this->crud->addField([   // select2_from_array
            'name'        => 'esito_id',
            'label'       => "Esito",
            'type'        => 'select2_from_array',
            'options'     => $status,
            'allows_null' => true,
            'default'     => null,
            'allows_multiple' => false, // OPTIONAL; needs you to cast this to array in your model;
            'wrapperAttributes' => ['class' => 'form-group col-md-6']
        ]);

        $this->crud->addField([   // select2_from_array
            'name'        => 'point',
            'label'       => "Punti (solo se esito è valorizzato)",
            'type'        => 'number',
            'default' => 10,
            'wrapperAttributes' => ['class' => 'form-group col-md-6']
        ]);

        $this->crud->addField([   // select2_from_array
            'name'        => 'date_associate',
            'label'       => "Data associazione da RPS",
            'type'        => 'date',
            'wrapperAttributes' => ['class' => 'form-group col-md-4']
        ]);

        $this->crud->addField([   // select2_from_array
            'name'        => 'date_accept',
            'label'       => "Data accettazione Cacciatore",
            'type'        => 'date',
            'wrapperAttributes' => ['class' => 'form-group col-md-4']
        ]);

        $this->crud->addField([   // select2_from_array
            'name'        => 'date_esito',
            'label'       => "Data esito",
            'type'        => 'date',
            'wrapperAttributes' => ['class' => 'form-group col-md-4']
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

    /**
     * Update the specified resource in the database.
     *
     * @return \Illuminate\Http\Response
     */
    public function update()
    {
        $this->crud->hasAccessOrFail('update');

        // execute the FormRequest authorization and validation, if one is required
        $request = $this->crud->validateRequest();
        // update the row in the db
        $item = $this->crud->update($request->get($this->crud->model->getKeyName()),
            $this->crud->getStrippedSaveRequest($request));
        $this->data['entry'] = $this->crud->entry = $item;

        $label = "";
        if(!$item->esito_id){
            $item->point = 0;
        }

        if($item->esito_id == 1){
            $point  = $request->get('point');
            if($point < 0){
                $point = -($point);
            }

            $item->point = $point;
            $label = "Capo abbattuto";
        }

        if($item->esito_id == 2){
            $point  = $request->get('point');
            if($point < 0){
                $point = -($point);
            }

            $item->point = -$point;
            $label = "Capo non abbattuto";
        }

        if($item->point != 0){
            $check = PluginCacciaHuntersPoints::where("hunter_chief_id", $item->id)->first();
            if(!$check){
                PluginCacciaHuntersPoints::insert([
                    "hunter_id" => $item->hunter_id,
                    "chief_id" => $item->chief_id,
                    "user_id" => $item->user_id,
                    "point" => $item->point,
                    "note" => $label,
                    "created_at" => Carbon::now()->toDateTimeString(),
                    "hunter_chief_id" => $item->id
                ]);
            }else{
                PluginCacciaHuntersPoints::where("hunter_chief_id", $item->id)->update([
                    "hunter_id" => $item->hunter_id,
                    "chief_id" => $item->chief_id,
                    "user_id" => $item->user_id,
                    "point" => $item->point,
                    "note" => $label
                ]);
            }
        }else{
            $check = PluginCacciaHuntersPoints::where("hunter_chief_id", $item->id)->first();
            if($check){
                $check->delete();
            }
        }

        $item->save();

        // show a success message
        \Alert::success(trans('backpack::crud.update_success'))->flash();

        // save the redirect choice for next time
        $this->crud->setSaveAction();

        return $this->crud->performSaveAction($item->getKey());
    }

    /**
     * Store a newly created resource in the database.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        $this->crud->hasAccessOrFail('create');

        // execute the FormRequest authorization and validation, if one is required
        $request = $this->crud->validateRequest();

        // insert item in the db
        $item = $this->crud->create($this->crud->getStrippedSaveRequest($request));
        $this->data['entry'] = $this->crud->entry = $item;

        $label = "";
        if(!$item->esito_id){
            $item->point = 0;
        }

        if($item->esito_id == 1){
            $point  = $request->get('point');
            if($point < 0){
                $point = -($point);
            }

            $item->point = $point;
            $label = "Capo abbattuto";
        }

        if($item->esito_id == 2){
            $point  = $request->get('point');
            if($point < 0){
                $point = -($point);
            }

            $item->point = -$point;
            $label = "Capo non abbattuto";
        }

        if($item->point != 0){
            $check = PluginCacciaHuntersPoints::where("hunter_chief_id", $item->id)->first();
            if(!$check){
                PluginCacciaHuntersPoints::insert([
                    "hunter_id" => $item->hunter_id,
                    "chief_id" => $item->chief_id,
                    "user_id" => $item->user_id,
                    "point" => $item->point,
                    "note" => $label,
                    "created_at" => Carbon::now()->toDateTimeString(),
                    "hunter_chief_id" => $item->id
                ]);
            }else{
                PluginCacciaHuntersPoints::where("hunter_chief_id", $item->id)->update([
                    "hunter_id" => $item->hunter_id,
                    "chief_id" => $item->chief_id,
                    "user_id" => $item->user_id,
                    "point" => $item->point,
                    "note" => $label
                ]);
            }
        }else{
            $check = PluginCacciaHuntersPoints::where("hunter_chief_id", $item->id)->first();
            if($check){
                $check->delete();
            }
        }

        $item->save();

        // show a success message
        \Alert::success(trans('backpack::crud.insert_success'))->flash();

        // save the redirect choice for next time
        $this->crud->setSaveAction();

        return $this->crud->performSaveAction($item->getKey());
    }
}
