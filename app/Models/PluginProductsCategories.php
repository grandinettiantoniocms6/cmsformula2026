<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class PluginProductsCategories extends Model
{
    use CrudTrait;
    use HasTranslations;
    use SoftDeletes;

    public $translatable = ["name", "slug", "description", "meta_description"];
    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'plugins_products_categories';
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

    public function getListPages()
    {
        if($this->list_pages){
            if($this->list_pages != "[]"){
                return "SI";
            }
        }

        return "NO";

    }

    public function getInList()
    {
        if($this->is_in_list_shop_page == 1){
            $url = route('dashboard.set.field.boolean', ['plugins_products_categories', $this->id, "is_in_list_shop_page", 0]);
            if(backpack_user()->roles[0]->id == 4){
                return "<span class='text text-success'><i class=\"las la-eye\"></i></span>";
            }
            return "<a href='$url' class='text text-success'><i class=\"las la-eye\"></i></a>";
        }else{
            $url = route('dashboard.set.field.boolean', ['plugins_products_categories', $this->id, "is_in_list_shop_page", 1]);
            if(backpack_user()->roles[0]->id == 4){
                return "<span class='text text-danger'><i class=\"las la-eye\"></i></span>";
            }
            return "<a href='$url' class='text text-danger'><i class=\"las la-eye\"></i></a>";
        }
    }

    public function getIsActive(){
        if($this->is_active == 1){
            $url = route('dashboard.set.field.boolean', ['plugins_products_categories', $this->id, "is_active", 0]);
            if(backpack_user()->roles[0]->id == 4){
                return "<span class='text text-success'><i class=\"las la-eye\"></i></span>";
            }
            return "<a href='$url' class='text text-success'><i class=\"las la-eye\"></i></a>";
        }else{
            $url = route('dashboard.set.field.boolean', ['plugins_products_categories', $this->id, "is_active", 1]);
            if(backpack_user()->roles[0]->id == 4){
                return "<span class='text text-danger'><i class=\"las la-eye\"></i></span>";
            }
            return "<a href='$url' class='text text-danger'><i class=\"las la-eye\"></i></a>";
        }
    }

    public function getNumber(){
        return PluginProductsCategoriesProducts::join("plugins_products", "plugins_products.id", "=", "plugin_product_product_id")
            ->whereNull("plugins_products.deleted_at")
            ->where("plugin_product_category_id", $this->id)
            ->count();
    }

    public function getPadre(){
        if($this->parent_id === null){
            return "Radice";
        }else{
            $cat = PluginProductsCategories::where("id", $this->parent_id)->first();
            if($cat){
                return $cat->name;
            }
        }
    }

    public function getMenu(){
        $type = "pluginProductsCategories";
        $url_edit = "/admin/$type/$this->id/edit";

        $num1 = PluginProductsCategoriesProducts::join("plugins_products", "plugins_products.id", "=", "plugin_product_product_id")
            ->whereNull("plugins_products.deleted_at")
            ->where("plugin_product_category_id", $this->id)
            ->count();

        $catFigli = PluginProductsCategories::where("parent_id", $this->id)->get()->pluck("id")->toArray();

        $num2 = 0;
        if(count($catFigli) > 0){
            $num2 = PluginProductsCategoriesProducts::join("plugins_products", "plugins_products.id", "=", "plugin_product_product_id")
                ->whereNull("plugins_products.deleted_at")
                ->whereIn("plugin_product_category_id", $catFigli)
                ->count();
        }

        $tot_num = $num1 + $num2;

        $htmlDelete = '';
        if($tot_num == 0){
            $htmlDelete = '<a href="javascript:void(0)" onclick="deleteEntry(this)" data-route="/admin/'.$type.'/'.$this->id.'" class="dropdown-item" data-button-type="delete">Elimina</a>';
        }

        $html = '<div class="dropdown">
                  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                       Gestione
                  </button>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                     <a class="dropdown-item" href="'.$url_edit.'">Modifica</a>
                     '.$htmlDelete.'
                  </div>
                </div>';

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


    public function get_tree_categories($categoryID){
        $vet = [];
        $vet[] = (int) $categoryID;
        $categories = PluginProductsCategories::where("id", $categoryID)->get();
        if($categories){
            foreach ($categories as $category){
                $category->first_level = PluginProductsCategories::where("parent_id", $category->id)->get();
                if($category->first_level){
                    foreach ($category->first_level as $category_first){
                        $vet[] = (int) $category_first->id;
                        $category_first->second_level = PluginProductsCategories::where("parent_id", $category_first->id)->get();
                        if($category_first->second_level) {
                            foreach ($category_first->second_level as $category_second) {
                                $vet[] = (int) $category_second->id;
                                $terzo = PluginProductsCategories::where("parent_id", $category_second->id)->get();
                                if($terzo) {
                                    foreach ($terzo as $category_terzo) {
                                        $vet[] = (int) $category_terzo->id;
                                        $quarto = PluginProductsCategories::where("parent_id", $category_terzo->id)->get();
                                        if($quarto) {
                                            foreach ($quarto as $category_quarto) {
                                                $vet[] = (int) $category_quarto->id;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return $vet;
    }
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

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
