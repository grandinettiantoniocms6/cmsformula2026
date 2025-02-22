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
class PluginProductsBuyersCrudController extends CrudController
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
        $adminPlugin = AdminPlugin::where("name", "pluginProducts")->first();
        if($adminPlugin->version < 3){
            die;
        }
        CRUD::setModel(\App\User::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/pluginProductsBuyers');
        CRUD::setEntityNameStrings('buyer', 'buyers');

        $this->crud->addClause('whereHas', 'roles', function ($query) {
            $item = Role::where("name", "Buyer")->first();
            if($item){
                $query->whereRaw("id = $item->id");
            }
        });

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
                'type'  => 'check',
            ],
            [
                'name'  => 'method_payment',
                'label' => 'Pagamento',
                'type'  => 'text',
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
                'function_name' => 'getMenu', // the method in your Model
                'function_parameters' => ["buyer"], // pass one/more parameters to that method
                'limit' => 10000, // Limit the number of characters shown
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
        CRUD::setValidation(PluginProductsClientsRequest::class);

        $this->crud->addField([
            'name'  => 'role_id',
            'value' => 7,
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
            'default'     => 106,
            'allows_multiple' => false, // OPTIONAL; needs you to cast this to array in your model;
        ]);

        $this->crud->addField([
            'name'  => 'method_payment',
            'label' => 'Metodo di Pagamento',
            'type'  => 'text'
        ]);

        $this->crud->addField([   // Checkbox
            'name'  => 'active',
            'label' => 'Attivo?',
            'type'  => 'switch',
            'default' => 1
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

            //$shopSetting = ShopSettings::first();
            //$role_id = $shopSetting->role_default_register;
            $role_id = $request['role_id'];

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

        $user = User::find($request->get('id'));
        if($user){
            if($request->get('name')){
                $user->name = $request['name'];
            }
            if($request->get('email')){
                $user->email = $request['email'];
            }
            if($request->get('mobile')){
                $user->mobile = $request['mobile'];
            }
            if($request->get('country_id')){
                $user->country_id = $request['country_id'];
            }
            if($request->get('method_payment')){
                $user->method_payment = $request['method_payment'];
            }
            if($request->get('active')){
                $user->active = $request['active'];
            }

            if($request->get('password')){
                $user->password = bcrypt($request['password']);
            }

            $user->save();

            \Alert::success(trans('backpack::crud.update_success'))->flash();
        }

        return redirect()->to("/admin/pluginProductsBuyers");

    }

}
