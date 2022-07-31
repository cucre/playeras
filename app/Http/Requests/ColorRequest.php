<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ColorRequest extends FormRequest
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

        $this->color = mb_strtoupper($this->color);

        $ignore = '';
        if($this->isMethod('put')){
            $ignore = ',' . $this->route('color')->color;
        }

        return [
            'color' => 'required|unique_unsensitive:colors,color' . $ignore,
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
