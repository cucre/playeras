<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $this->email = mb_strtoupper($this->email);

        $ignore = '';
        if($this->isMethod('put')){
            $ignore = ',' . $this->route('usuario')->email;
        }

        return [
            'name'    => 'required',
            'email'   => 'required|email|unique_unsensitive:users,email' . $ignore,
            'rol'     => 'required',
        ];
    }

    public function messages() {
        return [
            'required'           => 'El campo :attribute es obligatorio',
            'unique_unsensitive' => 'El :attribute ya existe',
            'min'                => 'Debe de contener mínimo :attribute caracteres',
        ];
    }

    public function attributes() {
        return [
            'name'                  => 'nombre del usuario',
            'email'                 => 'correo electrónico',
            'password'              => 'contraseña',
            'password_confirmation' => 'confirmación',
            'rol'                   => 'rol',
        ];
    }
}
