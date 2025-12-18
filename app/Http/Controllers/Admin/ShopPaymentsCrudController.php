<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ShopPaymentsRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ShopPaymentsCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ShopPaymentsCrudController extends CrudController
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

        CRUD::setModel(\App\Models\Payment::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/shopPayments');
        CRUD::setEntityNameStrings('pagamento', 'pagamenti');
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
                // run a function on the CRUD model and show its return value
                'name'  => 'name',
                'label' => 'Nome', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getName', // the method in your Model
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                'limit' => 10000, // Limit the number of characters shown
            ],
            [
                'name'  => 'is_paypal',
                'label' => 'Paypal',
                'type'  => 'check',
            ],
            [
                'name'  => 'is_contrassegno',
                'label' => 'Contrassegno',
                'type'  => 'check',
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
        CRUD::setValidation(ShopPaymentsRequest::class);

        $this->crud->addField([   // repeatable
            'name'  => 'name',
            'label' => 'Nome',
            'type'  => 'text',
        ]);

        $this->crud->addField([   // repeatable
            'name'  => 'info',
            'label' => 'Descrizione',
            'type'  => 'textarea',
        ]);

        $this->crud->addField([   // repeatable
            'name'  => 'is_paypal',
            'label' => 'Paypal?',
            'type'  => 'switch',
        ]);

        $this->crud->addField([   // repeatable
            'name'  => 'is_contrassegno',
            'label' => 'Contrassegno?',
            'type'  => 'switch',
            'wrapper' => ['class' => 'form-group col-md-2']
        ]);

        $this->crud->addField([   // repeatable
            'name'  => 'price_contrassegno',
            'label' => 'Costo Contrassegno',
            'type'  => 'text',
            'default' => 0,
            'wrapper' => ['class' => 'form-group col-md-2']
        ]);

        $this->crud->addField([   // repeatable
            'name'  => 'total_min_cart_contrassegno',
            'label' => 'Min Totale Carrello Contrassegno',
            'type'  => 'text',
            'default' => 0,
            'wrapper' => ['class' => 'form-group col-md-2']
        ]);

        $this->crud->addField([   // repeatable
            'name'  => 'total_max_cart_contrassegno',
            'label' => 'Max Totale Carrello Contrassegno',
            'type'  => 'text',
            'default' => 0,
            'wrapper' => ['class' => 'form-group col-md-2']
        ]);

        $this->crud->addField([   // repeatable
            'name'  => 'is_active',
            'label' => 'Attivo?',
            'type'  => 'switch',
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

    public function update()
    {
        $this->crud->hasAccessOrFail('update');

        // execute the FormRequest authorization and validation, if one is required
        $request = $this->crud->validateRequest();
        // update the row in the db
        $item = $this->crud->update($request->get($this->crud->model->getKeyName()),
            $this->crud->getStrippedSaveRequest($request));
        $this->data['entry'] = $this->crud->entry = $item;

        if($request->get('is_active') == 0){
            $this->crud->entry->is_active = 0;
            $this->crud->entry->save();
        }else{
            $this->crud->entry->is_active = 1;
            $this->crud->entry->save();
        }
        // show a success message
        \Alert::success(trans('backpack::crud.update_success'))->flash();

        // save the redirect choice for next time
        $this->crud->setSaveAction();

        return $this->crud->performSaveAction($item->getKey());
    }
}
