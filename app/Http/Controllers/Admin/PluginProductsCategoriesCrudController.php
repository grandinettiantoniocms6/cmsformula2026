<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PluginProductsCategoriesRequest;
use App\Models\AdminPlugin;
use App\Models\PluginProductsBrands;
use App\Models\PluginProductsCategories;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * Class PluginProductsCategoriesCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PluginProductsCategoriesCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ReorderOperation;
    use \Backpack\EditableColumns\Http\Controllers\Operations\MinorUpdateOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\PluginProductsCategories::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/pluginProductsCategories');
        CRUD::setEntityNameStrings('categoria', 'categorie');

        $this->crud->setListView(backpack_view('plugins.pluginProducts.categories_list'));
        $this->crud->setEditView(backpack_view('plugins.pluginProducts.categories_edit'));
        $this->crud->setCreateView(backpack_view('plugins.pluginProducts.categories_create'));

        $this->crud->query->orderBy("lft", "asc");
    }

    protected function setupReorderOperation()
    {
        // define which model attribute will be shown on draggable elements
        $this->crud->set('reorder.label', 'name');
        // define how deep the admin is allowed to nest the items
        // for infinite levels, set it to 0
        $this->crud->set('reorder.max_level', 3);
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

        $adminPlugin = AdminPlugin::where("name", "pluginProducts")->first();
        $addColumn = null;
        if($adminPlugin->version == 3){
            $addColumn =  [
                'name'  => 'is_purchasable',
                'label' => 'Acquistabile',
                'type'  => 'check',
            ];
        }
        // Columns.
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
                'label' => 'Nome',
                'type'  => 'text',
            ],
            [
                'name'  => 'slug',
                'label' => 'Permalink',
                'type'  => 'text',
            ],
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'parent_id',
                'label' => 'Padre', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getPadre', // the method in your Model
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                'limit' => 10000, // Limit the number of characters shown
            ],
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'num',
                'label' => 'N.Prod', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getNumber', // the method in your Model
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                'limit' => 10000, // Limit the number of characters shown
            ],
            [
                'name'  => 'is_active',
                'label' => 'Visibile',
                'type'  => 'editable_switch',

                // Optionals
                // All the options available on editable_checkbox are available here too, plus;
                'color'   => 'success',
                'onLabel' => '✓',
                'offLabel' => '✕',
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
        CRUD::setValidation(PluginProductsCategoriesRequest::class);

        $this->crud->addField([   // Browse
            'name'  => 'image',
            'label' => 'Immagine',
            'type'  => 'browse'
        ]);

        $categories = PluginProductsCategories::orderBy("name", "desc")->get()->pluck("name", "id")->toArray();
        if($categories){
            foreach ($categories as $category_id=>$category_label){
                $item = PluginProductsCategories::find($category_id);
                if($item->parent_id == 0 || $item->parent_id == null){
                    $categories[$category_id] = $category_label;
                }else{
                    $parent = PluginProductsCategories::find($item->parent_id);
                    if($parent->parent_id == 0 || $parent->parent_id == null){
                        $categories[$category_id] = "$parent->name > $category_label";
                    }else{
                        $parent_parent = PluginProductsCategories::find($parent->parent_id);
                        if($parent_parent->parent_id == 0 || $parent_parent->parent_id == null){
                            $categories[$category_id] = "$parent_parent->name > $parent->name > $category_label";
                        }else{
                            $parent_parent_parent = PluginProductsCategories::find($parent_parent->parent_id);
                            $categories[$category_id] = "$parent_parent_parent->name > $parent_parent->name > $parent->name > $category_label";
                        }
                    }
                }
            }
        }
        asort($categories);

        $categories[""] = "Radice";

        $this->crud->addField([   // select2_from_array
            'name'        => 'parent_id',
            'label'       => "Categoria padre",
            'type'        => 'select2_from_array',
            'options'     => $categories,
            'allows_null' => false,
            'default'     => "",
            // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
        ]);


        $this->crud->addField([   // Checkbox
            'name'  => 'is_active',
            'label' => 'Rendere questa categoria visibile nel sito?',
            'type'  => 'switch',
            'default' => 1
        ]);

        $adminPlugin = AdminPlugin::where("name", "pluginProducts")->first();
        if($adminPlugin->version == 3){
            $this->crud->addField([   // Checkbox
                'name'  => 'is_purchasable',
                'label' => 'Rendere acquistabile tutti i prodotti?',
                'type'  => 'switch',
                'default' => 1
            ]);
        }


        $trans = new AdminLanguageController();
        $trans->fields_lang("pluginProductsCategories", $this->crud);


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

        // show a success message
        \Alert::success(trans('backpack::crud.update_success'))->flash();

        // save the redirect choice for next time
        $this->crud->setSaveAction();

        $lang = new AdminLanguageController();
        $lang->update_lang("pluginProductsCategories", $this->crud, $request);
        $this->crud->entry->save();

        return $this->crud->performSaveAction($item->getKey());
    }

    public function store()
    {
        $this->crud->hasAccessOrFail('create');

        // execute the FormRequest authorization and validation, if one is required
        $request = $this->crud->validateRequest();

        // insert item in the db
        $item = $this->crud->create($this->crud->getStrippedSaveRequest($request));
        $this->data['entry'] = $this->crud->entry = $item;

        // show a success message
        \Alert::success(trans('backpack::crud.insert_success'))->flash();

        // save the redirect choice for next time
        $this->crud->setSaveAction();

        $lang = new AdminLanguageController();
        $lang->update_lang("pluginProductsCategories", $this->crud, $request);
        $this->crud->entry->save();

        return $this->crud->performSaveAction($item->getKey());
    }

    public function actions(Request $request){
        $button = $request->get('button');
        $ids = $request->get('ids');
        if($ids == null){
            return redirect()->back();
        }
        switch ($button){
            case "delete":
                PluginProductsCategories::withTrashed()->whereIn("id", $ids)->update([
                    "deleted_at" => Carbon::now()->toDateTimeString()
                ]);
                break;
        }

        \Alert::success("Operazione effettuata con successo!")->flash();

        return redirect()->back();
    }

    public function saveReorder()
    {
        $this->crud->hasAccessOrFail('reorder');

        $all_entries = \Request::input('tree');

        if(!is_array($all_entries)){
            $all_entries = json_decode($all_entries, true);
        }

        if (count($all_entries)) {
            $count = $this->crud->updateTreeOrder($all_entries);
        } else {
            return false;
        }

        return 'success for '.$count.' items';
    }
}
