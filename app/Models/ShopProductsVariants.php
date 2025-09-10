<?php

namespace App\Models;

use App\User;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class ShopProductsVariants extends Model
{
    use CrudTrait;
    use HasTranslations;
    use SoftDeletes;

    public $translatable = ["name", "slug", "meta_title", "meta_description", "meta_key", "description_short", "description", "tags", "custom_1", "custom_2"];
    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'plugins_products';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public function getCheck(){
        return "<input type='checkbox' class='checkbox' name='ids[]' value='{$this->id}'>";
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

    public function getIsEvidenza(){
        if($this->is_evidenza == 1){
            return "<span class='text text-success'><i class=\"las la-star\"></i></span>";
        }else{
            return "<span class='text text-danger'><i class=\"las la-star\"></i></span>";
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

            if(is_numeric(strpos($photo->image, "uploads"))){
                $url = url("$photo->image");
            }else{
                $url = url("uploads/products/$photo->image");
            }
            return "<img src='$url' width='40'>";
        }else{
            $url = url("plugins/pluginProducts/no-image.jpg");
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

        $url_edit = "/admin/$type/$this->id/edit?group_id=$this->group_id";
        $url_dropzone = "/admin/dropzone?table=plugins_products_images&id=$this->id";
        $url_photo = "/admin/pluginProductsImages?id=$this->id";
        $url_photo_size = "/admin/pluginProductsImagesSize?id=$this->id";
        $url_options = "/admin/pluginProductsOptions?id=$this->id";
        $url_attachments = "/admin/pluginProductsAttachments?id=$this->id";

        $num_foto = PluginProductsImages::where("product_id", $this->id)->count();
        $num_foto_size = PluginProductsImagesSize::where("product_id", $this->id)->count();
        $num_attachments = PluginProductsAttachments::where("product_id", $this->id)->count();

        $link_anteprima = "";
        if($this->is_active == 1){
            $lang = \App::getLocale();
            $lang_up = strtoupper($lang);

            $url_plugin_product = env("PLUGIN_PRODUCTS_URL_$lang_up");
            $url_site = env("APP_URL");

            $url_anteprima = "$url_site/$url_plugin_product/anteprima/$this->slug";
            $link_anteprima = "<a class=\"dropdown-item\" href=\"$url_anteprima\" target='_blank'>Anteprima</a>";
        }

        $icon_editing = "";
        $adminPlugin = AdminPlugin::where("name", "pluginProducts")->first();
        $link_editing = "<a class='dropdown-item' href='$url_dropzone'>Dropzone ($num_foto)</a> <a class='dropdown-item' href='$url_photo'>Foto ($num_foto)</a>
<a class='dropdown-item' href='$url_photo_size'>Foto taglie ($num_foto_size)</a>
<a class=\"dropdown-item\" href=\"$url_edit\">Modifica</a>";
        if($adminPlugin->version > 1){
            $link_varianti = "";
            $num_opt = PluginProductsOptions::where("product_id", $this->id)->count();
            $link_editing = "<a class='dropdown-item' href='$url_dropzone'>Dropzone ($num_foto)</a> <a class='dropdown-item' href='$url_photo'>Foto ($num_foto)</a>
<a class='dropdown-item' href='$url_photo_size'>Foto taglie ($num_foto_size)</a>
<a class='dropdown-item' href='$url_options'>Proprietà ($num_opt)</a> $link_varianti <a class=\"dropdown-item\" href=\"$url_edit\">Modifica</a>";
        }

        $link_attachments = "<a class='dropdown-item' href='$url_attachments'>Allegati ($num_attachments)</a>";

        $editing = UserNavigation::where("user_id", "!=", backpack_user()->id)->where("url", $url_edit)->first();

        $html_attributes = "";
        /*$attributes = ShopAttributesProducts::where("product_id", $this->id)->get();
        if($attributes){
            foreach ($attributes as $attribute){
                $attribute_item = ShopAttributes::find($attribute->attribute_id);

                if($attribute_item) {
                    $options = ShopAttributesOptions::where("shop_attribute_id", $attribute_item->id)
                        ->orderBy("value", "asc")
                        ->get();

                    $html_options = "";
                    if ($options) {
                        $html_options = "<select class='form-control' name='options[{$attribute->attribute_id}]'>";
                        $i = 0;
                        foreach ($options as $opt) {
                            if($opt->value == null){
                                continue;
                            }

                            $temp_value = json_decode($opt->value, true);

                            if($temp_value == null){
                                continue;
                            }
                            $name_option = addslashes($temp_value["it"]);

                            if($i == 0){
                                if($opt->id == $attribute->option_id){
                                    $html_options .= "<option value='{$opt->id}' selected>{$name_option}</option>";
                                }else{
                                    $html_options .= "<option value='{$opt->id}'>{$name_option}</option>";
                                }
                            }else{
                                $html_options .= "<option value='{$opt->id}'>{$name_option}</option>";
                            }
                            $i++;
                        }
                        $html_options .= "</select>";
                    }

                    $html_attributes .= '<div class="form-group">
                                        <label>' . $attribute_item->name . '</label>
                                        ' . $html_options . '
                                    </div>';
                }
            }
        }*/

        /*$modal = '<div class="modal fade" id="exampleModalNote_'.$this->id.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel_'.$this->id.'" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel_'.$this->id.'">Nuova opzione variante</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                              <form id="form-' . $this->id . '">
                                    <input type="hidden" name="product_id" value="'.$this->id.'">
                                    '.$html_attributes.'
                              </form>
                          </div>
                          <div class="modal-footer">
                             <a href="javascript:void(0)" onclick="cloneEntry(this)" data-route="/admin/'.$type.'/'.$this->id.'/clone" class="btn btn-success" data-button-type="clone">Duplica</a>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Annulla</button>
                          </div>
                        </div>
                      </div>
                    </div>';*/

        $modal = "";

        // <a href="javascript:void(0)" onclick="cloneEntry(this)" data-route="/admin/'.$type.'/'.$this->id.'/clone" class="dropdown-item" data-button-type="clone">Duplica</a>

        $html = ''.$modal.'<div class="dropdown">
                  <button class="btn btn-dark dropdown-toggle btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    '.$icon_editing.' Gestione
                  </button>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    '.$link_anteprima.'
                    '.$link_attachments.'
                    '.$link_editing.'
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
                              var res = route.split("/");

                              var dati = $("#form-"+res[3]).serialize();

                              $.ajax({
                                  url: route,
                                  type: "POST",
                                  data: dati,
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

        return $html;
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
