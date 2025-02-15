<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PluginInvitationsRequest;
use App\Models\Address;
use App\Models\Company;
use App\Models\Country;
use App\Models\PluginInvitations;
use App\Models\PluginInvitationsSettings;
use App\Models\PluginProductsCategoriesProducts;
use App\Models\ShopSettings;
use App\User;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;

/**
 * Class PluginInvitationsCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PluginInvitationsCrudController extends CrudController
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
        CRUD::setModel(\App\Models\PluginInvitations::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/pluginInvitations');

        if(backpack_user()->country_id){
            if(backpack_user()->country_id == config('config.default_country_user_it')){
                CRUD::setEntityNameStrings('invito', 'inviti');
            }else{
                CRUD::setEntityNameStrings('invitation', 'invitations');
            }
        }else{
            CRUD::setEntityNameStrings('invito', 'inviti');
        }

        $role_id_agente = 0;
        $item = Role::where("name", "Agente")->first();
        if($item){
            $role_id_agente = $item->id;
        }

        if(backpack_user()->roles[0]->id == $role_id_agente){
            $this->crud->query->where("user_id", backpack_user()->id);
        }
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $vet = null;
        if(backpack_user()->roles[0]->id <= 2){
           $vet = [
               // 1-n relationship
               'label'     => 'Agente', // Table column heading
               'type'      => 'select',
               'name'      => 'user_id', // the column that contains the ID of that connected entity;
               'entity'    => 'user', // the method that defines the relationship in your Model
               'attribute' => 'name', // foreign key attribute that is shown to user
               'model'     => "App\User", // foreign key model
           ];
        }

        $this->crud->removeButton("show");
        $this->crud->removeButton("update");
        $this->crud->removeButton("delete");

        $this->crud->addButtonFromModelFunction('line', 'getMenu', 'getMenu', 'beginning'); // add a button whose HTML is returned by a method in the CRUD model

        $this->crud->setColumns([
            [
                'name'  => 'name',
                'label' => (backpack_user()->country_id == config('config.default_country_user_it')) ? 'Nome' : 'Name',
                'type'  => 'text',
            ],
            [
                'name'  => 'email',
                'label' => 'Email',
                'type'  => 'text',
            ],
            $vet,
            [
                'name'  => 'city',
                'label' => (backpack_user()->country_id == config('config.default_country_user_it')) ? 'Città' : 'City',
                'type'  => 'text',
            ],
            [
                // 1-n relationship
                'label'     => (backpack_user()->country_id == config('config.default_country_user_it')) ? 'Nazione' : 'Country',
                'type'      => 'select',
                'name'      => 'country_id', // the column that contains the ID of that connected entity;
                'entity'    => 'country', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user
                'model'     => "App\Models\Country", // foreign key model
            ],
            [
                'name'  => 'is_login',
                'label' => (backpack_user()->country_id == config('config.default_country_user_it')) ? 'Accettato' : 'Accepted',
                'type'  => 'boolean',
                // optionally override the Yes/No texts
                // 'options' => [0 => 'Active', 1 => 'Inactive']
            ],
            [
                'name'  => 'updated_at',
                'label' => (backpack_user()->country_id == config('config.default_country_user_it')) ? 'Ultima modifica' : 'Last update',
                'type'  => 'datetime',
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
        CRUD::setValidation(PluginInvitationsRequest::class);

        /*if(backpack_user()->roles[0]->id > 2){
            die;
        }*/

        $setting = PluginInvitationsSettings::first();
        if($setting){

            $item = Role::find($setting->role_id);
            if($item){
                $invite = "<div class='alert alert-info'>Stai invitando un $item->name</div>";
            }else{
                $invite = "<div class='alert alert-danger'>Impostare le impostazioni di invito. Ruolo invito assente</div>";
            }

            $this->crud->addField([
                'name' => 'user_id2',
                'value' => $invite,
                'type' => 'custom_html'
            ]);
        }


        $parameters = \Route::current()->parameters();
        if($parameters){
            $role_id_agente = 0;
            $item = Role::where("name", "Agente")->first();
            if($item){
                $role_id_agente = $item->id;
            }

            $invitation = PluginInvitations::where("id", $parameters['id'])->first();
            if($invitation){
                if(backpack_user()->roles[0]->id == $role_id_agente){
                    if(backpack_user()->id != $invitation->user_id){
                       die;
                    }
                }
            }
        }

        $parameters = \Route::current()->parameters();
        if(count($parameters) == 0) {
            $this->crud->addField([
                'name' => 'user_id',
                'value' => backpack_user()->id,
                'type' => 'hidden'
            ]);

            $this->crud->addField([
                'name' => 'name',
                'label' => (backpack_user()->country_id == config('config.default_country_user_it')) ? 'Nome completo' : 'Full name',
                'type' => 'text',
                'attributes' => ['class' => 'form-control', 'id' => "name_invitation"],
            ]);

            $this->crud->addField([
                'name' => 'email',
                'label' => 'Email',
                'type' => 'email'
            ]);

            $this->crud->addField([
                'name' => 'city',
                'label' => (backpack_user()->country_id == config('config.default_country_user_it')) ? 'Città' : 'City',
                'type' => 'text'
            ]);

            $country = Country::orderBy("name", "asc")->get()->pluck("name", "id")->toArray();


            $this->crud->addField([   // select2_from_array
                'name'        => 'country_id',
                'label'       => (backpack_user()->country_id == config('config.default_country_user_it')) ? 'Nazione' : 'Country',
                'type'        => 'select2_from_array',
                'options'     => $country,
                'allows_null' => true,
                'default'     => 106,
                // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
            ]);


            $this->crud->addField([   // repeatable
                'name'  => 'ship_name',
                'label' => (backpack_user()->country_id == config('config.default_country_user_it')) ? 'Nominativo' : 'Name',
                'type'  => 'text',
                'attributes' => ['class' => 'form-control', 'id'=> "ship_name"],
                'tab' => (backpack_user()->country_id == config('config.default_country_user_it')) ? 'Indirizzo spedizione' : 'Shipping address'
            ]);

            $countries = Country::get()->pluck("name", "id")->toArray();
            $this->crud->addField([   // select2_from_array
                'name'        => 'ship_country_id',
                'label'       => (backpack_user()->country_id == config('config.default_country_user_it')) ? 'Nazione' : 'Country',
                'type'        => 'select2_from_array',
                'options'     => $countries,
                'allows_null' => true,
                'default'     => 348, //Italia
                'allows_multiple' => false, // OPTIONAL; needs you to cast this to array in your model;
                'tab' => (backpack_user()->country_id == config('config.default_country_user_it')) ? 'Indirizzo spedizione' : 'Shipping address'
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'ship_address1',
                'label' => (backpack_user()->country_id == config('config.default_country_user_it')) ? 'Indirizzo' : 'Address',
                'type'  => 'text',
                'tab' => (backpack_user()->country_id == config('config.default_country_user_it')) ? 'Indirizzo spedizione' : 'Shipping address'
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'ship_county',
                'label' => (backpack_user()->country_id == config('config.default_country_user_it')) ? 'Provincia' : 'Province',
                'type'  => 'text',
                'tab' => (backpack_user()->country_id == config('config.default_country_user_it')) ? 'Indirizzo spedizione' : 'Shipping address'
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'ship_city',
                'label' => (backpack_user()->country_id == config('config.default_country_user_it')) ? 'Città' : 'City',
                'type'  => 'text',
                'tab' => (backpack_user()->country_id == config('config.default_country_user_it')) ? 'Indirizzo spedizione' : 'Shipping address'
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'ship_postal_code',
                'label' => (backpack_user()->country_id == config('config.default_country_user_it')) ? 'Cap' : 'Zip code',
                'type'  => 'text',
                'tab' => (backpack_user()->country_id == config('config.default_country_user_it')) ? 'Indirizzo spedizione' : 'Shipping address'
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'ship_phone',
                'label' => (backpack_user()->country_id == config('config.default_country_user_it')) ? 'Telefono' : 'Phone',
                'type'  => 'text',
                'tab' => (backpack_user()->country_id == config('config.default_country_user_it')) ? 'Indirizzo spedizione' : 'Shipping address'
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'ship_mobile_phone',
                'label' => (backpack_user()->country_id == config('config.default_country_user_it')) ? 'Cellulare' : 'Mobile',
                'type'  => 'text',
                'tab' => (backpack_user()->country_id == config('config.default_country_user_it')) ? 'Indirizzo spedizione' : 'Shipping address'
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'ship_comment',
                'label' => 'Note',
                'type'  => 'text',
                'tab' => (backpack_user()->country_id == config('config.default_country_user_it')) ? 'Indirizzo spedizione' : 'Shipping address'
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'fatt_name',
                'label' => (backpack_user()->country_id == config('config.default_country_user_it')) ? 'Nominativo' : 'Name',
                'type'  => 'text',
                'attributes' => ['class' => 'form-control', 'id'=> "fatt_name"],
                'tab' => (backpack_user()->country_id == config('config.default_country_user_it')) ? 'Indirizzo fatturazione' : 'Billing address'
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'fatt_business_name',
                'label' => (backpack_user()->country_id == config('config.default_country_user_it')) ? 'Ragione sociale' : 'Business name',
                'type'  => 'text',
                'tab' => (backpack_user()->country_id == config('config.default_country_user_it')) ? 'Indirizzo fatturazione' : 'Billing address'
            ]);

            $countries = Country::get()->pluck("name", "id")->toArray();
            $this->crud->addField([   // select2_from_array
                'name'        => 'fatt_country_id',
                'label'       => (backpack_user()->country_id == config('config.default_country_user_it')) ? 'Nazione' : 'Country',
                'type'        => 'select2_from_array',
                'options'     => $countries,
                'allows_null' => true,
                'default'     => 348, //Italia
                'allows_multiple' => false, // OPTIONAL; needs you to cast this to array in your model;
                'tab' => (backpack_user()->country_id == config('config.default_country_user_it')) ? 'Indirizzo fatturazione' : 'Billing address'
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'fatt_address1',
                'label' => (backpack_user()->country_id == config('config.default_country_user_it')) ? 'Indirizzo' : 'Address',
                'type'  => 'text',
                'tab' => (backpack_user()->country_id == config('config.default_country_user_it')) ? 'Indirizzo fatturazione' : 'Billing address'
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'fatt_county',
                'label' => (backpack_user()->country_id == config('config.default_country_user_it')) ? 'Provincia' : 'Province',
                'type'  => 'text',
                'tab' => (backpack_user()->country_id == config('config.default_country_user_it')) ? 'Indirizzo fatturazione' : 'Billing address'
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'fatt_city',
                'label' => (backpack_user()->country_id == config('config.default_country_user_it')) ? 'Città' : 'City',
                'type'  => 'text',
                'tab' => (backpack_user()->country_id == config('config.default_country_user_it')) ? 'Indirizzo fatturazione' : 'Billing address'
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'fatt_postal_code',
                'label' => (backpack_user()->country_id == config('config.default_country_user_it')) ? 'Cap' : 'Zip code',
                'type'  => 'text',
                'tab' => (backpack_user()->country_id == config('config.default_country_user_it')) ? 'Indirizzo fatturazione' : 'Billing address'
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'fatt_fiscal_code_vat',
                'label' => (backpack_user()->country_id == config('config.default_country_user_it')) ? 'Codice fiscale/P.Iva' : 'Fiscal code/VAT',
                'type'  => 'text',
                'tab' => (backpack_user()->country_id == config('config.default_country_user_it')) ? 'Indirizzo fatturazione' : 'Billing address'
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'fatt_pec',
                'label' => 'Pec',
                'type'  => 'text',
                'tab' => (backpack_user()->country_id == config('config.default_country_user_it')) ? 'Indirizzo fatturazione' : 'Billing address'
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'fatt_sdi',
                'label' =>  (backpack_user()->country_id == config('config.default_country_user_it')) ? 'Codice SDI' : 'SDI code',
                'type'  => 'text',
                'tab' => (backpack_user()->country_id == config('config.default_country_user_it')) ? 'Indirizzo fatturazione' : 'Billing address'
            ]);
        }else{
            $this->crud->addField([
                'name' => 'name',
                'label' => (backpack_user()->country_id == config('config.default_country_user_it')) ? 'Nome completo' : 'Full name',
                'type' => 'text',
                'attributes' => ['class' => 'form-control', 'id' => "name_invitation"],
            ]);

            $this->crud->addField([
                'name' => 'email',
                'label' => 'Email',
                'type' => 'email'
            ]);
        }

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
        $pluginSetting = PluginInvitationsSettings::first();

        $this->crud->hasAccessOrFail('create');

        // execute the FormRequest authorization and validation, if one is required
        $request = $this->crud->validateRequest();

        $user = User::withTrashed()->where("email", $request->input('email'))->first();

        $check = PluginInvitations::where("email",  $request->input('email'))->first();

        if($user){
            if($user->deleted_at){
                $user->city = trim($request->input('city'));
                $user->country_id = trim($request->input('country_id'));
                $user->deleted_at = null;
                $user->save();
            }else{
                if($check){
                    return redirect()->back()->withErrors(['Account già invitato!']);
                }
            }
        }

        if(!$check){
            $item = $this->crud->create($this->crud->getStrippedSaveRequest());
        }else{
            $item = $check;
        }
        // insert item in the db
        $this->data['entry'] = $this->crud->entry = $item;

        // show a success message
        \Alert::success(trans('backpack::crud.insert_success'))->flash();

        $role_id = $pluginSetting->role_id;
        $code = unique_random("users", "code", "25");
        $password = \Str::random("8");

        if(!$user) {
            $user = User::create([
                "name" => trim($request->input('name')),
                "email" => trim($request->input('email')),
                "mobile" => trim($request->input('mobile')),
                "password" => trim(bcrypt($password)),
                "type_client" => 1, //azienda
                "code" => $code,
                "active" => $role_id == 7 ? 1 : 0, //se è buyer attivo già
                "city" => trim($request->input('city')),
                "country_id" => trim($request->input('country_id')),
            ]);

            $send_password = $password;
        }else{
            $user->code = $code;
            $user->save();

            $send_password = null;
        }

        $check = \DB::table('model_has_roles')->where("role_id", $role_id)->where("model_id", $user->id)->first();
        if(!$check){
            \DB::table('model_has_roles')->insert([
                "role_id" => $role_id,
                "model_type" => "App\User",
                "model_id" => $user->id
            ]);
        }

        //address
        $v_address = ["ship_name", "ship_country_id", "ship_address1", "ship_county", "ship_city", "ship_postal_code", "ship_phone", "ship_mobile_phone"];

        $cont_add = 0;
        foreach ($v_address as $v){
            if($request->get("$v")){
                $cont_add++;
            }
        }

        if($cont_add > 0){
            Address::insert([
                "name" => $request->get('ship_name'),
                "country_id" => $request->get('ship_country_id') ? $request->get('ship_country_id') : 0,
                "address1" => $request->get('ship_address1'),
                "county" => $request->get('ship_county'),
                "city" => $request->get('ship_city'),
                "postal_code" => $request->get('ship_postal_code'),
                "phone" => $request->get('ship_phone'),
                "mobile_phone" => $request->get('ship_mobile_phone'),
                "user_id" => $user->id,
                "created_at" => Carbon::now()->toDateTimeString()
            ]);
        }

        $v_address = ["fatt_name", "fatt_business_name", "fatt_country_id", "fatt_address1", "fatt_county", "fatt_city", "fatt_fiscal_code_vat", "fatt_pec", "fatt_sdi"];

        $cont_add = 0;
        foreach ($v_address as $v){
            if($request->get("$v")){
                $cont_add++;
            }
        }

        if($cont_add > 0){
            Company::insert([
                "name" => $request->get('fatt_name'),
                "business_name" => $request->get('fatt_business_name'),
                "address1" => $request->get('fatt_address1'),
                "county" => $request->get('fatt_county'),
                "city" => $request->get('fatt_city'),
                "fiscal_code_vat" => $request->get('fatt_fiscal_code_vat'),
                "country_id" => $request->get('fatt_country_id') ? $request->get('fatt_country_id') : 0,
                "pec" => $request->get('fatt_pec'),
                "postal_code" => $request->get('fatt_postal_code'),
                "sdi" => $request->get('fatt_sdi'),
                "user_id" => $user->id,
                "created_at" => Carbon::now()->toDateTimeString()
            ]);
        }

        $vet_email = ["code_activation" => $code, "password" => $send_password, "email" => $user->email, "country_id" => $user->country_id, "user" => backpack_user(), "role_id" => $role_id];
        $destinatario = $request->input('email');

        \Mail::send("common.emails.register_plugin_invitations", ['data' => $vet_email], function ($m) use ($destinatario, $user) {
            $m->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
            $m->replyTo(env('MAIL_TO_REPLAY'), env('MAIL_FROM_NAME'));
            if($user->country_id == config('config.default_country_user_it')){
                $m->to($destinatario)->subject("Invito");
            }else{
                $m->to($destinatario)->subject("Invitation");
            }
        });


        //SE UN AGENTE VUOLE INVITARE
       /* if($role_id != 7){ //Buyer
            $pluginSetting = PluginInvitationsSettings::first();
            $vet_email = ["code_activation" => $code, "password" => null, "email" => $user->email, "country_id" => $user->country_id, "user" => backpack_user()];
            $destinatario = $pluginSetting->email;
            \Mail::send("common.emails.register_plugin_invitations", ['data' => $vet_email], function ($m) use ($destinatario, $user) {
                $m->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                $user_name = \backpack_user()->name;

                if($user->country_id == config('config.default_country_user_it')){
                    $m->to($destinatario)->subject("Invitato da $user_name");
                }else{
                    $m->to($destinatario)->subject("Invited by $user_name");
                }
            });
        }*/

        // save the redirect choice for next time
        $this->crud->setSaveAction();

        return $this->crud->performSaveAction($item->getKey());
    }


    public function update()
    {
        $this->crud->hasAccessOrFail('update');

        // execute the FormRequest authorization and validation, if one is required
        $request = $this->crud->validateRequest();

        $user = User::withTrashed()->where("email", $request->input('email'))->first();
        if($user){
             return redirect()->back()->withErrors(['Email già registrata!']);
        }

        $resend = 0;
        $id = $request->get('id');
        $item_temp = PluginInvitations::find($id);
        if($item_temp){
            if($item_temp->email != $request->input('email')){
                $resend = 1;
            }
        }

        // update the row in the db
        $item = $this->crud->update($request->get($this->crud->model->getKeyName()),
            $this->crud->getStrippedSaveRequest());

        $this->data['entry'] = $this->crud->entry = $item;

        if($resend == 1){
            /*User::withTrashed()->where("email", $item_temp->email)->update([
                "email" => $request->input('email'),
                "password" => bcrypt($password)
            ]);*/

            $user =  User::withTrashed()->where("email", $request->input('email'))->first();
            if($user){
                $password = \Str::random("8");
                $user->password = bcrypt($password);
                $user->save();

                $vet_email = ["code_activation" => $user->code, "password" => null, "email" => $user->email, "country_id" => $user->country_id, "user" => backpack_user()];
                $destinatario = $request->input('email');

                \Mail::send("common.emails.register_plugin_invitations", ['data' => $vet_email], function ($m) use ($destinatario, $user) {
                    $m->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                    $m->replyTo(env('MAIL_TO_REPLAY'), env('MAIL_FROM_NAME'));
                    $m->to($destinatario)->subject("Invito");

                    if($user->country_id == config('config.default_country_user_it')){
                        $m->to($destinatario)->subject("Invito");
                    }else{
                        $m->to($destinatario)->subject("Invitation");
                    }
                });
            }


        }

        // show a success message
        \Alert::success(trans('backpack::crud.update_success'))->flash();

        // save the redirect choice for next time
        $this->crud->setSaveAction();

        return $this->crud->performSaveAction($item->getKey());
    }

    public function destroy($id)
    {
        $item = PluginInvitations::find($id);

        $this->crud->hasAccessOrFail('delete');

        // get entry ID from Request (makes sure its the last ID for nested resources)
        $id = $this->crud->getCurrentEntryId() ?? $id;

        if($item){
            $user = User::where("email", $item->email)->first();
            if($user){
                $user->forceDelete();
            }
        }

        return $this->crud->delete($id);
    }

    public function resend($id){
        $invitation = PluginInvitations::find($id);

        if($invitation){
            $user =  User::withTrashed()->where("email", $invitation->email)->first();
            if($user){
                $password = \Str::random("8");
                $user->password = bcrypt($password);
                $user->save();

                $vet_email = ["code_activation" => $user->code, "password" => null, "email" => $user->email, "country_id" => $user->country_id, "user" => backpack_user()];
                $destinatario = $invitation->email;

                \Mail::send("common.emails.register_plugin_invitations", ['data' => $vet_email], function ($m) use ($destinatario, $user) {
                    $m->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                    $m->replyTo(env('MAIL_TO_REPLAY'), env('MAIL_FROM_NAME'));

                    if($user->country_id == config('config.default_country_user_it')){
                        $m->to($destinatario)->subject("Invito");
                    }else{
                        $m->to($destinatario)->subject("Invitation");
                    }
                });

                $invitation->updated_at = Carbon::now()->toDateTimeString();
                $invitation->save();

                return true;
            }
        }

        return false;
    }
}
