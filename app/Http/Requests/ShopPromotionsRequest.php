<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;

class ShopPromotionsRequest extends FormRequest
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
            'name' => 'required',
            "start_date" => "required",
            "expiration_date" => "required",
            "reduction" => "required",
            "discount_type" => "required"
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
            'name.required' => 'Campo obbligatorio',
            "start_date.required" => "Campo obbligatorio",
            "expiration_date.required" => "Campo obbligatorio",
            "reduction.required" => "Campo obbligatorio",
            "discount_type.required" => "Campo obbligatorio"
        ];
    }
}
