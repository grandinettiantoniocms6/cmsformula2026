<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PluginProductsRequest;
use App\Models\AdminBlock;
use App\Models\AdminLanguage;
use App\Models\AdminPlugin;
use App\Models\AdminThumb;
use App\Models\Page;
use App\Models\PluginForms;
use App\Models\PluginProducts;
use App\Models\PluginProductsAttachments;
use App\Models\PluginProductsAttributes;
use App\Models\PluginProductsBrands;
use App\Models\PluginProductsCategories;
use App\Models\PluginProductsCategoriesProducts;
use App\Models\PluginProductsImages;
use App\Models\PluginProductsImagesSize;
use App\Models\PluginProductsLangs;
use App\Models\PluginProductsOptions;
use App\Models\PluginProductsPrices;
use App\Models\PluginProductsRelated;
use App\Models\PluginProductsSettings;
use App\Models\ShopAttributes;
use App\Models\ShopAttributesCategories;
use App\Models\ShopAttributesOptions;
use App\Models\ShopAttributesProducts;
use App\Models\ShopSettings;
use App\Models\Tax;
use App\Models\WebsiteSetting;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


/**
 * Class PluginProductsCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PluginProductsCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ReorderOperation;


    use \Backpack\CRUD\app\Http\Controllers\Operations\CloneOperation { clone as traitClone; }

    public function create_combinations(Request $request){
        $padre_id = $request->get('padre_id');
        $attributes = $request->get('attributes');

        $padre = PluginProducts::where("id", $padre_id)->where("is_variant", 0)->first();
        $id = $padre_id;

        if(count($attributes) == 1){
            foreach ($attributes as $k=>$vet) {
                foreach ($vet as $value) {

                    $attribute_option = ShopAttributesOptions::where("value", $value)
                        ->whereNotNull("code")
                        ->first();

                    $value_sku = $value;
                    if ($attribute_option) {
                        $value_sku = $attribute_option->code;
                    }

                    $new_name = "$padre->name $value";
                    $sku = "{$padre->sku}_{$value_sku}";

                    $opt = ShopAttributesOptions::whereRaw("value LIKE '%\"it\":\"$value\"%'")->where("shop_attribute_id", $k)->first();

                    $check = PluginProducts::where("sku", $sku)->first();
                    if($check){
                        continue;
                    }

                    $new = PluginProducts::find($padre_id)->replicate();

                    $vet = [];
                    $vetSlug = [];
                    $v_options = [];
                    $langs = AdminLanguage::where("is_active", 1)->get()->pluck("name", "name")->toArray();
                    foreach ($langs as $lang){
                        $vet[$lang] = $new_name;
                        $vetSlug[$lang] = \Str::slug($new_name, "-")."-$lang";
                    }

                    $new->name = $vet;
                    $new->slug = $vetSlug;
                    $new->sku = $sku;

                    if($opt){
                        $v_options[] = [
                            "option_id" => $opt->id
                        ];
                    }


                    $new->options = json_encode($v_options);
                    $new->is_active = 1;
                    $new->is_purchasable = 1;
                    $new->is_variant = 1;
                    $new->save();

                    if($opt){
                        ShopAttributesProducts::insert([
                            "product_id" => $new->id,
                            "attribute_id" => $k,
                            "option_id" => $opt->id,
                            "created_at" => Carbon::now()->toDateTimeString()
                        ]);
                    }


                    //categoria
                    $list = PluginProductsCategoriesProducts::where("plugin_product_product_id", $id)->get();
                    if($list){
                        foreach ($list as $cat){
                            PluginProductsCategoriesProducts::insert([
                                "plugin_product_product_id" => $new->id,
                                "plugin_product_category_id" => $cat->plugin_product_category_id,
                                "created_at" => Carbon::now()->toDateTimeString()
                            ]);
                        }
                    }

                    //images
                    $list = PluginProductsImages::where("product_id", $id)->get();
                    if($list){
                        foreach ($list as $image){
                            PluginProductsImages::insert([
                                "product_id" => $new->id,
                                "image" => $image->image,
                                "order" => $image->order,
                                "created_at" => Carbon::now()->toDateTimeString()
                            ]);
                        }
                    }

                    //options
                    $list = \DB::table("plugins_products_options")->where("product_id", $id)->whereNull("deleted_at")->get();
                    if($list){
                        foreach ($list as $option){
                            PluginProductsOptions::insert([
                                "product_id" => $new->id,
                                "attribute_id" => $option->attribute_id,
                                "value" => $option->value,
                                "parent_id" => $option->parent_id,
                                "lft" => $option->lft,
                                "rgt" => $option->rgt,
                                "depth" => $option->depth,
                                "created_at" => Carbon::now()->toDateTimeString()
                            ]);
                        }
                    }


                    //attachements
                    $list = \DB::table("plugins_products_attachments")->where("product_id", $id)->whereNull("deleted_at")->get();
                    if($list){
                        foreach ($list as $attachment){
                            PluginProductsAttachments::insert([
                                "name" => $attachment->name,
                                "file" => $attachment->file,
                                "product_id" => $new->id,
                                "parent_id" => $attachment->parent_id,
                                "lft" => $attachment->lft,
                                "rgt" => $attachment->rgt,
                                "depth" => $attachment->depth,
                                "created_at" => Carbon::now()->toDateTimeString()
                            ]);
                        }
                    }

                    //langs
                    $list = \DB::table("plugins_products_langs")->where("product_id", $id)->get();
                    if($list){
                        foreach ($list as $product_lang){
                            PluginProductsLangs::insert([
                                "product_id" => $new->id,
                                "lang" => $product_lang->lang,
                                "is_active" => $product_lang->is_active,
                                "image" => $product_lang->image,
                                "created_at" => Carbon::now()->toDateTimeString()
                            ]);
                        }
                    }

                }
            }
        }else{
            foreach ($attributes as $k=>$vet){
                foreach ($vet as $value){

                    $attribute_option = ShopAttributesOptions::where("value", $value)
                        ->whereNotNull("code")
                        ->first();

                    $value_sku = $value;
                    if($attribute_option){
                        $value_sku = $attribute_option->code;
                    }

                    foreach ($attributes as $j=>$vet2){
                        if($j == $k){
                            continue;
                        }

                        foreach ($vet2 as $value2){
                            $attribute_option = ShopAttributesOptions::where("value", $value2)
                                ->whereNotNull("code")
                                ->first();

                            $value2_sku = $value2;
                            if($attribute_option){
                                $value2_sku = $attribute_option->code;
                            }

                            $new_name = "$padre->name $value $value2";
                            $sku = "{$padre->sku}_{$value_sku}_{$value2_sku}";

                            $opt = ShopAttributesOptions::whereRaw("value LIKE '%\"it\":\"$value\"%'")->where("shop_attribute_id", $k)->first();
                            $opt2 = ShopAttributesOptions::whereRaw("value LIKE '%\"it\":\"$value2\"%'")->where("shop_attribute_id", $j)->first();

                            $check = PluginProducts::where("sku", $sku)->first();
                            if($check){
                                continue;
                            }


                            $new = PluginProducts::find($padre_id)->replicate();

                            $vet = [];
                            $vetSlug = [];
                            $v_options = [];
                            $langs = AdminLanguage::where("is_active", 1)->get()->pluck("name", "name")->toArray();
                            foreach ($langs as $lang){
                                $vet[$lang] = $new_name;
                                $vetSlug[$lang] = \Str::slug($new_name, "-")."-$lang";
                            }

                            $new->name = $vet;
                            $new->slug = $vetSlug;
                            $new->sku = $sku;

                            if($opt){
                                $v_options[] = [
                                    "option_id" => $opt->id
                                ];
                            }

                            if($opt2){
                                $v_options[] = [
                                    "option_id" => $opt2->id
                                ];
                            }


                            $new->options = json_encode($v_options);
                            $new->is_active = 1;
                            $new->is_purchasable = 1;
                            $new->is_variant = 1;
                            $new->save();

                            if($opt) {
                                ShopAttributesProducts::insert([
                                    "product_id" => $new->id,
                                    "attribute_id" => $k,
                                    "option_id" => $opt->id,
                                    "created_at" => Carbon::now()->toDateTimeString()
                                ]);
                            }

                            if($opt2) {
                                ShopAttributesProducts::insert([
                                    "product_id" => $new->id,
                                    "attribute_id" => $j,
                                    "option_id" => $opt2->id,
                                    "created_at" => Carbon::now()->toDateTimeString()
                                ]);
                            }


                            //echo "$new_name | $sku ||| $new->id<br>";

                            //categoria
                            $list = PluginProductsCategoriesProducts::where("plugin_product_product_id", $id)->get();
                            if($list){
                                foreach ($list as $cat){
                                    PluginProductsCategoriesProducts::insert([
                                        "plugin_product_product_id" => $new->id,
                                        "plugin_product_category_id" => $cat->plugin_product_category_id,
                                        "created_at" => Carbon::now()->toDateTimeString()
                                    ]);
                                }
                            }

                            //images
                            $list = PluginProductsImages::where("product_id", $id)->get();
                            if($list){
                                foreach ($list as $image){
                                    PluginProductsImages::insert([
                                        "product_id" => $new->id,
                                        "image" => $image->image,
                                        "order" => $image->order,
                                        "created_at" => Carbon::now()->toDateTimeString()
                                    ]);
                                }
                            }

                            //options
                            $list = \DB::table("plugins_products_options")->where("product_id", $id)->whereNull("deleted_at")->get();
                            if($list){
                                foreach ($list as $option){
                                    PluginProductsOptions::insert([
                                        "product_id" => $new->id,
                                        "attribute_id" => $option->attribute_id,
                                        "value" => $option->value,
                                        "parent_id" => $option->parent_id,
                                        "lft" => $option->lft,
                                        "rgt" => $option->rgt,
                                        "depth" => $option->depth,
                                        "created_at" => Carbon::now()->toDateTimeString()
                                    ]);
                                }
                            }


                            //attachements
                            $list = \DB::table("plugins_products_attachments")->where("product_id", $id)->whereNull("deleted_at")->get();
                            if($list){
                                foreach ($list as $attachment){
                                    PluginProductsAttachments::insert([
                                        "name" => $attachment->name,
                                        "file" => $attachment->file,
                                        "product_id" => $new->id,
                                        "parent_id" => $attachment->parent_id,
                                        "lft" => $attachment->lft,
                                        "rgt" => $attachment->rgt,
                                        "depth" => $attachment->depth,
                                        "created_at" => Carbon::now()->toDateTimeString()
                                    ]);
                                }
                            }

                            //langs
                            $list = \DB::table("plugins_products_langs")->where("product_id", $id)->get();
                            if($list){
                                foreach ($list as $product_lang){
                                    PluginProductsLangs::insert([
                                        "product_id" => $new->id,
                                        "lang" => $product_lang->lang,
                                        "is_active" => $product_lang->is_active,
                                        "image" => $product_lang->image,
                                        "created_at" => Carbon::now()->toDateTimeString()
                                    ]);
                                }
                            }

                        }
                    }
                }
                break;
            }
        }

        return redirect()->back();

    }

    public function associate_combinations(Request $request){

        $variants_ids = PluginProducts::where("group_id", $request->get('group_id'))->where("is_variant", 1)->get()->pluck("id", "id")->toArray();

        $option_id = $request->get('option_id');

        $products_ids = ShopAttributesProducts::where("option_id", $option_id)
            ->whereIn("product_id", $variants_ids)
            ->get()->pluck("product_id", "product_id")
            ->toArray();

        if(count($products_ids)){
            $field = $request->get('field');
            $value =  $request->get('value');

            switch ($field){
                case "foto":
                    foreach ($products_ids as $product_id){
                        PluginProductsImages::where("product_id", $product_id)->delete();

                        if(trim($value) != ""){
                            PluginProductsImages::create([
                                "product_id" => $product_id,
                                "image" => $value
                            ]);
                        }

                    }
                    break;

                case "qty":
                case "price":
                    PluginProducts::whereIn("id", $products_ids)->update([
                        "$field" => $value
                    ]);
                    break;

            }

            $count = count($products_ids);
            \Alert::success("Associazione avvenuta con successo su $count varianti")->flash();
        }else{
            \Alert::error("Nessuna variante modificata")->flash();
        }

        return redirect()->back();

    }

    public function clone($id)
    {
        $this->crud->hasAccessOrFail('clone');
        $this->crud->setOperation('clone');
        //dd(request()->all());
        // if you still want to call the old clone method
        $this->traitClone($id);

        $old = PluginProducts::find($id);
        $new = PluginProducts::where("sku", $old->sku)->orderBy("id", "desc")->first();

        if(\request()->has('options')){
            $options = \request()->get('options');

            $padre = PluginProducts::where("group_id", $old->group_id)->where("is_variant", 0)->first();

            $new_name = "$padre->name";
            $sku = "$padre->sku";

            //$new_name = "$old->name";
            //$sku = "$old->sku";

            /*if($old->code_article){
                $new_name .= " $old->code_article";
            }

            if($old->code_article){
                $sku .= "_$old->code_article";
            }*/

            $v_options = [];

            $i = 0;
            foreach ($options as $attribute_id=>$opt){
                $item_option = ShopAttributesOptions::find($opt);
                if($item_option){
                    if($i == 0){
                        //BLACK TY294 contiene TY294
                        if(is_numeric(strpos($item_option->value, $old->code_article))){
                            //BLACK TY294 = BLACK
                            $item_option->value = trim(str_replace($old->code_article, "", $item_option->value));
                            //dd($item_option->value);
                        }

                        $new_name .= " $item_option->value";
                        $sku .= " $item_option->value";
                    }else{
                        $new_name .= " $item_option->value";
                        $sku .= "_$item_option->value";
                    }

                    $v_options[] = [
                        "option_id" => $opt
                    ];

                    ShopAttributesProducts::insert([
                        "product_id" => $new->id,
                        "attribute_id" => $attribute_id,
                        "option_id" => $opt,
                        "created_at" => Carbon::now()->toDateTimeString()
                    ]);

                    $i++;
                }
            }


            $vet = [];
            $vetSlug = [];
            $langs = AdminLanguage::where("is_active", 1)->get()->pluck("name", "name")->toArray();
            foreach ($langs as $lang){
                $vet[$lang] = $new_name;
                $vetSlug[$lang] = \Str::slug($new_name, "-")."-$lang";
            }

            $new->name = $vet;
            $new->slug = $vetSlug;
            $new->sku = $sku;

            $new->options = json_encode($v_options);
            $new->is_active = 1;
        }else{
            $group = PluginProducts::whereNotNull("group_id")->orderBy("group_id", "desc")->first();
            if($group){
                $group_id = $group->group_id + 1;
            }else{
                $group_id = 1;
            }

            $new->group_id = $group_id;
            $new->is_active = 0;
        }

        $new->save();

        //categoria
        $list = PluginProductsCategoriesProducts::where("plugin_product_product_id", $id)->get();
        if($list){
            foreach ($list as $cat){
                PluginProductsCategoriesProducts::insert([
                    "plugin_product_product_id" => $new->id,
                    "plugin_product_category_id" => $cat->plugin_product_category_id,
                    "created_at" => Carbon::now()->toDateTimeString()
                ]);
            }
        }

        //images
        $list = PluginProductsImages::where("product_id", $id)->get();
        if($list){
            foreach ($list as $image){
                PluginProductsImages::insert([
                    "product_id" => $new->id,
                    "image" => $image->image,
                    "order" => $image->order,
                    "created_at" => Carbon::now()->toDateTimeString()
                ]);
            }
        }

        //options
        $list = \DB::table("plugins_products_options")->where("product_id", $id)->whereNull("deleted_at")->get();
        if($list){
            foreach ($list as $option){
                PluginProductsOptions::insert([
                    "product_id" => $new->id,
                    "attribute_id" => $option->attribute_id,
                    "value" => $option->value,
                    "parent_id" => $option->parent_id,
                    "lft" => $option->lft,
                    "rgt" => $option->rgt,
                    "depth" => $option->depth,
                    "created_at" => Carbon::now()->toDateTimeString()
                ]);
            }
        }


        //attachements
        $list = \DB::table("plugins_products_attachments")->where("product_id", $id)->whereNull("deleted_at")->get();
        if($list){
            foreach ($list as $attachment){
                PluginProductsAttachments::insert([
                    "name" => $attachment->name,
                    "file" => $attachment->file,
                    "product_id" => $new->id,
                    "parent_id" => $attachment->parent_id,
                    "lft" => $attachment->lft,
                    "rgt" => $attachment->rgt,
                    "depth" => $attachment->depth,
                    "created_at" => Carbon::now()->toDateTimeString()
                ]);
            }
        }

        //dd($old->id, $new->id);
    }
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\PluginProducts::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/pluginProducts');

        if(\request()->get('group_id')) {
            CRUD::setEntityNameStrings('variante', 'varianti');
        }else{
            $label = env('PLUGIN_PRODUCTS_LABEL_ADMIN', 'Prodotti');
            CRUD::setEntityNameStrings($label, $label);
        }

        if(backpack_user()->roles[0]->id >= 4){
            die;
        }

        $this->crud->setReorderView('vendor.backpack.base.custom_reorder_plugin_products');
        $this->crud->setListView('vendor.backpack.base.plugins.pluginProducts.list');
        $this->crud->setCreateView('vendor.backpack.base.plugins.pluginProducts.create');
        $this->crud->setEditView('vendor.backpack.base.plugins.pluginProducts.edit');

        $pluginSetting = PluginProductsSettings::first();
        $this->crud->query->orderBy($pluginSetting->order_field, $pluginSetting->order_type);

        $this->crud->query->where("is_variant", 0);
        //$this->crud->isReorderEnabled();
    }

    protected function setupReorderOperation()
    {
        // define which model attribute will be shown on draggable elements
        $this->crud->set('reorder.label', 'name');
      //  $this->crud->query->where("is_evidenza", "1");
        // define how deep the admin is allowed to nest the items
        // for infinite levels, set it to 0
        $this->crud->set('reorder.max_level', 1);
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
                    'searchLogic' => function ($query, $column, $searchTerm) {
                        $query->where('plugins_products.slug', 'like', '%'.$searchTerm.'%');
                    }
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
                ],
                [
                    'name'  => 'price',
                    'label' => 'Prezzo',
                    'type'  => 'text',
                ],
                /*[
                    'name'  => 'qty',
                    'label' => 'Qta',
                    'type'  => 'number',
                ],*/
                [
                    // 1-n relationship
                    'label'     => 'Tasse', // Table column heading
                    'type'      => 'select',
                    'name'      => 'tax_id', // the column that contains the ID of that connected entity;
                    'entity'    => 'tax', // the method that defines the relationship in your Model
                    'attribute' => 'value', // foreign key attribute that is shown to user
                    'model'     => "App\Models\ShopTaxes", // foreign key model
                ],
                [
                    // run a function on the CRUD model and show its return value
                    'name'  => 'is_active',
                    'label' => 'Visibile', // Table column heading
                    'type'  => 'model_function',
                    'function_name' => 'getIsActive', // the method in your Model
                    // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                    'limit' => 10000, // Limit the number of characters shown
                ],
                [
                    // run a function on the CRUD model and show its return value
                    'name'  => 'is_purchasable',
                    'label' => 'Acquistabile', // Table column heading
                    'type'  => 'model_function',
                    'function_name' => 'getIsPurchasable', // the method in your Model
                    // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                    'limit' => 10000, // Limit the number of characters shown
                ],
                /*
                [
                    // run a function on the CRUD model and show its return value
                    'name'  => 'is_evidenza',
                    'label' => 'In evidenza', // Table column heading
                    'type'  => 'model_function',
                    'function_name' => 'getIsEvidenza', // the method in your Model
                    // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                    'limit' => 10000, // Limit the number of characters shown
                ],
                */
                [
                    // run a function on the CRUD model and show its return value
                    'name'  => 'is_in_menu',
                    'label' => 'Azioni', // Table column heading
                    'type'  => 'model_function',
                    'function_name' => 'getMenu', // the method in your Model
                    // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                    'limit' => 10000, // Limit the number of characters shown
                ]
            ];
        }else{
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
                    'searchLogic' => function ($query, $column, $searchTerm) {
                        $query->where('plugins_products.slug', 'like', '%'.$searchTerm.'%');
                    }
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
                    'limit' => 1000
                ],
                [
                    // run a function on the CRUD model and show its return value
                    'name'  => 'category_list',
                    'label' => 'Categorie', // Table column heading
                    'type'  => 'model_function',
                    'function_name' => 'getCategories', // the method in your Model
                    // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                    'limit' => 10000, // Limit the number of characters shown
                ],
                [
                    // 1-n relationship
                    'label'     => 'Brand', // Table column heading
                    'type'      => 'select',
                    'name'      => 'brand_id', // the column that contains the ID of that connected entity;
                    'entity'    => 'brand', // the method that defines the relationship in your Model
                    'attribute' => 'name', // foreign key attribute that is shown to user
                    'model'     => "App\Models\PluginsProductsBrands", // foreign key model
                ],
                [
                    // run a function on the CRUD model and show its return value
                    'name'  => 'is_active',
                    'label' => 'Visibile', // Table column heading
                    'type'  => 'model_function',
                    'function_name' => 'getIsActive', // the method in your Model
                    // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                    'limit' => 10000, // Limit the number of characters shown
                ],
                [
                    // run a function on the CRUD model and show its return value
                    'name'  => 'is_evidenza',
                    'label' => 'In evidenza', // Table column heading
                    'type'  => 'model_function',
                    'function_name' => 'getIsEvidenza', // the method in your Model
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
            ];
        }
        // Columns.
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

            $ids = PluginProductsCategoriesProducts::where("plugin_product_category_id", $value)->pluck("plugin_product_product_id", "plugin_product_product_id")->toArray();
            if(count($ids)){
                $this->crud->addClause('whereIn', 'id', $ids);
            }else{
                $this->crud->addClause('whereIn', 'id', [0]);
            }
        });


        // simple filter
        $this->crud->addFilter([
            'type' => 'text',
            'name' => 'sku',
            'label' => 'SKU inizia con'
        ],
            false,
            function ($value) { // if the filter is active
                $this->crud->addClause('where', 'sku', 'LIKE', "$value%");
            });

        if($adminPlugin->version == 3) {
            $taxes = Tax::get()->pluck("value", "id")->toArray();
            // select2 filter
            $this->crud->addFilter([
                'name' => 'tax_id',
                'type' => 'select2',
                'label' => 'Tasse'
            ], function () use ($taxes) {
                return $taxes;
            }, function ($value) { // if the filter is active
                $this->crud->addClause('where', 'tax_id', $value);
            });


            $shopSetting = ShopSettings::first();
            if($shopSetting->is_subscriptions){
                // simple filter
                $this->crud->addFilter([
                    'type'  => 'simple',
                    'name'  => 'is_subscription',
                    'label' => 'Abbonamenti'
                ],
                    false,
                    function() { // if the filter is active
                        $this->crud->addClause('where', 'is_subscription', 1);
                    } );
            }
        }

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
        CRUD::setValidation(PluginProductsRequest::class);

        $parameters = \Route::current()->parameters();
        $labels = \App\Models\PluginProductsLabels::get()->pluck("value", "key")->toArray();

        $sku = null;
        $brand_id = null;
        $price = null;
        $price_SRP = null;
        $price_2 = null;
        $price_2_SRP = null;
        $price_dollar = null;
        $price_SRP_dollar = null;
        $qty = null;
        $product = null;
        $code_article = null;

        $cat_values = [];
        if(\request()->get('group_id') && count($parameters) == 0){
            $product = \App\Models\PluginProducts::where("group_id", request()->get('group_id'))->where("is_variant", 0)->first();
            $count_variant = \App\Models\PluginProducts::where("group_id", request()->get('group_id'))->where("is_variant", 1)->count();

            $this->crud->addField([   // CustomHTML
                'name'  => 'variant_html',
                'type'  => 'custom_html',
                'value' => "<h4>Stai aggiungendo una variante al prodotto <strong>$product->name</strong></h4><hr>"
            ]);

            $this->crud->addField([
                'name'  => 'group_id',
                'type'  => 'hidden',
                'value' => $product->group_id
            ]);

            $this->crud->addField([
                'name'  => 'is_variant',
                'type'  => 'hidden',
                'value' => 1
            ]);

            $this->crud->addField([
                'name'  => 'include_photo_padre',
                'label' => 'Includi le foto del padre',
                'type'  => 'switch'
            ]);

            $cat_values = PluginProductsCategoriesProducts::where("plugin_product_product_id", $product->id)->get()->pluck("plugin_product_category_id")->toArray();

            $sku = "$product->sku-$count_variant";
            $brand_id = $product->brand_id;
            $price = $product->price;
            $price_SRP = $product->price_srp;
            $price_2 = $product->price_2;
            $price_2_SRP = $product->price_2_srp;
            $price_dollar = $product->price_dollar;
            $price_SRP_dollar = $product->price_srp_dollar;

            $qty = $product->qty;
            $code_article = $product->code_article;


        }


        $trans = new AdminLanguageController();
        $trans->fields_lang("pluginProducts", $this->crud, $product);
        $adminPlugin = AdminPlugin::where("name", "pluginProducts")->first();

        $this->crud->addField([
            'name'  => 'sku',
            'label' => 'Sku prodotto',
            'type'  => 'text',
            'value' => $sku,
            'tab' => 'Impostazioni',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-4'
            ],
        ]);

        if($adminPlugin->version == 3) {

            if(env('CAMPI_AGGIUNTIVI_PRODOTTO') == 1){
                $this->crud->addField([
                    'name' => 'code_article',
                    'label' => 'Codice articolo',
                    'type' => 'text',
                    'tab' => 'Impostazioni',
                    'value' => $code_article,
                    'wrapperAttributes' => [
                        'class' => 'form-group col-md-2'
                    ],
                ]);

            }

            $this->crud->addField([
                'name' => 'ean13',
                'label' => 'Codice Ean13',
                'type' => 'text',
                'tab' => 'Impostazioni',
                'value' => $code_article,
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-2'
                ],
            ]);

            $taxes = Tax::get()->pluck("value", "id")->toArray();
            $this->crud->addField([   // select2_from_array
                'name'        => 'tax_id',
                'label'       => "Iva (Scegli l'aliquota desiderata) ",
                'type'        => 'select2_from_array',
                'options'     => $taxes,
                'allows_null' => false,
                'default'     => 1,
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-2'
                ],
                'tab' => 'Impostazioni',
            ]);

            $this->crud->addField([
                'name'  => 'sku',
                'label' => 'Sku prodotto',
                'type'  => 'text',
                'value' => $sku,
                'tab' => 'Impostazioni',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-4'
                ],
            ]);
        }

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
        asort($categories);

        /*$this->crud->addField([
            'name'  => 'tax_id',
            'type'  => 'hidden',
            'value' => 1
        ]);*/

        $disabled = [];
        if($parameters){
            $product_item = PluginProducts::find($parameters['id']);
            if($product_item){
                if($product_item->is_variant == 1){
                    $disabled = ["disabled" => true];
                }
            }


            $cat_values = PluginProductsCategoriesProducts::where("plugin_product_product_id", $parameters['id'])->get()->pluck("plugin_product_category_id")->toArray();
        }

        $this->crud->addField([   // select2_from_array
            'name'        => 'category_list',
            'label'       => "Categoria",
            'type'        => 'select2_from_array',
            'options'     => $categories,
            'allows_null' => false,
            'default'     => $cat_values,
            'tab' => 'Impostazioni',
            'attributes' => $disabled,
            'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ],
        ]);

        $this->crud->addField([
            'name'  => 'cat_new',
            'label' => 'Creazione rapida Categoria',
            'type'  => 'text',
            'tab' => 'Impostazioni',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ],
        ]);

        $brands = PluginProductsBrands::where("is_active", 1)->get()->pluck("name", "id")->toArray();
        $this->crud->addField([   // select2_from_array
            'name'        => 'brand_id',
            'label'       => "Brand",
            'type'        => 'select2_from_array',
            'options'     => $brands,
            'allows_null' => true,
            'default'     => null,
            'value' => $brand_id,
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ],
            'tab' => 'Impostazioni'
            // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
        ]);

        $this->crud->addField([
            'name'  => 'brand_new',
            'label' => 'Creazione rapida Brand',
            'type'  => 'text',
            'tab' => 'Impostazioni',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ],
        ]);

        $this->crud->addField([   // Browse
            'name'  => 'cover_photo',
            'label' => 'Foto Header (nel dettaglio prodotto)',
            'type'  => 'browse',
        ]);

        $this->crud->addField([   // Checkbox
            'name'  => 'is_active',
            'label' => 'Visibile?',
            'type'  => 'switch',
            'default' => 1,
            'tab' => 'Impostazioni',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
        ]);

        $this->crud->addField([   // Checkbox
            'name'  => 'is_evidenza',
            'label' => 'In evidenza',
            'type'  => 'switch',
            'tab' => 'Impostazioni',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-8'
            ],
        ]);




        $parameters = \Route::current()->parameters();
        if(count($parameters) == 0){
            $this->crud->addField([
                'label' => "Foto principale",
                'name' => "image",
                'type' => 'browse',
                //'crop' => true, // set to true to allow cropping, false to disable
                //'aspect_ratio' => 1, // omit or set to 0 to allow any aspect ratio
                // 'disk'      => 's3_bucket', // in case you need to show images from a different disk
                // 'prefix'    => 'uploads/images/profile_pictures/' // in case your db value is only the file name (no path), you can use this to prepend your path to the image src (in HTML), before it's shown to the user;
            ]);
        }

        /* AGGIUNTA INPUT PREZZO TESTO SEMPLICE BY WEBISLAND PER IMMOBILI */

        if($adminPlugin->version == 1) {
            $this->crud->addField([
                'name' => 'prezzo_semplice',
                'label' => 'Prezzo (usare il punto Esempio: 10.000)',
                'type' => 'text',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-4'
                ],
                'tab' => 'Impostazioni'
            ]);
        }

        /* END AGGIUNTA INPUT PREZZO TESTO SEMPLICE BY WEBISLAND PER IMMOBILI */

        if($adminPlugin->version > 1){
            $this->crud->addField([
                'name'  => 'price',
                'label' => 'Prezzo (&euro;) (iva esclusa)',
                'type'  => 'text',
                'value' => $price,
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ],
                'tab' => 'Impostazioni'
            ]);

            if($adminPlugin->version == 3){
                if(env('CAMPI_AGGIUNTIVI_PRODOTTO') == 1) {
                    $this->crud->addField([
                        'name' => 'price_srp',
                        'label' => 'Prezzo SRP (&euro;) (iva esclusa)',
                        'type' => 'text',
                        'tab' => 'Impostazioni',
                        'value' => $price_SRP,
                        'wrapperAttributes' => [
                            'class' => 'form-group col-md-6'
                        ],
                    ]);

                    $this->crud->addField([
                        'name' => 'price_dollar',
                        'label' => 'Prezzo (&#36;) (iva esclusa)',
                        'type' => 'text',
                        'tab' => 'Impostazioni',
                        'value' => $price_dollar,
                        'wrapperAttributes' => [
                            'class' => 'form-group col-md-6'
                        ],
                    ]);

                    $this->crud->addField([
                        'name' => 'price_srp_dollar',
                        'label' => 'Prezzo SRP (&#36;) (iva esclusa)',
                        'type' => 'text',
                        'tab' => 'Impostazioni',
                        'value' => $price_SRP_dollar,
                        'wrapperAttributes' => [
                            'class' => 'form-group col-md-6'
                        ],
                    ]);

                    $this->crud->addField([
                        'name' => 'price_2',
                        'label' => 'Prezzo 2 (&euro;) (iva esclusa)',
                        'type' => 'text',
                        'tab' => 'Impostazioni',
                        'value' => $price_2,
                        'wrapperAttributes' => [
                            'class' => 'form-group col-md-6'
                        ],
                    ]);

                    $this->crud->addField([
                        'name' => 'price_2_srp',
                        'label' => 'Prezzo 2 SRP (&euro;) (iva esclusa)',
                        'type' => 'text',
                        'tab' => 'Impostazioni',
                        'value' => $price_2_SRP,
                        'wrapperAttributes' => [
                            'class' => 'form-group col-md-6'
                        ],
                    ]);
                }
            }

            $this->crud->addField([
                'name'  => 'qty',
                'label' => 'Quantità',
                'type'  => 'number',
                'value' => $qty,
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-12'
                ],
                'tab' => 'Impostazioni'
            ]);


            $this->crud->addField([
                'name'  => 'video',
                'label' => 'Video (Url)',
                'type'  => 'text',
                'tab' => 'Impostazioni',
            ]);

            if($adminPlugin->version == 3){

                $this->crud->addField([   // Checkbox
                    'name'  => 'is_purchasable',
                    'label' => 'Rendere acquistabile il prodotto?',
                    'type'  => 'switch',
                    'default' => 1,
                    'wrapperAttributes' => [
                        'class' => 'form-group col-md-3'
                    ],
                ]);

                $this->crud->addField([   // Checkbox
                    'name'  => 'is_button_for_request',
                    'label' => 'Hai bisogno di misure personalizzate?',
                    'type'  => 'switch',
                    'default' => 1,
                    'wrapperAttributes' => [
                        'class' => 'form-group col-md-3'
                    ],
                ]);

                $pages = Page::orderBy("name", "asc")->get()->pluck("name", "id")->toArray();
                $this->crud->addField([   // select2_from_array
                    'name'        => 'form_page_id',
                    'label'       => "Pagina per richiesta misura",
                    'type'        => 'select2_from_array',
                    'options'     => $pages,
                    'allows_null' => true,
                    'default'     => null,
                    'wrapperAttributes' => [
                        'class' => 'form-group col-md-3'
                    ],
                    // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
                ]);

            }

            if(env('PROJECT_NAME') == "Maison-Flaneur"){
                $this->crud->addField([
                    'name' => 'delivery_start',
                    'label' => 'Data inizio spedizione',
                    'type' => 'text',
                    'tab' => 'Impostazioni'
                ]);

                $this->crud->addField([
                    'name' => 'delivery_end',
                    'label' => 'Data fine spedizione',
                    'type' => 'text',
                    'tab' => 'Impostazioni'
                ]);
            }
        }

        if($adminPlugin->version > 1){
            $this->crud->addField([
                'name'  => 'promo_price',
                'label' => 'Prezzo (€) in promozione - (Iva esclusa)  ',
                'type'  => 'text',
                'tab' => 'Promozione',
            ]);

            $this->crud->addField([
                'name'  => 'data_promo_start',
                'label' => 'Data inizio promo',
                'type'  => 'date',
                'tab' => 'Promozione',
            ]);

            $this->crud->addField([
                'name'  => 'data_promo_end',
                'label' => 'Data fine promo',
                'type'  => 'date',
                'tab' => 'Promozione',
            ]);

            $this->crud->addField([
                'name'  => 'hidden_promo_countdown',
                'label' => 'Nascondere countdown?',
                'type'  => 'switch',
                'tab' => 'Promozione',
            ]);
        }

        $this->crud->addField([   // repeatable
            'name'  => 'tags',
            'label' => 'Tag',
            'type'  => 'repeatable',
            'fields' => [
                [
                    'name'    => 'tag',
                    'type'    => 'text',
                    'label'   => 'Nome',
                    'wrapper' => ['class' => 'form-group col-md-4'],
                ],
            ],
            'tab' => "Tags",
            // optional
            'new_item_label'  => 'Nuovo tag', // customize the text of the button
        ]);


        $products = PluginProducts::where("is_active", 1)
            ->where("is_variant", 0)->get()->pluck("name", "id")->toArray();
        if(count($products)){
            $related = [];
            $parameters = \Route::current()->parameters();
            if(count($parameters)){
                $related = PluginProductsRelated::where("product_id", $parameters['id'])->get()->pluck("product_related_id")->toArray();
            }


            $labelCorrelati = @$labels['admin-tab-correlati'];


            /*$labelCorrelati = "Accessori";
            if($adminPlugin->version == 3){
                $labelCorrelati = "Correlati";
            }*/

            $this->crud->addField([   // select2_from_array
                'name'        => 'related',
                'label'       => "Prodotti correlati (digita il nome del prodotto e poi selezionalo) ",
                'type'        => 'select2_from_array',
                'options'     => $products,
                'allows_null' => true,
                'default'     => null,
                'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
                'tab' => $labelCorrelati,
                'value' => $related
            ]);
        }

        if($parameters || \request()->get('group_id')){
            if ($adminPlugin->version == 3) {
                $category_product = null;
                if(key_exists("id", $parameters)){
                    $category_product = PluginProductsCategoriesProducts::where("plugin_product_product_id", $parameters['id'])->pluck("plugin_product_category_id", "plugin_product_category_id")->toArray();

                    $attributes = ShopAttributesOptions::selectRaw("shop_attributes_options.*")
                        ->join("shop_attributes", "shop_attributes.id", "=", "shop_attribute_id")
                        ->join("shop_attributes_categories", "shop_attributes_categories.shop_attribute_id", "=", "shop_attributes.id")
                        ->whereIn("shop_category_id", $category_product)
                        ->orderBy("lft", "asc")
                        ->orderBy("ordine", "asc")
                        ->get();

                    if(!$attributes){
                        $attributes = ShopAttributesOptions::selectRaw("shop_attributes_options.*")
                            ->join("shop_attributes", "shop_attributes.id", "=", "shop_attribute_id")
                            ->orderBy("lft", "asc")
                            ->orderBy("ordine", "asc")
                            ->get();
                    }

                }else{
                    $attributes = ShopAttributesOptions::selectRaw("shop_attributes_options.*")
                        ->join("shop_attributes", "shop_attributes.id", "=", "shop_attribute_id")
                        ->orderBy("lft", "asc")
                        ->orderBy("ordine", "asc")
                        ->get();
                }

                $v_attributes = [];
                $v_attributes[null] = "seleziona";
                if ($attributes) {
                    foreach ($attributes as $attr) {

                        if($category_product){
                            $item_attribute = ShopAttributes::where("id", $attr->shop_attribute_id)
                                ->whereIn("category_id", $category_product)
                                ->first();

                            if(!$item_attribute){
                                $item_attribute = ShopAttributes::where("id", $attr->shop_attribute_id)
                                    ->first();
                            }
                        }else{
                            $item_attribute = ShopAttributes::where("id", $attr->shop_attribute_id)
                                ->first();

                        }

                        if($item_attribute){
                            $attr_name = $item_attribute->getTranslations('name', 'it');
                            $opt_name = $attr->getTranslations('value', 'it');

                            $v_attributes[$attr->id] = "{$attr_name['it']}: {$opt_name['it']}";

                        }
                    }
                }

                if(\request()->get('group_id')) {
                    $this->crud->addField([
                        'name' => 'include_photo_padre',
                        'label' => 'Includi le foto del padre',
                        'type' => 'switch'
                    ]);
                }

                if(\request()->get('group_id')) {
                    $this->crud->addField([
                        'name'  => 'name_variant',
                        'type'  => 'text',
                        'label' => "Nome/Codice variante",
                        'tab' => 'Opzioni'
                    ]);
                    $this->crud->addField([   // repeatable
                        'name' => 'options',
                        'label' => 'Opzioni',
                        'type' => 'repeatable',
                        'fields' => [
                            [   // select2_from_array
                                'name' => 'option_id',
                                'label' => "Nome",
                                'type' => 'select2_from_array',
                                'options' => $v_attributes,
                                'allows_null' => false,
                                'default' => null,
                                // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
                            ],
                        ],

                        // optional
                        'new_item_label' => 'Nuova opzione', // customize the text of the button
                        'init_rows' => 0, // number of empty rows to be initialized, by default 1
                        'min_rows' => 1, // minimum rows allowed, when reached the "delete" buttons will be hidden
                        'max_rows' => 2, // maximum rows allowed, when reached the "new item" button will be hidden
                        'tab' => 'Opzioni'
                    ]);
                }
            }


        }


        $products_langs = [];
        if($parameters){
            $products_langs = PluginProductsLangs::where("product_id", $parameters['id'])->get()->pluck("id", "lang")->toArray();
        }

        $this->crud->addField([   // CustomHTML
            'name' => 'separator_langs',
            'type' => 'custom_html',
            'value' => view(backpack_view('plugins.pluginProducts.products_langs'), compact('products_langs'))->render(),
            'tab' => 'Mostra/Nascondi in multilingua',
        ]);

        if($adminPlugin->version == 3) {
            $shopSetting = ShopSettings::first();
            if($shopSetting->is_subscriptions){
                $this->crud->addField([   // Checkbox
                    'name'  => 'is_subscription',
                    'label' => 'Tipologia ABBONAMENTO?',
                    'type'  => 'switch',
                    'tab' => 'Impostazioni',
                    'wrapperAttributes' => [
                        'class' => 'form-group col-md-3'
                    ],
                ]);

                $this->crud->addField([   // Checkbox
                    'name'  => 'subscription_days',
                    'label' => 'Giorni di ABBONAMENTO',
                    'type'  => 'number',
                    'tab' => 'Impostazioni',
                    'wrapperAttributes' => [
                        'class' => 'form-group col-md-3'
                    ],
                ]);
            }
        }
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
            $this->crud->getStrippedSaveRequest());
        $this->data['entry'] = $this->crud->entry = $item;

        if($item->is_evidenza == 0){
          //  $item->lft = null;
        /* Aggiunta input prezzo solo per versione 1 */
            $this->crud->entry->prezzo_semplice = $request->get('prezzo_semplice');
        /* End */
            $item->save();
        }

        // show a success message
        \Alert::success(trans('backpack::crud.update_success'))->flash();

        // save the redirect choice for next time
        $this->crud->setSaveAction();

        $lang = new AdminLanguageController();
        $lang->update_lang("pluginProducts", $this->crud, $request);

        if($request->has('name_variant')){
            $this->crud->entry->name_variant = $request->get('name_variant');
        }

        $this->crud->entry->include_photo_padre = (int) $request->get('include_photo_padre');
        $this->crud->entry->save();

        if($request->get('price') === null){
            PluginProducts::where("id", $this->crud->entry->id)->update([
                "price" => null
            ]);
        }

        $categories = $request->get('category_list');

        if($item->is_variant == 0){
            PluginProductsCategoriesProducts::where("plugin_product_product_id", $this->crud->entry->id)->delete();
            if($categories){
                foreach ($categories as $catID){
                    PluginProductsCategoriesProducts::insert([
                        "plugin_product_product_id" => $this->crud->entry->id,
                        "plugin_product_category_id" => $catID,
                        "created_at" => Carbon::now()->toDateTimeString()
                    ]);
                }
            }

            $figli = PluginProducts::where("group_id", $item->group_id)->where("is_variant", 1)->get();
            if($figli){
                foreach ($figli as $figlio){
                    PluginProductsCategoriesProducts::where("plugin_product_product_id", $figlio->id)->delete();
                    if($categories){
                        foreach ($categories as $catID){
                            PluginProductsCategoriesProducts::insert([
                                "plugin_product_product_id" => $figlio->id,
                                "plugin_product_category_id" => $catID,
                                "created_at" => Carbon::now()->toDateTimeString()
                            ]);
                        }
                    }
                }
            }
        }


        if($this->crud->entry->group_id == null && $this->crud->entry->is_variant == 0){
            $group = PluginProducts::whereNotNull("group_id")->orderBy("group_id", "desc")->first();
            if($group){
                $group_id = $group->group_id + 1;
            }else{
                $group_id = 1;
            }
            $this->crud->entry->group_id = $group_id;
            $this->crud->entry->save();
        }

        $related = $request->get('related');

        PluginProductsRelated::where("product_id", $this->crud->entry->id)->delete();
        $my_figli = PluginProducts::where("group_id", $this->crud->entry->group_id)->where("is_variant", 1)->get();
        if($my_figli) {
            foreach ($my_figli as $figlio) {
                PluginProductsRelated::where("product_id", $figlio->id)->delete();
            }
        }

        if($related) {
            foreach ($related as $relID) {
                if ($relID == null) {
                    continue;
                }

                $associato = PluginProducts::where("id", $relID)->first();
                $figli = PluginProducts::where("group_id", $associato->group_id)->where("is_variant", 1)->get();

                if ($figli) {
                    foreach ($figli as $figlio) {
                        PluginProductsRelated::where("product_id", $figlio->id)->delete();
                    }
                }
            }
        }

        if($related){
            foreach ($related as $relID){
                if($relID == null){
                    continue;
                }

                $associato = PluginProducts::where("id", $relID)->first();
                $figli = PluginProducts::where("group_id", $associato->group_id)->where("is_variant", 1)->get();

                if($figli){
                    foreach ($figli as $figlio){ //figli di A
                        //echo "$figlio->id metto {$this->crud->entry->id}<br>";
                        PluginProductsRelated::insert([
                            "product_id" => $figlio->id,
                            "product_related_id" => $this->crud->entry->id,
                            "created_at" => Carbon::now()->toDateTimeString()
                        ]);
                    }
                }

                $my_figli = PluginProducts::where("group_id", $this->crud->entry->group_id)->where("is_variant", 1)->get();
                if($my_figli){
                    foreach ($my_figli as $figlio){ //figli di A
                        PluginProductsRelated::insert([
                            "product_id" => $figlio->id,
                            "product_related_id" => $associato->id,
                            "created_at" => Carbon::now()->toDateTimeString()
                        ]);
                    }
                }

                $check = PluginProductsRelated::where("product_id", $this->crud->entry->id)
                    ->where("product_related_id", $relID)->first();
                if(!$check){
                    PluginProductsRelated::insert([
                        "product_id" => $this->crud->entry->id,
                        "product_related_id" => $relID,
                        "created_at" => Carbon::now()->toDateTimeString()
                    ]);
                }

                $check = PluginProductsRelated::where("product_id", $relID)
                    ->where("product_related_id", $this->crud->entry->id)->first();
                if(!$check){
                    PluginProductsRelated::insert([
                        "product_id" => $relID,
                        "product_related_id" => $this->crud->entry->id,
                        "created_at" => Carbon::now()->toDateTimeString()
                    ]);
                }

            }
        }

        $options = $request->get('options');

        $item->options = $options;
        $item->save();

        if($options){
            $v_options = json_decode($options, true);

            if(count($v_options)){
                ShopAttributesProducts::where("product_id", $this->crud->entry->id)->delete();
                foreach ($v_options as $opt_id){
                    $attribute = ShopAttributesOptions::where("id",$opt_id['option_id'])->first();
                    if($attribute){
                        ShopAttributesProducts::insert([
                            "attribute_id" => $attribute->shop_attribute_id,
                            "option_id" =>  $opt_id['option_id'],
                            "product_id" => $this->crud->entry->id
                        ]);
                    }
                }
            }
        }

        if($request->has('cat_new')){
            $cat_new = $request->get('cat_new');
            if(trim($cat_new) != ""){
                $check = PluginProductsCategories::where("name", $cat_new)->first();
                if(!$check){
                    $new = PluginProductsCategories::create([
                        "name" => $cat_new,
                        "slug" => \Str::slug($cat_new),
                        "parent_id" => null,
                        "is_active" => 1
                    ]);

                    PluginProductsCategoriesProducts::insert([
                        "plugin_product_product_id" => $this->crud->entry->id,
                        "plugin_product_category_id" => $new->id,
                        "created_at" => Carbon::now()->toDateTimeString()
                    ]);
                }
            }

        }

        if($request->has('brand_new')){
            $brand_new = $request->get('brand_new');

            if(trim($brand_new) != ""){
                $check = PluginProductsBrands::where("name", $brand_new)->first();
                if(!$check){
                    $new = PluginProductsBrands::create([
                        "name" => $brand_new,
                        "slug" => \Str::slug($cat_new),
                        "is_active" => 1
                    ]);

                    $this->crud->entry->brand_id = $new->id;
                    $this->crud->entry->save();

                }
            }

        }

        if($request->has('lang_active')){
            $lang_active = $request->get('lang_active');
            $lang_exist_image = $request->get('lang_exist_image');
            if($lang_exist_image == null){
                $lang_exist_image = [];
            }

            PluginProductsLangs::where("product_id", $this->crud->entry->id)->delete();

            //qual'è il blocco thumb impostato per i prodotti?
            $adminBlock = AdminBlock::where("name", "blockPluginProduct")->first();
            $adminThumb = AdminThumb::where("admin_block_id", $adminBlock->id)->get();

            $disk = config('backpack.base.root_disk_name');
            $destination_path = "public/thumb/special_images/{$this->crud->entry->id}";

            foreach ($lang_active as $lang=>$v){
                $path = null;
                if(key_exists($lang, $lang_exist_image)){
                    $path = $lang_exist_image[$lang];
                }

                if($request->hasFile('lang_image')){
                    if(key_exists($lang, $request->file('lang_image'))){

                        if($request->file('lang_image')[$lang]){
                            $file = $request->file('lang_image')[$lang];
                            $fileName = $file->getClientOriginalName();
                            $file->move(public_path("uploads/special_images/{$this->crud->entry->id}"), $fileName);
                            $path = "uploads/special_images/{$this->crud->entry->id}/$fileName";

                            $value = $path;
                            $basename = basename($value);
                            $nameFile = explode(".", $basename);

                            if(count($adminThumb)){
                                foreach ($adminThumb as $thumb){
                                    $image = \Image::make($value)->encode('webp', 90);

                                    $width = $thumb->width_max != 0 ? $thumb->width_max : null;
                                    $height = $thumb->height_max != 0 ? $thumb->height_max : null;
                                    $suffix = $thumb->suffix;

                                    $image->fit($width, $height, function ($constraint) {
                                        $constraint->upsize();
                                    });

                                    $filename = "$nameFile[0]-{$suffix}.webp";
                                    \Storage::disk($disk)->put($destination_path.'/'.$filename, $image->stream());
                                }
                            }
                        }
                    }
                }

                PluginProductsLangs::create([
                   "product_id" =>  $this->crud->entry->id,
                   "lang" => $lang,
                   "is_active" => $v,
                   "image" => $path
                ]);
            }
        }

        \Artisan::call('set:products_search', ['id'=> $this->crud->entry->id]);


        return $this->crud->performSaveAction($item->getKey());
    }

    public function store()
    {
        $this->crud->hasAccessOrFail('create');

        // execute the FormRequest authorization and validation, if one is required
        $request = $this->crud->validateRequest();


        // insert item in the db
        $item = $this->crud->create($this->crud->getStrippedSaveRequest());
        $this->data['entry'] = $this->crud->entry = $item;

        // show a success message
        \Alert::success(trans('backpack::crud.insert_success'))->flash();

        // save the redirect choice for next time
        $this->crud->setSaveAction();

        if($item->is_evidenza == 0){
            $item->lft = null;
            $item->save();
        }

        $value = $request->get('image');
        if($value){
            //qual'è il blocco thumb impostato per i prodotti?
            $adminBlock = AdminBlock::where("name", "blockPluginProduct")->first();
            $adminThumb = AdminThumb::where("admin_block_id", $adminBlock->id)->get();
            $disk = config('backpack.base.root_disk_name');
            $destination_path = "public/thumb/plugin_products";
            $basename = basename($value);
            $nameFile = explode(".", $basename);

            $imageUpload = new PluginProductsImages();

            $imageUpload->product_id = $this->crud->entry->id;
            $imageUpload->image = $value;
            $imageUpload->save();

            if(count($adminThumb)){
                foreach ($adminThumb as $thumb){
                    $image = \Image::make($value)->encode('webp', 90);

                    $width = $thumb->width_max != 0 ? $thumb->width_max : null;
                    $height = $thumb->height_max != 0 ? $thumb->height_max : null;
                    $suffix = $thumb->suffix;

                    $image->fit($width, $height, function ($constraint) {
                        $constraint->upsize();
                    });

                    $filename = "$nameFile[0]-{$suffix}.webp";
                    \Storage::disk($disk)->put($destination_path.'/'.$filename, $image->stream());
                }
            }
        }

        $lang = new AdminLanguageController();
        $lang->update_lang("pluginProducts", $this->crud, $request);
        $this->crud->entry->save();

        $categories = $request->get('category_list');
        PluginProductsCategoriesProducts::where("plugin_product_product_id", $this->crud->entry->id)->delete();
        if($categories){
            foreach ($categories as $catID){
                PluginProductsCategoriesProducts::insert([
                    "plugin_product_product_id" => $this->crud->entry->id,
                    "plugin_product_category_id" => $catID,
                    "created_at" => Carbon::now()->toDateTimeString()
                ]);
            }
        }

        if(!$request->get('group_id')){
            $group = PluginProducts::whereNotNull("group_id")->orderBy("group_id", "desc")->first();
            if($group){
                $group_id = $group->group_id + 1;
            }else{
                $group_id = 1;
            }

            $this->crud->entry->group_id = $group_id;
            $this->crud->entry->save();
        }


        $related = $request->get('related');
        PluginProductsRelated::where("product_id", $this->crud->entry->id)->delete();
        if($related){
            foreach ($related as $relID){
                if($this->crud->entry->id != $relID){
                    $check = PluginProductsRelated::where("product_id", $this->crud->entry->id)
                        ->where("product_related_id", $relID)->first();
                    if(!$check){
                        PluginProductsRelated::insert([
                            "product_id" => $this->crud->entry->id,
                            "product_related_id" => $relID,
                            "created_at" => Carbon::now()->toDateTimeString()
                        ]);
                    }

                    $check = PluginProductsRelated::where("product_id", $relID)
                        ->where("product_related_id", $this->crud->entry->id)->first();
                    if(!$check){
                        PluginProductsRelated::insert([
                            "product_id" => $relID,
                            "product_related_id" => $this->crud->entry->id,
                            "created_at" => Carbon::now()->toDateTimeString()
                        ]);
                    }

                }
            }
        }

        //options
        $options = $request->get('options');


        if($options){
            $v_options = json_decode($options, true);
            if(count($v_options)){
                ShopAttributesProducts::where("product_id", $this->crud->entry->id)->delete();
                foreach ($v_options as $opt_id){
                    $attribute = ShopAttributesOptions::where("id",$opt_id['option_id'])->first();
                    if($attribute){
                        ShopAttributesProducts::insert([
                            "attribute_id" => $attribute->shop_attribute_id,
                            "option_id" =>  $opt_id['option_id'],
                            "product_id" => $this->crud->entry->id
                        ]);
                    }
                }
            }
        }


        //se sto inserendo 1 variante
        if($this->crud->entry->is_variant == 1){
            $padre = PluginProducts::where("group_id", $this->crud->entry->group_id)->where("is_variant", 0)->first();
            if($padre){
                //prendo proprietà del padre
                $list = \DB::table("plugins_products_options")->where("product_id", $padre->id)->get();
                if($list){
                    foreach ($list as $opt){
                        \DB::table("plugins_products_options")->insert([
                            "product_id" => $this->crud->entry->id,
                            "attribute_id" => $opt->attribute_id,
                            "value" => $opt->value,
                            "parent_id" => $opt->parent_id,
                            "lft" => $opt->lft
                        ]);
                    }
                }
            }

        }

        if($request->has('cat_new')){
            $cat_new = $request->get('cat_new');
            if(trim($cat_new) != ""){
                $check = PluginProductsCategories::where("name", $cat_new)->first();
                if(!$check){
                    $new = PluginProductsCategories::create([
                        "name" => $cat_new,
                        "slug" => \Str::slug($cat_new),
                        "parent_id" => null,
                        "is_active" => 1
                    ]);

                    PluginProductsCategoriesProducts::insert([
                        "plugin_product_product_id" => $this->crud->entry->id,
                        "plugin_product_category_id" => $new->id,
                        "created_at" => Carbon::now()->toDateTimeString()
                    ]);
                }
            }

        }

        if($request->has('brand_new')){
            $brand_new = $request->get('brand_new');

            if(trim($brand_new) != ""){
                $check = PluginProductsBrands::where("name", $brand_new)->first();
                if(!$check){
                    $new = PluginProductsBrands::create([
                        "name" => $brand_new,
                        "slug" => \Str::slug($cat_new),
                        "is_active" => 1
                    ]);

                    $this->crud->entry->brand_id = $new->id;
                    $this->crud->entry->save();

                }
            }

        }

        if($request->has('lang_active')){
            $lang_active = $request->get('lang_active');
            $lang_exist_image = $request->get('lang_exist_image');
            if($lang_exist_image == null){
                $lang_exist_image = [];
            }

            PluginProductsLangs::where("product_id", $this->crud->entry->id)->delete();

            foreach ($lang_active as $lang=>$v){
                $path = null;
                if(key_exists($lang, $lang_exist_image)){
                    $path = $lang_exist_image[$lang];
                }

                if($request->hasFile('lang_image')){
                    if(key_exists($lang, $request->file('lang_image'))){

                        if($request->file('lang_image')[$lang]){
                            $file = $request->file('lang_image')[$lang];
                            $fileName = $file->getClientOriginalName();
                            $file->move(public_path("uploads/special_images/{$this->crud->entry->id}"), $fileName);
                            $path = "uploads/special_images/{$this->crud->entry->id}/$fileName";
                        }
                    }
                }

                PluginProductsLangs::create([
                    "product_id" =>  $this->crud->entry->id,
                    "lang" => $lang,
                    "is_active" => $v,
                    "image" => $path
                ]);
            }
        }

        \Artisan::call('set:products_search', ['id'=> $this->crud->entry->id]);

        return $this->crud->performSaveAction($item->getKey());
    }

    public function import_export(){
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
        asort($categories);

        return view(backpack_view("plugins.pluginProducts.import_export"), compact("categories"));
    }

    public function export(Request $request){
        header('Content-Type: text/html; charset=UTF-8');

        $category_id = $request->get('category');
        $langs = AdminLanguage::where("is_active", 1)->get()->pluck("name", "name")->toArray();

        $fields = ["name", "slug", "meta_title", "meta_description", "meta_key", "description_short", "description", "tags", "custom_1", "custom_2", "category", "attachments", "attachments_name"]; //"description"

        if($category_id == 0){
            $products = PluginProducts::whereRaw("is_active = 1")
                ->orderBy("sku", "asc")
                ->get();
        }else{
            $products = PluginProducts::selectRaw("plugins_products.*")
                ->join("plugins_products_categories_products", "plugins_products_categories_products.plugin_product_product_id", "=", "plugins_products.id")
                ->whereRaw("plugins_products.is_active = 1")
                ->where("plugins_products_categories_products.plugin_product_category_id", $category_id)
                ->orderBy("sku", "asc")
                ->get();
        }

        $data_temp = [];
        $data_temp[] = "sku";
        foreach ($fields as $field){
            foreach ($langs as $lang) {
                $data_temp[] = "{$field}_$lang";
            }
        }

        $data_temp[] = "brand";
        //$data_temp[] = "category";
        $data_temp[] = "is_active";
        $data_temp[] = "images";
        $data_temp[] = "accessories";
        //$data_temp[] = "attachments";

        $adminPlugin = AdminPlugin::where("name", "pluginProducts")->first();
        if($adminPlugin->version > 1){
            $data_temp[] = "price";
            $data_temp[] = "qty";
            $data_temp[] = "video";
            $data_temp[] = "property";
        }

        if($adminPlugin->version == 3) {
            $data_temp[] = "tax";
            $data_temp[] = "parent_sku";
            $data_temp[] = "code_article";
            $data_temp[] = "is_evidenza";
            $data_temp[] = "is_purchasable";
            $data_temp[] = "name_variant";
            $data_temp[] = "attributes";
            //$data_temp[] = "options";
            $data_temp[] = "ean13";
            $data_temp[] = "is_button_for_request";
            $data_temp[] = "form_page_id";
         }


        $data = [implode(";", $data_temp)];

        if ($products) {
            foreach ($products as $product) {
                $v = [];
                $v[] = "$product->sku";

                foreach ($fields as $field){
                    $categories = null;
                    if($field == "category"){
                        $categories_products = PluginProductsCategoriesProducts::where("plugin_product_product_id", $product->id)->get()
                            ->pluck("plugin_product_category_id", "plugin_product_category_id")->toArray();

                        if(count($categories_products)){
                            $categories =  PluginProductsCategories::whereIn("id", $categories_products)->get();
                        }
                    }

                    $attachments = null;
                    if($field == "attachments" || $field == "attachments_name"){
                        $attachments =  PluginProductsAttachments::where("product_id", $product->id)->get();
                    }

                    foreach ($langs as $lang) {
                        if($field != "category" && $field != "attachments" && $field != "attachments_name"){
                            $val = $product->getTranslation($field, $lang);
                        }

                        $val = str_replace("&#39;", "'", $val);

                        // Trasformazione caratteri per textarea editor ai fini dell'import/export csv. Se ci sarà bisogno aggiungere righe dopo 1736:
                        $val = str_replace("&agrave;", "à", $val);
                        $val = str_replace("&egrave;", "è", $val);
                        $val = str_replace("&igrave;", "ì", $val);
                        $val = str_replace("&ograve;", "ò", $val);
                        $val = str_replace("&ugrave;", "ù", $val);
                        $val = str_replace("&euro;", "€", $val);
                        $val = str_replace("&Agrave;", "À", $val);
                        $val = str_replace("&Egrave;", "È", $val);
                        $val = str_replace("&Igrave;", "Ì", $val);
                        $val = str_replace("&Ograve;", "Ò", $val);
                        $val = str_replace("&Ugrave;", "Ù", $val);
                        $val = str_replace("&bull;", "-", $val);
                        $val = str_replace("&rsquo;", "'", $val);
                        $val = str_replace("&nbsp;", "'", $val);
                        $val = str_replace("\r\n", "", $val);
                        $val = str_replace(";", "", $val);

                        switch ($field){
                            case "description_short":
                            case "description":
                                $v[] = (utf8_decode(html_entity_decode($val)));

                                //utf8_decode(html_entity_decode($val));
                                // //strip_tags($val);
                                // //utf8_decode(html_entity_decode($val));
                                break;
                            case "category":
                                $cat_v = [];
                                if($categories){
                                    foreach ($categories as $cat_){
                                        $cat_v[] = $cat_->getTranslation("name", $lang);
                                    }
                                }

                                if(count($cat_v)){
                                    $v[] = implode(",", $cat_v);
                                }else{
                                    $v[] = "";
                                }
                                break;

                            case "attachments":
                                $att_v = [];
                                if($attachments){
                                    foreach ($attachments as $cat_){
                                        $att_v[] = $cat_->getTranslation("file", $lang);
                                    }
                                }

                                if(count($att_v)){
                                    $v[] = implode(",", $att_v);
                                }else{
                                    $v[] = "";
                                }
                                break;

                            case "attachments_name":
                                $att_v = [];
                                if($attachments){
                                    foreach ($attachments as $cat_){
                                        $att_v[] = $cat_->getTranslation("name", $lang);
                                    }
                                }

                                if(count($att_v)){
                                    $v[] = implode(",", $att_v);
                                }else{
                                    $v[] = "";
                                }
                                break;

                            default:
                                $v[] = $val;
                                break;
                        }
                    }
                }

                if($product->brand_id){
                    $brand = PluginProductsBrands::find($product->brand_id);
                    if($brand){
                        $v[] = $brand->name;
                    }else{
                        $v[] = "";
                    }
                }else{
                    $v[] = "";
                }

                /*$catProd = PluginProductsCategoriesProducts::where("plugin_product_product_id", $product->id)->get();

                $v_cat_prod = [];
                if($catProd){
                    foreach ($catProd as $cp){
                        $category = PluginProductsCategories::find($cp->plugin_product_category_id);
                        if($category){
                            $v_cat_prod[] = $category->name;
                        }
                    }

                    if(count($v_cat_prod)){
                        $v[] = implode(",", $v_cat_prod);
                    }else{
                        $v[] = "";
                    }
                }else{
                    $v[] = "";
                }*/

                $v[] = $product->is_active;

                $images = PluginProductsImages::where("product_id", $product->id)->orderBy("order", "asc")->get()->pluck("image")->toArray();
                if(count($images)){
                    $v[] = implode(",", $images);
                }else{
                    $v[] = "";
                }

                $accessories = PluginProductsRelated::selectRaw("plugins_products.*")
                    ->join("plugins_products", "plugins_products.id", "=", "plugins_products_related.product_related_id")
                    ->where("product_id", $product->id)
                    ->get()->pluck("sku", "id")->toArray();
                if(count($accessories)){
                    $v[] = implode(",", $accessories);
                }else{
                    $v[] = "";
                }

                /*$attachments = PluginProductsAttachments::where("product_id", $product->id)
                    ->get()->pluck("file", "id")->toArray();
                if(count($attachments)){
                    $v[] = implode(",", $attachments);
                }else{
                    $v[] = "";
                } */

                if($adminPlugin->version > 1) {
                    $v[] = $product->price;
                    $v[] = $product->qty;
                    $v[] = $product->video;

                    $options = \DB::table("plugins_products_options")
                        ->selectRaw("plugins_products_attributes.name, plugins_products_options.attribute_id, plugins_products_options.value")
                        ->join("plugins_products_attributes", "plugins_products_attributes.id", "=", "plugins_products_options.attribute_id")
                        ->where("product_id", $product->id)
                        ->orderBy("plugins_products_options.lft", "asc")
                        ->get();

                    if ($options) {
                        $temp_opt = [];
                        foreach ($options as $opt) {
                            $temp_opt[] = "$opt->name|$opt->value";
                        }
                        $v[] = implode("#", $temp_opt);
                    } else {
                        $v[] = "";
                    }
                }

                if($adminPlugin->version == 3) {
                    $v[] = $product->tax->value;

                    $padre = PluginProducts::where("group_id", $product->group_id)->where("is_variant", 0)->first();
                    if($padre){
                        $v[] = $padre->sku;
                    }else{
                        $v[] = "";
                    }


                    $v[] = $product->code_article;
                    $v[] = $product->is_evidenza;
                    $v[] = $product->is_purchasable;
                    $v[] = $product->name_variant;

                    if($product->is_variant == 1){
                        $attributes = ShopAttributesOptions::join("shop_attributes_products", "shop_attributes_products.option_id", "=", "shop_attributes_options.id")
                            ->join("shop_attributes", "shop_attributes_options.shop_attribute_id", "=", "shop_attributes.id")
                            ->where("product_id", $product->id)
                            ->get();

                        if ($attributes) {
                            $temp_attr = [];
                            foreach ($attributes as $opt) {
                                $item_attribute = ShopAttributes::find($opt->shop_attribute_id);
                                if($item_attribute){
                                    $temp_attr[] = "$item_attribute->name|$opt->value";
                                }
                            }
                            $v[] = implode("#", $temp_attr);
                        } else {
                            $v[] = "";
                        }
                    }else{
                        $v[] = "";
                    }

                    /*if ($options) {
                        $temp_opt = [];
                        foreach ($options as $opt) {
                            $temp_opt[] = "$opt->name|$opt->value";
                        }
                        $v[] = implode("#", $temp_opt);
                    } else {
                        $v[] = "";
                    }*/

                    if($product->ean13){
                        $v[] = "'$product->ean13";
                    }else{
                        $v[] = "";
                    }

                    $v[] = $product->is_button_for_request;
                    $v[] = $product->form_page_id;
                }

              //  dump($v);

                $data[] = implode(";", $v);
                //dd($data);
            }
        }


        $csvFile = public_path() . "/plugins/pluginProducts/export.csv";
        $final_string = implode("\n",$data);


        file_put_contents($csvFile,$final_string);

        return redirect()->to(  "/plugins/pluginProducts/export.csv");
    }


    public function import(Request $req){
        /*
        PluginProducts::truncate();
        PluginProductsImages::truncate();
        PluginProductsRelated::truncate();
        PluginProductsAttachments::truncate();
        PluginProductsCategoriesProducts::truncate();
        ShopAttributesProducts::truncate();
           PluginProductsLangs::truncate();
        */

        $websiteSetting = WebsiteSetting::first();

        $langs = AdminLanguage::where("is_active", 1)->get()->pluck("name", "name")->toArray();

        $req->validate([
            'file' => 'required|max:20480'
        ]);

        if($req->file()) {
            $temp = explode("." , $req->file->getClientOriginalName());
            $fileName = "import.$temp[1]";
            $req->file('file')->storeAs('/', $fileName, 'public_plugin_products');

            $file = url("/plugins/pluginProducts/import.csv");
            $row = 1;
            if (($handle = fopen($file, "r")) !== FALSE) {
                while (($data = fgetcsv($handle, 10000, ";")) !== FALSE) {


                    //sku	name	permalink	brand	categories	price	qty	active	add_cart	is_variant	ean	weight	description	description_short	custom_field_1	custom_field_2	custom_field_3	images	product_url attachments category
                    if($row == 1){
                        $fields = $data;
                    }

                    if($row > 1){
                        $field_value = [];

                        foreach ($fields as $k=>$ff){
                            if(!key_exists($k, $data)){
                                continue;
                            }

                            $campo_lang = 0;
                            //è un campo traducibile?
                            foreach ($langs as $lang){

                                if(is_numeric(strpos($ff, "_$lang"))){

                                    $campo_lang = 1;
                                    $ff = trim(str_replace("_$lang", "", $ff));
                                    if($ff != "property"){
                                        if($ff == "description"){
                                            $field_value["$ff"]["$lang"] = trim(utf8_encode(html_entity_decode($data[$k])));
                                        }else{
                                            $field_value["$ff"]["$lang"] = trim(utf8_encode((html_entity_decode($data[$k]))));
                                        }
                                    }
                                }
                            }

                            /* $attachments = [];
                             $images = [];
                             $options = [];
                             $accessories = [];*/

                            if($campo_lang == 0){
                                switch ($ff){
                                    case "brand":
                                        if(trim($data[$k]) != ""){
                                            $brand = PluginProductsBrands::whereRaw("name LIKE '%\"it\":\"$data[$k]\"%'")->first();
                                            if(!$brand){
                                                $brand = PluginProductsBrands::create([
                                                    "name" => $data[$k],
                                                    "slug" => Str::slug($data[$k], '-'),
                                                    "is_active" => 0,
                                                    "created_at" => Carbon::now()->toDateTimeString()
                                                ]);
                                            }
                                            $field_value["brand_id"] = $brand ? $brand->id : null;
                                        }
                                        break;
                                    case "property":
                                        $options = explode("#", $data[$k]);
                                        break;
                                    case "images":
                                        $images = [];
                                        if(trim($data[$k]) != "") {
                                            $images = explode(",", $data[$k]);
                                        }
                                        break;
                                    case "accessories":
                                        $accessories = [];
                                        if(trim($data[$k]) != "") {
                                            $accessories = explode(",", $data[$k]);
                                        }
                                        break;
                                    case "attributes":
                                        $attributes = [];
                                        if(trim($data[$k]) != "") {
                                            $attributes = explode("#", $data[$k]);
                                        }
                                        break;
                                    case "tax":
                                        $tax = Tax::where("value", $data[$k])->first();
                                        $field_value["tax_id"] = $tax ? $tax->id : 1;
                                        break;
                                    case "ean13":
                                        if(trim($data[$k]) != ""){
                                            if($data[$k][0] == "'"){
                                                $field_value["ean13"] = substr($data[$k],1);
                                            }else{
                                                $field_value["ean13"] = substr($data[$k],0);
                                            }
                                        }
                                        break;
                                    case "parent_sku":
                                        if(trim($data[$k]) != ""){
                                            $padre = PluginProducts::where("sku", trim($data[$k]))->first();
                                            if($padre){
                                                $field_value["group_id"] = $padre->group_id;
                                                $field_value["is_variant"] = 1;
                                            }else{
                                                $group = PluginProducts::whereNotNull("group_id")->orderBy("group_id", "desc")->first();
                                                if($group){
                                                    $group_id = $group->group_id + 1;
                                                }else{
                                                    $group_id = 1;
                                                }
                                                $field_value["group_id"] = $group_id;
                                                $field_value["is_variant"] = 0;
                                            }
                                        }else{
                                            $group = PluginProducts::whereNotNull("group_id")->orderBy("group_id", "desc")->first();
                                            if($group){
                                                $group_id = $group->group_id + 1;
                                            }else{
                                                $group_id = 1;
                                            }
                                            $field_value["group_id"] = $group_id;
                                        }
                                        break;
                                    default:
                                        $field_value["$ff"] = $data[$k] == "" ? null : trim($data[$k]);
                                        break;
                                }
                            }
                        }

                        $categories = $field_value['category'];
                        $attachments = $field_value['attachments'];

                        $attachments_name = $field_value['attachments_name'];

                        unset($field_value['category']);
                        unset($field_value['attachments']);
                        unset($field_value['attachments_name']);


                        $sku = trim($data[0]); //sku
                        $product = PluginProducts::where("sku", $sku)->first();
                        if($product){
                            $field_value["group_id"] = $product->group_id;
                            $field_value["is_variant"] = $product->is_variant;
                        }

                        if($field_value){
                            foreach ($field_value as $k=>$v){
                                if(is_array($v)){
                                    $pieno = 0;
                                    foreach ($v as $k1=>$v1){
                                        if(trim($v1) != ""){
                                            $pieno++;
                                        }
                                    }

                                    if($pieno == 0){
                                        unset($field_value[$k]);
                                    }
                                }else{
                                    if($v === null){
                                        unset($field_value[$k]);
                                    }
                                }
                            }
                        }

                        if($product){
                            PluginProducts::where("sku", $sku)->update($field_value);
                            $product = PluginProducts::where("sku", $sku)->first();
                        }else{
                            if($sku == ""){
                                $padre = PluginProducts::where("is_variant", 0)->where("group_id", $field_value["group_id"])->first();

                                $v_sku_format = [];
                                $v_sku_format[] = $padre->sku;

                                $field_value["sku"] = "{$padre->sku}_XXXXXXXXXX";
                            }

                            $product = PluginProducts::create($field_value);
                        }

                        if($product->is_variant == 1){
                            if($padre){
                                $product->group_id = $padre->group_id;
                            }
                        }

                        //category
                        if($categories){
                            $v_cat_ids = [];
                            foreach ($categories as $category_item){
                                if(trim($category_item) != "") {
                                    $v_cat = explode("," , $category_item);
                                    if (count($v_cat)) {
                                        foreach ($v_cat as $cat) {
                                            $cat = trim($cat);
                                            //controlla categoria in ITALIANO se non esiste la crea altrimetni l'associa
                                            $category = PluginProductsCategories::whereRaw("name LIKE '%\"it\":\"$cat\"%'")->first();
                                            if (!$category) {
                                                $category = PluginProductsCategories::create([
                                                    "name" => $cat,
                                                    "slug" => Str::slug($cat, '-'),
                                                    "is_active" => 1,
                                                    "parent_id" => null,
                                                    "created_at" => Carbon::now()->toDateTimeString()
                                                ]);
                                            }
                                            $v_cat_ids[] = $category->id;
                                        }
                                    }
                                }
                                break;
                            }

                            if(count($v_cat_ids) > 0){
                                PluginProductsCategoriesProducts::where("plugin_product_product_id", $product->id)->delete();
                                foreach ($v_cat_ids as $cat_id){
                                    PluginProductsCategoriesProducts::create([
                                        "plugin_product_category_id" => $cat_id,
                                        "plugin_product_product_id" => $product->id
                                    ]);
                                }
                            }
                        }

                        //images
                        if($req->has('edit_foto')) {
                            if (count($images)) {
                                //qual'è il blocco thumb impostato per i prodotti?
                                $adminBlock = AdminBlock::where("name", "blockPluginProduct")->first();
                                $adminThumb = AdminThumb::where("admin_block_id", $adminBlock->id)->get();

                                $disk = config('backpack.base.root_disk_name');
                                $destination_path = "public/thumb/plugin_products";

                                PluginProductsImages::where("product_id", $product->id)->delete();

                                $order = 0;

                                foreach ($images as $image) {
                                    $image = trim($image);

                                    if (trim($image) != "") {
                                        if (file_exists($image)) {
                                            PluginProductsImages::insert([
                                                "product_id" => $product->id,
                                                "image" => $image,
                                                "order" => $order,
                                                "created_at" => Carbon::now()->toDateTimeString()
                                            ]);

                                            $value = $image;
                                            $basename = basename($value);
                                            $nameFile = explode(".", $basename);

                                            if (count($adminThumb)) {
                                                foreach ($adminThumb as $thumb) {
                                                    $image_temp = \Image::make($value)->encode('webp', 90);

                                                    if ($websiteSetting->watermark_url) {
                                                        $image_temp->insert(url($websiteSetting->watermark_url), $websiteSetting->watermark_position, $websiteSetting->watermark_x, $websiteSetting->watermark_y);
                                                    }

                                                    $width = $thumb->width_max != 0 ? $thumb->width_max : null;
                                                    $height = $thumb->height_max != 0 ? $thumb->height_max : null;
                                                    $suffix = $thumb->suffix;

                                                    $image_temp->fit($width, $height, function ($constraint) {
                                                        $constraint->upsize();
                                                    });

                                                    $filename = "$nameFile[0]-{$suffix}.webp";
                                                    \Storage::disk($disk)->put($destination_path . '/' . $filename, $image_temp->stream());
                                                }
                                            }

                                            $order++;
                                        }
                                    }
                                }
                            }
                        }

                        if(count($attachments)){

                            PluginProductsAttachments::where("product_id", $product->id)->delete();
                            if(key_exists("it", $attachments)){
                                $expl['it'] = explode(",", $attachments['it']);
                                $expl_name['it'] = explode(",", $attachments_name['it']);
                            }

                            if(key_exists("en", $attachments)){
                                $expl['en'] = explode(",", $attachments['en']);
                                $expl_name['en'] = explode(",", $attachments_name['en']);
                            }

                            if(count($expl)){
                                foreach ($expl as $k=>$vet){
                                    foreach ($vet as $k=>$v){
                                        $vet_names['it'] = $expl_name['it'][$k];
                                        $vet_names['en'] = $expl_name['en'][$k];

                                        $vet_files['it'] = $expl['it'][$k];
                                        $vet_files['en'] = $expl['en'][$k];


                                       $pieno = 0;
                                       foreach ($vet_files as $kF => $vF){
                                           if(trim($vF) != ""){
                                               $pieno++;
                                           }
                                       }

                                        if($pieno > 0){
                                            PluginProductsAttachments::insert([
                                                "product_id" => $product->id,
                                                "name" => json_encode($vet_names),
                                                "file" => json_encode($vet_files),
                                                "parent_id" => null,
                                                "created_at" => Carbon::now()->toDateTimeString()
                                            ]);
                                        }
                                    }
                                    break;
                                }
                            }
                        }

                        if(count($accessories)){
                            PluginProductsRelated::where("product_id", $product->id)->delete();
                            foreach ($accessories as $accessory){
                                if(trim($accessory) != ""){
                                    $related = PluginProducts::where("sku", $accessory)->first();
                                    if($related){
                                        PluginProductsRelated::insert([
                                            "product_id" => $product->id,
                                            "product_related_id" => $related->id,
                                            "created_at" => Carbon::now()->toDateTimeString()
                                        ]);
                                    }
                                }
                            }
                        }

                        //options
                        if(count($options)){
                            foreach ($options as $lang => $option){
                                $temp_opt = explode("|", $option);

                                $temp_opt[0] = trim($temp_opt[0]);

                                $attribute = PluginProductsAttributes::whereRaw("name LIKE '%$temp_opt[0]%'")->first();

                                if(!$attribute){
                                    \DB::table("plugins_products_attributes")->insert([
                                        "name" => trim($temp_opt[0])
                                    ]);

                                    $attribute = PluginProductsAttributes::whereRaw("name LIKE '%$temp_opt[0]%'")->first();
                                }

                                $check = PluginProductsOptions::where("product_id", $product->id)->where("attribute_id", $attribute->id)->first();
                                if(!$check){
                                    if(key_exists(1, $temp_opt)) {

                                        $item_option = new PluginProductsOptions();
                                        $item_option->product_id = $product->id;
                                        $item_option->attribute_id = $attribute->id;
                                        $item_option->value = json_decode($temp_opt[1], true);
                                        $item_option->save();

                                    }
                                }else{
                                    if(key_exists(1, $temp_opt)){
                                        $check->value = json_decode($temp_opt[1], true);
                                        $check->save();
                                    }

                                }
                            }
                        }

                        //attributes
                        if($product->is_variant == 1){
                            if(count($attributes)){
                                $v_options = [];

                                foreach ($attributes as $attribute){
                                    $temp_opt = explode("|", $attribute);

                                    $temp_opt[0] = trim($temp_opt[0]);
                                    $attribute = ShopAttributes::whereRaw("name LIKE '%\"it\":\"$temp_opt[0]\"%'")->first();

                                    if(!$attribute){
                                        $attribute = ShopAttributes::create([
                                            "name" => trim($temp_opt[0])
                                        ]);
                                    }

                                    if(count($v_cat_ids) > 0){
                                        foreach ($v_cat_ids as $cat_id) {
                                            $check = ShopAttributesCategories::where("shop_attribute_id", $attribute->id)->where("shop_category_id", $cat_id)->first();
                                            if (!$check) {
                                                ShopAttributesCategories::create(["shop_attribute_id" => $attribute->id, "shop_category_id" => $cat_id]);
                                            }
                                        }
                                    }

                                    $temp_opt[1] = trim($temp_opt[1]);
                                    $option = ShopAttributesOptions::whereRaw("value LIKE '%\"it\":\"$temp_opt[1]\"%'")
                                        ->where("shop_attribute_id", $attribute->id)
                                        ->first();
                                    if(!$option){
                                        $option = ShopAttributesOptions::create([
                                             "shop_attribute_id" => $attribute->id,
                                             "value" => trim($temp_opt[1]),
                                             "code" => \Str::slug(trim($temp_opt[1]))
                                        ]);
                                    }


                                    $v_sku_format[] = $option->code;

                                    if($attribute && $option){
                                        $check = ShopAttributesProducts::where("product_id", $product->id)
                                            ->where("attribute_id", $option->shop_attribute_id)
                                            ->where("option_id", $option->id)
                                            ->first();
                                        if(!$check){
                                            $check = ShopAttributesProducts::create([
                                                "product_id" => $product->id,
                                                "attribute_id" => $option->shop_attribute_id,
                                                "option_id" => $option->id
                                            ]);
                                        }

                                        $v_options[] = [
                                            "option_id" => $option->id
                                        ];
                                    }

                                    $product->options = json_encode($v_options);
                                    $product->save();
                                }

                                if($sku == "") {
                                    $product->sku = implode("_", $v_sku_format);
                                    $product->save();

                                    $duplicato_count = PluginProducts::where("sku", $product->sku)->orderBy("id", "asc")->count();

                                    if($duplicato_count > 1){
                                        PluginProducts::where("sku", $product->sku)
                                            ->where("id", "<", $product->id)
                                            ->delete();
                                    }
                                }
                            }
                        }

                        \Artisan::call('set:products_search', ['id'=> $product->id]);
                    }
                    $row++;
                }

                $langs = \App\Models\AdminLanguage::where("is_active", 1)->get()->pluck("name", "name")->toArray();
                $list = PluginProducts::get();
                if($list){
                    foreach ($list as $item){
                        foreach ($langs as $lang){
                            $check = PluginProductsLangs::where("product_id", $item->id)->where("lang", $lang)->first();
                            if(!$check){
                                PluginProductsLangs::create([
                                    "product_id" => $item->id,
                                    "lang" => "$lang",
                                    "is_active" => 1
                                ]);
                            }
                        }
                    }
                }
            }

            return back()
                ->with('success','File caricato con successo')
                ->with('file', $fileName);
        }
    }


    public function import_maison(Request $req){
        if($req->has('svuota')) {
            PluginProducts::truncate();
            PluginProductsImages::truncate();
            PluginProductsRelated::truncate();
            PluginProductsAttachments::truncate();
            PluginProductsCategoriesProducts::truncate();
            ShopAttributesProducts::truncate();
            PluginProductsPrices::truncate();
            PluginProductsLangs::truncate();
        }

        $v_attributes = ShopAttributes::orderBy("lft", "asc")->get()->pluck("id")->toArray();

        $req->validate([
            'file' => 'required|max:20480'
        ]);

        if($req->file()) {
            $temp = explode("." , $req->file->getClientOriginalName());
            $fileName = "import.$temp[1]";
            $req->file('file')->storeAs('/', $fileName, 'public_plugin_products');

            $file = url("/plugins/pluginProducts/import.csv");
            $row = 1;
            if (($handle = fopen($file, "r")) !== FALSE) {
                while (($data = fgetcsv($handle, 10000, ";")) !== FALSE) {
                    //sku	name	permalink	brand	categories	price	qty	active	add_cart	is_variant	ean	weight	description	description_short	custom_field_1	custom_field_2	custom_field_3	images	product_url

                    /*
                          0 => "Etichetta_1(it e en)"
                          1 => "categoria_en"
                          2 => "categoria_it"
                          3 => "nome modello principale"
                          4 => "codice articolo"
                          5 => "nome colore_en"
                          6 => "taglie"
                          7 => "SKU_en"
                          8 => "descrizione breve_en"
                          9 => "descrizione breve_it"
                          10 => "descrizione-lunga_en"
                          11 => "descrizione-lunga_it"
                          12 => "tags_en"
                          13 => "tags_it"
                          14 => b"prezzo €"
                          15 => "prezzo $"
                          16 => b"prezzo € SRP (retail)"
                          17 => "prezzo $ SRP (retail)"
                          18 => "images"
                          19 => "images_padre"
                          20 => "images_figli"
                          21 => "correlati"
                          22 => "delivery_start"
                          23 => "delivery_end",
                          24 => size chart
                          25 => "prezzo 2 €",
                          26 => "prezzo 2 € SRP"
                    */

                    if($row > 1){


                        $sku = trim($data[7]);
                        $v_sku = explode("_", $sku);


                        $tags_it = str_replace("|", ",", $data[13]);
                        $tags_en = str_replace("|", ",", $data[12]);

                        $slug_category = \Str::slug(trim($data[2]));

                        $category = PluginProductsCategories::whereRaw("slug LIKE '%\"$slug_category\"%'")->first();
                        if(!$category){
                            $category = PluginProductsCategories::create([
                                "name" => ["it" => trim($data[2]), "en" => trim($data[1])],
                                "slug" => ["it" => \Str::slug(trim($data[2])), "en" => \Str::slug(trim($data[1]))],
                                "is_active" => 1,
                                "parent_id" => null
                            ]);
                        }else{
                            $category->name = ["it" => trim($data[2]), "en" => trim($data[1])];
                            $category->slug = ["it" => \Str::slug(trim($data[2])), "en" => \Str::slug(trim($data[1]))];
                            $category->save();
                        }


                        //padre
                        $padre = PluginProducts::where("sku", $v_sku[0])->where("is_variant", 0)->first();
                        if(!$padre){
                            $group = PluginProducts::whereNotNull("group_id")->orderBy("group_id", "desc")->first();
                            if($group){
                                $group_id = $group->group_id + 1;
                            }else{
                                $group_id = 1;
                            }

                            $padre = PluginProducts::create([
                                "name" => ["it" => trim($data[3]), "en" => trim($data[3])],
                                "slug" => ["it" => \Str::slug(trim("$data[3]-it")), "en" => \Str::slug(trim("$data[3]-en"))],
                                "group_id" => $group_id,
                                "custom_1" => ["it" => trim($data[0]), "en" => trim($data[0])],
                                "description_short" => ["it" => trim($data[9]), "en" => trim($data[8])],
                                "description" => ["it" => trim($data[11]), "en" => trim($data[10])],
                                "sku" => $v_sku[0],
                                "code_article" => null,
                                "is_variant" => 0,
                                "is_purchasable" => 0,
                                "tax_id" => 5,
                                "price" => $data[14],
                                "price_dollar" => trim($data[15]) == "" ? null : $data[15],
                                "price_srp" => key_exists(16, $data) ? $data[16] : null,
                                "price_srp_dollar" =>  trim($data[17]) == "" ? null : $data[17],
                                "price_2" => key_exists(25, $data) ? $data[25] : null,
                                "price_2_srp" => key_exists(26, $data) ? $data[26] : null,
                                "tags" => ["it" => trim($tags_it), "en" => trim($tags_en)],
                                "is_active" => 1,
                                "qty" => 10000
                            ]);
                        }

                        //images padre
                        if($req->has('edit_foto')) {
                            if(key_exists(19, $data)){
                                $images = explode("|", $data[19]);
                                PluginProductsImages::where("product_id", $padre->id)->delete();
                                if ($images) {
                                    $i = 0;
                                    foreach ($images as $image) {
                                        if(trim($image) != ""){

                                            /*$temp = explode(".", $image);

                                            if (file_exists("uploads/products/import/$image")) {

                                                if (key_exists(1, $temp)) {
                                                    $checkImage = "thumb/plugin_products/$temp[0]-list.{$temp[1]}";
                                                } else {
                                                    $checkImage = "thumb/plugin_products/$temp[0]-list";
                                                }

                                                if (!file_exists($checkImage)) {
                                                    $disk = config('backpack.base.root_disk_name');
                                                    $destination_path = "public/thumb/plugin_products";

                                                    $value = "uploads/products/import/$image";
                                                    $basename = basename($value);
                                                    $nameFile = explode(".", $basename);

                                                    $image = \Image::make($value);
                                                    $image->fit(990, null, function ($constraint) {
                                                        $constraint->aspectRatio();
                                                    });
                                                    $filename = "$nameFile[0]-list.{$nameFile[1]}";
                                                    \Storage::disk($disk)->put($destination_path.'/'.$filename, $image->stream());

                                                    $image = \Image::make($value);
                                                    $image->fit(120, null, function ($constraint) {
                                                        $constraint->aspectRatio();
                                                    });
                                                    $filename = "$nameFile[0]-mini.{$nameFile[1]}";
                                                    \Storage::disk($disk)->put($destination_path.'/'.$filename, $image->stream());
                                                }
                                            }*/

                                            PluginProductsImages::insert([
                                                "product_id" => $padre->id,
                                                "image" => "uploads/products/import/$image",
                                                "order" => $i
                                            ]);
                                            $i++;
                                        }
                                    }
                                }
                            }
                        }

                        PluginProductsCategoriesProducts::where("plugin_product_product_id", $padre->id)->delete();
                        PluginProductsCategoriesProducts::insert([
                            "plugin_product_product_id" => $padre->id,
                            "plugin_product_category_id" => $category->id
                        ]);



                        $first_attribute = ShopAttributesOptions::where("value", $data[5])->where("shop_attribute_id", $v_attributes[0])->first();
                        if(!$first_attribute){
                            $first_attribute = ShopAttributesOptions::create([
                                "shop_attribute_id" => $v_attributes[0],
                                "value" => $data[5]
                            ]);
                        }

                        $second_attribute = ShopAttributesOptions::where("value", $data[6])->where("shop_attribute_id", $v_attributes[1])->first();
                        if(!$second_attribute){
                            $second_attribute = ShopAttributesOptions::create([
                                "shop_attribute_id" => $v_attributes[1],
                                "value" => $data[6]
                            ]);
                        }

                        $options = [];
                        $options[] = ["option_id" => $first_attribute->id];
                        $options[] = ["option_id" => $second_attribute->id];

                        $product = PluginProducts::where("sku", $sku)->first();
                        if(!$product){
                            $product = PluginProducts::create([
                                "name" => ["it" => trim($data[3]), "en" => trim($data[3])],
                                "slug" => ["it" => \Str::slug("$data[7]-it"), "en" => \Str::slug("$data[7]-en")],
                                "group_id" => $padre->group_id,
                                "custom_1" => ["it" => trim($data[0]), "en" => trim($data[0])],
                                "description_short" => ["it" => trim($data[9]), "en" => trim($data[8])],
                                "description" => ["it" => trim($data[11]), "en" => trim($data[10])],
                                "sku" => $sku,
                                "code_article" => $data[4],
                                "name_variant" => $data[5],
                                "options" => json_encode($options),
                                "is_variant" => 1,
                                "is_purchasable" => 1,
                                "tax_id" => 5,
                                "price" => $data[14],
                                "price_dollar" => trim($data[15]) == "" ? null : $data[15],
                                "price_srp" => $data[16],
                                "price_srp_dollar" => trim($data[17]) == "" ? null : $data[17],
                                "price_2" => key_exists(25, $data) ? $data[25] : null,
                                "price_2_srp" => key_exists(26, $data) ? $data[26] : null,
                                "tags" => ["it" => trim($tags_it), "en" => trim($tags_en)],
                                "is_active" => 1,
                                "qty" => 10000,
                                "delivery_start" => key_exists(22, $data) ? $data[22] : null,
                                "delivery_end" => key_exists(23, $data) ? $data[23] : null
                            ]);
                        }else{
                            if($req->has('edit_dati')) {
                                PluginProducts::where("id", $product->id)->update([
                                    "name" => ["it" => trim($data[3]), "en" => trim($data[3])],
                                    "slug" => ["it" => \Str::slug("$data[7]-it"), "en" => \Str::slug("$data[7]-en")],
                                    "custom_1" => ["it" => trim($data[0]), "en" => trim($data[0])],
                                    "description_short" => ["it" => trim($data[9]), "en" => trim($data[8])],
                                    "description" => ["it" => trim($data[11]), "en" => trim($data[10])],
                                    "sku" => $sku,
                                    "code_article" => $data[4],
                                    "name_variant" => $data[5],
                                    "options" => json_encode($options),
                                    "price" => $data[14],
                                    "price_dollar" => trim($data[15]) == "" ? null : $data[15],
                                    "price_srp" => $data[16],
                                    "price_srp_dollar" => trim($data[17]) == "" ? null : $data[17],
                                    "price_2" => key_exists(25, $data) ? $data[25] : null,
                                    "price_2_srp" => key_exists(26, $data) ? $data[26] : null,
                                    "tags" => ["it" => trim($tags_it), "en" => trim($tags_en)],
                                    "delivery_start" => key_exists(22, $data) ? $data[22] : null,
                                    "delivery_end" => key_exists(23, $data) ? $data[23] : null
                                ]);
                            }
                        }

                        PluginProductsPrices::where("figlio_id", $product->id)->delete();

                        PluginProductsPrices::insert([
                            "padre_id" => $padre->id,
                            "figlio_id" => $product->id,
                            "price" => $data[14],
                            "type_price" => "euro"
                        ]);

                        if(trim($data[15]) != ""){
                            PluginProductsPrices::insert([
                                "padre_id" => $padre->id,
                                "figlio_id" => $product->id,
                                "price" => $data[15],
                                "type_price" => "dollar"
                            ]);
                        }

                        if(key_exists(25, $data)){
                            PluginProductsPrices::insert([
                                "padre_id" => $padre->id,
                                "figlio_id" => $product->id,
                                "price" => $data[25],
                                "type_price" => "euro_2"
                            ]);
                        }



                        ShopAttributesProducts::where("product_id", $product->id)->delete();
                        ShopAttributesProducts::create([
                            "attribute_id" => $v_attributes[0],
                            "option_id" => $first_attribute->id,
                            "product_id" => $product->id
                        ]);

                        ShopAttributesProducts::create([
                            "attribute_id" => $v_attributes[1],
                            "option_id" => $second_attribute->id,
                            "product_id" => $product->id
                        ]);

                        PluginProductsCategoriesProducts::where("plugin_product_product_id", $product->id)->delete();
                        PluginProductsCategoriesProducts::insert([
                            "plugin_product_product_id" => $product->id,
                            "plugin_product_category_id" => $category->id
                        ]);

                        //images
                        if($req->has('edit_foto')) {

                            PluginProductsImages::where("product_id", $product->id)->delete();

                            //images_figlio
                            $imagesFiglio = explode("|", $data[20]);
                            if ($imagesFiglio) {
                                $i = 0;
                                $includi_padre = 0;
                                foreach ($imagesFiglio as $image) {
                                    //$image = "1611999042967csi.jpg";

                                    if (trim($image) != "") {
                                        /*$temp = explode(".", $image);

                                        if (file_exists("uploads/products/import/$image")) {

                                            if (key_exists(1, $temp)) {
                                                $checkImage = "thumb/plugin_products/$temp[0]-list.{$temp[1]}";
                                            } else {
                                                $checkImage = "thumb/plugin_products/$temp[0]-list";
                                            }

                                            if (!file_exists($checkImage)) {
                                                $disk = config('backpack.base.root_disk_name');
                                                $destination_path = "public/thumb/plugin_products";

                                                $value = "uploads/products/import/$image";
                                                $basename = basename($value);
                                                $nameFile = explode(".", $basename);

                                                $image = \Image::make($value);
                                                $image->fit(990, null, function ($constraint) {
                                                    $constraint->aspectRatio();
                                                });
                                                $filename = "$nameFile[0]-list.{$nameFile[1]}";
                                                \Storage::disk($disk)->put($destination_path.'/'.$filename, $image->stream());

                                                $image = \Image::make($value);
                                                $image->fit(120, null, function ($constraint) {
                                                    $constraint->aspectRatio();
                                                });
                                                $filename = "$nameFile[0]-mini.{$nameFile[1]}";
                                                \Storage::disk($disk)->put($destination_path.'/'.$filename, $image->stream());
                                            }
                                        }*/

                                        PluginProductsImages::insert([
                                            "product_id" => $product->id,
                                            "image" => "uploads/products/import/$image",
                                            "order" => $i
                                        ]);
                                        $i++;
                                    }
                                }
                            }

                            $images = explode("|", $data[18]);
                            if ($images) {
                                foreach ($images as $image) {
                                    if (trim($image) != "") {
                                        $basename = basename($image);
                                        $temp_img = explode("_", $basename);
                                        if (count($temp_img) == 2) {
                                            $includi_padre = 1;
                                        }
                                        PluginProductsImages::insert([
                                            "product_id" => $product->id,
                                            "image" => "uploads/products/import/$image",
                                            "order" => $i
                                        ]);
                                        $i++;
                                    }
                                }

                                if ($imagesFiglio[0] != "") {
                                    $includi_padre = 0;
                                }
                            }

                            $product->include_photo_padre = $includi_padre;
                            $product->save();

                            if(key_exists(24, $data)){
                                //size chart
                                if(trim($data[24]) != ""){
                                    PluginProductsImagesSize::where("product_id", $product->id)->delete();
                                    PluginProductsImagesSize::insert([
                                        "product_id" => $product->id,
                                        "image" => "uploads/products/size/$data[24]",
                                        "order" => 1
                                    ]);
                                }
                            }


                        }

                        //correlati
                        if($req->has('edit_correlati')) {
                            $related = explode("|", $data[21]);
                            PluginProductsRelated::whereRaw("product_id = $product->id OR product_related_id = $product->id")->delete();
                            if ($related) {
                                foreach ($related as $relSKU) {
                                    $productRel = PluginProducts::where("sku", $relSKU)->first();
                                    if ($productRel) {
                                        $check = PluginProductsRelated::where("product_id", $product->id)
                                            ->where("product_related_id", $productRel->id)->first();
                                        if (!$check) {
                                            PluginProductsRelated::insert([
                                                "product_id" => $product->id,
                                                "product_related_id" => $productRel->id,
                                                "created_at" => Carbon::now()->toDateTimeString()
                                            ]);
                                        }

                                        $check = PluginProductsRelated::where("product_id", $productRel->id)
                                            ->where("product_related_id", $product->id)->first();
                                        if (!$check) {
                                            PluginProductsRelated::insert([
                                                "product_id" => $productRel->id,
                                                "product_related_id" => $product->id,
                                                "created_at" => Carbon::now()->toDateTimeString()
                                            ]);
                                        }
                                    }
                                }
                            }
                        }


                    }
                    $row++;
                }
            }

            $langs = \App\Models\AdminLanguage::where("is_active", 1)->get()->pluck("name", "name")->toArray();
            $list = PluginProducts::get();
            if($list){
                foreach ($list as $item){
                    foreach ($langs as $lang){
                        $check = PluginProductsLangs::where("product_id", $item->id)->where("lang", $lang)->first();
                        if(!$check){
                            PluginProductsLangs::create([
                                "product_id" => $item->id,
                                "lang" => "$lang",
                                "is_active" => 1
                            ]);
                        }
                    }
                }
            }

            return back()
                ->with('success','File caricato con successo')
                ->with('file', $fileName);
        }
    }

    public function destroy($id)
    {
        $this->crud->hasAccessOrFail('delete');

        // get entry ID from Request (makes sure its the last ID for nested resources)
        $id = $this->crud->getCurrentEntryId() ?? $id;

        PluginProductsAttachments::where("product_id", $id)->delete();
        PluginProductsRelated::where("product_id", $id)->delete();
        PluginProductsImages::where("product_id", $id)->delete();
        PluginProductsOptions::where("product_id", $id)->delete();

        return $this->crud->delete($id);
    }

    public function actions(Request $request){
        $button = $request->get('button');
        if($button == "truncate"){
            PluginProducts::truncate();
            PluginProductsRelated::truncate();
            PluginProductsPrices::truncate();
            PluginProductsOptions::truncate();
            PluginProductsImagesSize::truncate();
            PluginProductsImages::truncate();
            PluginProductsAttachments::truncate();
            PluginProductsLangs::truncate();
            PluginProductsCategoriesProducts::truncate();
            ShopAttributesProducts::truncate();

            return redirect()->back();
        }

        $ids = $request->get('ids');
        if($ids == null){
            return redirect()->back();
        }
        switch ($button){
            case "delete_variants":
                $list = PluginProducts::withTrashed()->whereIn("id", $ids)->get();
                if($list) {
                    foreach ($list as $product) {
                        PluginProductsRelated::where("product_id", $product->id)->forceDelete();
                        PluginProductsOptions::where("product_id", $product->id)->forceDelete();
                        PluginProductsImagesSize::where("product_id", $product->id)->forceDelete();
                        PluginProductsImages::where("product_id", $product->id)->forceDelete();
                        PluginProductsAttachments::where("product_id", $product->id)->forceDelete();
                        PluginProductsLangs::where("product_id", $product->id)->forceDelete();
                        PluginProductsCategoriesProducts::where("plugin_product_product_id", $product->id)->forceDelete();
                        ShopAttributesProducts::where("product_id", $product->id)->forceDelete();

                        $product->delete();
                    }
                }
                break;

            case "delete":
                $list = PluginProducts::withTrashed()->whereIn("id", $ids)->get();

                if($list){
                    foreach ($list as $product){
                        $figli = PluginProducts::where("group_id", $product->group_id)->get();
                        if($figli){
                            foreach ($figli as $figlio){
                                PluginProductsRelated::where("product_id", $figlio->id)->forceDelete();
                                PluginProductsOptions::where("product_id", $figlio->id)->forceDelete();
                                PluginProductsImagesSize::where("product_id", $figlio->id)->forceDelete();
                                PluginProductsImages::where("product_id", $figlio->id)->forceDelete();
                                PluginProductsAttachments::where("product_id", $figlio->id)->forceDelete();
                                PluginProductsLangs::where("product_id", $figlio->id)->forceDelete();
                                ShopAttributesProducts::where("product_id", $figlio->id)->forceDelete();
                                PluginProductsCategoriesProducts::where("plugin_product_product_id", $figlio->id)->forceDelete();

                                $figlio->delete();
                            }
                        }

                        PluginProductsRelated::where("product_id", $product->id)->forceDelete();
                        PluginProductsOptions::where("product_id", $product->id)->forceDelete();
                        PluginProductsImagesSize::where("product_id", $product->id)->forceDelete();
                        PluginProductsImages::where("product_id", $product->id)->forceDelete();
                        PluginProductsAttachments::where("product_id", $product->id)->forceDelete();
                        PluginProductsLangs::where("product_id", $product->id)->forceDelete();
                        ShopAttributesProducts::where("product_id", $product->id)->forceDelete();
                        PluginProductsCategoriesProducts::where("plugin_product_product_id", $product->id)->forceDelete();
                        $product->delete();
                    }
                }
                break;

        }

        \Alert::success("Operazione effettuata con successo!")->flash();

        return redirect()->back();
    }

    public function generate_thumb($id)
    {
        \Artisan::call('set:products_search', ['id'=> $id]);


        \Alert::success("Operazione effettuata con successo!")->flash();
        return redirect()->back();
    }
}
