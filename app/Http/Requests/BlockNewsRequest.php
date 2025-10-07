<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;

class BlockNewsRequest extends FormRequest
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
        // qui metto solo i request dei campi presenti su modifica blocco (no campi multi)
        if(is_numeric(strpos($_SERVER['QUERY_STRING'], "multi")) || ($_SERVER['REQUEST_METHOD'] == "POST" && is_numeric(strpos($_SERVER['HTTP_REFERER'], "multi")))){
            return [
                'name' => 'required'
            ];
        }

        // qui metto solo i request dei campi Multi presenti sull'inserimento dei record del blocco
        return [
            //'foto' => 'required',
            'title' => 'required',
            'slug' => 'required',
            'date' => 'required',
            //'description' => 'required',
            'category' => 'required'
        ];

    }



    /*public function rules()
    {

        if(is_numeric(strpos($_SERVER['REQUEST_URI'], "multi"))){
            return [];
        }

        return [
            'title' => 'required|max:255',
            'slug' => 'required|max:255',
            'date' => 'required',
            'description' => 'required',
        ];
    }*/

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
        return [
            'name.required' => 'Nome obbligatorio',
            //'foto.required' => 'Immagine obbligatoria',
            'title.required' => 'Titolo obbligatorio',
            'slug.required' => 'Permalink obbligatorio',
            'description.required' => 'Notizia obbligatoria',
            'date.required' => 'Data pubblicazione obbligatoria',
            'category.required' => 'Categoria obbligatoria'
        ];
    }
}
