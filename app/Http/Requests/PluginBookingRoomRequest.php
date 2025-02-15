<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;

class PluginBookingRoomRequest extends FormRequest
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
            //'price' => 'required',
            //'qty_min' => 'required',
            //'qty_max' => 'required',
            //'data_bookable_start' => 'required',
            //'data_bookable_end' => 'required',
            'plugin_booking_type_id' => 'required'
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
            'name.required' => 'Nome obbligatoria',
            'price.required' => 'Prezzo obbligatorio',
            'qty_min.required' => 'Min. letti obbligatorio',
            'qty_max.required' => 'Max. letti obbligatorio',
            'plugin_booking_type_id.required' => 'Tipologia obbligatoria'
        ];
    }
}
