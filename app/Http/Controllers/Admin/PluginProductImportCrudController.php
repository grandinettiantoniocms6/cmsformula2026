<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PluginProductImportRequest;
use App\Models\AdminLanguage;
use App\Models\PluginProductImport;
use App\Models\PluginProducts;
use App\Models\PluginProductsBrands;
use App\Models\PluginProductsCategories;
use App\Models\PluginProductsCategoriesProducts;
use App\Models\PluginProductsImages;
use App\Models\PluginProductsLangs;
use App\Models\PluginProductsOptions;
use App\Models\ShopAttributes;
use App\Models\ShopAttributesCategories;
use App\Models\ShopAttributesOptions;
use App\Models\ShopAttributesProducts;
use App\Models\Tax;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * Class PluginProductImportCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PluginProductImportCrudController extends CrudController
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
        CRUD::setModel(\App\Models\PluginProductImport::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/plugin-product-import');
        CRUD::setEntityNameStrings('Import configurazione', 'Import configurazioni');
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

        // Columns.
        $this->crud->setColumns([
            [
                'name'  => 'name',
                'label' => 'Nome',
                'type'  => 'text',
            ],
        ]);
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(PluginProductImportRequest::class);
        CRUD::setFromDb(); // set fields from db columns.

        /**
         * Fields can be defined using the fluent syntax:
         * - CRUD::field('price')->type('number');
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

    public function importSpecialMappingSave(Request $req)
    {
        //campi obbligatori
        $fields = [
            "sku",
            "name",
            "category",
            "price",
        ];

        $id = $req->get('id');
        $name = $req->get('name');
        $mapping = $req->get('mapping');

        $name_attribute_1 = $req->get('name_attribute_1');
        $name_attribute_2 = $req->get('name_attribute_2');

        $attribute = ShopAttributes::whereRaw("name LIKE '%\"it\":\"$name_attribute_1\"%'")->first();
        if(!$attribute){
            ShopAttributes::create([
                "name" => trim($name_attribute_1)
            ]);
        }

        $attribute = ShopAttributes::whereRaw("name LIKE '%\"it\":\"$name_attribute_2\"%'")->first();
        if(!$attribute){
            ShopAttributes::create([
                "name" => trim($name_attribute_2)
            ]);
        }

        $error = "";
        foreach ($fields as $field){
            if(!in_array($field, $mapping)){
                $error .= "<br>$field";
            }
        }

        if(trim($error) != ""){
            return back()
                ->withInput()
                ->with('error', "Campi obbligatori nel mapping: <br>$error");
        }

        $config = PluginProductImport::find($id);
        $config->name = $name;
        $config->name_attribute_1 = $name_attribute_1;
        $config->name_attribute_2 = $name_attribute_2;
        $config->mapping = json_encode($mapping);
        $config->save();

        \Alert::success("Operazione effettuata con successo!")->flash();
        return redirect()->to("/admin/plugin/pluginProducts/import_export");

    }

    public function importSpecialMapping(Request $req)
    {
        $req->validate([
            'file' => 'required|max:20480'
        ]);

        $config_id = (int) $req->get('config_id');
        $button = $req->get('submit');

        $langs = AdminLanguage::where("is_active", 1)->get()->pluck("name", "name")->toArray();

        if($req->file()) {
            $name_original = $req->file->getClientOriginalName();
            $extension = $req->file->getClientOriginalExtension();

            $fileName = "import.$extension";
            $req->file('file')->storeAs('/', $fileName, 'public_plugin_products');

            if($extension == "xlsx" || $extension == "xls"){
                if($config_id == 0){
                    // Legge tutte le righe come collection
                    $data = \Excel::toCollection(null, $req->file('file'))->first();

                    // Prima riga come intestazioni
                    $headers = array_map('strtolower', $data->shift()->toArray());
                    $result = [];
                    foreach ($headers as $field) {
                        $result[$field] = null;
                    }

                    $plugin = PluginProductImport::create([
                        "name" => "$name_original",
                        "mapping" => json_encode($result)
                    ]);

                    return redirect()->to("/admin/plugin/pluginProducts/import_export?id={$plugin->id}");
                }else{
                    if($button == "view"){
                        return redirect()->to("/admin/plugin/pluginProducts/import_export?id={$config_id}");
                    }

                    // Legge tutte le righe come collection
                    $data = \Excel::toCollection(null, $req->file('file'))->first();

                    // Prima riga come intestazioni
                    $headers = array_map('strtolower', $data->shift()->toArray());
                    $rows = $data->map(function ($row) use ($headers) {
                        return array_combine($headers, $row->toArray());
                    });

                    $config = PluginProductImport::find($config_id);
                    $v_mapping = json_decode($config->mapping, true);

                    $mapping = [];
                    //mi creo mapping per chiave valore
                    foreach ($v_mapping as $k=>$v){
                        if($v){
                            $key = array_search($k, $headers);
                            $mapping[$key] = $v;
                        }
                    }

                    $row = 1;
                    $products = [];
                    $categories_total = [];

                   foreach ($rows as $values){
                       $data = array_values($values);
                       foreach ($mapping as $k=>$v){
                            $products[$row][$v] = $data[$k];
                       }
                       $row++;
                    }
                }
            }else{
                $file = url("/plugins/pluginProducts/import.csv");
                if (($handle = fopen($file, "r")) !== FALSE) {
                    while (($data = fgetcsv($handle, 10000, ";")) !== FALSE) {
                        break;
                    }

                    if($config_id == 0){
                        $result = [];
                        foreach ($data as $field) {
                            $result[$field] = null;
                        }

                        $plugin = PluginProductImport::create([
                            "name" => "Temp name",
                            "mapping" => json_encode($result)
                        ]);

                        return redirect()->to("/admin/plugin/pluginProducts/import_export?id={$plugin->id}");

                    }else{
                        if($button == "view"){
                            return redirect()->to("/admin/plugin/pluginProducts/import_export?id={$config_id}");
                        }

                        $config = PluginProductImport::find($config_id);
                        $v_mapping = json_decode($config->mapping, true);

                        $row = 1;
                        $mapping = [];

                        $products = [];
                        $categories_total = [];

                        if (($handle = fopen($file, "r")) !== FALSE) {
                            while (($data = fgetcsv($handle, 10000, ";")) !== FALSE) {
                                if($row == 1){
                                    //mi creo mapping per chiave valore
                                    foreach ($v_mapping as $k=>$v){
                                        if($v){
                                            $key = array_search($k, $data);
                                            $mapping[$key] = $v;
                                        }
                                    }
                                    $row++;
                                    continue;
                                }

                                foreach ($mapping as $k=>$v){
                                    $products[$row][$v] = $data[$k];
                                }
                                $row++;
                            }
                        }
                    }

                }
            }

            if(count($products)){

                $row = 1;
                foreach ($products as $k=>$product){

                    $images = null;
                    $categories = [];
                    $options_1 = [];
                    $options_2 = [];

                    foreach ($product as $field => $value){
                        switch ($field){
                            case "options_1":
                                if(trim($value) != ""){
                                    $attribute = ShopAttributes::whereRaw("name LIKE '%\"it\":\"{$config->name_attribute_1}\"%'")->first();
                                    if($attribute){
                                        $v_opt = explode("," , $value);
                                        if (count($v_opt)) {
                                            foreach ($v_opt as $opt) {
                                                $cat = trim($opt);
                                                $option = ShopAttributesOptions::whereRaw("value LIKE '%\"it\":\"$opt\"%'")->first();
                                                if (!$option) {
                                                    $option = ShopAttributesOptions::create([
                                                        "shop_attribute_id" => $attribute->id,
                                                        "value" => $cat,
                                                        "created_at" => Carbon::now()->toDateTimeString()
                                                    ]);
                                                }
                                                $options_1[] = $option->id;
                                            }
                                        }
                                    }
                                }

                                unset($product[$field]);
                                break;

                            case "options_2":
                                if(trim($value) != ""){
                                    $attribute = ShopAttributes::whereRaw("name LIKE '%\"it\":\"{$config->name_attribute_2}\"%'")->first();
                                    if($attribute){
                                        $v_opt = explode("," , $value);
                                        if (count($v_opt)) {
                                            foreach ($v_opt as $opt) {
                                                $cat = trim($opt);
                                                $option = ShopAttributesOptions::whereRaw("value LIKE '%\"it\":\"$opt\"%'")->first();
                                                if (!$option) {
                                                    $option = ShopAttributesOptions::create([
                                                        "shop_attribute_id" => $attribute->id,
                                                        "value" => $cat,
                                                        "created_at" => Carbon::now()->toDateTimeString()
                                                    ]);
                                                }
                                                $options_2[] = $option->id;
                                            }
                                        }
                                    }
                                }
                                unset($product[$field]);
                                break;

                            case "images":
                                if(trim($value) != ""){
                                    $images = $value;
                                }
                                unset($product[$field]);
                                break;
                            case "name":
                                $product['name'] = ["it" => $value];
                                break;
                            case "slug":
                                $product['slug'] = ["it" => $value];
                                break;
                            case "meta_title":
                                $product['meta_title'] = ["it" => $value];
                                break;
                            case "meta_description":
                                $product['meta_description'] = ["it" => $value];
                                break;
                            case "meta_key":
                                $product['meta_key'] = ["it" => $value];
                                break;
                            case "description_short":
                                $product['description_short'] = ["it" => $value];
                                break;
                            case "description":
                                $product['description'] = ["it" => $value];
                                break;
                            case "tags":
                                $product['tags'] = ["it" => $value];
                                break;
                            case "custom_1":
                                $product['custom_1'] = ["it" => $value];
                                break;
                            case "custom_2":
                                $product['custom_2'] = ["it" => $value];
                                break;
                            case "brand":
                                if(trim($value) != ""){
                                    $brand = PluginProductsBrands::whereRaw("name LIKE '%\"it\":\"$data[$k]\"%'")->first();
                                    if(!$brand){
                                        $brand = PluginProductsBrands::create([
                                            "name" => $data[$k],
                                            "slug" => Str::slug($data[$k], '-'),
                                            "is_active" => 0,
                                            "created_at" => Carbon::now()->toDateTimeString()
                                        ]);
                                    }
                                    $product["brand_id"] = $brand ? $brand->id : null;
                                }
                                unset($product[$field]);
                                break;
                            case "category":
                                if(trim($value) != ""){
                                    $v_cat = explode("," , $value);
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
                                            $categories[] = $category->id;
                                            $categories_total[$category->id] = $category->id;
                                        }
                                    }
                                }
                                unset($product[$field]);
                                break;
                            case "subcategory":
                                if(trim($value) != ""){
                                    $v_cat = explode("," , $value);
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
                                            $categories[] = $category->id;
                                            $categories_total[$category->id] = $category->id;
                                        }
                                    }
                                }
                                unset($product[$field]);
                                break;
                            case "property":
                                $options = explode("#", $value);
                                unset($product[$field]);
                                break;
                            case "images":
                                $images = [];
                                if(trim($value) != "") {
                                    $images = explode(",", $value);
                                }
                                unset($product[$field]);
                                break;
                            case "accessories":
                                $accessories = [];
                                if(trim($value) != "") {
                                    $accessories = explode(",", $value);
                                }
                                unset($product[$field]);
                                break;
                            case "attributes":
                                $attributes = [];
                                if(trim($value) != "") {
                                    $attributes = explode("#", $value);
                                }
                                unset($product[$field]);
                                break;
                            case "tax":
                                $tax = Tax::where("value", $value)->first();
                                $products["tax_id"] = $tax ? $tax->id : 1;
                                unset($product[$field]);
                                break;
                            case "ean13":
                                if(trim($value) != ""){
                                    if($value[0] == "'"){
                                        $product["ean13"] = substr($value,1);
                                    }else{
                                        $product["ean13"] = substr($value,0);
                                    }
                                }
                                break;
                            case "parent_sku":
                                if(trim($value) != ""){
                                    $padre = PluginProducts::where("sku", trim($value))->first();
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
                        }
                    }


                    if(!key_exists("qty", $product)){
                        $product["qty"] = 1000;
                    }

                    if(!key_exists("tax", $product)){
                        $tax = Tax::where("value", 22)->first();
                        $product["tax_id"] = $tax->id; //22%
                    }

                    if(!key_exists("slug", $product)){
                        $product["slug"] = [];
                    }

                    //CONTROLLO IL PARENT_SKU
                    $padre = null;
                    if(key_exists("parent_sku", $product) && ((!str_contains($product["parent_sku"], $product["sku"])) || $product['sku'] == "")){

                        if($product['parent_sku'] == "B110011"){
                            //dd($product, "aaa");
                        }

                        $padre = PluginProducts::where("sku", $product["parent_sku"])->where("is_variant", 0)->first();
                        if(!$padre){
                            $group = PluginProducts::whereNotNull("group_id")->orderBy("group_id", "desc")->first();
                            if($group){
                                $group_id = $group->group_id + 1;
                            }else{
                                $group_id = 1;
                            }

                            $product['sku_temp'] = $product['sku'];
                            $product['sku'] = $product['parent_sku'];

                            if(trim($product['sku']) != ""){
                                $product['slug'] = ["it" => \Str::slug("{$product['name']['it']} {$product['sku']}")];
                            }else{
                                $product['slug'] = ["it" => \Str::slug("{$product['name']['it']} {$product['parent_sku']}")];
                            }

                            foreach ($langs as $lang) {
                                if($lang != "it"){
                                    $product['name'][$lang] = null;
                                    $product['slug'][$lang] = null;
                                    $product['meta_title'][$lang] = null;
                                    $product['meta_description'][$lang] = null;
                                    $product['meta_key'][$lang] = null;
                                    $product['description'][$lang] = null;
                                    $product['description_short'][$lang] = null;
                                }
                            }

                            if(!key_exists('is_active', $product)){
                                $product['is_active'] = 1;
                            }

                            $product['group_id'] = $group_id;
                            $padre = PluginProducts::create($product);

                            if(count($categories) > 0){
                                PluginProductsCategoriesProducts::where("plugin_product_product_id", $padre->id)->delete();
                                foreach ($categories as $cat_id){
                                    PluginProductsCategoriesProducts::create([
                                        "plugin_product_category_id" => $cat_id,
                                        "plugin_product_product_id" => $padre->id
                                    ]);
                                }
                            }

                            PluginProductsImages::where("product_id", $padre->id)->delete();
                            if($images){
                                $v_images = explode(",", $images);
                                if($v_images){
                                    $order = 0;
                                    foreach ($v_images as $image){
                                        PluginProductsImages::insert([
                                            "product_id" => $padre->id,
                                            "is_ext" => 1,
                                            "image" => $image,
                                            "order" => $order,
                                            "created_at" => Carbon::now()->toDateTimeString()
                                        ]);
                                        $order++;
                                    }
                                }
                            }

                            $product['sku'] = $product['sku_temp'];

                        }

                        // $product['include_photo_padre'] = 1;
                        $product['group_id'] = $padre->group_id;
                    }


                    //SE STA LA RIGA DEL PADRE vai avanti
                    if($product['parent_sku'] != "" && $product['sku'] == ""){
                        continue;
                    }

                    $product['is_variant'] = 0;
                    if($padre){
                        $product['sku'] = "{$product['parent_sku']}_{$product['sku']}";
                        $product['is_variant'] = 1;
                        unset($product['parent_sku']);
                    }

                    if(trim($product['sku']) != ""){
                        $product['slug'] = ["it" => \Str::slug("{$product['name']['it']} {$product['sku']}")];
                    }else{
                        $product['slug'] = ["it" => \Str::slug("{$product['name']['it']} {$product['parent_sku']}")];
                    }

                    $itemP = PluginProducts::where("sku", $product["sku"])->first();

                    if(key_exists("parent_sku", $product) && !$padre){
                        if(!$padre){

                            //controllo se per caso esiste il padre tramite parent_sku
                            $padre = PluginProducts::where("sku", $product["parent_sku"])->where("is_variant", 0)->first();
                            if($padre){


                                $product['sku'] = "{$product['parent_sku']}_{$product['sku']}";
                                $product['slug'] = ["it" => \Str::slug("{$product['name']['it']} {$product['sku']}")];
                                $product['is_variant'] = 1;
                                $product['group_id'] = $padre->group_id;
                                unset($product['parent_sku']);

                                $itemP = PluginProducts::where("sku", $product["sku"])->first();
                            }
                        }

                        if(!$padre){
                            $product['sku'] = $product['parent_sku'];
                        }

                    }

                    if(!$itemP){
                        if(!key_exists("group_id", $product)){
                            $group = PluginProducts::whereNotNull("group_id")->orderBy("group_id", "desc")->first();
                            if($group){
                                $group_id = $group->group_id + 1;
                            }else{
                                $group_id = 1;
                            }

                            $product['group_id'] = $group_id;
                        }

                        foreach ($langs as $lang) {
                            if($lang != "it"){
                                $product['name'][$lang] = null;
                                $product['slug'][$lang] = null;
                                $product['meta_title'][$lang] = null;
                                $product['meta_description'][$lang] = null;
                                $product['meta_key'][$lang] = null;
                                $product['description'][$lang] = null;
                                $product['description_short'][$lang] = null;
                            }
                        }

                        if(!key_exists('is_active', $product)){
                            $product['is_active'] = 1;
                        }

                        $itemP = PluginProducts::create($product);

                    }else{
                        if(key_exists("parent_sku", $product)){
                            unset($product['parent_sku']);
                        }

                        PluginProducts::where("id", $itemP->id)->update($product);
                        $itemP = PluginProducts::where("sku", $product["sku"])->first();
                    }

                    if(count($categories) > 0){
                        PluginProductsCategoriesProducts::where("plugin_product_product_id", $itemP->id)->delete();
                        foreach ($categories as $cat_id){
                            PluginProductsCategoriesProducts::create([
                                "plugin_product_category_id" => $cat_id,
                                "plugin_product_product_id" => $itemP->id
                            ]);
                        }
                    }

                    //opzioni alla variante
                    ShopAttributesProducts::where("product_id", $itemP->id)->delete();

                    $v_options_json = [];
                    if(count($options_1) > 0){
                        foreach ($options_1 as $opt_id){
                            $option = ShopAttributesOptions::find($opt_id);
                            if($option){
                                ShopAttributesProducts::create([
                                    "attribute_id" => $option->shop_attribute_id,
                                    "product_id" => $itemP->id,
                                    "option_id" => $opt_id
                                ]);

                                $v_options_json[] = ["option_id" => $opt_id];
                            }
                        }
                    }

                    if(count($options_2) > 0){
                        foreach ($options_2 as $opt_id){
                            $option = ShopAttributesOptions::find($opt_id);
                            if($option){
                                ShopAttributesProducts::create([
                                    "attribute_id" => $option->shop_attribute_id,
                                    "product_id" => $itemP->id,
                                    "option_id" => $opt_id
                                ]);

                                $v_options_json[] = ["option_id" => $opt_id];
                            }
                        }
                    }

                    if(count($v_options_json)){
                        $itemP->options = json_encode($v_options_json);
                        $itemP->save();
                    }

                    //IMAGESSSS
                    PluginProductsImages::where("product_id", $itemP->id)->delete();
                    if($images){
                        $v_images = explode(",", $images);
                        if($v_images){
                            $order = 0;
                            foreach ($v_images as $image){
                                PluginProductsImages::insert([
                                    "product_id" => $itemP->id,
                                    "is_ext" => 1,
                                    "image" => $image,
                                    "order" => $order,
                                    "created_at" => Carbon::now()->toDateTimeString()
                                ]);

                                $order++;
                            }
                        }

                    }



                    $row++;

                    if($row == 150){
                        break;
                    }
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

            \Artisan::call('set:products_search', ['id'=> 0]);
            \Artisan::call('set:products_categories_search');
        }


        //ASSOCIAZIONE CATEGORIE TOTALI DELL'IMPORT COME CATEGORIE ATTRIBUTI
        if($categories_total && ($config->name_attribute_1 || $config->name_attribute_2)){
            if($config->name_attribute_1){
                $attribute = ShopAttributes::whereRaw("name LIKE '%\"it\":\"{$config->name_attribute_1}\"%'")->first();
                foreach ($categories_total as $cat_id){
                    ShopAttributesCategories::create([
                       "shop_attribute_id" => $attribute->id,
                       "shop_category_id" => $cat_id
                    ]);
                }
            }

            if($config->name_attribute_2){
                $attribute = ShopAttributes::whereRaw("name LIKE '%\"it\":\"{$config->name_attribute_2}\"%'")->first();
                foreach ($categories_total as $cat_id){
                    ShopAttributesCategories::create([
                        "shop_attribute_id" => $attribute->id,
                        "shop_category_id" => $cat_id
                    ]);
                }
            }
        }
        die;

        return redirect()->back()->withInput();

    }
}
