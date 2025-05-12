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
use App\Models\UserSubscription;
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
class PluginProductsClientsCrudController extends CrudController
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
        CRUD::setRoute(config('backpack.base.route_prefix') . '/pluginProductsClients');
        CRUD::setEntityNameStrings('cliente', 'clienti');

        $this->crud->addClause('whereHas', 'roles', function ($query) {
            $item = Role::where("name", "Cliente")->first();
            if($item){
                $query->whereRaw("id = $item->id");
            }
        });

        if(backpack_user()->roles[0]->id == 7){
            $this->crud->query->where("user_id", backpack_user()->id);
        }

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

        $shopSetting = ShopSettings::first();

        $addColumn = [
            'name'  => '',
            'label' => '',
            'type'  => 'hidden',
        ];
        if($shopSetting->is_subscriptions){
            $addColumn =  [
                // run a function on the CRUD model and show its return value
                'name'  => 'subscription_id',
                'label' => 'Abbonamento', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getSubscription', // the method in your Model
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                'limit' => 10000, // Limit the number of characters shown
            ];
        }else{
            $addColumn =  [
                // run a function on the CRUD model and show its return value
                'name' => "buyer",
                'label' => "Creato da", // Table column heading
                'type' => "model_function",
                'function_name' => 'get_buyer', // the method in your Model
                'limit' => 1000, // Limit the number of characters shown
            ];
        }


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
                // run a function on the CRUD model and show its return value
                'name'  => 'type_client',
                'label' => 'Tipo', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getTypeClient', // the method in your Model
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                'limit' => 10000, // Limit the number of characters shown
            ],
            [
                'name'  => 'active',
                'label' => 'Attivo',
                'type'  => 'check',
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
            $addColumn,
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'is_in_menu',
                'label' => 'Azioni', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getMenu', // the method in your Model
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


        $buyers = User::join("model_has_roles", "model_has_roles.model_id", "=", "id")
            ->where("role_id", 7)
            ->pluck("name", "id")->toArray();

        if(count($buyers)){
            $this->crud->addFilter([ // select2 filter
                'name' => 'is_user',
                'type' => 'select2',
                'label'=> 'Buyer'
            ], function() use ($buyers) {
                return $buyers;
            }, function($value) { // if the filter is active
                $this->crud->addClause('where', 'user_id', '=', $value);
            });
        }


        if($shopSetting->is_subscriptions){

            // simple filter
            $this->crud->addFilter([
                'type'  => 'simple',
                'name'  => 'is_subscription',
                'label' => 'Con Abbonamenti'
            ],
                false,
                function() { // if the filter is active
                    $ids = UserSubscription::get()->pluck("user_id", "user_id")->toArray();
                    if(count($ids) > 0){
                        $this->crud->addClause('whereIn', 'id', $ids);
                    }else{
                        $this->crud->addClause('whereIn', 'id', [0]);
                    }
                } );
        }
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

        $parameters = \Route::current()->parameters();
        if(count($parameters) > 0){
           /* $this->crud->addField([
                'name'  => 'password',
                'label' => 'Password',
                'type'  => 'password'
            ]);*/
        }else{
            $this->crud->addField([
                'name'  => 'password',
                'label' => 'Password *',
                'type'  => 'password',
                'attributes' => [
                    'required' => 'required3'
                ],
            ]);
        }

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
            'type'  => 'checkbox',
            'default' => 1,
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
        ]);

        $this->crud->addField([   // Checkbox
            'name'  => 'check_privacy',
            'label' => 'Accetti la normativa Privacy?',
            'type'  => 'checkbox',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
        ]);

        $this->crud->addField([   // Checkbox
            'name'  => 'check_newsletter',
            'label' => 'Accetti di ricevere la Newsletter?',
            'type'  => 'checkbox',
            'default' => 0,
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
        ]);

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

            $this->crud->entry->user_id = backpack_user()->id;
            $this->crud->entry->save();

            // show a success message
            \Alert::success(trans('backpack::crud.insert_success'))->flash();

            // save the redirect choice for next time
            $this->crud->setSaveAction();

            $shopSetting = ShopSettings::first();

            if(backpack_user()->roles[0]->id == 7){
                $item->type_client = 1;
                $item->save();
            }

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
            /*if($request->get("password") === null){
                $request->request->remove('password');
            }*/

            // update the row in the db
            $item = $this->crud->update($request->get($this->crud->model->getKeyName()),
                $this->crud->getStrippedSaveRequest($request));


            $this->data['entry'] = $this->crud->entry = $item;

            if($request->get('password')){
                $this->crud->entry->password = bcrypt($request['password']);
                $this->crud->entry->save();
            }

            // show a success message
            \Alert::success(trans('backpack::crud.update_success'))->flash();

            // save the redirect choice for next time
            $this->crud->setSaveAction();

            return $this->crud->performSaveAction($item->getKey());
        }

        return redirect()->back();

    }

}
