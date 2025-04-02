<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PluginProductsRequestsRequest;
use App\Http\Requests\ShopOrdersRequestsRequest;
use App\Models\AdminPlugin;
use App\Models\PluginProductsRequests;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ShopOrdersRequestsCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ShopOrdersRequestsCrudController extends CrudController
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
        if(in_array(backpack_user()->roles[0]->id, [4,5,6,7,8,9])){
            die;
        }

        CRUD::setModel(\App\Models\PluginProductsRequests::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/shopOrdersRequests');
        CRUD::setEntityNameStrings('richiesta', 'richieste');

        $this->crud->query->whereNotNull("order_id");
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
        $this->crud->removeButton("create");
        $this->crud->removeButton("update");
        $this->crud->removeButton("delete");

        $v = [];
        // righe 58-59 con null dava errore 500
        $other_columns = "";
        $other_columns_2 = "";
        $i = 1;

        if(count($v)) {
            foreach ($v as $value) {
                $label = ucfirst($value);
                switch ($i) {
                    case 1:
                        $other_columns = [
                            // run a function on the CRUD model and show its return value
                            'name' => $value,
                            'label' => $label, // Table column heading
                            'type' => 'model_function',
                            'function_name' => 'getField', // the method in your Model
                            'function_parameters' => [$value], // pass one/more parameters to that method
                            'limit' => 10000, // Limit the number of characters shown
                        ];
                        break;

                    case 2:
                        $other_columns_2 = [
                            // run a function on the CRUD model and show its return value
                            'name' => $value,
                            'label' => $label, // Table column heading
                            'type' => 'model_function',
                            'function_name' => 'getField', // the method in your Model
                            'function_parameters' => [$value], // pass one/more parameters to that method
                            'limit' => 10000, // Limit the number of characters shown
                        ];
                        break;
                }
                $i++;
            }
        }

        $labelColumn = "Prodotti";
        $adminPlugin = AdminPlugin::where("name", "pluginProducts")->first();
        if($adminPlugin->version == 3){
            $labelColumn = "Prodotti/Ordini";
        }

        // Columns.
        $this->crud->setColumns([
            [
                'name'  => 'id',
                'label' => '#ID',
                'type'  => 'text',
            ],
            [
                'name'  => 'created_at',
                'label' => 'Data richiesta',
                'type'  => 'datetime',
            ],
            $other_columns,
            $other_columns_2,
            [
                'name'  => 'email',
                'label' => 'Email',
                'type'  => 'text',
            ],
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'product_id',
                'label' => $labelColumn, // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getProductOrOrder', // the method in your Model
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                'limit' => 10000, // Limit the number of characters shown
            ],
            [
                'name'  => 'is_active',
                'label' => 'Processata',
                'type'  => 'editable_switch',

                // Optionals
                // All the options available on editable_checkbox are available here too, plus;
                'color'   => 'success',
                'onLabel' => '✓',
                'offLabel' => '✕',
            ],
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'is_read',
                'label' => 'Letta', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getIsRead', // the method in your Model
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                'limit' => 10000, // Limit the number of characters shown
            ],
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
        CRUD::setValidation(PluginProductsRequestsRequest::class);

        $this->crud->addField([
            'name'  => 'product_id',
            'type'  => 'hidden'
        ]);

        $html = "";

        $parameters = \Route::current()->parameters();
        if(count($parameters)){
            $request_item = PluginProductsRequests::where("id", $parameters['id'])->first();
            $request_item->is_read = 1;
            $request_item->save();

            $html .= "<p><strong>Oggetto</strong><br> {$request_item->object}</p>";
            $content = json_decode($request_item->content, true);
            foreach($content as $k=>$v){
                if(is_numeric(strpos($k, "My name"))){
                    continue;
                }

                if(is_numeric(strpos($k, "my_name"))){
                    continue;
                }

                if($v == "1"){
                    $v = "Accettata";
                }

                if($k == "order_id"){
                    $k = "Ordine n.";
                }

                if($k == "name_support"){
                    continue;
                }

                if($k == "content_support"){
                    $k = "Messaggio";
                }

                $k = ucwords($k);
                $k = str_replace("_", " ", $k);

                if(is_array($v)){
                    $html .= "<p><strong>$k</strong></p><ul>";
                    foreach ($v as $value){
                        $html .= "<li>$value</li>";
                    }
                    $html .="</ul>";
                }else{
                    if(!in_array($k, ['G-recaptcha-response', 'Valid from'])){
                        $html .= "<p><strong>$k</strong><br>{$v}</p>";
                    }
                }
            }
        }

        $this->crud->addField([   // CustomHTML
            'name'  => 'separator',
            'type'  => 'custom_html',
            'value' => "$html"
        ]);

        $this->crud->addField([   // Checkbox
            'name'  => 'is_done',
            'label' => 'Richiesta processata?',
            'type'  => 'switch',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-12'
            ],
        ]);

        $this->crud->addField([   // Checkbox
            'name'  => 'processed_by',
            'label' => 'Processata da',
            'type'  => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-12'
            ],
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
