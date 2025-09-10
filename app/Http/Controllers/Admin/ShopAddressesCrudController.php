<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ShopAddressesRequest;
use App\Models\Country;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ShopAddressesCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ShopAddressesCrudController extends CrudController
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
        if(in_array(backpack_user()->roles[0]->id, [3,4,5,6,8,9])){
            die;
        }

        CRUD::setModel(\App\Models\Address::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/shopAddresses');
        CRUD::setEntityNameStrings('Indirizzo di spedizione', 'Indirizzi di spedizione');
        $this->crud->setListView(backpack_view('plugins.ecommerce.Address'));
        $this->crud->setCreateView(backpack_view('plugins.ecommerce.AddressCreate'));
        $this->crud->setEditView(backpack_view('plugins.ecommerce.AddressEdit'));

        if(request()->get('user_id')){
            $this->crud->query->where("user_id", request()->get('user_id'));
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

        $this->crud->removeButton('show');

        $this->crud->setColumns([
            [
                'name'  => 'name',
                'label' => 'Nominativo',
                'type'  => 'text',
            ],
            [
                'name'  => 'address1',
                'label' => 'Indirizzo',
                'type'  => 'text',
            ],
            [
                'name'  => 'county',
                'label' => 'Prov',
                'type'  => 'text',
            ],
            [
                'name'  => 'city',
                'label' => 'Città',
                'type'  => 'text',
            ],
            [
                'name'  => 'postal_code',
                'label' => 'Cap',
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
        CRUD::setValidation(ShopAddressesRequest::class);

        $this->crud->addField([   // repeatable
            'name'  => 'user_id',
            'value' => request()->get('user_id'),
            'type'  => 'hidden',
        ]);

        $this->crud->addField([   // repeatable
            'name'  => 'name',
            'label' => 'Nominativo',
            'type'  => 'text',
        ]);

        $countries = Country::get()->pluck("name", "id")->toArray();
        $this->crud->addField([   // select2_from_array
            'name'        => 'country_id',
            'label'       => "Nazione",
            'type'        => 'select2_from_array',
            'options'     => $countries,
            'allows_null' => false,
            'default'     => 106, //Italia
            'allows_multiple' => false, // OPTIONAL; needs you to cast this to array in your model;
        ]);

        $this->crud->addField([   // repeatable
            'name'  => 'address1',
            'label' => 'Indirizzo',
            'type'  => 'text',
        ]);

        $this->crud->addField([   // repeatable
            'name'  => 'county',
            'label' => 'Provincia',
            'type'  => 'text',
        ]);

        $this->crud->addField([   // repeatable
            'name'  => 'city',
            'label' => 'Città',
            'type'  => 'text',
        ]);

        $this->crud->addField([   // repeatable
            'name'  => 'postal_code',
            'label' => 'Cap',
            'type'  => 'text',
        ]);

        $this->crud->addField([   // repeatable
            'name'  => 'phone',
            'label' => 'Telefono',
            'type'  => 'text',
        ]);

        $this->crud->addField([   // repeatable
            'name'  => 'mobile_phone',
            'label' => 'Cellulare',
            'type'  => 'text',
        ]);

        $this->crud->addField([   // repeatable
            'name'  => 'comment',
            'label' => 'Note',
            'type'  => 'text',
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


        // register any Model Events defined on fields
        $this->crud->registerFieldEvents();

        // insert item in the db
        $item = $this->crud->create($this->crud->getStrippedSaveRequest($request));
        $this->data['entry'] = $this->crud->entry = $item;

        // show a success message
        \Alert::success(trans('backpack::crud.insert_success'))->flash();

        // save the redirect choice for next time
        $this->crud->setSaveAction();

        return $this->crud->performSaveAction($item->getKey());
    }
}
