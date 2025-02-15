<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;

class PluginInterventionsRequest extends FormRequest
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
           // 'client_id' => 'required',
            'date_intervention' => 'required',
            'vehicle_id' => 'required',
            'driver_id' => 'required',
            'laborer_id' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'mobile' => 'required',
            'address' => 'required',
            'civico' => 'required',
            'comune' => 'required',
            //'provincia' => 'required',
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
            'client_id.required' => 'Cliente obbligatorio',
            'date_intervention.required' => 'Data intervento obbligatoria',
            'vehicle_id.required' => 'Mezzo obbligatorio',
            'driver_id.required' => 'Autista obbligatorio',
            'first_name.required' => 'Nome cliente obbligatorio',
            'last_name.required' => 'Cognome cliente obbligatorio',
            'mobile.required' => 'Cellulare cliente obbligatorio',
            'address.required' => 'Indirizzo obbligatorio',
            'civico.required' => 'Civico obbligatorio',
            'comune.required' => 'Comune obbligatorio',
            'provincia.required' => 'Provincia obbligatoria',
        ];
    }
}
