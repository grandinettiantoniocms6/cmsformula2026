<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;

class PluginParkingReservationRequest extends FormRequest
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
            'type_park' => 'required',
            'date_start' => 'required',
            'date_end' => 'required',
            'total' => 'required',
            'number_days' => 'required',
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
            'name.required' => 'Nome e cognome obbligatorio',
            'type_park.required' => 'Tipo parcheggio obbligatorio',
            'date_start.required' => 'Data ingresso obbligatorio',
            'date_end.required' => 'Data uscita obbligatorio',
            'total.required' => 'Totale obbligatorio',
            'number_days.required' => 'Num.Giorni obbligatorio',
        ];
    }
}
