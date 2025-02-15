<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\AdminPlugin;
use Illuminate\Foundation\Http\FormRequest;

class PluginProductsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $adminPlugin = AdminPlugin::where("name", "pluginProducts")->first();
        if($adminPlugin->version == 3){
            return [
                'name' => 'required|max:255',
                'slug' => 'required|max:255',
                'sku' => 'required|max:255',
                //'category_list' => 'required',
               // 'price' => 'required',
               // 'qty' => 'required',
            ];
        }else{
            return [
                'name' => 'required|max:255',
                'slug' => 'required|max:255',
                'sku' => 'required|max:255',
                //'category_list' => 'required',
            ];
        }


    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        $adminPlugin = AdminPlugin::where("name", "pluginProducts")->first();
        if($adminPlugin->version == 3){
            return [
                'name.required' => 'Nome obbligatorio',
                'slug.required' => 'Permalink obbligatorio',
                'sku.required' => 'SKU obbligatorio',
                'category_list.required' => 'Categoria obbligatoria',
                'price.required' => 'Prezzo obbligatorio',
                'qty.required' => 'Qta obbligatoria'
            ];
        }else{
            return [
                'name.required' => 'Nome obbligatorio',
                'slug.required' => 'Permalink obbligatorio',
                'sku.required' => 'SKU obbligatorio',
                'category_list.required' => 'Categoria obbligatoria'
            ];
        }


    }
}
