<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PluginProductsClientsRequest;
use App\Http\Requests\PluginProductsRequest;
use App\Models\AdminLanguage;
use App\Models\AdminPlugin;
use App\Models\Country;
use App\Models\PluginProducts;
use App\Models\PluginProductsAttachments;
use App\Models\PluginProductsAttributes;
use App\Models\PluginProductsBrands;
use App\Models\PluginProductsCategories;
use App\Models\PluginProductsCategoriesProducts;
use App\Models\PluginProductsImages;
use App\Models\PluginProductsOptions;
use App\Models\PluginProductsRelated;
use App\Models\ShopSettings;
use App\User;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;


/**
 * Class PluginProductsCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PluginBookingClientsCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\EditableColumns\Http\Controllers\Operations\MinorUpdateOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        $adminPlugin = AdminPlugin::where("name", "pluginBookings")->where("is_active", 1)->first();
        if(!$adminPlugin){
            die;
        }
        CRUD::setModel(\App\User::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/pluginBookingClients');
        CRUD::setEntityNameStrings('cliente', 'clienti');



        $this->crud->addClause('whereHas', 'roles', function ($query) {
            $item = Role::where("name", "Cliente")->first();
            if($item){
                $query->whereRaw("id = $item->id");
            }
        });

        $this->crud->enableExportButtons();

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
        $this->crud->removeButton("update");
        $this->crud->removeButton("delete");

        // Columns.
        $this->crud->setColumns([
            [
                'name'  => 'name',
                'label' => 'Nome',
                'type'  => 'text',
            ],
            [
                'name'  => 'email',
                'label' => 'Email',
                'type'  => 'text',
            ],
            [
                'name'  => 'mobile',
                'label' => 'Cellulare',
                'type'  => 'text',
            ],
            [
                'name'  => 'active',
                'label' => 'Attivo',
                'type'  => 'editable_switch',

                // Optionals
                // All the options available on editable_checkbox are available here too, plus;
                'color'   => 'success',
                'onLabel' => '✓',
                'offLabel' => '✕',
            ],
            [
                'name'  => 'check_privacy',
                'label' => 'Privacy',
                'type'  => 'check',
            ],
            [
                'name'  => 'check_newsletter',
                'label' => 'Newsletter',
                'type'  => 'check',
            ],
            [
                'name'  => 'created_at',
                'label' => 'Registrato il',
                'type'  => 'datetime',
            ],
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'is_in_menu',
                'label' => 'Azioni', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getMenuBooking', // the method in your Model
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                'limit' => 10000, // Limit the number of characters shown
            ]
        ]);

        $status = ["NO", "SI"];
        $this->crud->addFilter([ // select2 filter
            'name' => 'active',
            'type' => 'select2',
            'label'=> 'Attivo'
        ], function() use ($status) {
            return $status;
        }, function($value) { // if the filter is active
            $this->crud->addClause('where', 'active', '=', $value);
        });


        $status = ["NO", "SI"];
        $this->crud->addFilter([ // select2 filter
            'name' => 'check_newsletter',
            'type' => 'select2',
            'label'=> 'Newsletter'
        ], function() use ($status) {
            return $status;
        }, function($value) { // if the filter is active
            if($value == 0){
                $value = null;
            }

            $this->crud->addClause('where', 'check_newsletter', '=', $value);
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
        CRUD::setValidation(PluginProductsClientsRequest::class);

        $this->crud->addField([
            'name'  => 'role_id',
            'value' => 5,
            'type'  => 'hidden'
        ]);

        $this->crud->addField([
            'name'  => 'name',
            'label' => 'Nome',
            'type'  => 'text'
        ]);

        $this->crud->addField([
            'name'  => 'email',
            'label' => 'Email',
            'type'  => 'email'
        ]);

        $this->crud->addField([
            'name'  => 'mobile',
            'label' => 'Cellulare',
            'type'  => 'text'
        ]);

        $this->crud->addField([
            'name'  => 'password',
            'label' => 'Password',
            'type'  => 'password'
        ]);

        $countries = Country::get()->pluck("name", "id")->toArray();
        $this->crud->addField([   // select2_from_array
            'name'        => 'country_id',
            'label'       => "Nazionalità",
            'type'        => 'select2_from_array',
            'options'     => $countries,
            'allows_null' => true,
            'default'     => null,
            'allows_multiple' => false, // OPTIONAL; needs you to cast this to array in your model;
        ]);

        $this->crud->addField([   // Checkbox
            'name'  => 'active',
            'label' => 'Attivo?',
            'type'  => 'switch',
            'default' => 1,
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
        ]);

        $parameters = \Route::current()->parameters();
        if(count($parameters) == 0) {
            $this->crud->addField([   // Checkbox
                'name'  => 'check_privacy',
                'label' => 'Privacy?',
                'type'  => 'switch',
                'default' => 1,
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-3'
                ],
            ]);

            $this->crud->addField([   // Checkbox
                'name'  => 'check_newsletter',
                'label' => 'Newsletter?',
                'type'  => 'switch',
                'default' => 1,
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-3'
                ],
            ]);
        }else{
            $this->crud->addField([   // Checkbox
                'name'  => 'check_privacy',
                'label' => 'Privacy?',
                'type'  => 'switch',
                'default' => 1,
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-3'
                ],
                'attributes' => [
                    'disabled' => 'disabled'
                ],
            ]);

            $this->crud->addField([   // Checkbox
                'name'  => 'check_newsletter',
                'label' => 'Newsletter?',
                'type'  => 'switch',
                'default' => 1,
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-3'
                ],
                'attributes' => [
                    'disabled' => 'disabled'
                ],
            ]);
        }

        $this->crud->addField([
            'name'  => 'business_name',
            'label' => 'Ragione sociale',
            'type'  => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
            'tab' => "Fatturazione"
        ]);

        $this->crud->addField([
            'name'  => 'vat',
            'label' => 'P.Iva/CodiceFiscale',
            'type'  => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
            'tab' => "Fatturazione"
        ]);

        $this->crud->addField([
            'name'  => 'pec',
            'label' => 'Pec',
            'type'  => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
            'tab' => "Fatturazione"
        ]);

        $this->crud->addField([
            'name'  => 'sdi',
            'label' => 'Sdi',
            'type'  => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
            'tab' => "Fatturazione"
        ]);

        $this->crud->addField([
            'name'  => 'address_invoice',
            'label' => 'Indirizzo',
            'type'  => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
            'tab' => "Fatturazione"
        ]);

        $this->crud->addField([
            'name'  => 'street_invoice',
            'label' => 'Civico',
            'type'  => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-1'
            ],
            'tab' => "Fatturazione"
        ]);

        $this->crud->addField([
            'name'  => 'zip_invoice',
            'label' => 'Cap',
            'type'  => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-1'
            ],
            'tab' => "Fatturazione"
        ]);

        $this->crud->addField([
            'name'  => 'city_invoice',
            'label' => 'Città',
            'type'  => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-2'
            ],
            'tab' => "Fatturazione"
        ]);

        $this->crud->addField([
            'name'  => 'province_invoice',
            'label' => 'Provincia',
            'type'  => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-2'
            ],
            'tab' => "Fatturazione"
        ]);

        $this->crud->addField([
            'name'  => 'state_invoice',
            'label' => 'Nazione',
            'type'  => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-2'
            ],
            'tab' => "Fatturazione"
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
        $request = $this->crud->validateRequest();
        $user = User::where("email", $request->get('email'))->first();

        if(!$user){
            // execute the FormRequest authorization and validation, if one is required

            $request['code'] = unique_random("users", "code", 25);

            // insert item in the db
            $item = $this->crud->create($this->crud->getStrippedSaveRequest($request));
            $this->data['entry'] = $this->crud->entry = $item;

            $this->crud->entry->password = bcrypt($request['password']);
            $this->crud->entry->save();

            // show a success message
            \Alert::success(trans('backpack::crud.insert_success'))->flash();

            // save the redirect choice for next time
            $this->crud->setSaveAction();

            $shopSetting = ShopSettings::first();
            $role_id = $shopSetting->role_default_register;

            $check = \DB::table('model_has_roles')->where("role_id", $role_id)
                ->where("model_id", $this->crud->entry->id)
                ->first();

            if(!$check){
                \DB::table('model_has_roles')->insert([
                    "role_id" => $role_id,
                    "model_type" => 'App\User',
                    "model_id" => $this->crud->entry->id
                ]);
            }

            return $this->crud->performSaveAction($item->getKey());
        }else{
            \Alert::error("Email già esistente")->flash();
            return redirect()->back();
        }

    }

    public function update()
    {
        $this->crud->hasAccessOrFail('update');

        // execute the FormRequest authorization and validation, if one is required
        $request = $this->crud->validateRequest();

        $shopSetting = ShopSettings::first();
        $role_id = $shopSetting->role_default_register;


        $role = \DB::table('model_has_roles')->where("model_id", $request->get('id'))
            ->where("role_id", "!=", $role_id)->first();

        if(!$role){
            $item = User::find($request->get('id'));
            $item->name = $request->get('name');
            $item->email = $request->get('email');
            $item->mobile = $request->get('mobile');
            $item->country_id = $request->get('country_id');
            $item->active = $request->get('active');

            $item->business_name = $request->get('business_name');
            $item->vat = $request->get('vat');
            $item->pec = $request->get('pec');
            $item->sdi = $request->get('sdi');
            $item->address_invoice = $request->get('address_invoice');
            $item->street_invoice = $request->get('street_invoice');
            $item->zip_invoice = $request->get('zip_invoice');
            $item->city_invoice = $request->get('city_invoice');
            $item->province_invoice = $request->get('province_invoice');
            $item->state_invoice = $request->get('state_invoice');

            $item->save();

            if($request->get('password')){
                $psw = $request->get('password');
                if($psw !== null){
                    if(strlen($psw) > 7){
                        $item->password = bcrypt($request['password']);
                        $item->save();
                    }
                }
            }

            // show a success message
            \Alert::success(trans('backpack::crud.update_success'))->flash();

            // save the redirect choice for next time
            $this->crud->setSaveAction();

            return $this->crud->performSaveAction($item->getKey());
        }else{
            $item = User::find($request->get('id'));
            $item->name = $request->get('name');
            $item->email = $request->get('email');
            $item->mobile = $request->get('mobile');
            $item->country_id = $request->get('country_id');
            $item->active = $request->get('active');


            $item->business_name = $request->get('business_name');
            $item->vat = $request->get('vat');
            $item->pec = $request->get('pec');
            $item->sdi = $request->get('sdi');
            $item->address_invoice = $request->get('address_invoice');
            $item->street_invoice = $request->get('street_invoice');
            $item->zip_invoice = $request->get('zip_invoice');
            $item->city_invoice = $request->get('city_invoice');
            $item->province_invoice = $request->get('province_invoice');
            $item->state_invoice = $request->get('state_invoice');

            $item->save();

            if($request->get('password')){
                $psw = $request->get('password');
                if($psw !== null){
                    if(strlen($psw) > 7){
                        $item->password = bcrypt($request['password']);
                        $item->save();
                    }
                }
            }
        }

        return redirect()->back();

    }

}
