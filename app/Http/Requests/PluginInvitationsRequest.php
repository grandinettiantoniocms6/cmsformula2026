<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;

class PluginInvitationsRequest extends FormRequest
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

        $parameters = \Route::current()->parameters();
        if(count($parameters) == 0) {
            return [
                'name' => 'required|max:255',
                'ship_name' => 'required',
                'fatt_name' => 'required',
                'email' => 'required'
            ];
        }else{
            return [
                'name' => 'required|max:255',
                'email' => 'required'
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
        return [
            'name.required' => 'Campo obbligatorio',
            'ship_name.required' => 'Campo obbligatorio',
            'fatt_name.required' => 'Campo obbligatorio',
            'email.required' => 'Campo obbligatorio'
        ];
    }
}
