<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TallaRequest extends FormRequest
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

        $this->email = mb_strtoupper($this->talla);

        $ignore = '';
        if($this->isMethod('put')){
            $ignore = ',' . $this->route('talla')->talla;
        }

        return [
            'talla' => 'required|unique_unsensitive:tallas,talla' . $ignore,
        ];
    }

    public function messages() {
        return [
            
        ];
    }

    public function attributes() {
        return [

        ];
    }
}
