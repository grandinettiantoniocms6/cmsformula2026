<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;

class BlockMetroRequest extends FormRequest
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
            'foto' => 'required'
        ];

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
        // qui metto i messaggi alert di tutti gl input request (multi e non)
        return [
            'name.required' => 'Nome obbligatorio',
            'foto.required' => 'Foto obbligatoria'

        ];
    }
}
