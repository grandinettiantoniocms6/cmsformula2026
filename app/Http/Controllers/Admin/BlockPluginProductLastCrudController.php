<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\BlockPluginProductLastRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class BlockPluginProductLastCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class BlockPluginProductLastCrudController extends CrudController
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
        CRUD::setModel(\App\Models\BlockPluginProductLast::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/blockPluginProductLast');
        CRUD::setEntityNameStrings('Blocco catalogo ultimi inseriti', 'Blocco catalogo ultimi inseriti');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::setFromDb(); // columns

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
        CRUD::setValidation(BlockPluginProductLastRequest::class);

        $this->crud->addField([   // repeatable
            'name'  => 'name',
            'label' => 'Nome blocco',
            'type'  => 'text',
        ]);

        $this->crud->addField([   // repeatable
            'name'  => 'col_span',
            'label' => 'Numero di prodotti per riga',
            'type'        => 'select2_from_array',
            'options'     => [1=>1, 2=>2, 3=>3, 4=>4, 5=>5, 6=>6],
            'allows_null' => false,
            'default'     => 4,
        ]);

        $this->crud->addField([   // repeatable
            'name'  => 'number_items',
            'label' => 'Numero elementi per blocco',
            'type'  => 'number',
        ]);

        $this->crud->addField([   // repeatable
            'name'  => 'ultimi_inseriti',
            'label' => 'Ultimi inseriti',
            'type'  => 'switch',
        ]);

        $this->crud->addField([   // repeatable
            'name'  => 'piu_venduti',
            'label' => 'Più venduti',
            'type'  => 'switch',
        ]);

        $this->crud->addField([   // repeatable
            'name'  => 'in_vetrina',
            'label' => 'In evidenza',
            'type'  => 'switch',
        ]);

        $this->crud->addField([   // repeatable
            'name'  => 'in_promo',
            'label' => 'In promozione',
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
}
