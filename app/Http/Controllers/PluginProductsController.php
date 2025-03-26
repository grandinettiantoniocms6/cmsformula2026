<?php


namespace App\Http\Controllers;


use App\Http\Requests\PluginProductsRequest;
use App\Models\AdminBlock;
use App\Models\AdminLanguage;
use App\Models\BlockContact;
use App\Models\BlockNews;
use App\Models\Cart;
use App\Models\Page;
use App\Models\PageBlock;
use App\Models\PluginProducts;
use App\Models\PluginProductsAttachments;
use App\Models\PluginProductsBrands;
use App\Models\PluginProductsCategories;
use App\Models\PluginProductsCategoriesProducts;
use App\Models\PluginProductsContacts;
use App\Models\PluginProductsImages;
use App\Models\PluginProductsImagesSize;
use App\Models\PluginProductsLabels;
use App\Models\PluginProductsLangs;
use App\Models\PluginProductsOptions;
use App\Models\PluginProductsRelated;
use App\Models\PluginProductsRequests;
use App\Models\PluginProductsSearch;
use App\Models\PluginProductsSettings;
use App\Models\Promotion;
use App\Models\ShopAttributes;
use App\Models\ShopAttributesOptions;
use App\Models\ShopAttributesProducts;
use App\Models\ShopSettings;
use App\Models\WebsiteSetting;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class PluginProductsController extends Controller
{

    public function search_results(Request $request){

        $q = trim(addslashes($request->get('search')));
        $lang = \App::getLocale();
        $lang_ = strtoupper($lang);
        $slug_prodotti = env("PLUGIN_PRODUCTS_URL_$lang_");
        $page = Page::whereRaw("slug like '%$slug_prodotti%'")->where("is_active", 1)->first();

        return redirect()->to("{$page->slug}?q=$q");
    }

    public function pluginProducts($slug = null, Request $request)
    {
        $startTime = microtime(true);

        $adminPlugin = \App\Models\AdminPlugin::where("name", "pluginProducts")->first();

        $currenturl = url()->full();
        $currentSlug = basename($currenturl);

        $adminLangs = AdminLanguage::where("is_active", 1)->where("is_frontend", 1)->get();
        if($adminLangs){
            foreach ($adminLangs as $item_lang){
                $item = Page::whereRaw("slug LIKE '%\"{$item_lang->name}\":\"$currentSlug\"%'")->first();
                if($item){
                    App::setLocale($item_lang->name);
                }
            }
        }

        //SPECIAL PAGE SHOPS
        $special_urls = [];
        $pages_special_shop = Page::where("is_special_shop", 1)->get();
        if($pages_special_shop){
            foreach ($pages_special_shop as $ps){
                $special_urls[] = $ps->slug;
            }
        }

        if(count($special_urls)){
            foreach ($special_urls as $special){
                foreach ($adminLangs as $item_lang){
                    $special_urls[] = "$special-{$item_lang->name}";
                }
            }
        }

        $lang = \App::getLocale();
        $lang_ = strtoupper($lang);
        $slug_prodotti = env("PLUGIN_PRODUCTS_URL_$lang_");

        $ajax_mode = 0;
        if($request->has('ajax')){
            $ajax_mode = 1;

            if(count($request->except('ajax')) == 0){
                return response()->json([
                    'redirect' => 1,
                    "slug" => $slug_prodotti
                ]);
            }
        }



        if($special_urls){
            foreach ($special_urls as $special){
                if(strpos( \URL::current(),$special)){
                    if(!$slug){
                        $slug = $special;
                        if(\App::getLocale() != "it"){
                            $slug = "$special-".\App::getLocale();
                        }
                    }
                    break;
                }
            }
        }



        $page = Page::whereRaw("slug like '%$slug_prodotti%'")->where("is_active", 1)->first();
        if(!$page){
            if($ajax_mode == 0){
                return redirect()->to("/");
            }else{
                return response()->json(['error' => 'page']);
            }
        }

        $website = WebsiteSetting::first();

        $menu = Page::where("is_in_menu", 1)->where("is_active", 1)->where("parent_id", null)->orderBy("lft", "asc")->get();
        if($menu){
            foreach ($menu as $item){
                $check = Page::where("is_in_menu", 1)->where("parent_id", $item->id)->orderBy("lft", "asc")->get();
                if($check){
                    $item->figli = $check;
                }
            }
        }

        $plugin = PluginProductsSettings::first();
        $select_order_by = "$plugin->order_field|$plugin->order_type";
        $agent = new \Jenssegers\Agent\Agent();
        if($agent->isMobile() || $agent->isTablet()){
            $select_show_number = $plugin->number_product_mobile;
        }else{
            $select_show_number = $plugin->number_product;
        }

        $field_order_by = $plugin->order_field;
        $field_order_type = $plugin->order_type;

        if($request->has('order_by')){
            $order_by = $request->get('order_by');

            if($order_by == "undefined"){
                $field_order_by = "lft";
                $field_order_type = "asc";
                $select_order_by = "lft";
            }else{
                $temp = explode("|", $order_by);
                $field_order_by = $temp[0];
                $field_order_type = $temp[1];
                $select_order_by = $order_by;
            }
        }

        if($request->has('show_number')){
            $select_show_number = $request->get('show_number');
        }


        $v_padri = [];
        $sql_padri = "1=1";

        if($request->has('options_check')){
            $options_check = explode(",", $request->get('options_check'));

            $v_sql_options = [];
            $sql_options = "1=1";
            if($options_check){
                foreach ($options_check as $id){
                     $v_sql_options[] = "options LIKE '%,$id,%'";
                }
                $sql_options = "(".implode(" OR ", $v_sql_options).")";
            }

            $ids_temp  = [];
            $p_ids = PluginProductsSearch::whereRaw("$sql_options")->pluck("group_id", "group_id")->toArray();
            if(count($p_ids)){
                $ids_temp = PluginProductsSearch::whereIn("group_id", $p_ids)->where("is_variant", 0)->where("is_active", 1)->pluck("plugin_product_id", "plugin_product_id")->toArray();
            }

            if(count($ids_temp)){
                foreach ($ids_temp as $idt){
                    $v_padri[] = $idt;
                }
            }

            if(count($v_padri)){
                $v_padri = array_unique($v_padri);
                $sql_padri = "plugins_products.id IN (".implode(",", $v_padri).")";
            }
        }


        $sql_brands = "";
        if($request->has('brands_check')){
            $brands_check = $request->get('brands_check');
            $sql_brands = "AND plugins_products.brand_id IN ($brands_check)";
        }

        $sql_tags = "";
        if($request->has('tags_check')){
            $tags_check = $request->get('tags_check');
            $tags_vet = explode(",", $tags_check);
            if(count($tags_vet) == 1){
                $tags_vet[0] = addslashes($tags_vet[0]);

                $sql_tags = "AND plugins_products.tags LIKE '%$tags_vet[0]%'";
            }else{
                $sql_tags = "AND (";
                $i=1;
                foreach ($tags_vet as $tag){
                    $tag = addslashes($tag);

                    if(count($tags_vet) == $i){
                        $sql_tags .= "plugins_products.tags LIKE '%$tag%'";
                    }else{
                        $sql_tags .= "plugins_products.tags LIKE '%$tag%' OR ";
                    }

                    $i++;
                }
                $sql_tags .= ")";
            }
        }

        $sql_price_max = "";
        if($request->has('price_max')){
            $price_max = $request->get('price_max');
            $sql_price_max = "AND plugins_products.price <= $price_max";
        }

        $sql_search = "";
        if($request->has('q')){
            $q = trim(addslashes($request->get('q')));
            $sql_search = "AND (name LIKE '%$q%' OR sku LIKE '%$q%' OR description LIKE '%$q%' OR description_short LIKE '%$q%')";
        }

        $sqlCondition = "AND 1=1";
        if($adminPlugin->version == 3){
            $sqlCondition = "AND qty > 0";
        }

        $products_processed_total = null;

        $slug_temp = $slug;
        if($slug){
            $category = PluginProductsCategories::where("is_active", 1)
                ->whereRaw("slug LIKE '%$slug%'")
                ->first();

            if($category){
                if($category->parent_id){
                    $parent = PluginProductsCategories::where("is_active", 1)
                        ->whereNotNull("list_pages")
                        ->where("id", $category->parent_id)->first();
                    if($parent){
                        $slug = $parent->slug;
                    }
                }
            }

            //MENU A SX CATEGORIE

            if(in_array($slug_temp, $special_urls)){
                $categories = PluginProductsCategories::where("is_active", 1)
                    ->where("parent_id", null)
                    ->where("is_in_list_shop_page", 0)
                    ->whereRaw("list_pages LIKE '%$slug%'")
                    ->where("is_purchasable", 1)
                    ->orderBy("lft", "asc")
                    ->get();
            }else{
                if(is_numeric(strpos(\Request::url(), "/$slug_prodotti/"))){
                    $categories = PluginProductsCategories::where("is_active", 1)
                        ->where("parent_id", null)
                        ->where("is_purchasable", 1)
                        ->where("is_in_list_shop_page", 1)
                        ->orderBy("lft", "asc")
                        ->get();
                }else{
                    $trovato = 0;
                    foreach ($special_urls as $special){
                        if(is_numeric(strpos(\Request::url(), "/$special/"))){
                            $categories = PluginProductsCategories::where("is_active", 1)
                                ->where("parent_id", null)
                                ->where("is_in_list_shop_page", 0)
                                ->whereRaw("list_pages LIKE '%$special%'")
                                ->where("is_purchasable", 1)
                                ->orderBy("lft", "asc")
                                ->get();

                            if($categories){
                                $trovato = 1;
                                break;
                            }
                        }
                    }

                    if($trovato == 0){
                        $categories = PluginProductsCategories::where("is_active", 1)
                            ->where("parent_id", null)
                            ->where("is_purchasable", 1)
                            ->where("is_in_list_shop_page", 1)
                            ->orderBy("lft", "asc")
                            ->get();
                    }
                }
            }
        }else{
            $categories = PluginProductsCategories::where("is_active", 1)
                ->where("parent_id", null)
                ->where("is_purchasable", 1)
                ->where("is_in_list_shop_page", 1)
                ->orderBy("lft", "asc")
                ->get();
        }

        if($slug_temp){
            $slug = $slug_temp;
        }

        $sql_categories = "1=1";
        $category = null;
        if($slug){
            $category = PluginProductsCategories::where("is_active", 1)
                ->whereRaw("slug LIKE '%\"$lang\":\"$slug\"%'")
                ->first();

            if(!$category){
                if($ajax_mode == 0){
                    return redirect()->to("/");
                }else{
                    return response()->json(['error' => 'category']);
                }
            }

            $v_cat = [];
           // $v_cat[] = $category->id;

            $figli = PluginProductsCategories::where("is_active", 1)->where("parent_id", $category->id)->get();
            if(count($figli)){
                if($figli){
                    foreach($figli as $figlio){
                        $v_cat[] = $figlio->id;
                    }
                }
            }else{
                $v_cat[] = $category->id;
            }

            if($v_cat){
                foreach ($v_cat as $item_cat_id){
                   $v_sql_categories[] = "categories LIKE '%,$item_cat_id,%'";
                }
                $sql_categories = "(".implode(" OR ", $v_sql_categories).")";
            }
        }else{
            $v_cat = [];

            if($categories){
                foreach ($categories as $temp_category){
                    $v_cat[] = $temp_category->id;

                    $figli = PluginProductsCategories::where("is_active", 1)->where("parent_id", $temp_category->id)->get();
                    if($figli){
                        if($figli){
                            foreach($figli as $figlio){
                                $v_cat[] = $figlio->id;
                            }
                        }
                    }
                }
            }

            if($v_cat){
                foreach ($v_cat as $item_cat_id){
                    $v_sql_categories[] = "categories LIKE '%,$item_cat_id,%'";
                }
                $sql_categories = "(".implode(" OR ", $v_sql_categories).")";
            }
        }

        $products = PluginProducts::selectRaw("plugins_products.*, plugins_products_search.vet_ids_list")
            ->join("plugins_products_search", "plugins_products_search.plugin_product_id", "=", "plugins_products.id")
            ->whereRaw("$sql_categories AND langs LIKE '%,$lang,%' AND plugins_products.is_active = 1")
            ->where("plugins_products.is_variant", 0)
            ->whereRaw("$sql_padri $sql_brands $sql_tags $sql_price_max $sqlCondition $sql_search")
            ->orderBy("is_evidenza", "DESC")
            ->orderBy("plugins_products.$field_order_by", $field_order_type)
            ->groupBy("plugins_products.id")
            ->paginate($select_show_number);

        $products_processed = PluginProducts::selectRaw("plugins_products.*, plugins_products_search.attributes, plugins_products_search.options as search_options, plugins_products_search.price as search_price, plugins_products_search.brands as search_brands, plugins_products_search.tags as search_tags")
            ->join("plugins_products_search", "plugins_products_search.plugin_product_id", "=", "plugins_products.id")
            ->whereRaw("$sql_categories AND langs LIKE '%,$lang,%'")
            ->where("plugins_products.is_active", 1)
            ->whereRaw("$sql_padri $sql_brands $sql_tags $sql_price_max $sqlCondition $sql_search")
            ->orderBy("is_evidenza", "DESC")
            ->orderBy("plugins_products.$field_order_by", $field_order_type)
            ->groupBy("plugins_products.id")
            ->get();

        $endTime = (microtime(true) - $startTime);
        //echo $endTime;

        $variable = $this->get_all_products_sidebar($products_processed, $plugin);

        $tags = $variable['tags'];
        $brands = $variable['brands_ids'];
        $attributes_v = $variable['attributes_v'];
        $prices = $variable['prices'];

        if($ajax_mode == 0){
            $categories = $this->get_categories_sidebar($categories, $products_processed_total);
        }

        $itemProduct = null;
        $thema = env('TEMA');

        $labels = PluginProductsLabels::get()->pluck("value", "key")->toArray();

        if($ajax_mode == 0){
            return view("$thema.plugins.pluginProducts.list", compact('menu', 'page','website', 'plugin', 'products', 'categories', 'itemProduct','tags','labels','category','select_order_by','select_show_number','attributes_v','slug_prodotti','brands','prices'));
        }else{

            $change_brands = 0;
            $v_checked = [];
            if($request->has('options_check')){
                $v_checked = explode(",", $request->get('options_check'));
                $change_brands++;
            }
            $htmlFilterAttributes = view("$thema.plugins.pluginProducts.inc.filters_attributes_ajax", compact('attributes_v', 'plugin','v_checked'))->render();

            $v_checked = [];
            if($request->has('tags_check')){
                $v_checked = explode(",", $request->get('tags_check'));
                $change_brands++;
            }
            $htmlFilterTags = view("$thema.plugins.pluginProducts.inc.filters_tags_ajax", compact('tags', 'plugin','v_checked'))->render();

            $v_checked_price = end($prices);
            if($request->get('price_max')){
                $v_checked_price = $request->get('price_max');
                $change_brands++;
            }
            $htmlFilterPrices = view("$thema.plugins.pluginProducts.inc.filters_prices_ajax", compact('prices', 'plugin','v_checked_price'))->render();


            $v_checked = [];
            if ($request->has('brands_check')) {
                $v_checked = explode(",", $request->get('brands_check'));
            }
            $htmlFilterBrands = view("$thema.plugins.pluginProducts.inc.filters_brands_ajax", compact('brands', 'plugin', 'v_checked'))->render();
            $shopSetting = ShopSettings::first();

            $html = view("$thema.plugins.pluginProducts.inc.productListAjax", compact('menu', 'page','website', 'plugin', 'products', 'categories', 'itemProduct','tags','labels','category','select_order_by','select_show_number','attributes_v','slug_prodotti','brands','shopSetting','adminPlugin'))->render();

            return response()->json(['error' => '0', 'html' => $html, 'html_filter_attributes' => $htmlFilterAttributes, "html_filter_tags" => $htmlFilterTags, "html_filter_prices" => $htmlFilterPrices, "html_filter_brands" => $htmlFilterBrands, 'change_brands' => $change_brands, 'paginations' => $products]);
        }
    }

    public function pluginProductsTags($slug = null, Request $request)
    {
        $lang = \App::getLocale();
        $lang_ = strtoupper($lang);
        $slug_prodotti = env("PLUGIN_PRODUCTS_URL_$lang_");

        return redirect()->to("/$slug_prodotti?tags_check=$slug");
    }


    public function pluginProductsBrands($slug = null, Request $request)
    {
        $lang = \App::getLocale();
        $lang_ = strtoupper($lang);
        $slug_prodotti = env("PLUGIN_PRODUCTS_URL_$lang_");
        $item = PluginProductsBrands::whereRaw("slug LIKE '%\"$lang\":\"$slug\"%'")->first();
        if(!$item){
            return redirect()->to("/");
        }

        if(env("PROJECT_NAME") == "Manega" && strpos( \URL::current(),"luxury")){
            return redirect()->to("/luxury?brands_check=$item->id");
        }

        return redirect()->to("/$slug_prodotti?brands_check=$item->id");

    }


    public function pluginProductsDetail($category, $slug)
    {

        $website = WebsiteSetting::first();

        $currenturl = url()->full();
        $currentSlug = basename($currenturl);
        $adminLangs = AdminLanguage::where("is_active", 1)->where("is_frontend", 1)->get();
        if($adminLangs){
            foreach ($adminLangs as $item_lang){
                $item = PluginProducts::whereRaw("slug LIKE '%\"{$item_lang->name}\":\"$currentSlug\"%'")->first();
                if($item){
                    App::setLocale($item_lang->name);
                }
            }
        }


        $lang = \App::getLocale();
        $lang_ = strtoupper($lang);
        $slug_prodotti = env("PLUGIN_PRODUCTS_URL_$lang_");

        $page = Page::whereRaw("slug like '%$slug_prodotti%'")->where("is_active", 1)->first();
        if(!$page){
            return redirect()->to("/");
        }


        $menu = Page::where("is_in_menu", 1)->where("is_active", 1)->where("parent_id", null)->orderBy("lft", "asc")->get();
        if($menu){
            foreach ($menu as $item){
                $check = Page::where("is_in_menu", 1)->where("parent_id", $item->id)->orderBy("lft", "asc")->get();
                if($check){
                    $item->figli = $check;
                }
            }
        }


        $itemProduct = PluginProducts::where("is_active", 1)->whereRaw("slug LIKE '%\"$lang\":\"$slug\"%'")->first();
        if(!$itemProduct){
            return redirect()->route("pluginProducts.404.$lang");
        }



        $check_lang = PluginProductsLangs::where("product_id", $itemProduct->id)->where("lang", $lang)
            ->where("is_active", 1)
            ->first();

        if(!$check_lang){
            return redirect()->route("pluginProducts.404.$lang");
        }

        $shopSetting = ShopSettings::first();
        if($shopSetting->type_view_variant == 3 && $itemProduct->is_variant == 0){
            //prendo ids varianti
            $variants_ids = PluginProducts::where("group_id", $itemProduct->group_id)
                ->where("is_variant", 1)
                ->where("is_active", 1)
                ->get()->pluck("id")
                ->toArray();

            if($variants_ids){
                $temp_ids = \App\Models\PluginProducts::selectRaw("count(*) as tot, code_article, group_concat(id) as ids")
                    ->whereIn("id", $variants_ids)
                    ->orderBy("code_article", "ASC")
                    ->groupBy("code_article")
                    ->get();

                //prendo il primo attribute in ordine
                $attribute_first = ShopAttributes::orderBy("lft", "asc")->first();

                $vet_ids = ShopAttributesProducts::selectRaw("GROUP_CONCAT(product_id) as ids, option_id")
                    ->whereRaw("product_id IN ({$temp_ids[0]->ids})")
                    ->join("shop_attributes_options", "shop_attributes_options.id", "=", "shop_attributes_products.option_id")
                    ->where("attribute_id", $attribute_first->id)
                    ->orderBy("shop_attributes_options.value", "asc")
                    ->groupBy("option_id")
                    ->get()
                    ->pluck("ids", "option_id")
                    ->toArray();

                $vet_ids_final = [];
                if($vet_ids){
                    foreach ($vet_ids as $k=>$v){
                        //tra gli ids quali ha attribute_shop_id 2 con valore inferiore alfabeticamente?
                        $temp_option = \App\Models\ShopAttributesOptions::find($k);
                        $temp_v = explode(",", $v);

                        $options_p = \App\Models\ShopAttributesProducts::selectRaw("shop_attributes_products.product_id")
                            ->join("shop_attributes_options", "shop_attributes_options.id", "=", "shop_attributes_products.option_id")
                            ->whereIn("product_id", $temp_v)
                            ->where("attribute_id", 2)
                            ->orderBy("shop_attributes_options.value", "asc")
                            ->first();

                        $vet_ids[$k] = $options_p->product_id;
                        $vet_ids_final[$temp_option->value] = $options_p->product_id;
                    }
                }

                ksort($vet_ids_final);

                foreach($vet_ids_final as $product_id){
                    $itemProductVariant = PluginProducts::where("id", $product_id)->first();
                    if($itemProductVariant){
                        return redirect()->route("pluginProducts.detail.".\App::getLocale(), [$category,$itemProductVariant->slug]);
                    }
                }
            }
        }

        if($shopSetting->type_view_variant == 4){
            if($itemProduct->is_variant == 0){
                //prendo ids varianti
                $variants_ids = PluginProducts::where("group_id", $itemProduct->group_id)
                    ->where("is_variant", 1)
                    ->where("is_active", 1)
                    ->get()->pluck("id")
                    ->toArray();

                if($variants_ids){
                    $shopAttributeProduct = ShopAttributes::orderBy("lft", "asc")->first();
                    $options = ShopAttributesOptions::where("shop_attribute_id", $shopAttributeProduct->id)
                        ->orderBy("ordine", "asc")
                        ->get();

                    if($options){
                        foreach ($options as $option){
                            $count = ShopAttributesProducts::where("attribute_id", $option->shop_attribute_id)
                                ->where("option_id", $option->id)
                                ->whereIn("product_id", $variants_ids)
                                ->count();
                            if($count > 0){
                                break;
                            }
                        }
                    }

                    //prendo tutti i prodotti che hanno quell'attributo
                    $prod_same_attributes = ShopAttributesProducts::where("attribute_id", $option->shop_attribute_id)
                        ->where("option_id", $option->id)
                        ->whereIn("product_id", $variants_ids)
                        ->get()->pluck("product_id", "product_id")->toArray();

                    //prendo l'attributo opposto
                    $shopAttributeOpposite = ShopAttributes::where("id", "!=", $shopAttributeProduct->id)->first();

                    if($shopAttributeOpposite){
                        //prendo le opzioni d quell'attributo opposto
                        $options = ShopAttributesOptions::where("shop_attribute_id", $shopAttributeOpposite->id)
                            ->orderBy("ordine", "asc")
                            ->get();
                        if($options){
                            foreach ($options as $option){
                                $check = ShopAttributesProducts::where("attribute_id", $option->shop_attribute_id)
                                    ->where("option_id", $option->id)
                                    ->whereIn("product_id", $prod_same_attributes)
                                    ->first();

                                if($check){
                                    $product_id = $check->product_id;
                                    $itemProductVariant = PluginProducts::where("id", $product_id)->first();

                                    if($itemProductVariant){
                                        $cat_prod_slug = "no-categoria";
                                        $cat_prod = $itemProductVariant->category();
                                        if($cat_prod){
                                            $cat_prod_slug = $cat_prod->slug;
                                        }
                                        return redirect()->route("pluginProducts.detail.".\App::getLocale(), [$cat_prod_slug,$itemProductVariant->slug]);
                                    }
                                }
                            }
                        }
                    }

                }
            }
        }


        $plugin = PluginProductsSettings::first();
        $itemProduct->images = PluginProductsImages::where("product_id", $itemProduct->id)->orderBy("order", "asc")->get();
        $itemProduct->images_size = PluginProductsImagesSize::where("product_id", $itemProduct->id)->orderBy("order", "asc")->get();
        $itemProduct->options = PluginProductsOptions::selectRaw("plugins_products_attributes.name, plugins_products_options.attribute_id, plugins_products_options.value")
        ->join("plugins_products_attributes", "plugins_products_attributes.id", "=", "plugins_products_options.attribute_id")
        ->where("product_id", $itemProduct->id)
            ->orderBy("plugins_products_options.lft", "asc")
            ->get();
        $itemProduct->related = PluginProductsRelated::where("product_id", $itemProduct->id)->get();
        $itemProduct->attachmentsList = PluginProductsAttachments::where("product_id", $itemProduct->id)->orderBy("lft", "asc")->get();
        $itemProduct->category = $itemProduct->category();

        if(trim($itemProduct->tags) == ""){
            $itemProduct->tags = null;
        }

        $now = Carbon::now();
        $itemProduct->in_promo = 0;
        if($itemProduct->data_promo_end){
            $data_end = Carbon::createFromFormat("Y-m-d", $itemProduct->data_promo_end);
            if($now->lte($data_end)){
                $itemProduct->in_promo = 1;
            }
        }else{
            if($itemProduct->promo_price < $itemProduct->price && ($itemProduct->promo_price != "" && $itemProduct->promo_price != "")){
                $itemProduct->in_promo = 1;
            }
        }

        if($itemProduct->related){
            foreach ($itemProduct->related as $related){
                $related->product = PluginProducts::where("id", $related->product_related_id)->first();
                if($related->product){
                    $related->product->category = $related->product->category();
                    $related->product->cover = $related->product->getCover();

                    $related->product->in_promo = 0;
                    if($related->product->data_promo_end){
                        $data_end = Carbon::createFromFormat("Y-m-d", $related->product->data_promo_end);
                        if($now->lte($data_end)){
                            $related->product->in_promo = 1;
                        }
                    }else{
                        if($related->product->promo_price < $related->product->price && ($related->promo_price != "" && $related->promo_price != "")){
                            $related->product->in_promo = 1;
                        }
                    }
                }
            }
        }


        $tags = [];

        $search = PluginProductsSearch::where("plugin_product_id", $itemProduct->id)->first();
        if($search){
            $temp_tags = explode(",", $search->tags);
            $temp_tags = array_unique($temp_tags);
            if(count($temp_tags)){
                foreach ($temp_tags as $tag){
                    if(trim($item) != ""){
                        $tags[] = trim($item);
                    }
                }
            }
        }

        if(count($tags)){
            $tags = array_unique($tags);
        }

        /*$categories = PluginProductsCategories::where("is_active", 1)->where("parent_id", null)->orderBy("lft", "asc")->get();
        if($categories){
            foreach ($categories as $item){
                $item->count = PluginProductsCategoriesProducts::join("plugins_products_categories", "plugins_products_categories.id", "=", "plugins_products_categories_products.plugin_product_category_id")
                    ->where("plugin_product_category_id", $item->id)
                    ->where("plugins_products_categories.is_active", 1)
                    ->count();

                $check = PluginProductsCategories::where("parent_id", $item->id)->orderBy("lft", "asc")->get();
                if($check){
                    $item->figli = $check;
                    if($item->figli){
                        foreach($item->figli as $figlio){
                            $figlio->count = PluginProductsCategoriesProducts::join("plugins_products_categories", "plugins_products_categories.id", "=", "plugins_products_categories_products.plugin_product_category_id")
                                ->where("plugin_product_category_id", $figlio->id)
                                ->where("plugins_products_categories.is_active", 1)
                                ->count();
                        }
                    }
                }
            }
        }*/

        $categories = null;

        $formContact = PluginProductsContacts::first();

        $thema = env('TEMA');
        $labels = PluginProductsLabels::get()->pluck("value", "key")->toArray();
        $products = null;

        $blade = "detail";

        return view("$thema.plugins.pluginProducts.$blade", compact('menu', 'page','website', 'plugin', 'products', 'categories', 'itemProduct','formContact','tags','labels'));
    }

    public function not_found(){
        $thema = env('TEMA');
        $menu = Page::where("is_in_menu", 1)->where("is_active", 1)->where("parent_id", null)->orderBy("lft", "asc")->get();
        if($menu){
            foreach ($menu as $item){
                $check = Page::where("is_in_menu", 1)->where("parent_id", $item->id)->orderBy("lft", "asc")->get();
                if($check){
                    $item->figli = $check;
                }
            }
        }

        $lang = \App::getLocale();
        $lang_ = strtoupper($lang);
        $slug_prodotti = env("PLUGIN_PRODUCTS_URL_$lang_");
        $page = Page::whereRaw("slug like '%$slug_prodotti%'")->where("is_active", 1)->first();
        if(!$page){
            return redirect()->to("/");
        }

        $website = WebsiteSetting::first();
        $plugin = PluginProductsSettings::first();
        $categories = null;
        $tags = null;
        return view("$thema.plugins.pluginProducts.404", compact('menu', 'page','website','plugin','categories','tags'));
    }


    public function contact_form_send(Request $request){
        if(env('LOCAL') != 1){
            /*$this->validate($request, [
                'g-recaptcha-response' => 'required|captcha',
            ]);*/
        }

        $item = PluginProductsContacts::first();

        $product_id = $request->get('product_id');
        $data = $request->except(['_token', 'product_id']);


        $product = PluginProducts::where("id", $product_id)->first();
        if($product){
            $data['prodotto'] = $product->name;
        }

        $vet_email = ["request" => $data];
        $dst_email = $item->email;

       // dd(env('MAIL_FROM_ADDRESS'), $dst_email);

        \Mail::send("common.emails.contact", ['data' => $vet_email], function ($m) use ($dst_email, $item, $data) {
            $m->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
            $m->to($dst_email);

            if($item->cc){
                $cc_email = explode(",", $item->cc);
                $m->cc($cc_email);
            }

            if($item->ccn){
                $ccn_email = explode(",", $item->ccn);
                $m->bcc($ccn_email);
            }

            if($item->object_form){
                $m->subject($item->getTranslation('object_form', \App::getLocale()));
            }else{
                $m->subject("Richiesta informazioni");
            }
        });

        PluginProductsRequests::create([
            "email" => $data['email'],
            "product_id" => $product->id,
            "object" => $item->getTranslation('object_form', \App::getLocale()),
            "content" => json_encode($data)
        ]);

        return redirect()->back()->with('messageContact', $item->getTranslation('message_ringraziamento', \App::getLocale()));
    }


    public function createPdf($id){
        $pdf = \App::make('snappy.pdf.wrapper');
        $thema = env('TEMA');
        $website = WebsiteSetting::first();
        $labels = PluginProductsLabels::get()->pluck("value", "key")->toArray();

        $setting = PluginProductsSettings::first();
        $itemProduct = PluginProducts::where("id", $id)->first();
        if($itemProduct){
            $itemProduct->images = PluginProductsImages::where("product_id", $itemProduct->id)->orderBy("order", "asc")->get();
            $itemProduct->options = PluginProductsOptions::selectRaw("plugins_products_attributes.name, plugins_products_options.attribute_id, plugins_products_options.value")
                ->join("plugins_products_attributes", "plugins_products_attributes.id", "=", "plugins_products_options.attribute_id")
                ->where("product_id", $itemProduct->id)
                ->orderBy("plugins_products_options.lft", "asc")
                ->get();
            $itemProduct->related = PluginProductsRelated::where("product_id", $itemProduct->id)->get();
            $itemProduct->category = $itemProduct->category();


            if($itemProduct->related){
                foreach ($itemProduct->related as $related){
                    $related->product = PluginProducts::where("id", $related->product_related_id)->first();
                    if($related->product){
                        $related->product->cover =  $related->product->getCover();
                    }
                }
            }
        }

        $html = view("$thema.plugins.pluginProducts.pdf.detail", compact('itemProduct','website','labels','setting'))->render();
        $pdf->loadHTML($html)->setPaper('a4');

        $footerHtml = "";

        if($setting->dati_footer_pdf){
            $footerHtml .= "$setting->dati_footer_pdf";
        }

        $pdf->setOption('footer-html', $footerHtml );

        $itemProduct->sku = str_replace(".","-", $itemProduct->sku);
        return $pdf->download("$itemProduct->sku.pdf");

    }

    public function search(Request $request){
        $adminLangs = AdminLanguage::where("is_active", 1)->where("is_frontend", 1)->get();

        $path_parts = pathinfo($_SERVER['HTTP_REFERER']);

        $lang = \App::getLocale();
        $lang_ = strtoupper($lang);
        $slug_prodotti = env("PLUGIN_PRODUCTS_URL_$lang_");

        $slug = $path_parts['basename'];
        //SPECIAL PAGE SHOPS
        $special_urls = [];
        $pages_special_shop = Page::where("is_special_shop", 1)->get();
        if($pages_special_shop){
            foreach ($pages_special_shop as $ps){
                $special_urls[] = $ps->slug;
            }
        }

        if(count($special_urls)){
            foreach ($special_urls as $special){
                foreach ($adminLangs as $item_lang){
                    $special_urls[] = "$special-{$item_lang->name}";
                }
            }
        }

        if($special_urls){
            foreach ($special_urls as $special){
                if(strpos( \URL::current(),$special)){
                    if(!$slug){
                        $slug = $special;
                        if(\App::getLocale() != "it"){
                            $slug = "$special-".\App::getLocale();
                        }
                    }
                    break;
                }
            }
        }

        //MENU A SX CATEGORIE
        if(in_array($slug, $special_urls)){
            $categories = PluginProductsCategories::where("is_active", 1)
                ->where("parent_id", null)
                ->where("is_in_list_shop_page", 0)
                ->whereRaw("list_pages LIKE '%$slug%'")
                ->where("is_purchasable", 1)
                ->orderBy("lft", "asc")
                ->get();
        }else {
            if (is_numeric(strpos(\Request::url(), "/$slug_prodotti/"))) {
                $categories = PluginProductsCategories::where("is_active", 1)
                    ->where("parent_id", null)
                    ->where("is_purchasable", 1)
                    ->where("is_in_list_shop_page", 1)
                    ->orderBy("lft", "asc")
                    ->get();
            } else {
                $trovato = 0;
                foreach ($special_urls as $special) {
                    if (is_numeric(strpos(\Request::url(), "/$special/"))) {
                        $categories = PluginProductsCategories::where("is_active", 1)
                            ->where("parent_id", null)
                            ->where("is_in_list_shop_page", 0)
                            ->whereRaw("list_pages LIKE '%$special%'")
                            ->where("is_purchasable", 1)
                            ->orderBy("lft", "asc")
                            ->get();

                        if ($categories) {
                            $trovato = 1;
                            break;
                        }
                    }
                }

                if ($trovato == 0) {
                    $categories = PluginProductsCategories::where("is_active", 1)
                        ->where("parent_id", null)
                        ->where("is_purchasable", 1)
                        ->where("is_in_list_shop_page", 1)
                        ->orderBy("lft", "asc")
                        ->get();
                }
            }
        }


        $v_cat = [];
        $sql_categories = "1=1";
        if($categories){
            foreach ($categories as $temp_category){
                $v_cat[] = $temp_category->id;

                $figli = PluginProductsCategories::where("is_active", 1)->where("parent_id", $temp_category->id)->get();
                if($figli){
                    if($figli){
                        foreach($figli as $figlio){
                            $v_cat[] = $figlio->id;
                        }
                    }
                }
            }
        }

        if($v_cat){
            foreach ($v_cat as $item_cat_id){
                $v_sql_categories[] = "categories LIKE '%,$item_cat_id,%'";
            }
            $sql_categories = "(".implode(" OR ", $v_sql_categories).")";
        }

        $q = trim(addslashes($request->input('q')));
        $shopSetting = ShopSettings::first();
        $pluginSetting = PluginProductsSettings::first();
        $labels = PluginProductsLabels::get()->pluck("value", "key")->toArray();

        $products = PluginProducts::selectRaw("plugins_products.*, plugins_products_search.vet_ids_list")
            ->join("plugins_products_search", "plugins_products_search.plugin_product_id", "=", "plugins_products.id")
            ->whereRaw("$sql_categories AND langs LIKE '%,$lang,%' AND plugins_products.is_active = 1")
            ->where("plugins_products.is_variant", 0)
            ->whereRaw("plugins_products.is_active = 1 AND (name LIKE '%$q%' OR sku LIKE '%$q%' OR description LIKE '%$q%' OR description_short LIKE '%$q%')")
            ->orderBy("is_evidenza", "DESC")
            ->orderBy("plugins_products.name", "asc")
            ->groupBy("plugins_products.id")
            ->get();

        $list = [];
        if(count($products)){
            $now = Carbon::now();
            foreach ($products as $product){
                $product->cover = $product->getCoverMini();
                $product->in_promo = 0;
                if($product->data_promo_end){
                    $data_end = Carbon::createFromFormat("Y-m-d", $product->data_promo_end);
                    if($now->lte($data_end)){
                        $product->in_promo = 1;
                    }
                }else{
                    if($product->promo_price < $product->price && ($product->promo_price != "" && $product->promo_price != "")){
                        $product->in_promo = 1;
                    }
                }

                $product->slug_category = "no-categoria";
                $cat_prod = $product->category();
                if($cat_prod){
                    $product->slug_category = $cat_prod->slug;
                }

                $product->label = $product->name;
                $product->value = $product->id;

                $product->price_view = "";
                $product->add_cart = "";

                $product->button_cart = @$labels['autocomplete-button-add-cart'];

                if($shopSetting){
                    if($shopSetting->search_with_price == 1){
                        $symbol = "&euro;";
                        if(\Auth::user() && in_array(\Auth::user()->country_id, config('config.default_country_user_dollar'))){
                            if($product->price_dollar){
                                $symbol = "&#36;";
                            }
                        }
                        if(\Auth::user() && in_array(\Auth::user()->country_id, config('config.default_country_user_listino_2'))){
                            if($product->price_2){
                                $symbol = "&euro;";
                            }
                        }

                        if(env('VIEW_WITH_IVA') == 1){
                            $promo_price = $product->get_promo_price(true);
                        }else{
                            $promo_price = $product->get_promo_price();
                        }

                        if($promo_price != 0){
                            $promo_price_view = number_format($promo_price, 2, ",", ".");

                            if($promo_price_view != "0,00"){
                                $product->price_view = "$symbol $promo_price_view";
                            }else{
                                $product->price_view = "";
                            }

                        }

                    }
                }


                if($pluginSetting){
                    if($pluginSetting->view_price_autocomplete_topbar_ecommerce == 1){
                        $symbol = "&euro;";
                        if(\Auth::user() && in_array(\Auth::user()->country_id, config('config.default_country_user_dollar'))){
                            if($product->price_dollar){
                                $symbol = "&#36;";
                            }
                        }
                        if(\Auth::user() && in_array(\Auth::user()->country_id, config('config.default_country_user_listino_2'))){
                            if($product->price_2){
                                $symbol = "&euro;";
                            }
                        }

                        if(env('VIEW_WITH_IVA') == 1){
                            $promo_price = $product->get_promo_price(true);
                        }else{
                            $promo_price = $product->get_promo_price();
                        }
                        $promo_price_view = number_format($promo_price, 2, ",", ".");

                        if($promo_price_view != "0,00"){
                            $product->price_view = "$symbol $promo_price_view";
                        }else{
                            $product->price_view = "";
                        }

                    }


                    if($pluginSetting->view_addcart_autocomplete_topbar_ecommerce == 1){
                        $url_add = route('add.cart.product.search');
                        $product->add_cart = "$url_add?id=$product->id";

                        if($pluginSetting->icon_button_autocomplete_topbar_ecommerce){
                            $product->button_cart = "<i class='$pluginSetting->icon_button_autocomplete_topbar_ecommerce'></i>";
                        }
                    }
                }

                if($pluginSetting->view_price_autocomplete_topbar_ecommerce == 0){
                    $product->price_view = "";
                }

                if($pluginSetting->view_price_autocomplete_topbar_ecommerce == 0){
                    $product->add_cart = "";
                    $product->button_cart = "";
                }

                if($product->in_cart()){
                    $product->add_cart = "";
                }

                if(trim($product->price_view) == ""){
                    $product->add_cart = "";
                }


                $list[] = $product;
            }
        }else{

            $product = new \stdClass();
            $product->label = "0";
            $product->value = "0";


            $list[] = $product;
        }

        return json_encode($list);

        //$product = implode(",", $list);
        //echo"[" . $product . "]";
    }



    public function loginProcess(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ],
            [
                "email.required" => "Email campo obbligatorio",
                "password.required" => "Password campo obbligatorio",
            ]
        );

        $credentials = $request->only('email', 'password');
        $user = User::where("email", $request->get('email'))->first();
        if(!$user){
            return redirect()->back()->withErrors(['Account non riconosciuto!']);
        }

        if($user->active == 0){
            return redirect()->back()->withErrors(['Account non attivo!']);
        }

        if (\Auth::attempt($credentials)) {
            \Session::put("user_id", $user->id);

            if(\Session::has("cart.products")){
                $products = \Session::get('cart.products');
                if($products){
                    foreach ($products as $product){
                        Cart::insert([
                            "product_id" => $product->product_id,
                            "user_id" => $user->id,
                            "qty" => $product->qty,
                            "price" => $product->price,
                            "created_at" => Carbon::now()->toDateTimeString()
                        ]);
                    }
                }

                \Session::forget('cart.products');
            }

            if(\Session::get('redirect_to_checkout') === true){
                \Session::forget('redirect_to_checkout');
                return redirect()->to('/checkout_new');
            }

            return redirect()->route('myarea.dashboard');
        }

        return redirect()->back()->withErrors(['Account non riconosciuto!']);
    }


    public function get_categories_sidebar($categories, $productsAllVet_Temp = null){
        if($categories){
            foreach ($categories as $k=>$item){
                $item->count = PluginProductsSearch::whereRaw("categories LIKE '%,$item->id,%'")->where("is_active", 1)->where("is_variant", 0)->count();
                $check = PluginProductsCategories::where("parent_id", $item->id)->where("is_active", 1)->orderBy("lft", "asc")->get();
                if($check){
                    $item->figli = $check;
                    if($item->figli){

                        $tot_figli = 0;
                        foreach($item->figli as $figlio){
                            $figlio->count = PluginProductsSearch::whereRaw("categories LIKE '%,$figlio->id,%'")->where("is_active", 1)->where("is_variant", 0)->count();
                            $tot_figli = $tot_figli + $figlio->count;

                            $check_2 = PluginProductsCategories::where("parent_id", $figlio->id)->where("is_active", 1)->orderBy("lft", "asc")->get();
                            if($check_2){
                                $figlio->figli_2 = $check_2;
                                foreach($figlio->figli_2 as $figlio2){
                                    $figlio2->count = PluginProductsSearch::whereRaw("categories LIKE '%,$figlio2->id,%'")->where("is_active", 1)->where("is_variant", 0)->count();
                                    $check_3 = PluginProductsCategories::where("parent_id", $figlio2->id)->where("is_active", 1)->orderBy("lft", "asc")->get();
                                    if($check_3) {
                                        $figlio2->figli_3 = $check_3;
                                        foreach($figlio2->figli_3 as $figlio3) {
                                            $figlio3->count = PluginProductsSearch::whereRaw("categories LIKE '%,$figlio3->id,%'")->where("is_active", 1)->where("is_variant", 0)->count();
                                        }
                                    }
                                }
                            }
                        }


                    }else{
                        if($item->count == 0){
                            unset($categories[$k]);
                            continue;
                        }
                    }
                }
            }
        }

        return $categories;
    }

    public function get_all_products_sidebar($products_processed = null, $pluginSetting){
        $productsAll = $products_processed;
        $productsAllVet = $products_processed->pluck("id")->toArray();
        //$productsAllVetAttributes = $products_processed->whereNotNull("attributes")->pluck("attributes", "id")->toArray();

        $brands = [];
        $brands_ids = [];
        $tags = [];

        $attributes_v = [];
        $attribute_item_second = null;

        if($pluginSetting->show_attributes_sidebar == 1){

            if($products_processed){
                foreach ($products_processed as $prod){
                    if($prod->attributes){
                        $attributes_prod = json_decode($prod->attributes,true);
                        if($attributes_prod){
                            foreach ($attributes_prod as $attribute_id => $options){
                                if(key_exists($attribute_id, $attributes_v)){
                                    foreach ($options as $option_id){
                                        $attributes_v[$attribute_id][$option_id] = $option_id;
                                    }

                                }else{
                                    $attributes_v[$attribute_id] = [];
                                    foreach ($options as $option_id){
                                        $attributes_v[$attribute_id][$option_id] = $option_id;
                                    }
                                }
                            }
                        }
                    }
                }
            }

            if($attributes_v){
                foreach ($attributes_v as $k=>$options){
                    foreach ($options as $k2=>$optionsId){
                        $option_name = ShopAttributesOptions::find($optionsId);
                        if($option_name){
                            $attributes_v[$k][$k2] = $option_name->value;
                        }
                    }
                }
            }

        }


        //calcolo dei prezzi dei prodotti
        $vet_prices = [];

        if($pluginSetting->show_prices_sidebar == 1) {
            $now = Carbon::now()->toDateTimeString();

            $promo_priority = Promotion::whereRaw("(start_date <= '$now' AND expiration_date >='$now') AND is_forced = 1")
                ->count();

            if ($promo_priority > 0) {
                $categories_ids = PluginProductsCategoriesProducts::whereIn("plugin_product_product_id", $productsAllVet)->get()
                    ->pluck("plugin_product_category_id")
                    ->toArray();

                //controllo se esistono promozioni per categoria
                if (count($categories_ids)) {
                    $promotions = Promotion::whereIn("category_id", $categories_ids)
                        ->whereRaw("(start_date <= '$now' AND expiration_date >='$now')")
                        ->get();

                    if ($promotions) {
                        foreach ($promotions as $promo) {
                            foreach ($productsAll as $product) {
                                $priceStart = $product->price;
                                if ($promo->discount_type == "Amount") {
                                    if (env('VIEW_WITH_IVA') == 1) {
                                        $priceStart = round($product->price + (($product->price * $product->tax->value) / 100), 2);
                                    }

                                    $priceStart = $priceStart - $promo->reduction;
                                } else {
                                    $priceStart = $priceStart - (($priceStart * ($promo->reduction)) / 100);
                                }

                                if ($product->brand_id !== null) {
                                    $promotions = Promotion::where("brand_id", $product->brand_id)
                                        ->whereNull("category_id")
                                        ->whereRaw("(start_date <= '$now' AND expiration_date >='$now')")
                                        ->get();
                                    if (count($promotions)) {
                                        foreach ($promotions as $promo) {
                                            if ($promo->discount_type == "Amount") {
                                                if (env('VIEW_WITH_IVA') == 1) {
                                                    $priceStart = round($product->price + (($product->price * $product->tax->value) / 100), 2);
                                                }

                                                $priceStart = $priceStart - $promo->reduction;
                                            } else {
                                                $priceStart = $priceStart - (($priceStart * ($promo->reduction)) / 100);
                                            }
                                        }
                                    }
                                }
                                $vet_prices[$product->id] = $priceStart;
                            }
                        }
                    }
                }
            }
        }

        $brands_v = [];
        $brands_ids = [];

        if($pluginSetting->show_brands_sidebar == 1) {
            if ($productsAll) {
                foreach ($productsAll as $product) {
                    if ($pluginSetting->show_prices) {
                        $vet_prices[$product->id] = $product->search_price;
                    }

                    if ($pluginSetting->show_brands_sidebar) {
                        $itemBrands = explode(",", $product->search_brands);

                        if (env("PROJECT_NAME") == "Manega" && strpos(\URL::current(), "luxury")) {
                            if ($product->brand->is_purchasable == 0) {
                                if (count($itemBrands)) {
                                    foreach ($itemBrands as $item) {
                                        if (trim($item) != "") {
                                            $brands_v[trim(strtolower($item))] = ucfirst(trim($item));
                                        }
                                    }
                                }
                            }
                        } else {
                            if (count($itemBrands)) {
                                foreach ($itemBrands as $item) {
                                    if (trim($item) != "") {
                                        $brands_v[trim(strtolower($item))] = ucfirst(trim($item));
                                    }
                                }
                            }
                        }
                    }

                    if ($pluginSetting->show_tags) {
                        $itemTags = explode(",", $product->tags);
                        if (count($itemTags)) {
                            foreach ($itemTags as $item) {
                                if (trim($item) != "") {
                                    $tags[trim(strtolower($item))] = ucfirst(trim($item));
                                }
                            }
                        }
                    }
                }
            }

            if (count($brands_v)) {
                foreach ($brands_v as $brand_id) {
                    $temp = PluginProductsBrands::find($brand_id);
                    if ($temp) {
                        $brands[$temp->slug] = $temp->name;
                        $brands_ids[] = $brand_id;
                    }
                }
            }
        }

        if(count($attributes_v)){
            if($attribute_item_second) {
                asort($attributes_v[$attribute_item_second->id]);
            }
        }

        asort($vet_prices);
        asort($brands);
        asort($tags);
        $tags = array_unique($tags);

        return ["tags" => $tags, "productsAll" => $productsAll, "attributes_v" => $attributes_v, "brands" => $brands, "brands_ids" => $brands_ids,  "prices" => $vet_prices];
    }

    public function comparatore()
    {
        $cart = $this->loading_compare();

        $thema = env('TEMA');

        $menu = Page::where("is_in_menu", 1)->where("is_active", 1)->where("parent_id", null)->orderBy("lft", "asc")->get();
        if($menu){
            foreach ($menu as $item){
                $check = Page::where("is_in_menu", 1)->where("parent_id", $item->id)->orderBy("lft", "asc")->get();
                if($check){
                    $item->figli = $check;
                }
            }
        }

        $page = null;

        return view("$thema.plugins.pluginProducts.comparatore", compact('cart', 'menu', 'page'));
    }

    public function advice_compare($id, Request $request)
    {
        $v_ = [];
        $in_view = \Session::get("user.compare");

        if(is_array($in_view)){
            if(count($in_view)){
                foreach ($in_view as $cID){
                    $v_[] = $cID;
                }
            }
        }

        if(!in_array($id, $v_)){
            \Session::push("user.compare", $id);
        }

        if($request->has('list')){
            return response()->json([
               "ok" => 1
            ]);
        }

        return redirect()->back();
    }


    public function loading_compare(){

        $cart = \Session::get('user.compare');
        if(!$cart){
            return [];
        }

        $cart = array_unique($cart);

        return $cart;

    }


    public function advice_compare_remove($id){
        $cart =  \Session::get("user.compare");
        if ($cart) {
            foreach ($cart as $k=>$itemId){
                if($id == $itemId){
                    unset($cart[$k]);
                }
            }
        }
        \Session::put("user.compare", $cart);

        return redirect()->back();
    }

    public function chooseDetail($slug, $id){
        $lang = \App::getLocale();
        $itemProduct = PluginProducts::where("is_active", 1)->whereRaw("slug LIKE '%\"$lang\":\"$slug\"%'")->first();
        if(!$itemProduct){
            return redirect()->route("pluginProducts.404.$lang");
        }

        $variants_ids = \App\Models\PluginProducts::where("group_id", $itemProduct->group_id)
            ->where("is_variant", 1)
            ->where("is_active", 1)
            ->get()->pluck("id")
            ->toArray();

        $shopAttributeProduct = ShopAttributesProducts::find($id);

        //prendo tutti i prodotti che hanno quell'attributo
        $prod_same_attributes = ShopAttributesProducts::where("attribute_id", $shopAttributeProduct->attribute_id)
            ->where("option_id", $shopAttributeProduct->option_id)
            ->whereIn("product_id", $variants_ids)
            ->get()->pluck("product_id", "product_id")->toArray();

        //prendo l'attributo opposto
        $shopAttributeOpposite = ShopAttributes::where("id", "!=", $shopAttributeProduct->attribute_id)->first();

        if($shopAttributeOpposite){
            //prendo le opzioni d quell'attributo opposto
            $options = ShopAttributesOptions::where("shop_attribute_id", $shopAttributeOpposite->id)
                ->orderBy("ordine", "asc")
                ->get();
            if($options){
                foreach ($options as $option){
                    $check = ShopAttributesProducts::where("attribute_id", $option->shop_attribute_id)
                        ->where("option_id", $option->id)
                        ->whereIn("product_id", $prod_same_attributes)
                        ->first();
                    if($check){
                        $product_id = $check->product_id;
                        $itemProductVariant = PluginProducts::where("id", $product_id)->first();
                        if($itemProductVariant){
                            $cat_prod_slug = "no-categoria";
                            $cat_prod = $itemProductVariant->category();
                            if($cat_prod){
                                $cat_prod_slug = $cat_prod->slug;
                            }
                            return redirect()->route("pluginProducts.detail.".\App::getLocale(), [$cat_prod_slug,$itemProductVariant->slug]);
                        }
                    }
                }
            }
        }else{
            $itemProductVariant = PluginProducts::where("id", $shopAttributeProduct->product_id)->first();
            if($itemProductVariant){
                $cat_prod_slug = "no-categoria";
                $cat_prod = $itemProductVariant->category();
                if($cat_prod){
                    $cat_prod_slug = $cat_prod->slug;
                }

                return redirect()->route("pluginProducts.detail.".\App::getLocale(), [$cat_prod_slug,$itemProductVariant->slug]);
            }
        }


    }
}
