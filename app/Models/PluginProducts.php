<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class PluginProducts extends Model
{
    use CrudTrait;
    use HasTranslations;
    use SoftDeletes;

    public $translatable = ["name", "slug", "meta_title", "meta_description", "meta_key", "description_short", "info_extra_list", "description", "tags", "custom_1", "custom_2", "title_labels", "description_labels"];

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'plugins_products';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id','category_list','variant_html', 'image', 'cat_new', 'brand_new'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];

    protected $casts = [
        'attachments' => 'array'
    ];

    protected static $listingPreloadedProductIds = [];
    protected static $listingImagesByProduct = [];
    protected static $listingLangImagesByProduct = [];
    protected static $listingCartByProduct = [];
    protected static $listingCartLoadedProductIds = [];
    protected static $listingSessionCartByProduct = null;
    protected static $listingShopSetting = null;
    protected static $promoPriceMemo = [];
    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public function getCheck(){
        return "<input type='checkbox' class='checkbox' name='ids[]' value='{$this->id}'>";
    }


    public function getIsEvidenza(){
        if($this->is_evidenza == 1){
            $url = route('dashboard.set.field.boolean', ['plugins_products', $this->id, "is_evidenza", 0]);
            if(backpack_user()->roles[0]->id == 4){
                return "<span class='text text-success'><i class=\"las la-star\"></i></span>";
            }
            return "<a href='$url' class='text text-success'><i class=\"las la-star\"></i></a>";
        }else{
            $url = route('dashboard.set.field.boolean', ['plugins_products', $this->id, "is_evidenza", 1]);
            if(backpack_user()->roles[0]->id == 4){
                return "<span class='text text-danger'><i class=\"las la-star\"></i></span>";
            }
            return "<a href='$url' class='text text-danger'><i class=\"las la-star\"></i></a>";
        }
    }

    public function getIsPurchasable(){
        if($this->is_purchasable == 1){
            $url = route('dashboard.set.field.boolean', ['plugins_products', $this->id, "is_purchasable", 0]);
            if(backpack_user()->roles[0]->id == 4){
                return "<span class='text text-success'><i class=\"las la-star\"></i></span>";
            }
            return "<a href='$url' class='text text-success'><i class=\"las la-star\"></i></a>";
        }else{
            $url = route('dashboard.set.field.boolean', ['plugins_products', $this->id, "is_purchasable", 1]);
            if(backpack_user()->roles[0]->id == 4){
                return "<span class='text text-danger'><i class=\"las la-star\"></i></span>";
            }
            return "<a href='$url' class='text text-danger'><i class=\"las la-star\"></i></a>";
        }
    }

    public function getFoto()
    {
        $photo = PluginProductsImages::where("product_id", $this->id)->orderBy("order", "asc")->first();
        if($photo){
            if($photo->is_ext == 1){
                $url = $photo->image;
                return "<img src='$url' width='60'>";
            }

            $basename = basename($photo->image);
            $temp = explode(".", $basename);

            if (key_exists(1, $temp)) {
                $checkImage = "thumb/plugin_products/$temp[0]-mini.webp";
            } else {
                $checkImage = "thumb/plugin_products/$temp[0]-mini";
            }

            if (file_exists($checkImage)) {
                $url = url($checkImage);
                return "<img src='$url'>";
            }

            if(is_numeric(strpos($photo->image, "uploads"))){
                $url = url("$photo->image");
            }else{
                $url = url("uploads/products/$photo->image");
            }
            return "<img src='$url' width='40'>";
        }else{
            $url = url("uploads/no-image.jpg");
            return "<img src='$url' width='40'>";
        }
    }

    public function getCategories(){
        $list = PluginProductsCategoriesProducts::join("plugins_products_categories", "plugins_products_categories.id", "=", "plugins_products_categories_products.plugin_product_category_id")
        ->where("plugin_product_product_id", $this->id)
            ->get();

        if($list){
            $html = "<ul>";
            if(count($list) > 1){
                $html .= "<li>Associato a più categorie</li>";
            }else{
                foreach ($list as $item){
                    $name = json_decode($item->name, true);
                    $html .= "<li>{$name['it']}</li>";
                }
            }

            $html .= "</ul>";
        }

        return $html;
    }


    public function getMenu(){
        $type = "pluginProducts";

        $url_edit = "/admin/$type/$this->id/edit";
        $url_photo = "/admin/pluginProductsImages?id=$this->id";
        $url_photo_size = "/admin/pluginProductsImagesSize?id=$this->id";
        $url_dropzone = "/admin/dropzone?table=plugins_products_images&id=$this->id";
        $url_options = "/admin/pluginProductsOptions?id=$this->id";
        $url_attachments = "/admin/pluginProductsAttachments?id=$this->id";

        $num_foto = PluginProductsImages::where("product_id", $this->id)->count();
        $num_foto_size = PluginProductsImagesSize::where("product_id", $this->id)->count();
        $num_attachments = PluginProductsAttachments::where("product_id", $this->id)->count();

        $icon_editing = "";
        $adminPlugin = AdminPlugin::where("name", "pluginProducts")->first();
        $link_editing = "<a class='dropdown-item' href='$url_dropzone'>Dropzone ($num_foto)</a><a class='dropdown-item' href='$url_photo'>Foto ($num_foto)</a>
<a class='dropdown-item' href='$url_photo_size'>Foto taglie ($num_foto_size)</a>";

        $icon_varianti = "<i class='nav-icon las la-shopping-bag'></i>";
        if($adminPlugin->version >= 1){
            $link_varianti = "";
            $url_varianti = "/admin/shopProductsVariants?group_id=$this->group_id";
            if($adminPlugin->version == 3){
                $n_varianti = PluginProducts::where("is_variant", 1)->where("group_id", $this->group_id)->count();
                $link_varianti = "<a class='dropdown-item' href='$url_varianti'>Varianti ($n_varianti)</a>";

                if($n_varianti > 0){
                    $icon_varianti = "<i class='nav-icon las la-list'></i>";
                }

            }

            $genera_thumb = "";
            if(backpack_user()->roles[0]->id == 1){
                $url_thumb = route("pluginsProducts.generate_thumb", $this->id);
               // $genera_thumb = "<a class='dropdown-item' href='$url_thumb'>Rigenera Thumb</a>";
            }


            $num_opt = PluginProductsOptions::where("product_id", $this->id)->count();
            $link_editing = "<a class='dropdown-item' href='$url_dropzone'>Dropzone ($num_foto)</a> <a class='dropdown-item' href='$url_photo'>Foto ($num_foto)</a>
<a class='dropdown-item' href='$url_photo_size'>Foto Taglie($num_foto_size)</a>
<a class='dropdown-item' href='$url_options'>Proprietà ($num_opt)</a> $link_varianti";

        }

        $link_anteprima = "";
        if($this->is_active == 1){
            $lang = \App::getLocale();
            $lang_up = strtoupper($lang);

            $url_plugin_product = env("PLUGIN_PRODUCTS_URL_$lang_up");
            $url_site = env("APP_URL");

            $url_anteprima = "$url_site/$url_plugin_product/anteprima/$this->slug";
            $link_anteprima = "<a class=\"dropdown-item\" href=\"$url_anteprima\" target='_blank'>Anteprima</a>";
        }



        $link_attachments = "<a class='dropdown-item' href='$url_attachments'>Allegati ($num_attachments)</a>";

        $editing = UserNavigation::where("user_id", "!=", backpack_user()->id)->where("url", $url_edit)->first();

        $html = '<div class="dropdown">
                  <button class="btn btn-dark dropdown-toggle btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    '.$icon_editing.' '.$icon_varianti.' Gestione
                  </button>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    '.$link_anteprima.'
                    <a class="dropdown-item" href='.$url_edit.'>Modifica</a>
                    '.$link_editing.'
                    '.$link_attachments.'
                     '.$genera_thumb.'
                    <a href="javascript:void(0)" onclick="cloneEntry(this)" data-route="/admin/'.$type.'/'.$this->id.'/clone" class="dropdown-item" data-button-type="clone">Duplica</a>
                    <a href="javascript:void(0)" onclick="deleteEntry(this)" data-route="/admin/'.$type.'/'.$this->id.'" class="dropdown-item" data-button-type="delete">Elimina</a>
                  </div>
                </div>';
        if($editing){
            $icon_editing = "<i class='la la-exclamation text text-danger'></i>";

            $user = User::find($editing->user_id);
            if($user){
                $link_editing = "<span class=\"text text-danger\">$user->name in modifica...</span>";
            }

            $html = ''.$icon_editing.' '.$link_editing.'';
        }

        $html .= '<script>
                        if (typeof cloneEntry != \'function\') {
                          $("[data-button-type=clone]").unbind(\'click\');

                          function cloneEntry(button) {
                              // ask for confirmation before deleting an item
                              // e.preventDefault();
                              var button = $(button);
                              var route = button.attr(\'data-route\');

                              $.ajax({
                                  url: route,
                                  type: "POST",
                                  success: function(result) {
                                      // Show an alert with the result
                                      new Noty({
                                        type: "success",
                                        text: "<strong>Elemento duplicato</strong><br>Un nuovo elemento è stato creato con le stesse informazioni di questo."
                                      }).show();

                                      // Hide the modal, if any
                                      $(\'.modal\').modal(\'hide\');

                                      if (typeof crud !== \'undefined\') {
                                        crud.table.ajax.reload();
                                      }
                                  },
                                  error: function(result) {
                                      // Show an alert with the result
                                      new Noty({
                                        type: "warning",
                                        text: "<strong>Duplicazione fallita</strong><br>Il nuovo elemento non può essere creato. Per favore, riprova."
                                      }).show();
                                  }
                              });
                          }
                        }
                        // make it so that the function above is run after each DataTable draw event
                        // crud.addFunctionToDataTablesDrawEventQueue(\'cloneEntry\');
                    </script>';

        $html .='<script>

            if (typeof deleteEntry != \'function\') {
              $("[data-button-type=delete]").unbind(\'click\');

              function deleteEntry(button) {
                // ask for confirmation before deleting an item
                // e.preventDefault();
                var button = $(button);
                var route = button.attr(\'data-route\');
                var row = $("#crudTable a[data-route=\'"+route+"\']").closest(\'tr\');

                swal({
                  title: "Avvertimento",
                  text: "Sei sicuro di eliminare questo elemento?",
                  icon: "warning",
                  buttons: {
                    cancel: {
                      text: "Annulla",
                      value: null,
                      visible: true,
                      className: "bg-secondary",
                      closeModal: true,
                    },
                    delete: {
                      text: "Elimina",
                      value: true,
                      visible: true,
                      className: "bg-danger",
                    }
                  },
                }).then((value) => {
                    if (value) {
                        $.ajax({
                          url: route,
                          type: \'DELETE\',
                          success: function(result) {
                              if (result == 1) {
                                  // Show a success notification bubble
                                  new Noty({
                                    type: "success",
                                    text: "<strong>Elemento eliminato</strong><br>L\'elemento è stato eliminato con successo."
                                  }).show();

                                  // Hide the modal, if any
                                  $(\'.modal\').modal(\'hide\');

                                  // Remove the details row, if it is open
                                  if (row.hasClass("shown")) {
                                      row.next().remove();
                                  }

                                  // Remove the row from the datatable
                                  row.remove();
                              } else {
                                  // if the result is an array, it means
                                  // we have notification bubbles to show
                                  if (result instanceof Object) {
                                    // trigger one or more bubble notifications
                                    Object.entries(result).forEach(function(entry, index) {
                                      var type = entry[0];
                                      entry[1].forEach(function(message, i) {
                                          new Noty({
                                            type: type,
                                            text: message
                                          }).show();
                                      });
                                    });
                                  } else {// Show an error alert
                                      swal({
                                        title: "NON eliminato",
                                        text: "C\'è stato un errore. L\'elemento potrebbe non essere stato eliminato.",
                                        icon: "error",
                                        timer: 4000,
                                        buttons: false,
                                      });
                                  }
                              }
                          },
                          error: function(result) {
                              // Show an alert with the result
                              swal({
                                title: "NON eliminato",
                                text: "C\'è stato un errore. L\'elemento potrebbe non essere stato eliminato.",
                                icon: "error",
                                timer: 4000,
                                buttons: false,
                              });
                          }
                      });
                    }
                });

              }
            }

            // make it so that the function above is run after each DataTable draw event
            // crud.addFunctionToDataTablesDrawEventQueue(\'deleteEntry\');
        </script>';

        return $html;
    }

    public function setAttachmentsAttribute($value)
    {
        $attribute_name = "attachments";
        $disk = "public";
        $destination_path = "uploads/attachments";

        $this->uploadMultipleFilesToDisk($value, $attribute_name, $disk, $destination_path);
    }

    public function setPriceAttribute($value)
    {
        if($value){
            $this->attributes['price'] = str_replace(",", ".", $value);
        }

    }
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function category(){
        $item = PluginProductsCategoriesProducts::selectRaw("plugins_products_categories.*")
            ->join("plugins_products_categories", "plugins_products_categories.id", "=", "plugins_products_categories_products.plugin_product_category_id")
            ->where("plugin_product_product_id", $this->id)
            ->first();

        if($item){
            return PluginProductsCategories::find($item->id);
        }

        return null;
    }

    public function brand(){
        return $this->belongsTo(PluginProductsBrands::class, "brand_id");
    }

    public function in_wishlist($user_id){
        return Wishlist::where("user_id", $user_id)->where("product_id", $this->id)->first();
    }

    public function in_cart(){
        if(\Session::has('user_id')){
            $userId = (int) \Session::get('user_id');
            if(in_array($this->id, self::$listingCartLoadedProductIds, true)){
                return self::$listingCartByProduct[$this->id] ?? false;
            }

            $item = Cart::where("user_id", $userId)
                ->where("product_id", $this->id)
                ->first();
            self::$listingCartByProduct[$this->id] = $item;
            self::$listingCartLoadedProductIds[] = (int) $this->id;
            return $item ?: false;
        }else{
            if(self::$listingSessionCartByProduct === null){
                self::$listingSessionCartByProduct = [];
                $cart = \Session::get('cart.products');
                if($cart){
                    foreach ($cart as $item){
                        self::$listingSessionCartByProduct[$item->product_id] = $item;
                    }
                }
            }

            return self::$listingSessionCartByProduct[$this->id] ?? false;
        }
    }

    public function getFinalPrice(){
        if(env('VIEW_WITH_IVA') == 1){
            if($this->tax){
                $finalPrice = $this->price + (($this->price * $this->tax->value)/100);
                return $finalPrice;
            }
        }

        $finalPrice = $this->price;
        return $finalPrice;
    }

    public function getCoverMini(){
        $check = PluginProductsImages::where("product_id", $this->id)->orderBy("order", "asc")->first();
        $cover = url('uploads/no-image.jpg');
        if($check){
            if($check->is_ext == 1){
                $url = $check->image;
                return $url;
            }


            $basename = basename($check->image);
            $temp = explode(".", $basename);

            if(env("PROJECT_NAME") != "Maison-Flaneur") {
                if (key_exists(1, $temp)) {
                    $checkImage = "thumb/plugin_products/$temp[0]-mini.webp";
                } else {
                    $checkImage = "thumb/plugin_products/$temp[0]-mini";
                }

                if (file_exists($checkImage)) {
                    $url = url($checkImage);
                    return $url;
                }
            }

            if(env("PROJECT_NAME") != "Maison-Flaneur") {
                if (key_exists(1, $temp)) {
                    $checkImage = "thumb/plugin_products/$temp[0]-list.webp";
                } else {
                    $checkImage = "thumb/plugin_products/$temp[0]-list";
                }

                if (file_exists($checkImage)) {
                    $url = url($checkImage);
                    return $url;
                }
            }

            if(is_numeric(strpos($check->image, "uploads"))){
                $url = url($check->image);
            }else{
                $url = url("uploads/products/$check->image");
            }

            return $url;
        }

        return $cover;
    }


    public function getCover(){
        $lang = \App::getLocale();
        $check = $this->getListingLangImageForProduct($lang);
        if(!$check){
            $images = $this->getListingImagesForProduct();
            $check = $images[0] ?? null;
        }

        $cover = url('uploads/no-image.jpg');
        if($check){
            if($check->is_ext == 1){
                $url = $check->image;
                return $url;
            }

            $basename = basename($check->image);
            $temp = explode(".", $basename);


            if(env("PROJECT_NAME") != "Maison-Flaneur") {
                if (key_exists(1, $temp)) {
                    $checkImage = "thumb/plugin_products/$temp[0]-list.webp";
                } else {
                    $checkImage = "thumb/plugin_products/$temp[0]-list";
                }

                if(is_numeric(strpos($check->image, "uploads/special_images"))){
                    if (key_exists(1, $temp)) {
                        $checkImage = "thumb/special_images/{$this->id}/$temp[0]-list.webp";
                    }
                }

                if (file_exists($checkImage)) {
                    $url = url($checkImage);
                    return $url;
                }
            }

            if(is_numeric(strpos($check->image, "uploads"))){
                $url = url($check->image);
            }else{
                $url = url("uploads/products/$check->image");
            }

            return $url;
        }

        return $cover;
    }

    public function getCoverExcel(){
        $check = PluginProductsImages::where("product_id", $this->id)->orderBy("order", "asc")->first();
        $cover = 'uploads/no-image.jpg';
        if($check){
            if($check->is_ext == 1){
                $url = $check->image;
                return $url;
            }

            if(is_numeric(strpos($check->image, "uploads"))){
                $url = $check->image;
            }else{
                $url = "uploads/products/$check->image";
            }

            $cover = $url;
        }

        return $cover;
    }

    public function getLastPhoto(){
        $check = PluginProductsImages::where("product_id", $this->id)->orderBy("order", "desc")->first();
        $cover = url('uploads/no-image.jpg');
        if($check){
            if($check->is_ext == 1){
                $url = $check->image;
                return $url;
            }

            if(is_numeric(strpos($check->image, "uploads"))){
                $url = url($check->image);
            }else{
                $url = url("uploads/products/$check->image");
            }

            $cover = $url;
        }
        return $cover;
    }

    public function getSecondPhoto(){
        $shopSetting = self::getListingShopSetting();
        $k = ((int) ($shopSetting->mouseover_image_number ?? 1)) - 1;
        if($k < 0){
            $k = 0;
        }

        $list = $this->getListingImagesForProduct();
        $count = count($list);
        if($count > 1){
            if($list){
                $i = 0;
                foreach ($list as $image){
                    if($i == $k){
                        if($image->is_ext == 1){
                            $url = $image->image;
                            return $url;
                        }

                        $basename = basename($image->image);
                        $temp = explode(".", $basename);

                        if(env("PROJECT_NAME") != "Maison-Flaneur") {
                            if (key_exists(1, $temp)) {
                                $checkImage = "thumb/plugin_products/$temp[0]-list.webp";
                            } else {
                                $checkImage = "thumb/plugin_products/$temp[0]-list";
                            }

                            if (file_exists($checkImage)) {
                                $url = url($checkImage);
                                return $url;
                            }
                        }

                        if(is_numeric(strpos($image->image, "uploads"))){
                            $url = url($image->image);
                        }else{
                            $url = url("uploads/products/$image->image");
                        }

                        $cover = $url;
                        return $cover;
                    }
                    $i++;
                }
            }
        }

        return false;
    }

    public static function preloadForListing(array $productIds, $lang = null)
    {
        $productIds = array_values(array_unique(array_filter(array_map('intval', $productIds))));
        if(!count($productIds)){
            return;
        }

        $lang = $lang ?: \App::getLocale();
        if(!array_key_exists($lang, self::$listingLangImagesByProduct)){
            self::$listingLangImagesByProduct[$lang] = [];
        }

        $missingProductIds = array_values(array_diff($productIds, self::$listingPreloadedProductIds));
        if(count($missingProductIds)){
            $images = PluginProductsImages::whereIn("product_id", $missingProductIds)
                ->orderBy("order", "asc")
                ->get();
            foreach ($images as $image){
                self::$listingImagesByProduct[$image->product_id][] = $image;
            }
            foreach ($missingProductIds as $productId){
                if(!array_key_exists($productId, self::$listingImagesByProduct)){
                    self::$listingImagesByProduct[$productId] = [];
                }
            }

            $langImages = PluginProductsLangs::whereIn("product_id", $missingProductIds)
                ->where("lang", $lang)
                ->whereNotNull("image")
                ->get();
            foreach ($langImages as $langImage){
                self::$listingLangImagesByProduct[$lang][$langImage->product_id] = $langImage;
            }
            foreach ($missingProductIds as $productId){
                if(!array_key_exists($productId, self::$listingLangImagesByProduct[$lang])){
                    self::$listingLangImagesByProduct[$lang][$productId] = false;
                }
            }

            self::$listingPreloadedProductIds = array_values(array_unique(array_merge(self::$listingPreloadedProductIds, $missingProductIds)));
        }

        if(\Session::has('user_id')){
            $missingCartIds = array_values(array_diff($productIds, self::$listingCartLoadedProductIds));
            if(count($missingCartIds)){
                $userId = (int) \Session::get('user_id');
                $items = Cart::where("user_id", $userId)
                    ->whereIn("product_id", $missingCartIds)
                    ->get();

                foreach ($missingCartIds as $productId){
                    self::$listingCartByProduct[$productId] = false;
                }
                foreach ($items as $item){
                    self::$listingCartByProduct[$item->product_id] = $item;
                }

                self::$listingCartLoadedProductIds = array_values(array_unique(array_merge(self::$listingCartLoadedProductIds, $missingCartIds)));
            }
        }else{
            if(self::$listingSessionCartByProduct === null){
                self::$listingSessionCartByProduct = [];
                $cart = \Session::get('cart.products');
                if($cart){
                    foreach ($cart as $item){
                        self::$listingSessionCartByProduct[$item->product_id] = $item;
                    }
                }
            }
        }

        self::getListingShopSetting();
    }

    protected static function getListingShopSetting()
    {
        if(self::$listingShopSetting === null){
            self::$listingShopSetting = ShopSettings::first();
        }

        return self::$listingShopSetting;
    }

    protected function getListingImagesForProduct()
    {
        if(array_key_exists($this->id, self::$listingImagesByProduct)){
            return self::$listingImagesByProduct[$this->id];
        }

        $list = PluginProductsImages::where("product_id", $this->id)->orderBy("order", "asc")->get();
        self::$listingImagesByProduct[$this->id] = $list ? $list->all() : [];

        return self::$listingImagesByProduct[$this->id];
    }

    protected function getListingLangImageForProduct($lang)
    {
        if(!array_key_exists($lang, self::$listingLangImagesByProduct)){
            self::$listingLangImagesByProduct[$lang] = [];
        }

        if(isset(self::$listingLangImagesByProduct[$lang]) && array_key_exists($this->id, self::$listingLangImagesByProduct[$lang])){
            return self::$listingLangImagesByProduct[$lang][$this->id] ?: null;
        }

        $item = PluginProductsLangs::where("product_id", $this->id)
            ->where("lang", $lang)
            ->whereNotNull("image")
            ->first();

        self::$listingLangImagesByProduct[$lang][$this->id] = $item ?: false;

        return $item;
    }

    public function tax()
    {
        return $this->belongsTo(Tax::class, "tax_id");
    }

    public function getShipPrice($price){
        /*if($this->shipping_id){
            $ship = ShippingRange::whereRaw("min <= '$price' AND max >= '$price' AND shipping_id = {$this->shipping_id}")->first();
            if($ship){
                return round($ship->price,2);
            }
        }*/
        return 0;
    }


    public function get_promo_price($piuiva = null){
        $countryId = \Auth::user() ? (int) \Auth::user()->country_id : 0;
        $memoKey = implode('|', [
            (int) $this->id,
            $piuiva ? 1 : 0,
            $countryId
        ]);

        if(array_key_exists($memoKey, self::$promoPriceMemo)){
            return self::$promoPriceMemo[$memoKey];
        }

        $now = Carbon::now()->toDateTimeString();
        $now_base = Carbon::now();

        $plugin = PluginProductsSettings::first();
        $adminPlugin = AdminPlugin::where("name", "pluginProducts")->first();

        $priceStart = $this->price;

        if(\Auth::user() && in_array(\Auth::user()->country_id, config('config.default_country_user_dollar'))){
            if($this->price_dollar){
                $priceStart = $this->price_dollar;
            }
        }

        if(\Auth::user() && in_array(\Auth::user()->country_id, config('config.default_country_user_listino_2'))){
            if($this->price_2){
                $priceStart = $this->price_2;
            }
        }

        //AGGIUNTA NELLA MODIFICA CHE UNA O PIù OPZIONI POSSONO AVERE DEI PREZZI AGGIUNTIVI
        if($this->is_variant == 1){
            $sum_price_options = \App\Models\ShopAttributesProducts::selectRaw("shop_attributes_options.*")
                ->join("shop_attributes_options", "shop_attributes_options.id", "=", "option_id")
                ->whereNull("shop_attributes_options.deleted_at")
                ->where("product_id", $this->id)->sum("price");

            $priceStart = $priceStart + $sum_price_options;
        }

        $promo_priority = Promotion::whereRaw("(start_date <= '$now' AND expiration_date >='$now') AND is_forced = 1")
            ->count();

        if($promo_priority > 0){
            $categories_ids = PluginProductsCategoriesProducts::where("plugin_product_product_id", $this->id)->get()
                ->pluck("plugin_product_category_id")
                ->toArray();

            //controllo se esistono promozioni per categoria
            if(count($categories_ids)){
                $promotions = Promotion::whereIn("category_id", $categories_ids)
                    ->whereRaw("(start_date <= '$now' AND expiration_date >='$now')")
                    ->get();

                if($promotions){
                    foreach ($promotions as $promo){
                        if ($promo->discount_type == "Amount") {
                            $priceStart = round($this->getFinalPrice(),2);

                            $priceStart = $priceStart - $promo->reduction;
                        } else {
                            $priceStart = $priceStart - (($priceStart * ($promo->reduction)) / 100);
                        }
                    }
                }
            }

            if($this->brand_id !== null) {
                $promotions = Promotion::where("brand_id", $this->brand_id)
                    ->whereNull("category_id")
                    ->whereRaw("(start_date <= '$now' AND expiration_date >='$now')")
                    ->get();
                if (count($promotions)) {
                    foreach ($promotions as $promo) {
                        if ($promo->discount_type == "Amount") {
                            $priceStart = round($this->getFinalPrice(),2);
                            $priceStart = $priceStart - $promo->reduction;
                        } else {
                            $priceStart = $priceStart - (($priceStart * ($promo->reduction)) / 100);
                        }
                    }
                }
            }

            if($piuiva){
                $finalPrice = ($priceStart + (($priceStart * $this->tax->value)/100));
                self::$promoPriceMemo[$memoKey] = $finalPrice;
                return $finalPrice;
            }

            self::$promoPriceMemo[$memoKey] = $priceStart;
            return $priceStart;
        }

        if(($plugin->show_prices || $adminPlugin->version == 3) && $this->promo_price !== null && trim($this->promo_price) != "" && $this->data_promo_end && $this->data_promo_start){
            $data_start = Carbon::createFromFormat("Y-m-d", $this->data_promo_start);
            $data_end = Carbon::createFromFormat("Y-m-d", $this->data_promo_end);

            if($now_base->gt($data_start) && $now_base->lt($data_end)){
                if($piuiva){
                    $finalPrice = ($this->promo_price + (($this->promo_price * $this->tax->value)/100));
                    self::$promoPriceMemo[$memoKey] = $finalPrice;
                    return $finalPrice;
                }

                self::$promoPriceMemo[$memoKey] = $this->promo_price;
                return $this->promo_price;
            }
        }

        if($piuiva){
            $finalPrice = ($priceStart + (($priceStart * $this->tax->value)/100));
            self::$promoPriceMemo[$memoKey] = $finalPrice;
            return $finalPrice;
        }
        self::$promoPriceMemo[$memoKey] = $priceStart;
        return $priceStart;
    }

    public function get_promo_price_cart($qty, $piuiva = null){
        $shopSetting = ShopSettings::first();

        $now = Carbon::now()->toDateTimeString();
        $now_base = Carbon::now();

        $plugin = PluginProductsSettings::first();
        $adminPlugin = AdminPlugin::where("name", "pluginProducts")->first();

        $priceStart = $this->price;

        //------------------PRODUCT QUANTITY
        if($shopSetting->is_qta_minima){
            $products_quantities = PluginProductsQuantities::where("plugin_product_id", $this->id)
                ->where("quantity_min", "<=", $qty)
                ->orderBy("quantity_min", "DESC")
                ->first();
            if($products_quantities && $shopSetting->is_qta_minima){
                $priceStart = $products_quantities->price;
            }
        }


        if(\Auth::user() && in_array(\Auth::user()->country_id, config('config.default_country_user_dollar'))){
            if($this->price_dollar){
                $priceStart = $this->price_dollar;
            }
        }

        if(\Auth::user() && in_array(\Auth::user()->country_id, config('config.default_country_user_listino_2'))){
            if($this->price_2){
                $priceStart = $this->price_2;
            }
        }

        //AGGIUNTA NELLA MODIFICA CHE UNA O PIù OPZIONI POSSONO AVERE DEI PREZZI AGGIUNTIVI
        if($this->is_variant == 1){
            $sum_price_options = \App\Models\ShopAttributesProducts::selectRaw("shop_attributes_options.*")
                ->join("shop_attributes_options", "shop_attributes_options.id", "=", "option_id")
                ->whereNull("shop_attributes_options.deleted_at")
                ->where("product_id", $this->id)->sum("price");

            $priceStart = $priceStart + $sum_price_options;
        }

        $promo_priority = Promotion::whereRaw("(start_date <= '$now' AND expiration_date >='$now') AND is_forced = 1")
            ->count();

        if($promo_priority > 0){
            $categories_ids = PluginProductsCategoriesProducts::where("plugin_product_product_id", $this->id)->get()
                ->pluck("plugin_product_category_id")
                ->toArray();

            //controllo se esistono promozioni per categoria
            if(count($categories_ids)){
                $promotions = Promotion::whereIn("category_id", $categories_ids)
                    ->whereRaw("(start_date <= '$now' AND expiration_date >='$now')")
                    ->get();

                if($promotions){
                    foreach ($promotions as $promo){
                        if ($promo->discount_type == "Amount") {
                            $priceStart = round($this->getFinalPrice(),2);

                            $priceStart = $priceStart - $promo->reduction;
                        } else {
                            $priceStart = $priceStart - (($priceStart * ($promo->reduction)) / 100);
                        }
                    }
                }
            }



            if($this->brand_id !== null) {
                $promotions = Promotion::where("brand_id", $this->brand_id)
                    ->whereNull("category_id")
                    ->whereRaw("(start_date <= '$now' AND expiration_date >='$now')")
                    ->get();
                if (count($promotions)) {
                    foreach ($promotions as $promo) {
                        if ($promo->discount_type == "Amount") {
                            $priceStart = round($this->getFinalPrice(),2);
                            $priceStart = $priceStart - $promo->reduction;
                        } else {
                            $priceStart = $priceStart - (($priceStart * ($promo->reduction)) / 100);
                        }
                    }
                }
            }

            if($piuiva){
                $finalPrice = ($priceStart + (($priceStart * $this->tax->value)/100));
                return $finalPrice;
            }

            return $priceStart;
        }

        if(($plugin->show_prices || $adminPlugin->version == 3) && $this->promo_price !== null && trim($this->promo_price) != "" && $this->data_promo_end && $this->data_promo_start){
            $data_start = Carbon::createFromFormat("Y-m-d", $this->data_promo_start);
            $data_end = Carbon::createFromFormat("Y-m-d", $this->data_promo_end);

            if($now_base->gt($data_start) && $now_base->lt($data_end)){
                if($piuiva){
                    $finalPrice = ($this->promo_price + (($this->promo_price * $this->tax->value)/100));
                    return $finalPrice;
                }

                return $this->promo_price;
            }
        }

        if($piuiva){
            $taxRate   = (float)$this->tax->value / 100;
            $netUnit   = (float)$priceStart;

            // conta i decimali effettivi del prezzo unitario
            $decimals = strlen(substr(strrchr(rtrim(number_format($netUnit, 3, '.', ''), '0'), '.'), 1));

            if ($decimals > 2) {
                // Prezzo con più di 2 decimali → arrotonda per unità (es. 49.181)
                $unitGross = round($netUnit * (1 + $taxRate), 2, PHP_ROUND_HALF_UP);
                $finalPrice = round($unitGross, 2, PHP_ROUND_HALF_UP);
            } else {
                // Prezzo con 2 decimali → calcolo sul totale (es. 10.10)
                $finalPrice = $netUnit * (1 + $taxRate);
            }

            return $finalPrice;
        }

        return $priceStart;
    }

    public function get_vet_ids($shopSetting){
        $vet_ids = [];
        if($shopSetting->view_variants_in_list == 1){
            //prendo ids varianti
            $variants_ids = \App\Models\PluginProducts::where("group_id", $this->group_id)
                ->where("is_variant", 1)
                ->where("is_active", 1)
                ->get()->pluck("id")
                ->toArray();

            $vet_ids = \App\Models\ShopAttributesProducts::selectRaw("GROUP_CONCAT(product_id) as ids, option_id")
                ->join("shop_attributes_options", "shop_attributes_options.id", "=", "shop_attributes_products.option_id")
                ->where("attribute_id", 1)
                ->whereIn("product_id", $variants_ids)
                ->orderBy("shop_attributes_options.value", "asc")
                ->groupBy("option_id")
                ->get()
                ->pluck("ids", "option_id")
                ->toArray();
        }

        if($shopSetting->view_variants_in_list == 2){
            //prendo ids varianti
            $variants_ids = \App\Models\PluginProducts::where("group_id", $this->group_id)
                ->where("is_variant", 1)
                ->where("is_active", 1)
                ->get()->pluck("id")
                ->toArray();

            $attributes = \App\Models\ShopAttributes::orderBy("lft", "asc")->get();
            if($attributes){
                foreach ($attributes as $attribute_item){
                    $options = \App\Models\ShopAttributesOptions::selectRaw("shop_attributes_products.id, shop_attributes_options.value,shop_attributes_products.product_id, shop_attributes.type_layout, shop_attributes_options.background_color")
                        ->join("shop_attributes_products", "shop_attributes_options.id", "shop_attributes_products.option_id")
                        ->join("shop_attributes", "shop_attributes.id", "shop_attributes_options.shop_attribute_id")
                        ->where("attribute_id", $attribute_item->id)
                        ->whereIn("product_id", $variants_ids)
                        ->orderBy("shop_attributes_options.ordine", "asc")
                        ->groupBy("value")
                        ->get();

                    $vet_ids[$attribute_item->name] = $options;
                }
            }
        }

        return $vet_ids;
    }

    public function get_vet_ids_search($shopSetting){
        $vet_ids = [];
        if($shopSetting->view_variants_in_list == 1){
            //prendo ids varianti
            $variants_ids = \App\Models\PluginProducts::where("group_id", $this->group_id)
                ->where("is_variant", 1)
                ->where("is_active", 1)
                ->get()->pluck("id")
                ->toArray();

            $vet_ids = \App\Models\ShopAttributesProducts::selectRaw("GROUP_CONCAT(product_id) as ids, option_id")
                ->join("shop_attributes_options", "shop_attributes_options.id", "=", "shop_attributes_products.option_id")
                ->where("attribute_id", 1)
                ->whereIn("product_id", $variants_ids)
                ->orderBy("shop_attributes_options.value", "asc")
                ->groupBy("option_id")
                ->get()
                ->pluck("ids", "option_id")
                ->toArray();
        }

        if($shopSetting->view_variants_in_list == 2){
            //prendo ids varianti
            $variants_ids = \App\Models\PluginProducts::where("group_id", $this->group_id)
                ->where("is_variant", 1)
                ->where("is_active", 1)
                ->get()->pluck("id")
                ->toArray();

            $attributes = \App\Models\ShopAttributes::orderBy("lft", "asc")->get();
            if($attributes){
                foreach ($attributes as $attribute_item){
                    $options = \App\Models\ShopAttributesOptions::selectRaw("shop_attributes_products.id, shop_attributes_options.id as option_id, shop_attributes_options.value,shop_attributes_products.product_id, shop_attributes.type_layout, shop_attributes_options.background_color")
                        ->join("shop_attributes_products", "shop_attributes_options.id", "shop_attributes_products.option_id")
                        ->join("shop_attributes", "shop_attributes.id", "shop_attributes_options.shop_attribute_id")
                        ->where("attribute_id", $attribute_item->id)
                        ->whereIn("product_id", $variants_ids)
                        ->orderBy("shop_attributes_options.ordine", "asc")
                        ->groupBy("value")
                        ->get();

                    if($options){
                        foreach ($options as $option){
                            $product_temp = \App\Models\PluginProducts::find($option->product_id);

                            $option->url_product = null;
                            if($product_temp){
                                $cat_prod_slug = "no-categoria";
                                $cat_prod = $product_temp->category();
                                if($cat_prod){
                                    $cat_prod_slug = $cat_prod->slug;
                                }

                                $option->url_product = route("pluginProducts.detail.".\App::getLocale(), [$cat_prod_slug, $product_temp->slug]);
                                //$option->url_product = route("pluginProducts.choose.".\App::getLocale(), [$product_temp->slug, $option->id]);
                            }

                            $vet_ids[$attribute_item->name][] = $option;
                        }
                    }

                }
            }
        }

        return $vet_ids;
    }
    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
