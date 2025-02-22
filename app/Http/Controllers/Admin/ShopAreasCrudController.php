<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AreaRequest as StoreRequest;
use App\Http\Requests\AreaRequest as UpdateRequest;
use App\Http\Requests\ShopAreasRequest;
use App\Models\Area;
use App\Models\AreaCity;
use App\Models\AreaCountry;
use App\Models\City;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Carbon\Carbon;

/**
 * Class ShopAreasCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ShopAreasCrudController extends CrudController
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

        CRUD::setModel(\App\Models\Area::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/shopAreas');
        CRUD::setEntityNameStrings('zona', 'zone');
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
                'name'  => 'name',
                'label' => 'Nome',
                'type'  => 'text',
            ],
            [
                'label' => "Nazioni",
                'type' => "model_function",
                'function_name' => 'getNumberCountry',
            ],
            [
                'label' => "Città",
                'type' => "model_function",
                'function_name' => 'getNumberCity',
            ],
            [
                'name'  => 'is_active',
                'label' => 'Attivo',
                'type'  => 'check',
            ]
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
        CRUD::setValidation(ShopAreasRequest::class);

        $regions = City::groupBy("regione")->orderBy("regione")->get()->pluck("regione", "regione")->toArray();
        $provinces = City::groupBy("sigla_provincia")->orderBy("sigla_provincia")->get()->pluck("sigla_provincia", "sigla_provincia")->toArray();

        $parameters = \Route::current()->parameters();

        $regions_values = [];
        $provinces_values = [];
        if(count($parameters)){
            $item = Area::find($parameters['id']);
            if($item->regions){
                $regions_values = explode(",", $item->regions);
            }
            if($item->provinces){
                $provinces_values = explode(",", $item->provinces);
            }

        }

        $this->crud->addFields([
            [
                'name'  => 'name',
                'label' => 'Nome',
                'type'  => 'text',
            ],
            [       // Select2Multiple = n-n relationship (with pivot table)
                'label' => "Seleziona le nazioni",
                'type' => 'select2_multiple',
                'name' => 'countries', // the method that defines the relationship in your Model
                'entity' => 'countries', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user
                'model' => "App\Models\Country", // foreign key model
                'pivot' => true, // on create&update, do you need to add/delete pivot table entries?
                // 'select_all' => true, // show Select All and Clear buttons?
            ],
            [   // select2_from_array
                'name'        => 'regions',
                'label'       => "oppure le Regioni",
                'type'        => 'select2_from_array',
                'options'     => $regions,
                'value' => $regions_values,
                'allows_null' => true,
                'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
            ],
            [   // select2_from_array
                'name'        => 'provinces',
                'label'       => "oppure le Province",
                'type'        => 'select2_from_array',
                'options'     => $provinces,
                'value' => $provinces_values,
                'allows_null' => true,
                'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
            ],
           /* [
                // 1-n relationship
                'label' => "Città", // Table column heading
                'type' => "select2_from_ajax_multiple",
                'name' => 'cities', // the column that contains the ID of that connected entity
                'entity' => 'cities', // the method that defines the relationship in your Model
                'attribute' => "nome_comune", // foreign key attribute that is shown to user
                'model' => "App\Models\City", // foreign key model
                'data_source' => url("api/cities"), // url to controller search function (with /{id} should return model)
                'minimum_input_length' => 2, // minimum characters to type before querying results,
                'placeholder' => '',
                'pivot' => false,
            ],*/
            [
                'name'  => 'is_active',
                'label' => 'Attivo',
                'type'  => 'switch',
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

        $countries = $request->get('countries');
        $regions = $request->get('regions');
        $provinces = $request->get('provinces');
        $cities = $request->get('cities');

        $cities_by_regions = [];
        $cities_by_provinces = [];
        $cities_by_cities = [];

        if($regions){
            $cities_by_regions = City::whereIn("regione", $regions)->get()->pluck("id")->toArray();
        }
        if($provinces){
            $cities_by_provinces = City::whereIn("sigla_provincia", $provinces)->get()->pluck("id")->toArray();
        }
        if($cities){
            $cities_by_cities = City::whereIn("id", $cities)->get()->pluck("id")->toArray();
        }

        $totals = array_merge($cities_by_regions, $cities_by_provinces, $cities_by_cities);
        $totals = array_unique($totals);

        $last_id = Area::orderBy("id", "desc")->first();

        $request->request->add(['id' => $last_id->id + 1]);

        $this->crud->performSaveAction($item->getKey());



        if(count($totals)){
            foreach ($totals as $id){
                AreaCity::insert([
                    "area_id" => $last_id->id,
                    "city_id" => $id,
                    "created_at" => Carbon::now()->toDateTimeString()
                ]);
            }

            AreaCountry::insert([
                "area_id" => $last_id->id,
                "country_id" => 106,
                "created_at" => Carbon::now()->toDateTimeString()
            ]);
        }

        if($countries){
            foreach ($countries as $id){
                $check = AreaCountry::where("area_id", $last_id->id)->where("country_id", $id)->first();
                if(!$check){
                    AreaCountry::insert([
                        "area_id" => $last_id->id,
                        "country_id" => $id,
                        "created_at" => Carbon::now()->toDateTimeString()
                    ]);
                }
            }
        }

        return redirect()->to("/admin/shopAreas");
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

        $countries = $request->get('countries');
        $regions = $request->get('regions');
        $provinces = $request->get('provinces');
        $cities = $request->get('cities');

        $cities_by_regions = [];
        $cities_by_provinces = [];
        $cities_by_cities = [];

        if($regions){
            $cities_by_regions = City::whereIn("regione", $regions)->get()->pluck("id")->toArray();
        }
        if($provinces){
            $cities_by_provinces = City::whereIn("sigla_provincia", $provinces)->get()->pluck("id")->toArray();
        }
        if($cities){
            $cities_by_cities = City::whereIn("id", $cities)->get()->pluck("id")->toArray();
        }

        $totals = array_merge($cities_by_regions, $cities_by_provinces, $cities_by_cities);
        $totals = array_unique($totals);

        AreaCountry::where("area_id", $this->crud->entry->id)->delete();
        AreaCity::where("area_id", $this->crud->entry->id)->delete();
        if(count($totals)){
            foreach ($totals as $id){
                AreaCity::insert([
                    "area_id" => $this->crud->entry->id,
                    "city_id" => $id,
                    "created_at" => Carbon::now()->toDateTimeString()
                ]);
            }

            AreaCountry::insert([
                "area_id" => $this->crud->entry->id,
                "country_id" => 106,
                "created_at" => Carbon::now()->toDateTimeString()
            ]);
        }

        if($countries){
            foreach ($countries as $id){
                $check = AreaCountry::where("area_id", $this->crud->entry->id)->where("country_id", $id)->first();
                if(!$check){
                    AreaCountry::insert([
                        "area_id" => $this->crud->entry->id,
                        "country_id" => $id,
                        "created_at" => Carbon::now()->toDateTimeString()
                    ]);
                }
            }
        }

        return $this->crud->performSaveAction($item->getKey());
    }



}
