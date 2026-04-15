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
use App\Models\ShopSettings;
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

        $attribute = $this->getOrCreateAttribute($name_attribute_1);
        if(!$attribute){
            ShopAttributes::create([
                "name" => trim($name_attribute_1)
            ]);
        }

        $attribute = $this->getOrCreateAttribute($name_attribute_2);
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
            'file_special' => 'required|max:20480'
        ]);

        $config_id = (int) $req->get('config_id');
        $button = $req->get('submit');

        $shopSetting = ShopSettings::first();

        $langs = AdminLanguage::where("is_active", 1)->get()->pluck("name", "name")->toArray();

        if($req->file()) {
            $name_original = $req->file_special->getClientOriginalName();
            $extension = $req->file_special->getClientOriginalExtension();

            $fileName = "import.$extension";
            $req->file('file_special')->storeAs('/', $fileName, 'public_plugin_products');

            if($extension == "xlsx" || $extension == "xls"){
                if($config_id == 0){
                    // Legge tutte le righe come collection
                    $data = \Excel::toCollection(null, $req->file('file_special'))->first();

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

                    return response()->json([
                        "url" => "/admin/plugin/pluginProducts/import_export?id={$plugin->id}"
                    ]);

                    return redirect()->to("/admin/plugin/pluginProducts/import_export?id={$plugin->id}");
                }else{
                    if($button == "view"){
                        return response()->json([
                            "url" => "/admin/plugin/pluginProducts/import_export?id={$config_id}"
                        ]);

                        return redirect()->to("/admin/plugin/pluginProducts/import_export?id={$config_id}");
                    }

                    // Legge tutte le righe come collection
                    $data = \Excel::toCollection(null, $req->file('file_special'))->first();

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
                            $key = array_search(strtolower($k), $headers);
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

                        return response()->json([
                            "url" => "/admin/plugin/pluginProducts/import_export?id={$plugin->id}"
                        ]);

                        return redirect()->to("/admin/plugin/pluginProducts/import_export?id={$plugin->id}");

                    }else{
                        if($button == "view"){
                            return response()->json([
                                "url" => "/admin/plugin/pluginProducts/import_export?id={$config_id}"
                            ]);

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
                $productBySkuCache = [];
                $maxGroupId = (int) PluginProducts::whereNotNull("group_id")->max("group_id");
                $importedProductIds = [];

                $row = 1;
                foreach ($products as $k=>$product){

                    $images = null;
                    $categories = [];
                    $options_1 = [];
                    $options_2 = [];

                    foreach ($product as $field => $value){
                        $value = $this->normalizeImportedValue($value);
                        switch ($field){
                            case "options_1":
                                if(trim($value) != ""){
                                    $attribute = $this->getOrCreateAttribute($config->name_attribute_1);
                                    if($attribute){
                                        $v_opt = explode("," , $value);
                                        if (count($v_opt)) {
                                            foreach ($v_opt as $opt) {
                                                $cat = trim($opt);
                                                $option = $this->getOrCreateAttributeOption($attribute->id, $cat);
                                                $options_1[] = $option->id;
                                            }
                                        }
                                    }
                                }

                                unset($product[$field]);
                                break;

                            case "options_2":
                                if(trim($value) != ""){
                                    $attribute = $this->getOrCreateAttribute($config->name_attribute_2);
                                    if($attribute){
                                        $v_opt = explode("," , $value);
                                        if (count($v_opt)) {
                                            foreach ($v_opt as $opt) {
                                                $cat = trim($opt);
                                                $option = $this->getOrCreateAttributeOption($attribute->id, $cat);
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
                                    $brand = $this->getOrCreateBrand($value);
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
                                            $category = $this->getOrCreateCategory($cat);
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
                                            $category = $this->getOrCreateCategory($cat);
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
                                $tax = $this->getTaxByValue($value);
                                $product["tax_id"] = $tax ? $tax->id : 1;
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
                                    $padre = $this->getProductBySkuCached(trim($value), $productBySkuCache);
                                    if($padre){
                                        $field_value["group_id"] = $padre->group_id;
                                        $field_value["is_variant"] = 1;
                                    }else{
                                        $field_value["group_id"] = $this->nextGroupId($maxGroupId);
                                        $field_value["is_variant"] = 0;
                                    }
                                }else{
                                    $field_value["group_id"] = $this->nextGroupId($maxGroupId);
                                }
                                break;
                        }
                    }


                    if(!key_exists("qty", $product)){
                        $product["qty"] = 1000;
                    }

                    if(!key_exists("tax", $product)){
                        $tax = $this->getTaxByValue(22);
                        $product["tax_id"] = $tax->id; //22%
                    }

                    if(!key_exists("slug", $product)){
                        $product["slug"] = [];
                    }

                    $product["is_purchasable"] = $shopSetting->is_add_to_cart_list;

                    //CONTROLLO IL PARENT_SKU
                    $padre = null;
                    if(key_exists("parent_sku", $product) && ((!str_contains($product["parent_sku"], $product["sku"])) || $product['sku'] == "")){

                        if($product['parent_sku'] == "B110011"){
                            //dd($product, "aaa");
                        }

                        $padre = $this->getProductBySkuCached($product["parent_sku"], $productBySkuCache, true);
                        if(!$padre){
                            $group_id = $this->nextGroupId($maxGroupId);

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

                            $product['qty'] = 1000;

                            $product["is_purchasable"] = $shopSetting->is_add_to_cart_list;

                            $product['group_id'] = $group_id;
                            $skuTemp = $product['sku_temp'] ?? '';
                            unset($product['sku_temp']);
                            $padre = PluginProducts::create($product);
                            $this->rememberProductInSkuCache($padre, $productBySkuCache);
                            $importedProductIds[] = $padre->id;

                            if(count($categories) > 0){
                                PluginProductsCategoriesProducts::where("plugin_product_product_id", $padre->id)->delete();
                                $categoryRows = [];
                                foreach ($categories as $cat_id){
                                    $categoryRows[] = [
                                        "plugin_product_category_id" => $cat_id,
                                        "plugin_product_product_id" => $padre->id
                                    ];
                                }
                                if ($categoryRows) {
                                    PluginProductsCategoriesProducts::insert($categoryRows);
                                }
                            }

                            PluginProductsImages::where("product_id", $padre->id)->delete();
                            if($images){
                                $v_images = explode(",", $images);
                                if($v_images){
                                    $order = 0;
                                    $imageRows = [];
                                    foreach ($v_images as $image){
                                        $imageRows[] = [
                                            "product_id" => $padre->id,
                                            "is_ext" => 1,
                                            "image" => $image,
                                            "order" => $order,
                                            "created_at" => Carbon::now()->toDateTimeString()
                                        ];
                                        $order++;
                                    }
                                    if ($imageRows) {
                                        PluginProductsImages::insert($imageRows);
                                    }
                                }
                            }

                            $product['sku'] = $skuTemp;

                        }else{
                            if(trim($padre->name) == ""){
                                PluginProducts::where("id", $padre->id)->update(
                                    ["name" => $product['name']]
                                );
                            }

                            if(trim($padre->description) == ""){
                                PluginProducts::where("id", $padre->id)->update(
                                    ["description" => $product['description']]
                                );
                            }
                        }

                        // $product['include_photo_padre'] = 1;
                        $product['group_id'] = $padre->group_id;
                    }

                    //SE STA LA RIGA DEL PADRE vai avanti
                    if(isset($product['parent_sku'])){
                        if($product['parent_sku'] != "" && $product['sku'] == ""){
                            continue;
                        }
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

                    $product["is_purchasable"] = $shopSetting->is_add_to_cart_list;

                    $itemP = $this->getProductBySkuCached($product["sku"], $productBySkuCache);

                    if(key_exists("parent_sku", $product) && !$padre){
                        if(!$padre){

                            //controllo se per caso esiste il padre tramite parent_sku
                            $padre = $this->getProductBySkuCached($product["parent_sku"], $productBySkuCache, true);
                            if($padre){
                                $product['sku'] = "{$product['parent_sku']}_{$product['sku']}";
                                $product['slug'] = ["it" => \Str::slug("{$product['name']['it']} {$product['sku']}")];
                                $product['is_variant'] = 1;
                                $product['group_id'] = $padre->group_id;
                                unset($product['parent_sku']);

                                $itemP = $this->getProductBySkuCached($product["sku"], $productBySkuCache);
                            }
                        }

                        if(!$padre){
                            $product['sku'] = $product['parent_sku'];
                        }
                    }

                    if(!$itemP){
                        if(!key_exists("group_id", $product)){
                            $product['group_id'] = $this->nextGroupId($maxGroupId);
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

                        $product["is_purchasable"] = $shopSetting->is_add_to_cart_list;

                        $itemP = PluginProducts::create($product);
                        $this->rememberProductInSkuCache($itemP, $productBySkuCache);
                        $importedProductIds[] = $itemP->id;

                    }else{
                        if(key_exists("parent_sku", $product)){
                            unset($product['parent_sku']);
                        }

                        // Use model update to trigger translatable mutators/casts (eg. description JSON)
                        $itemP->update($product);
                        $this->rememberProductInSkuCache($itemP->fresh(), $productBySkuCache);
                        $itemP = $this->getProductBySkuCached($product["sku"], $productBySkuCache, false, true);
                        if($itemP){
                            $importedProductIds[] = $itemP->id;
                        }
                    }

                    if(count($categories) > 0){
                        PluginProductsCategoriesProducts::where("plugin_product_product_id", $itemP->id)->delete();
                        $categoryRows = [];
                        foreach ($categories as $cat_id){
                            $categoryRows[] = [
                                "plugin_product_category_id" => $cat_id,
                                "plugin_product_product_id" => $itemP->id
                            ];
                        }
                        if ($categoryRows) {
                            PluginProductsCategoriesProducts::insert($categoryRows);
                        }
                    }

                    //opzioni alla variante
                    ShopAttributesProducts::where("product_id", $itemP->id)->delete();

                    $v_options_json = [];
                    $attributeProductRows = [];
                    if(count($options_1) > 0){
                        foreach ($options_1 as $opt_id){
                            $option = $this->getAttributeOptionByIdCached($opt_id);
                            if($option){
                                $attributeProductRows[] = [
                                    "attribute_id" => $option->shop_attribute_id,
                                    "product_id" => $itemP->id,
                                    "option_id" => $opt_id
                                ];

                                $v_options_json[] = ["option_id" => $opt_id];
                            }
                        }
                    }

                    if(count($options_2) > 0){
                        foreach ($options_2 as $opt_id){
                            $option = $this->getAttributeOptionByIdCached($opt_id);
                            if($option){
                                $attributeProductRows[] = [
                                    "attribute_id" => $option->shop_attribute_id,
                                    "product_id" => $itemP->id,
                                    "option_id" => $opt_id
                                ];

                                $v_options_json[] = ["option_id" => $opt_id];
                            }
                        }
                    }
                    if ($attributeProductRows) {
                        ShopAttributesProducts::insert($attributeProductRows);
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
                            $imageRows = [];
                            foreach ($v_images as $image){
                                $imageRows[] = [
                                    "product_id" => $itemP->id,
                                    "is_ext" => 1,
                                    "image" => $image,
                                    "order" => $order,
                                    "created_at" => Carbon::now()->toDateTimeString()
                                ];

                                $order++;
                            }
                            if ($imageRows) {
                                PluginProductsImages::insert($imageRows);
                            }
                        }

                    }

                    $row++;

                    /*if($row == 150){
                        break;
                    }*/
                }
            }

            $importedProductIds = array_values(array_unique($importedProductIds ?? []));
            if (count($importedProductIds) > 0) {
                $langNames = array_keys($langs);
                $existingLangRows = PluginProductsLangs::whereIn("product_id", $importedProductIds)
                    ->whereIn("lang", $langNames)
                    ->get(["product_id", "lang"]);

                $existingMap = [];
                foreach ($existingLangRows as $existingRow) {
                    $existingMap[$existingRow->product_id . "|" . $existingRow->lang] = true;
                }

                $langRowsToInsert = [];
                foreach ($importedProductIds as $productId) {
                    foreach ($langNames as $lang) {
                        $mapKey = $productId . "|" . $lang;
                        if (!isset($existingMap[$mapKey])) {
                            $langRowsToInsert[] = [
                                "product_id" => $productId,
                                "lang" => (string) $lang,
                                "is_active" => 1
                            ];
                        }
                    }
                }

                if ($langRowsToInsert) {
                    PluginProductsLangs::insert($langRowsToInsert);
                }
            }

        }


        //ASSOCIAZIONE CATEGORIE TOTALI DELL'IMPORT COME CATEGORIE ATTRIBUTI
        if($categories_total && ($config->name_attribute_1 || $config->name_attribute_2)){
            if($config->name_attribute_1){
                $attribute = ShopAttributes::whereRaw("name LIKE '%\"it\":\"{$config->name_attribute_1}\"%'")->first();
                if(!$attribute){
                    $attribute = ShopAttributes::create([
                        "name" => trim($config->name_attribute_1)
                    ]);
                }

                foreach ($categories_total as $cat_id){
                    ShopAttributesCategories::create([
                       "shop_attribute_id" => $attribute->id,
                       "shop_category_id" => $cat_id
                    ]);
                }
            }

            if($config->name_attribute_2){
                $attribute = ShopAttributes::whereRaw("name LIKE '%\"it\":\"{$config->name_attribute_2}\"%'")->first();
                if(!$attribute){
                    $attribute = ShopAttributes::create([
                        "name" => trim($config->name_attribute_2)
                    ]);
                }

                foreach ($categories_total as $cat_id){
                    ShopAttributesCategories::create([
                        "shop_attribute_id" => $attribute->id,
                        "shop_category_id" => $cat_id
                    ]);
                }
            }
        }

        return response()->json([
            "url" => null,
            "message" => "Caricati $row righe"
        ]);

       // return redirect()->back()->withInput();

    }

    public function importSpecialPostImportActions(Request $req)
    {
        $runProductsSearch = (bool) $req->boolean('run_products_search');
        $runProductsCategoriesSearch = (bool) $req->boolean('run_products_categories_search');

        if (!$runProductsSearch && !$runProductsCategoriesSearch) {
            \Alert::warning("Nessuna operazione selezionata.")->flash();
            return redirect()->back();
        }

        $executed = [];
        if ($runProductsSearch) {
            \Artisan::call('set:products_search', ['id' => 0]);
            $executed[] = "set:products_search";
        }
        if ($runProductsCategoriesSearch) {
            \Artisan::call('set:products_categories_search');
            $executed[] = "set:products_categories_search";
        }

        \Alert::success("Operazioni post-import completate: " . implode(", ", $executed))->flash();
        return redirect()->back();
    }

    private function escapeLikeValue($value)
    {
        return str_replace(['\\', '%', '_'], ['\\\\', '\\%', '\\_'], trim((string) $value));
    }

    private function normalizeImportedValue($value)
    {
        if (is_object($value) && method_exists($value, '__toString')) {
            $value = (string) $value;
        }

        if (!is_string($value)) {
            return $value;
        }

        $value = trim($value);
        if ($value === '') {
            return $value;
        }

        // Prevent malformed UTF-8 from breaking translatable JSON fields.
        if (!preg_match('//u', $value)) {
            $converted = @iconv('Windows-1252', 'UTF-8//IGNORE', $value);
            if ($converted !== false && $converted !== '') {
                $value = $converted;
            }
        }

        return $value;
    }

    private function getOrCreateAttribute($name)
    {
        static $cache = [];
        $name = trim((string) $name);
        if ($name === '') {
            return null;
        }

        $key = Str::lower($name);
        if (isset($cache[$key])) {
            return $cache[$key];
        }

        $escaped = $this->escapeLikeValue($name);
        $attribute = ShopAttributes::whereRaw("name LIKE ?", ['%"it":"' . $escaped . '"%'])->first();
        if (!$attribute) {
            $attribute = ShopAttributes::create(["name" => $name]);
        }

        $cache[$key] = $attribute;
        return $attribute;
    }

    private function getOrCreateAttributeOption($attributeId, $value)
    {
        static $cache = [];
        $value = trim((string) $value);
        if ($value === '' || !$attributeId) {
            return null;
        }

        $key = $attributeId . ':' . Str::lower($value);
        if (isset($cache[$key])) {
            return $cache[$key];
        }

        $escaped = $this->escapeLikeValue($value);
        $option = ShopAttributesOptions::where("shop_attribute_id", $attributeId)
            ->whereRaw("value LIKE ?", ['%"it":"' . $escaped . '"%'])
            ->first();

        if (!$option) {
            $option = ShopAttributesOptions::create([
                "shop_attribute_id" => $attributeId,
                "value" => $value,
                "created_at" => Carbon::now()->toDateTimeString()
            ]);
        }

        $cache[$key] = $option;
        return $option;
    }

    private function getOrCreateBrand($value)
    {
        static $cache = [];
        $value = trim((string) $value);
        if ($value === '') {
            return null;
        }

        $key = Str::lower($value);
        if (isset($cache[$key])) {
            return $cache[$key];
        }

        $escaped = $this->escapeLikeValue($value);
        $brand = PluginProductsBrands::whereRaw("name LIKE ?", ['%"it":"' . $escaped . '"%'])->first();
        if (!$brand) {
            $brand = PluginProductsBrands::create([
                "name" => $value,
                "slug" => Str::slug($value, '-'),
                "is_active" => 1,
                "created_at" => Carbon::now()->toDateTimeString()
            ]);
        }

        $cache[$key] = $brand;
        return $brand;
    }

    private function getOrCreateCategory($value)
    {
        static $cache = [];
        $value = trim((string) $value);
        if ($value === '') {
            return null;
        }

        $key = Str::lower($value);
        if (isset($cache[$key])) {
            return $cache[$key];
        }

        $escaped = $this->escapeLikeValue($value);
        $category = PluginProductsCategories::whereRaw("name LIKE ?", ['%"it":"' . $escaped . '"%'])->first();
        if (!$category) {
            $category = PluginProductsCategories::create([
                "name" => $value,
                "slug" => Str::slug($value, '-'),
                "is_active" => 1,
                "parent_id" => null,
                "created_at" => Carbon::now()->toDateTimeString()
            ]);
        }

        $cache[$key] = $category;
        return $category;
    }

    private function getTaxByValue($value)
    {
        static $cache = [];
        $key = (string) $value;
        if (array_key_exists($key, $cache)) {
            return $cache[$key];
        }

        $cache[$key] = Tax::where("value", $value)->first();
        return $cache[$key];
    }

    private function nextGroupId(&$maxGroupId)
    {
        $maxGroupId = (int) $maxGroupId + 1;
        return $maxGroupId;
    }

    private function getProductBySkuCached($sku, array &$cache, $onlyNonVariant = false, $forceRefresh = false)
    {
        $sku = trim((string) $sku);
        if ($sku === '') {
            return null;
        }

        $cacheKey = ($onlyNonVariant ? 'base:' : 'all:') . $sku;
        if (!$forceRefresh && array_key_exists($cacheKey, $cache)) {
            return $cache[$cacheKey];
        }

        $query = PluginProducts::where("sku", $sku);
        if ($onlyNonVariant) {
            $query->where("is_variant", 0);
        }
        $cache[$cacheKey] = $query->first();

        return $cache[$cacheKey];
    }

    private function rememberProductInSkuCache($product, array &$cache)
    {
        if (!$product || !isset($product->sku)) {
            return;
        }

        $cache['all:' . $product->sku] = $product;
        if ((int) $product->is_variant === 0) {
            $cache['base:' . $product->sku] = $product;
        }
    }

    private function getAttributeOptionByIdCached($id)
    {
        static $cache = [];
        $id = (int) $id;
        if ($id <= 0) {
            return null;
        }

        if (array_key_exists($id, $cache)) {
            return $cache[$id];
        }

        $cache[$id] = ShopAttributesOptions::find($id);
        return $cache[$id];
    }
}
