<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;

class ShopAddressesRequest extends FormRequest
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
            'name' => 'required|min:5|max:255',
            'address1' => 'required|min:5|max:255',
            'county' => 'required',
            'city' => 'required',
            'postal_code' => 'required'
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
            'name.required' => 'Nominativo obbligatorio',
            'address1.required' => 'Indirizzo obbligatorio',
            'county.required' => 'Provincia obbligatoria',
            'city.required' => 'Città obbligatorio',
            'postal_code.required' => 'Cap obbligatorio'
        ];
    }
}
