<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class ShopAttributes extends Model
{
    use CrudTrait;
    use HasTranslations;
    public $translatable = ['name'];
    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'shop_attributes';
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
    public function getNumOptions(){
        $count = ShopAttributesOptions::where("shop_attribute_id", $this->id)->count();
        return "<a href='/admin/shopAttributesOptions?shop_attribute_id=$this->id'>$count</a>";
    }

    public function getCategories(){

        $html = "";
        $ids = ShopAttributesCategories::where("shop_attribute_id", $this->id)->pluck("shop_category_id", "shop_category_id")->toArray();
        if(count($ids)){
            foreach ($ids as $id){
                $item = PluginProductsCategories::find($id);
                if($item){
                    $html .= "$item->name<br>";
                }
            }
        }else{
            $categories = PluginProductsCategories::selectRaw("plugins_products_categories.name")
                ->join("plugins_products_categories_products", "plugins_products_categories_products.plugin_product_category_id", "=", "plugins_products_categories.id")
                ->join("plugins_products", "plugins_products.id", "=", "plugins_products_categories_products.plugin_product_product_id")
                ->join("shop_attributes_products", "shop_attributes_products.product_id", "=", "plugins_products.id")
                ->where("shop_attributes_products.attribute_id", $this->id)
                ->where("plugins_products.qty", ">", 0)
                ->where("plugins_products.is_active", "=", 1)
                ->groupBy("plugins_products_categories.name")
                ->get();

            if(count($categories) > 0){
                $html .= "<span class='text text-danger'>";

                foreach ($categories as $cat){
                    $html .= "$cat->name <br>";
                }

                $html .= "</span>";
            }


        }

        return $html;
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function category(){
        return $this->belongsTo(PluginProductsCategories::class, "category_id");
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
