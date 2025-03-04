<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ShopAttributesRequest;
use App\Models\PluginProductsCategories;
use App\Models\PluginProductsCategoriesProducts;
use App\Models\ShopAttributes;
use App\Models\ShopAttributesCategories;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Http\Request;

/**
 * Class ShopAttributesCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ShopAttributesCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ReorderOperation;

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

        CRUD::setModel(\App\Models\ShopAttributes::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/shopAttributes');
        CRUD::setEntityNameStrings('attributo', 'attributi');

        $this->crud->query->orderBy("lft", "asc");

        $this->crud->setCreateView(backpack_view('custom_attributes_create'));
        $this->crud->setEditView(backpack_view('custom_attributes_edit'));

    }

    protected function setupReorderOperation()
    {
        // define which model attribute will be shown on draggable elements
        $this->crud->set('reorder.label', 'name');
        // define how deep the admin is allowed to nest the items
        // for infinite levels, set it to 0
        $this->crud->set('reorder.max_level', 0);
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

        /*$number = ShopAttributes::count();
        if($number == 2){
            $this->crud->removeButton('create');
        }*/

        //$this->crud->addButtonFromModelFunction('line', 'add_option', 'add_option', 'beginning'); // add a button whose HTML is returned by a method in the CRUD model

        $this->crud->setColumns([
            [
                'name'  => 'name',
                'label' => 'Nome',
                'type'  => 'text',
            ],
            [
                // select_from_array
                'name'    => 'type_layout',
                'label'   => 'Layout',
                'type'    => 'select_from_array',
                'options' => [0 => "Rettangolari con sfondo e valore", 1 => "Tondi con sfondo"],
            ],
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'categories',
                'label' => 'Categorie', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getCategories', // the method in your Model
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                'limit' => 10000, // Limit the number of characters shown
            ],
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'num_options',
                'label' => 'N.Opzioni', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getNumOptions', // the method in your Model
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                'limit' => 10000, // Limit the number of characters shown
            ],
        ]);

        $categories = PluginProductsCategories::where("is_active", 1)->orderBy("name", "desc")->get()->pluck("name", "id")->toArray();
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

        $this->crud->addFilter([
            'name'  => 'category_id',
            'type'  => 'select2',
            'label' => 'Categoria'
        ], function () use ($categories) {
            return $categories;
        }, function ($value) { // if the filter is active
            $this->crud->addClause('where', 'category_id', $value);
        });
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(ShopAttributesRequest::class);

        $this->crud->addField([   // select2_from_array
            'name'        => 'type_layout',
            'label'       => "Tipo layout (solo per shopsetting > dettaglio > Tipo di dettaglio varianti > Radiobutton",
            'type'        => 'select2_from_array',
            'options'     => [0 => "Rettangolari con sfondo e valore", 1 => "Tondi con sfondo"],
            'allows_null' => false,
            'default'     =>  0,
            'wrapperAttributes' => [
                'class' => 'form-group col-md-12',
            ],
        ]);

        $categories = PluginProductsCategories::where("is_active", 1)->orderBy("name", "desc")->get()->pluck("name", "id")->toArray();
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

        $ids = [];
        $parameters = \Route::current()->parameters();
        if(count($parameters)){
            $ids = ShopAttributesCategories::where("shop_attribute_id", $parameters['id'])->pluck("shop_category_id", "shop_category_id")->toArray();
        }


        $this->crud->addField([   // select2_from_array
            'name'        => 'categories',
            'label'       => "Categorie",
            'type'        => 'select2_from_array',
            'options'     => $categories,
            'allows_null' => false,
            'default'     => null,
            'value' => $ids,
            'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
            'wrapperAttributes' => [
                'class' => 'form-group col-md-12'
            ],
        ]);

        $trans = new AdminLanguageController();
        $trans->fields_lang("shopAttributes", $this->crud);
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


    public function check(Request $request){
        $category_id = $request->get('category_id');

        $trovato = 0;
        if($request->has('id')){
            $id = $request->get('id');

            $check = ShopAttributes::where("shop_attributes.id", "!=", $id)
                ->join("shop_attributes_categories", "shop_attributes_categories.shop_attribute_id", "=", "shop_attributes.id")
                ->where("shop_attributes_categories.shop_category_id", $category_id)
                ->get();
        }else{
            $check = ShopAttributes::join("shop_attributes_categories", "shop_attributes_categories.shop_attribute_id", "=", "shop_attributes.id")
                ->where("shop_attributes_categories.shop_category_id", $category_id)
                ->get();
        }

        $v = [];

        $count = count($check);
        if(count($check) > 2){
            $trovato = 1;

            foreach ($check as $item){
                $v[] = $item->name;
            }

        }

        if($count > 2){
            $cat = implode(", ", $v);
        }

        if($trovato > 0){
            return response()->json([
                "error" => 1,
                "message" => "Categoria già associata $count volte<br> <strong>$cat</strong>",
                "request" => $request->all()
            ]);
        }
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
        $lang->update_lang("shopAttributes", $this->crud, $request);
        $this->crud->entry->save();


        ShopAttributesCategories::where("shop_attribute_id", $item->id)->delete();
        if($request->has('categories')){
            $categories = $request->get('categories');
            if(count($categories)){
                foreach ($categories as $categoryID){
                    ShopAttributesCategories::create([
                        "shop_attribute_id" => $item->id,
                        "shop_category_id" => $categoryID
                    ]);
                }
            }
        }

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
        $lang->update_lang("shopAttributes", $this->crud, $request);
        $this->crud->entry->save();

        if($request->has('categories')){
            $categories = $request->get('categories');
            if(count($categories)){
                foreach ($categories as $categoryID){
                    ShopAttributesCategories::create([
                        "shop_attribute_id" => $item->id,
                        "shop_category_id" => $categoryID
                    ]);
                }
            }
        }


        return $this->crud->performSaveAction($item->getKey());
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
