<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ShopProductsVariantsRequest;
use App\Models\AdminPlugin;
use App\Models\ShopSettings;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ShopProductsVariantsCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ShopProductsVariantsCrudController extends CrudController
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

        if(backpack_user()->roles[0]->id > 2){
            die;
        }

        CRUD::setModel(\App\Models\ShopProductsVariants::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/shopProductsVariants');
        CRUD::setEntityNameStrings('variante', 'varianti');
        $this->crud->setListView(backpack_view('custom_products_variants'));

        $this->crud->query->where("group_id", request()->get('group_id'));
        $this->crud->query->where("is_variant", 1);

        //$this->crud->query->orderBy("id", "desc");
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
        //$this->crud->removeButton("delete");
        $this->crud->removeButton("clone");

        $adminPlugin = AdminPlugin::where("name", "pluginProducts")->first();
        if($adminPlugin->version == 3){
            $vet = [
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
                    // run a function on the CRUD model and show its return value
                    'name'  => 'photo',
                    'label' => 'Foto', // Table column heading
                    'type'  => 'model_function',
                    'function_name' => 'getFoto', // the method in your Model
                    // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                    'limit' => 10000, // Limit the number of characters shown
                ],
                [
                    'name'  => 'sku',
                    'label' => 'Sku',
                    'type'  => 'text',
                ],
                [
                    'name'  => 'name',
                    'label' => 'Nome',
                    'type'  => 'text',
                    'limit' => 10000, // Limit the number of characters shown
                ],
                [
                    'name'  => 'price',
                    'label' => 'Prezzo',
                    'type'  => 'text',
                ],
                [
                    'name'  => 'is_active',
                    'label' => 'Vis.',
                    'type'  => 'editable_switch',

                    // Optionals
                    // All the options available on editable_checkbox are available here too, plus;
                    'color'   => 'success',
                    'onLabel' => '✓',
                    'offLabel' => '✕',
                ],
                [
                    'name'  => 'is_purchasable',
                    'label' => 'Acq.',
                    'type'  => 'editable_switch',

                    // Optionals
                    // All the options available on editable_checkbox are available here too, plus;
                    'color'   => 'success',
                    'onLabel' => '✓',
                    'offLabel' => '✕',
                ],
            ];

            $shopSetting = ShopSettings::first();
            if($shopSetting->is_caricamento_file){
                $vet[] = [
                    'name'  => 'is_caricamento_file',
                    'label' => 'File',
                    'type'  => 'editable_switch',

                    // Optionals
                    // All the options available on editable_checkbox are available here too, plus;
                    'color'   => 'success',
                    'onLabel' => '✓',
                    'offLabel' => '✕',
                ];

                $vet[] = [
                    'name'  => 'is_caricamento_file_required',
                    'label' => 'File*',
                    'type'  => 'editable_switch',

                    // Optionals
                    // All the options available on editable_checkbox are available here too, plus;
                    'color'   => 'success',
                    'onLabel' => '✓',
                    'offLabel' => '✕',
                ];
            }

            if($shopSetting->is_textarea_message){
                $vet[] = [
                    'name'  => 'is_textarea_message',
                    'label' => 'Testo',
                    'type'  => 'editable_switch',

                    // Optionals
                    // All the options available on editable_checkbox are available here too, plus;
                    'color'   => 'success',
                    'onLabel' => '✓',
                    'offLabel' => '✕',
                ];

                $vet[] = [
                    'name'  => 'is_textarea_message_required',
                    'label' => 'Testo*',
                    'type'  => 'editable_switch',

                    // Optionals
                    // All the options available on editable_checkbox are available here too, plus;
                    'color'   => 'success',
                    'onLabel' => '✓',
                    'offLabel' => '✕',
                ];
            }

            $vet[] =  [
                // run a function on the CRUD model and show its return value
                'name'  => 'is_in_menu',
                'label' => 'Azioni', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getMenu', // the method in your Model
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                'limit' => 10000, // Limit the number of characters shown
            ];


        }


        $this->crud->setColumns($vet);

        $this->crud->addFilter([
            'name'  => 'status',
            'type'  => 'dropdown',
            'label' => 'Stato'
        ], [
            1 => 'Visibile',
            2 => 'Non visibile',
            3 => 'In evidenza',
            4 => 'Non in evidenza',
        ], function($value) { // if the filter is active
            switch ($value){
                case 1:
                    $this->crud->addClause('where', 'is_active', 1);
                    break;
                case 2:
                    $this->crud->addClause('where', 'is_active', 0);
                    break;
                case 3:
                    $this->crud->addClause('where', 'is_evidenza', 1);
                    break;
                case 4:
                    $this->crud->addClause('where', 'is_evidenza', 0);
                    break;
            }
            // $this->crud->addClause('where', 'status', $value);
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
        CRUD::setValidation(ShopProductsVariantsRequest::class);

        CRUD::setFromDb(); // fields

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
