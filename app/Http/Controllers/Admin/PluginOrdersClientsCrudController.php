<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PluginOrdersClientsRequest;
use App\Models\Baseuser;
use App\Models\PluginOrdersClients;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Http\Request;

/**
 * Class PluginOrdersClientsCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PluginOrdersClientsCrudController extends CrudController
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
        if(backpack_user()->roles[0]->id > 3){
            die;
        }

        CRUD::setModel(\App\Models\PluginOrdersClients::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/pluginOrdersClients');
        CRUD::setEntityNameStrings('cliente', 'clienti');
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

        if(backpack_user()->roles[0]->id > 3){
            die;
        }

        // Columns.
        $this->crud->setColumns([
            [
                'name'  => 'first_name',
                'label' => 'Nome',
                'type'  => 'text',
            ],
            [
                'name'  => 'last_name',
                'label' => 'Cognome',
                'type'  => 'text',
            ],
            [
                'name'  => 'business_name',
                'label' => 'Ragione sociale',
                'type'  => 'text',
            ],
            [
                'name'  => 'email',
                'label' => 'Email',
                'type'  => 'text',
            ],
            [
                'name'  => 'mobile_1',
                'label' => 'Cellulare',
                'type'  => 'text',
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
        if(backpack_user()->roles[0]->id > 3){
            die;
        }

        CRUD::setValidation(PluginOrdersClientsRequest::class);

        $this->crud->addField([
            'name' => 'first_name',
            'label' => "Nome",
            'type' => 'text',
            'attributes' => ['class' => 'form-control'],
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ],
        ]);

        $this->crud->addField([
            'name' => 'last_name',
            'label' => "Cognome",
            'type' => 'text',
            'attributes' => ['class' => 'form-control'],
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ],
        ]);

        $this->crud->addField([
            'name' => 'birthday',
            'label' => "Data di nascita",
            'type' => 'date',
            'attributes' => ['class' => 'form-control'],
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ],
        ]);


        $this->crud->addField([
            'name' => 'place_birthday',
            'label' => "Luogo di nascita",
            'type' => 'text',
            'attributes' => ['class' => 'form-control'],
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ],
        ]);

        $this->crud->addField([
            'name' => 'address',
            'label' => "Indirizzo",
            'type' => 'text',
            'attributes' => ['class' => 'form-control'],
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ],
        ]);

        $this->crud->addField([
            'name' => 'city',
            'label' => "Città",
            'type' => 'text',
            'attributes' => ['class' => 'form-control'],
            'wrapperAttributes' => [
                'class' => 'form-group col-md-4'
            ],
        ]);

        $this->crud->addField([
            'name' => 'zip',
            'label' => "CAP",
            'type' => 'text',
            'attributes' => ['class' => 'form-control'],
            'wrapperAttributes' => [
                'class' => 'form-group col-md-2'
            ],
        ]);

        $this->crud->addField([
            'name' => 'business_name',
            'label' => "Ragione sociale",
            'type' => 'text',
            'attributes' => ['class' => 'form-control'],
            'wrapperAttributes' => [
                'class' => 'form-group col-md-12'
            ],
        ]);

        $this->crud->addField([
            'name' => 'fiscal_code',
            'label' => "Codice fiscale",
            'type' => 'text',
            'attributes' => ['class' => 'form-control'],
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ],
        ]);

        $this->crud->addField([
            'name' => 'vat',
            'label' => "Partita iva",
            'type' => 'text',
            'attributes' => ['class' => 'form-control'],
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ],
        ]);

        $this->crud->addField([
            'name' => 'sdi',
            'label' => "Codice SDI",
            'type' => 'text',
            'attributes' => ['class' => 'form-control'],
            'wrapperAttributes' => [
                'class' => 'form-group col-md-12'
            ],
        ]);

        $this->crud->addField([
            'name' => 'email',
            'label' => "Email",
            'type' => 'text',
            'attributes' => ['class' => 'form-control'],
            'wrapperAttributes' => [
                'class' => 'form-group col-md-12'
            ],
        ]);

        $this->crud->addField([
            'name' => 'phone',
            'label' => "Telefono",
            'type' => 'text',
            'attributes' => ['class' => 'form-control'],
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ],
        ]);

        $this->crud->addField([
            'name' => 'fax',
            'label' => "Fax",
            'type' => 'text',
            'attributes' => ['class' => 'form-control'],
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ],
        ]);

        $this->crud->addField([
            'name' => 'mobile_1',
            'label' => "Cellulare 1",
            'type' => 'text',
            'attributes' => ['class' => 'form-control'],
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ],
        ]);

        $this->crud->addField([
            'name' => 'mobile_2',
            'label' => "Cellulare 2",
            'type' => 'text',
            'attributes' => ['class' => 'form-control'],
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ],
        ]);


        $this->crud->addField([
            'name' => 'note',
            'label' => "Note",
            'type' => 'ckeditor',
            'attributes' => ['class' => 'form-control'],
            'wrapperAttributes' => [
                'class' => 'form-group col-md-12'
            ],
        ]);


        $this->crud->addField([
            'name' => "user_id",
            'value' => backpack_user()->id,
            'type'  => 'hidden',
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
        if(backpack_user()->roles[0]->id > 3){
            die;
        }

        $this->setupCreateOperation();
    }

    public function autocomplete(Request $request) {
        $term = addslashes($request->input('q'));
        $baseusers = PluginOrdersClients::whereRaw("deleted_at is null AND (last_name like '%$term%' OR first_name like '%$term%' OR business_name like '%$term%')")->get();
        if($baseusers){
            $vet = [];
            foreach ($baseusers as $baseuser){
                $vet[] = ["text" => "$baseuser->last_name $baseuser->first_name", "id" => $baseuser->id];
            }
        }
        return response()->json(["items" => $vet]);
    }

    public function get_client(Request $request){
        $id = $request->get('id');
        $client = PluginOrdersClients::where("id", $id)->first();
        return response()->json(["client" => $client]);
    }
}
