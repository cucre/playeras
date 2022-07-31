<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
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
        return [
            'name' => 'required',
            'description' => 'required',
            'permissions' => 'required|not_in:0'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El campo Nombre del Rol es obligatorio.',
            'description.required' => 'El campo Descripción del Rol es obligatorio.',
            'permissions.required' => 'Debe seleccionar al menos un permiso',
        ];
    }
}
