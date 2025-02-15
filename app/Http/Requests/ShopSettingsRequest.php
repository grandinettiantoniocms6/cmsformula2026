<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;

class ShopSettingsRequest extends FormRequest
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
        return [
            'ccn_registered' => 'required',
            'ccn_ordered' => 'required',
            'custom_color_1' => 'required',
            'custom_color_2' => 'required'
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
            'ccn_registered.required' => 'E-mail (divise da virgola) per ricevere in copia quando avviene una registrazione',
            'ccn_ordered.required' => 'E-mail (divisi per virgola) in copia nascosta quando avviene un ordine',
            'custom_color_1.required' => 'Colore etichetta 1 obbligatoria',
            'custom_color_2.required' => 'Colore etichetta 2 obbligatoria'
        ];
    }
}
