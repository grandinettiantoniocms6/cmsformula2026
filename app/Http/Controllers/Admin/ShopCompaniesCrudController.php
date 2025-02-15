<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ShopCompaniesRequest;
use App\Models\Country;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ShopCompaniesCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ShopCompaniesCrudController extends CrudController
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
        if(backpack_user()->roles[0]->id > 2){
            die;
        }

        CRUD::setModel(\App\Models\Company::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/shopCompanies');
        CRUD::setEntityNameStrings('Indirizzo di fatturazione', 'Indirizzi di fatturazione');

        $this->crud->setListView('vendor.backpack.base.plugins.ecommerce.Companies');
        $this->crud->setCreateView('vendor.backpack.base.plugins.ecommerce.CompaniesCreate');
        $this->crud->setEditView('vendor.backpack.base.plugins.ecommerce.CompaniesEdit');

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
                'name'  => 'business_name',
                'label' => 'Ragione sociale',
                'type'  => 'text',
            ],
            [
                'name'  => 'fiscal_code_vat',
                'label' => 'P.Iva',
                'type'  => 'text',
            ],
            [
                'name'  => 'fiscal_code',
                'label' => 'CodFiscale',
                'type'  => 'text',
            ],
            [
                'name'  => 'sdi',
                'label' => 'sdi',
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
        CRUD::setValidation(ShopCompaniesRequest::class);

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

        $this->crud->addField([   // repeatable
            'name'  => 'business_name',
            'label' => 'Ragione sociale',
            'type'  => 'text',
        ]);

        $countries = Country::get()->pluck("name", "id")->toArray();
        $this->crud->addField([   // select2_from_array
            'name'        => 'country_id',
            'label'       => "Nazione",
            'type'        => 'select2_from_array',
            'options'     => $countries,
            'allows_null' => false,
            'default'     => 348, //Italia
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
            'name'  => 'fiscal_code_vat',
            'label' => 'P.Iva',
            'type'  => 'text',
        ]);

        $this->crud->addField([   // repeatable
            'name'  => 'fiscal_code',
            'label' => 'CodiceFiscale',
            'type'  => 'text',
        ]);

        $this->crud->addField([   // repeatable
            'name'  => 'pec',
            'label' => 'Pec',
            'type'  => 'text',
        ]);

        $this->crud->addField([   // repeatable
            'name'  => 'sdi',
            'label' => 'Codice SDI',
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
}
