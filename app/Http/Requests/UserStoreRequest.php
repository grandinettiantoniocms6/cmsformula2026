<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
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
            'email'    => 'required|unique:'.config('permission.table_names.users', 'users').',email',
            'name'     => 'required',
            'password' => ['required', 'confirmed', 'min:8', 'regex:/[a-z]/', 'regex:/[A-Z]/', 'regex:/[0-9]/'],
            'roles_show' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'email.unique'    => 'Email già esistente',
            'email.required'    => 'Email obbligatoria',
            'password.required'    => 'Password obbligatoria',
            'password.confirmed'    => 'La conferma password non coincide',
            'password.min'    => 'La password deve contenere almeno 8 caratteri',
            'password.regex'    => 'La password deve contenere almeno una minuscola, una maiuscola e un numero',
            'roles_show.unique'    => 'Ruolo obbligatorio',
            'validation.required'    => 'Campi obbligatori',
            'validation.confirmed'    => 'Campi obbligatori',
        ];
    }
}
