<?php

namespace App\Http\Controllers\Admin;

use App\Models\Country;
use App\Models\PluginProducts;
use App\User;
use App\Http\Requests\UserStoreRequest as StoreRequest;
use Backpack\PermissionManager\app\Http\Requests\UserUpdateCrudRequest as UpdateRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Spatie\Permission\Models\Role;

class CustomUserCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitStore; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { update as traitUpdate; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        if(backpack_user()->roles[0]->id > 2){
            die;
        }

        $this->crud->setModel(config('backpack.permissionmanager.models.user'));
        $this->crud->setEntityNameStrings(trans('backpack::permissionmanager.user'), trans('backpack::permissionmanager.users'));
        $this->crud->setRoute(backpack_url('userCustom'));
        $this->crud->setListView(backpack_view('users.list'));

        if(backpack_user()->roles[0]->id == 2){
            $usersID = \DB::table("model_has_roles")
                ->where("role_id", ">", 1)
                ->where("role_id", "!=", 5)
                //->whereIn("role_id", [2,3,4,6,])  //clienti e rivenditori esclusi
                ->get()
                ->pluck("model_id")
                ->toArray();
            if(count($usersID)){
                $this->crud->query->whereIn("id", $usersID);
            }
        }
    }

    public function setupListOperation()
    {
        if(backpack_user()->roles[0]->id > 2) {
            die;
        }

        $this->crud->removeButton("show");

        $this->crud->setColumns([
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'id',
                'label' => '<input type="checkbox" id="select_all"/>', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getCheck', // the method in your Model
                'limit' => 1000,
                'orderable' => false
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
            ],
            [
                'name'  => 'name',
                'label' => trans('backpack::permissionmanager.name'),
                'type'  => 'text',
            ],
            [
                'name'  => 'email',
                'label' => trans('backpack::permissionmanager.email'),
                'type'  => 'email',
            ],
            [ // n-n relationship (with pivot table)
                'label'     => trans('backpack::permissionmanager.roles'), // Table column heading
                'type'      => 'select_multiple',
                'name'      => 'roles', // the method that defines the relationship in your Model
                'entity'    => 'roles', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user
                'model'     => config('permission.models.role'), // foreign key model
            ],
            [ // n-n relationship (with pivot table)
                'label'     => trans('backpack::permissionmanager.extra_permissions'), // Table column heading
                'type'      => 'select_multiple',
                'name'      => 'permissions', // the method that defines the relationship in your Model
                'entity'    => 'permissions', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user
                'model'     => config('permission.models.permission'), // foreign key model
            ],

        ]);
    }

    public function setupCreateOperation()
    {
        $this->addUserFields();
        $this->crud->setValidation(StoreRequest::class);
    }

    public function setupUpdateOperation()
    {
        $this->addUserFields();
        $this->crud->setValidation(UpdateRequest::class);
    }

    /**
     * Store a newly created resource in the database.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        $this->crud->setRequest($this->crud->validateRequest());
        $this->crud->setRequest($this->handlePasswordInput($this->crud->getRequest()));
        $this->crud->unsetValidation(); // validation has already been run
        $this->traitStore();

        $check = \DB::table('model_has_roles')->where("role_id", request()->get('roles')[0])
            ->where("model_id", $this->crud->entry->id)
            ->first();

        if(!$check){
            \DB::table('model_has_roles')->insert([
                "role_id" => request()->get('roles')[0],
                "model_type" => 'App\User',
                "model_id" => $this->crud->entry->id
            ]);
        }

        return redirect()->to("/admin/userCustom");
    }

    /**
     * Update the specified resource in the database.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update()
    {

        $this->crud->setRequest($this->crud->validateRequest());
        $this->crud->setRequest($this->handlePasswordInput($this->crud->getRequest()));
        $this->crud->unsetValidation(); // validation has already been run

        $this->traitUpdate();

        \DB::table('model_has_roles')->where("model_id", $this->crud->entry->id)->delete();

        \DB::table('model_has_roles')->insert([
            "role_id" => $this->crud->getRequest()->get('roles')[0],
            "model_type" => 'App\User',
            "model_id" => $this->crud->entry->id
        ]);

        return redirect()->to("/admin/userCustom");
    }

    /**
     * Handle password input fields.
     */
    protected function handlePasswordInput($request)
    {
        // Remove fields not present on the user.
        $request->request->remove('password_confirmation');
        $request->request->remove('roles_show');
        $request->request->remove('permissions_show');

        // Encrypt password if specified.
        if ($request->input('password')) {
            $request->request->set('password', Hash::make($request->input('password')));
        } else {
            $request->request->remove('password');
        }

        return $request;
    }

    protected function addUserFields()
    {
        $countries = Country::get()->pluck("name", "id")->toArray();

        if(backpack_user()->roles[0]->id == 2){
            $role = null;

            $user_id = null;
            if(\Route::current()->parameter('id')){
                $user_id = \Route::current()->parameter('id');
            }

            if($user_id){
                $role = \DB::table('model_has_roles')->where("model_id", $user_id)->first();
            }

            $role_list = Role::where("id", ">=", 2)->get()->pluck("name", "id")->toArray();


            $this->crud->addFields([
                [
                    'name'  => 'name',
                    'label' => trans('backpack::permissionmanager.name'),
                    'type'  => 'text',
                ],
                [
                    'name'  => 'email',
                    'label' => trans('backpack::permissionmanager.email'),
                    'type'  => 'email',
                ],
                [
                    'name'  => 'password',
                    'label' => trans('backpack::permissionmanager.password'),
                    'type'  => 'password',
                ],
                [
                    'name'  => 'password_confirmation',
                    'label' => trans('backpack::permissionmanager.password_confirmation'),
                    'type'  => 'password',
                ],
                [   // select2_from_array
                    'name'        => 'type_client',
                    'label'       => "Tipo cliente",
                    'type'        => 'select2_from_array',
                    'options'     => [0 => "Privato", 1 => "Azienda"],
                    'allows_null' => true,
                    'default'     => 0,
                ],
                [   // radio
                    'name'        => 'roles[]', // the name of the db column
                    'label'       => 'Ruolo', // the input label
                    'type'        => 'radio',
                    'options'     => $role_list,
                    // optional
                    'value' => $role ? $role->role_id : 2,
                    'inline'      => true, // show the radios all on the same line?
                ],
                [   // radio
                    'name'        => 'roles_show[]', // the name of the db column
                    'label'       => 'Ruolo', // the input label
                    'type'        => 'hidden',
                    // optional
                    'value' => $role ? $role->role_id : 2,
                ],
                [   // select2_from_array
                    'name'        => 'country_id',
                    'label'       => "Nazione",
                    'type'        => 'select2_from_array',
                    'options'     => $countries,
                    'allows_null' => true,
                    'default'     => null,
                    // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
                ],
            ]);
        }else{
            $this->crud->addFields([
                [
                    'name'  => 'name',
                    'label' => trans('backpack::permissionmanager.name'),
                    'type'  => 'text',
                ],
                [
                    'name'  => 'email',
                    'label' => trans('backpack::permissionmanager.email'),
                    'type'  => 'email',
                ],
                [
                    'name'  => 'password',
                    'label' => trans('backpack::permissionmanager.password'),
                    'type'  => 'password',
                ],
                [
                    'name'  => 'password_confirmation',
                    'label' => trans('backpack::permissionmanager.password_confirmation'),
                    'type'  => 'password',
                ],
                [   // select2_from_array
                    'name'        => 'type_client',
                    'label'       => "Tipo cliente",
                    'type'        => 'select2_from_array',
                    'options'     => [0 => "Privato", 1 => "Azienda"],
                    'allows_null' => true,
                    'default'     => 0,
                ],
                [   // select2_from_array
                    'name'        => 'country_id',
                    'label'       => "Nazione",
                    'type'        => 'select2_from_array',
                    'options'     => $countries,
                    'allows_null' => true,
                    'default'     => null,
                    // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
                ],
                [
                    // two interconnected entities
                    'label'             => trans('backpack::permissionmanager.user_role_permission'),
                    'field_unique_name' => 'user_role_permission',
                    'type'              => 'checklist_dependency',
                    'name'              => 'roles,permissions',
                    'subfields'         => [
                        'primary' => [
                            'label'            => trans('backpack::permissionmanager.roles'),
                            'name'             => 'roles', // the method that defines the relationship in your Model
                            'entity'           => 'roles', // the method that defines the relationship in your Model
                            'entity_secondary' => 'permissions', // the method that defines the relationship in your Model
                            'attribute'        => 'name', // foreign key attribute that is shown to user
                            'model'            => config('permission.models.role'), // foreign key model
                            'pivot'            => true, // on create&update, do you need to add/delete pivot table entries?]
                            'number_columns'   => 3, //can be 1,2,3,4,6
                        ],
                        'secondary' => [
                            'label'          => "",
                            'name'           => 'permissions', // the method that defines the relationship in your Model
                            'entity'         => 'permissions', // the method that defines the relationship in your Model
                            'entity_primary' => 'roles', // the method that defines the relationship in your Model
                            'attribute'      => 'name', // foreign key attribute that is shown to user
                            'model'          => config('permission.models.permission'), // foreign key model
                            'pivot'          => true, // on create&update, do you need to add/delete pivot table entries?]
                            'number_columns' => 3, //can be 1,2,3,4,6
                        ],
                    ],
                ],
            ]);
        }

    }

    public function destroy($id)
    {
        $this->crud->hasAccessOrFail('delete');

        // get entry ID from Request (makes sure its the last ID for nested resources)
        $id = $this->crud->getCurrentEntryId() ?? $id;

        $user = User::find($id);
        if($user){
            $user->deleted_at = Carbon::now()->toDateTimeString();
            $timestamp = Carbon::now()->timestamp;
            $user->email = "{$timestamp}_$user->email";
            $user->save();
        }

        return "1";
    }


    public function actions(Request $request){
        $button = $request->get('button');
        $ids = $request->get('ids');
        if($ids == null){
            return redirect()->back();
        }
        switch ($button){
            case "delete":
                User::whereIn("id", $ids)->delete();
                break;
        }

        \Alert::success("Operazione effettuata con successo!")->flash();

        return redirect()->back();
    }
}
