<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;

class BlockHeroRequest extends FormRequest
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
        if (\Str::contains(url()->full(), 'multi')) {
            return [
                'name' => 'required'
            ];
        }

        // qui metto solo i request dei campi Multi presenti sull'inserimento dei record del blocco
        return [
            //'sfondo' => 'required',
            //'foto' => 'required'


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
        return [
            'name.required' => 'Nome obbligatorio',
            //'sfondo.required' => 'Immagine di sfondo obbligatoria',
            //'foto.required' => 'Immagine destra obbligatoria'

        ];
    }
}
